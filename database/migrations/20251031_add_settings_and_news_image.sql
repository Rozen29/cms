-- Migration: add settings table and image_path column
USE `min1pringsewu`;

CREATE TABLE IF NOT EXISTS `settings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `skey` VARCHAR(100) NOT NULL UNIQUE,
  `svalue` TEXT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `news`
  ADD COLUMN `image_path` VARCHAR(255) NULL AFTER `content`;
