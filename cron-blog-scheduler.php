<?php
// cron-blog-scheduler.php
// This script should be run periodically (e.g., every minute or hour) via a cron job.

include(__DIR__ . "/includes/config.php");

try {
    // 0 = Draft, 1 = Published, 2 = Scheduled
    
    // Select all blogs that are scheduled (status = 2) and the schedule_date is less than or equal to current time
    $sql = "UPDATE `blog` 
            SET `status` = 1 
            WHERE `status` = 2 
            AND `schedule_date` IS NOT NULL 
            AND `schedule_date` <= NOW()";

    if ($con->query($sql) === TRUE) {
        $affected_rows = $con->affected_rows;
        echo "Successfully updated $affected_rows scheduled blog(s) to published status.\n";
    } else {
        echo "Error updating records: " . $con->error . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
