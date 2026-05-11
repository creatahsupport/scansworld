<?php
/**
 * pushToGoogleSheet()
 * Sends appointment row data to the Google Apps Script Web App,
 * which writes it into Google Sheets.
 *
 * @param array $data  Associative array of fields to send.
 * @return bool        true on success, false on failure.
 */
function pushToGoogleSheet(array $data): bool
{
    // -------------------------------------------------------
    // Replace this URL after you deploy the Apps Script web app.
    // Menu: Extensions → Apps Script → Deploy → New deployment
    //       → Web app → Execute as: Me → Who has access: Anyone
    // -------------------------------------------------------
    $apps_script_url = $_ENV['GOOGLE_APPS_SCRIPT_URL'] ?? '';

    if (empty($apps_script_url)) {
        error_log('[GoogleSheets] GOOGLE_APPS_SCRIPT_URL is not set in .env');
        return false;
    }

    $payload = json_encode($data);

    $ch = curl_init($apps_script_url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,   // Apps Script redirects
        CURLOPT_TIMEOUT        => 10,
    ]);

    $response = curl_exec($ch);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($error) {
        error_log('[GoogleSheets] cURL error: ' . $error);
        return false;
    }

    $decoded = json_decode($response, true);
    return isset($decoded['status']) && $decoded['status'] === 'success';
}
