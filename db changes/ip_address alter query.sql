-- ============================================================
-- IP Address ALTER Queries
-- Run these on your database to add ip_address support
-- ============================================================

-- 1. enquiry table (contact-us.php form)
--    Also adds created_at for timestamp tracking
ALTER TABLE `enquiry`
    ADD `ip_address` VARCHAR(45) NULL AFTER `message`,
    ADD `created_at` DATETIME NULL AFTER `ip_address`;

-- NOTE: book_appointment table already has ip_address column
-- (added in previous migration: "book appointment alter query.sql")
-- No changes needed for book_appointment.

-- ============================================================
-- master-health-check-packages forms do NOT save to DB --
-- they only send email, so no DB change needed for those.
-- ============================================================
