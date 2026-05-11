/**
 * Google Apps Script — Scans World Appointment Sync
 * =====================================================
 * HOW TO USE:
 * 1. Open your Google Sheet → Extensions → Apps Script
 * 2. Paste this entire file and Save (💾)
 * 3. Deploy → New deployment → Web app
 *    → Execute as: Me | Who has access: Anyone
 * 4. Copy Web App URL → paste into .env as GOOGLE_APPS_SCRIPT_URL
 *
 * For Sheet → DB sync (onEdit trigger):
 * 5. Set DB_WEBHOOK_URL and WEBHOOK_SECRET below
 * 6. Click Triggers (⏰ clock icon) → Add Trigger
 *    → Function: onEditTrigger
 *    → Event source: From spreadsheet
 *    → Event type: On edit
 *    → Click Save
 *
 * Sheet column layout (auto-created on first run):
 *   A: ID | B: Name | C: Phone | D: Branch | E: Service
 *   F: Appointment Date | G: Appointment Time | H: Enquiry Date | I: Source
 *   J: Status | K: Follow-up Date | L: Reason
 */

// ── CONFIGURE THESE TWO VALUES ────────────────────────────────────────────────
var DB_WEBHOOK_URL  = "https://scans-world.companyonline.in/admin/sheet_webhook.php";

// Must match SHEET_WEBHOOK_SECRET in your .env file

var WEBHOOK_SECRET  = "a3f8c2d91b74e6053f2a1c8d9e4b07f1";
// ─────────────────────────────────────────────────────────────────────────────

// Column numbers (1-indexed)
var COL_ID          = 1;   // A
var COL_STATUS      = 10;  // J
var COL_FOLLOWUP    = 11;  // K
var COL_REASON      = 12;  // L

// Status values allowed in the sheet dropdown
var ALL_STATUSES = ["Open", "Closed", "Not Turned Up", "Follow-up"];

// ── Status transition rules ───────────────────────────────────────────────────
// Key = current status, Value = array of statuses it CAN be changed to
// Empty array [] = LOCKED (no changes allowed)
var ALLOWED_TRANSITIONS = {
  "Open"         : ["Closed", "Not Turned Up", "Follow-up"],
  "Follow-up"    : ["Closed", "Not Turned Up"],
  "Closed"       : [],   // LOCKED
  "Not Turned Up": []    // LOCKED
};


// ─── PHP → Sheet: receive new booking or status update ───────────────────────
function doPost(e) {
  try {
    var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
    var data  = JSON.parse(e.postData.contents);

    ensureHeaders(sheet);

    if (data.action === "status_update") {
      updateRowById(sheet, data);
    } else {
      var newRow = sheet.getLastRow() + 1;
      sheet.appendRow([
        data.id               || "",
        data.name             || "",
        data.phone            || "",
        data.branch           || "",
        data.service          || "",
        data.appointment_date || "",
        data.appointment_time || "",
        data.enquiry_date     || "",
        data.source           || "Direct",
        "Open",  // default status
        "",      // followup_date
        "",      // reason
      ]);
      // Apply dropdown to the new row's status cell
      setStatusDropdown(sheet, newRow);
    }

    return ContentService
      .createTextOutput(JSON.stringify({ status: "success" }))
      .setMimeType(ContentService.MimeType.JSON);

  } catch (error) {
    return ContentService
      .createTextOutput(JSON.stringify({ status: "error", message: error.message }))
      .setMimeType(ContentService.MimeType.JSON);
  }
}


// ─── Sheet → DB: fires when user edits any cell ──────────────────────────────
function onEditTrigger(e) {
  var sheet = e.source.getActiveSheet();
  var row   = e.range.getRow();
  var col   = e.range.getColumn();

  if (row < 2) return; // skip header row

  // ── Only allow edits to Status (J), Follow-up Date (K), or Reason (L) columns ──
  // Check every column in the edited range
  var startCol = e.range.getColumn();
  var endCol = e.range.getLastColumn();
  
  var isAllowed = true;
  for (var c = startCol; c <= endCol; c++) {
    if (c !== COL_STATUS && c !== COL_FOLLOWUP && c !== COL_REASON) {
      isAllowed = false;
      break;
    }
  }

  if (!isAllowed) {
    // REVERT the change
    if (e.oldValue === undefined) {
      e.range.clearContent();
    } else {
      e.range.setValue(e.oldValue);
      
      // ✅ Apply correct formatting based on column
      var colNum = e.range.getColumn();
      
      if (colNum === 6 || colNum === 8 || colNum === COL_FOLLOWUP) {
        // Date columns (Appointment Date, Enquiry Date, Follow-up Date)
        e.range.setNumberFormat('yyyy-mm-dd');
      } 
      else if (colNum === 7) {
        // Time column (Appointment Time)
        e.range.setNumberFormat('h:mm am/pm');
      }
      else {
        // Standard text/number columns
        e.range.setNumberFormat('@'); // Plain text to avoid decimal issues
      }
    }
    
    SpreadsheetApp.getUi().alert(
      "🚫 Protected Data",
      "You cannot edit this column. The change has been reverted.\n\n" +
      "Structural changes (Delete/Insert) are blocked for all non-owner users.",
      SpreadsheetApp.getUi().ButtonSet.OK
    );
    return;
  }

  // ── Enforce status transition rules ──────────────────────────────────────
  if (col === COL_STATUS) {
    var newStatus  = sheet.getRange(row, COL_STATUS).getValue();
    var oldStatus  = e.oldValue || "Open"; // value before edit

    // Normalize (in case oldValue is undefined for a fresh cell)
    if (!oldStatus || oldStatus === "") oldStatus = "Open";

    var allowed = ALLOWED_TRANSITIONS[oldStatus];

    if (allowed === undefined) {
      // Unknown old status — allow the change
    } else if (allowed.length === 0) {
      // LOCKED — revert the change and warn the user
      e.range.setValue(oldStatus);
      SpreadsheetApp.getUi().alert(
        "⚠️ Status Locked",
        "\"" + oldStatus + "\" cannot be changed anymore.",
        SpreadsheetApp.getUi().ButtonSet.OK
      );
      return;
    } else if (allowed.indexOf(newStatus) === -1) {
      // Not in allowed transitions — revert
      e.range.setValue(oldStatus);
      SpreadsheetApp.getUi().alert(
        "⚠️ Invalid Status Change",
        "\"" + oldStatus + "\" can only be changed to: " + allowed.join(", ") + ".\n\nYou tried to set: \"" + newStatus + "\"",
        SpreadsheetApp.getUi().ButtonSet.OK
      );
      return;
    }
  }

  // ── Get row ID ────────────────────────────────────────────────────────────
  var id = sheet.getRange(row, COL_ID).getValue();
  if (!id) return;

  // ── Read current row values ───────────────────────────────────────────────
  var values = sheet.getRange(row, 1, 1, 12).getValues()[0];

  var payload = JSON.stringify({
    id            : String(values[COL_ID - 1]),
    status        : values[COL_STATUS - 1]   || "Open",
    follow_up_date : values[COL_FOLLOWUP - 1] || "",
    reason        : values[COL_REASON - 1]   || "",
  });

  Logger.log("Sending to webhook → " + payload);

  if (!DB_WEBHOOK_URL || !WEBHOOK_SECRET) {
    Logger.log("Webhook not configured — skipping DB sync");
    return;
  }

  try {
    var response = UrlFetchApp.fetch(DB_WEBHOOK_URL, {
      method            : "post",
      contentType       : "application/json",
      payload           : payload,
      headers           : { "X-Webhook-Secret": WEBHOOK_SECRET },
      muteHttpExceptions: true,
    });
    Logger.log("Response code: " + response.getResponseCode());
    Logger.log("Response body: " + response.getContentText());
  } catch (err) {
    Logger.log("Webhook fetch error: " + err.message);
  }
}


/**
 * onChangeTrigger(e)
 * Fires when sheet structure changes (insertion/deletion of rows).
 * Note: You MUST set this up as an installable trigger:
 * Triggers (⏰) → Add Trigger → Function: onChangeTrigger → Event type: On change
 */
function onChangeTrigger(e) {
  if (e.changeType === 'REMOVE_ROW' || e.changeType === 'INSERT_ROW') {
    SpreadsheetApp.getUi().alert(
      "⚠️ Structural Change Detected",
      "Manually inserting or deleting rows is NOT recommended and may break the database sync.\n\n" +
      "If you need to remove data, please do it via the Admin Dashboard or simply set the status to 'Closed'.\n\n" +
      "Please Undo (Ctrl+Z) if this was a mistake.",
      SpreadsheetApp.getUi().ButtonSet.OK
    );
  }
}


// ─── Find row by ID and update status/followup/reason columns ────────────────
function updateRowById(sheet, data) {
  var allData = sheet.getDataRange().getValues();

  for (var i = 1; i < allData.length; i++) {
    if (String(allData[i][COL_ID - 1]) === String(data.id)) {
      sheet.getRange(i + 1, COL_STATUS).setValue(data.status        || "Open");
      sheet.getRange(i + 1, COL_FOLLOWUP).setValue(data.follow_up_date || "");
      sheet.getRange(i + 1, COL_REASON).setValue(data.reason        || "");
      return;
    }
  }

  // Row not found — append it
  var newRow = sheet.getLastRow() + 1;
  sheet.appendRow([
    data.id               || "",
    data.name             || "",
    data.phone            || "",
    data.branch           || "",
    data.service          || "",
    data.appointment_date || "",
    data.appointment_time || "",
    data.enquiry_date     || "",
    data.source           || "Direct",
    data.status           || "Open",
    data.follow_up_date    || "",
    data.reason           || "",
  ]);
  setStatusDropdown(sheet, newRow);
}


// ─── Apply dropdown validation to a single status cell ───────────────────────
function setStatusDropdown(sheet, row) {
  var rule = SpreadsheetApp.newDataValidation()
    .requireValueInList(ALL_STATUSES, true)
    .setAllowInvalid(false)
    .build();
  sheet.getRange(row, COL_STATUS).setDataValidation(rule);
}


// ─── Run this ONCE manually to apply dropdowns to all existing rows ───────────
// In Apps Script editor: select this function → click ▶ Run
function applyDropdownsToAllRows() {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  var lastRow = sheet.getLastRow();
  if (lastRow < 2) return;

  var rule = SpreadsheetApp.newDataValidation()
    .requireValueInList(ALL_STATUSES, true)
    .setAllowInvalid(false)
    .build();

  // Apply to all data rows in column J
  sheet.getRange(2, COL_STATUS, lastRow - 1, 1).setDataValidation(rule);
  Logger.log("Dropdown applied to rows 2 to " + lastRow);
}


// ─── Auto-create styled header row if sheet is empty ─────────────────────────
function ensureHeaders(sheet) {
  if (sheet.getLastRow() === 0 || sheet.getRange(1, 1).getValue() !== "ID") {
    sheet.insertRowBefore(1);
    sheet.getRange(1, 1, 1, 12).setValues([[
      "ID", "Name", "Phone", "Branch", "Service",
      "Appointment Date", "Appointment Time", "Enquiry Date", "Source",
      "Status", "Follow-up Date", "Reason"
    ]]);
    sheet.getRange(1, 1, 1, 12)
      .setFontWeight("bold")
      .setBackground("#4a86e8")
      .setFontColor("#ffffff");
  }
  // Also ensure protection is set up
  setupProtection();
}


/**
 * setupProtection()
 * Programmatically locks the entire sheet except for the editable columns (J, K, L).
 * This PHYSICALLY disables "Delete Row" and "Insert Row" for other users.
 * 
 * Run this ONCE manually: select 'setupProtection' → click ▶ Run
 */
function setupProtection() {
  var ss = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = ss.getActiveSheet();
  
  // 1. Remove all existing protections on this sheet
  var protections = sheet.getProtections(SpreadsheetApp.ProtectionType.SHEET);
  for (var i = 0; i < protections.length; i++) {
    protections[i].remove();
  }
  
  // 2. Protect the entire sheet
  var protection = sheet.protect().setDescription('Global Sheet Protection');
  
  // 3. Set editors to ONLY the owner (Me)
  // This is what disables the Delete/Insert menu items for everyone else
  protection.getEditors().forEach(function(ed) {
    protection.removeEditor(ed);
  });
  
  // 4. Add an EXCEPTION range for the editable columns (J2:L1000)
  // Users will still be able to edit Status, Follow-up Date, and Reason
  var editableRange = sheet.getRange('J2:L5000');
  protection.setUnprotectedRanges([editableRange]);
  
  Logger.log("✅ Sheet Protected. Columns J, K, L are editable. Row insertion/deletion is now BLOCKED for others.");
}
