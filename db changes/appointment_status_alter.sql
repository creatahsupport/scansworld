ALTER TABLE `book_appointment`
    ADD COLUMN `appointment_status`        TINYINT     NOT NULL DEFAULT 0         COMMENT '0=Open, 1=Closed, 2=Not Turned Up, 3=Follow-up'  AFTER `ip_address`,
    ADD COLUMN `follow_up_date` DATE        NULL     DEFAULT NULL      COMMENT 'Required when appointment_status = 3 (Follow-up)'             AFTER `appointment_status`,
    ADD COLUMN `reason`        VARCHAR(500) NULL     DEFAULT NULL      COMMENT 'Reason for appointment_status change'                         AFTER `follow_up_date`;

ALTER TABLE `book_appointment` CHANGE `appointment_time` `appointment_time` INT NOT NULL;
