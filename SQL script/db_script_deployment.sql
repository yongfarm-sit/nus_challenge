-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema tp_acc_erp
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tp_acc_erp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `tp_acc_erp` ;
-- -----------------------------------------------------
-- Table for Microsoft Authentication
-- -----------------------------------------------------
CREATE TABLE ms_graph_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    email VARCHAR(255) NULL,
    access_token TEXT NOT NULL,
    refresh_token TEXT NULL,
    expires VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- -----------------------------------------------------
-- Table `tp_acc_erp`.`vendors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`vendors` (
  `VendorID` INT NOT NULL AUTO_INCREMENT,
  `CompanyName` VARCHAR(100) NOT NULL,
  `DisplayName` VARCHAR(100) NULL DEFAULT NULL,
  `ContactEmail` VARCHAR(100) NULL DEFAULT NULL,
  `MobileNumber` VARCHAR(20) NULL DEFAULT NULL,
  `FaxNumber` VARCHAR(20) NULL DEFAULT NULL,
  `Address` VARCHAR(255) NULL DEFAULT NULL,
  `account_no` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`VendorID`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`bills`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`bills` (
  `vendor_id` INT NULL DEFAULT NULL,
  `bill_id` VARCHAR(36) NOT NULL,
  `bill_no` VARCHAR(36) NOT NULL,
  `bill_date` DATE NOT NULL,
  `bill_status` ENUM('Pending', 'Paid') NOT NULL DEFAULT 'Pending',
  `due_date` DATE NULL DEFAULT NULL,
  `total_amount` DECIMAL(10,2) NULL DEFAULT NULL,
  `payment_term` VARCHAR(100) NULL DEFAULT NULL,
  `billing_address` VARCHAR(255) NULL DEFAULT NULL,
  `memo` TEXT NULL DEFAULT NULL,
  `attachment` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`bill_id`),
  INDEX `fk_bills_vendor` (`vendor_id` ASC) VISIBLE,
  CONSTRAINT `fk_bills_vendor`
    FOREIGN KEY (`vendor_id`)
    REFERENCES `tp_acc_erp`.`vendors` (`VendorID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;



-- -----------------------------------------------------
-- Table `tp_acc_erp`.`bill_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`bill_item` (
  `bill_id` VARCHAR(36) NULL DEFAULT NULL,
  `item_id` INT NOT NULL AUTO_INCREMENT,
  `item_name` VARCHAR(100) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `qty` INT NULL DEFAULT NULL,
  `unit_price` DECIMAL(10,2) NULL DEFAULT NULL,
  `total_price` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  INDEX `fk_bill_item_bill` (`bill_id` ASC) VISIBLE,
  CONSTRAINT `fk_bill_item_bill`
    FOREIGN KEY (`bill_id`)
    REFERENCES `tp_acc_erp`.`bills` (`bill_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;



-- -----------------------------------------------------
-- Table `tp_acc_erp`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`customer` (
  `CustomerID` INT NOT NULL AUTO_INCREMENT,
  `CompanyName` VARCHAR(100) NULL DEFAULT NULL,
  `ContactPerson` VARCHAR(100) NULL DEFAULT NULL,
  `CustomerType` VARCHAR(50) NOT NULL DEFAULT 'Individual',
  `Email` VARCHAR(100) NOT NULL,
  `ContactNo` VARCHAR(20) NULL DEFAULT NULL,
  `Address` TEXT NULL DEFAULT NULL,
  `PostalCode` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`CustomerID`),
  UNIQUE INDEX `Email` (`Email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4
;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`customerinvoice`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`customerinvoice` (
  `InvoiceID` INT NOT NULL AUTO_INCREMENT,
  `CustomerID` INT NOT NULL,
  `InvoiceDate` DATE NOT NULL,
  `TotalAmount` DECIMAL(10,2) NOT NULL,
  `Status` VARCHAR(64) NULL DEFAULT NULL,
  PRIMARY KEY (`InvoiceID`),
  INDEX `fk_customerinvoice_customer` (`CustomerID` ASC) VISIBLE,
  CONSTRAINT `fk_customerinvoice_customer`
    FOREIGN KEY (`CustomerID`)
    REFERENCES `tp_acc_erp`.`customer` (`CustomerID`)
    ON DELETE CASCADE
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;




-- -----------------------------------------------------
-- Table `tp_acc_erp`.`failed_jobs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `failed_jobs_uuid_unique` (`uuid` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`inventory_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`inventory_items` (
  `item_id` VARCHAR(36) NOT NULL,
  `item_name` VARCHAR(255) NOT NULL,
  `sku` VARCHAR(100) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `quantity_on_hand` INT NOT NULL,
  `lower_limit` INT NOT NULL,
  `ppu` DECIMAL(10,2) NOT NULL,
  `category` VARCHAR(100) NULL DEFAULT NULL,
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`item_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`migrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`password_resets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`personal_access_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL DEFAULT NULL,
  `last_used_at` TIMESTAMP NULL DEFAULT NULL,
  `expires_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `personal_access_tokens_token_unique` (`token` ASC) VISIBLE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type` ASC, `tokenable_id` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`supplier`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`supplier` (
  `supplier_id` VARCHAR(36) NOT NULL,
  `supplier_name` VARCHAR(255) NOT NULL,
  `contact_info` VARCHAR(255) NULL DEFAULT NULL,
  `address` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`supplier_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`user` (
  `user_id` VARCHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`purchase_order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`purchase_order` (
  `order_id` VARCHAR(36) NOT NULL,
  `supplier_id` VARCHAR(36) NOT NULL,
  `user_id` VARCHAR(36) NOT NULL,
  `order_date` DATE NOT NULL,
  `payment_terms` VARCHAR(100) NULL DEFAULT NULL,
  `expected_delivery` DATE NULL DEFAULT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `status` VARCHAR(50) NULL DEFAULT NULL,
  `billed_amt` DECIMAL(10,2) NULL DEFAULT NULL,
  `goods_receipts_doc` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  INDEX `fk_purchase_order_supplier` (`supplier_id` ASC) VISIBLE,
  INDEX `fk_purchase_order_user` (`user_id` ASC) VISIBLE,
  INDEX `payment_terms` (`payment_terms` ASC) VISIBLE,
  CONSTRAINT `fk_purchase_order_supplier`
    FOREIGN KEY (`supplier_id`)
    REFERENCES `tp_acc_erp`.`supplier` (`supplier_id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_purchase_order_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `tp_acc_erp`.`user` (`user_id`)
    ON DELETE CASCADE
) ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`po_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`po_items` (
  `order_item_id` VARCHAR(36) NOT NULL,
  `order_id` VARCHAR(36) NOT NULL,
  `item_id` VARCHAR(36) NOT NULL,
  `quantity_ordered` INT NOT NULL,
  `unit_price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  INDEX `fk_po_items_order` (`order_id` ASC) VISIBLE,
  INDEX `fk_po_items_inventory` (`item_id` ASC) VISIBLE,
  CONSTRAINT `fk_po_items_order`
    FOREIGN KEY (`order_id`)
    REFERENCES `tp_acc_erp`.`purchase_order` (`order_id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_po_items_inventory`
    FOREIGN KEY (`item_id`)
    REFERENCES `tp_acc_erp`.`inventory_items` (`item_id`)
    ON DELETE CASCADE
) ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;



-- -----------------------------------------------------
-- Table `tp_acc_erp`.`receipts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`receipts` (
  `receipt_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `vendor_name` VARCHAR(255) NOT NULL,
  `purchase_date` DATE NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(10) NOT NULL,
  `payment_method` VARCHAR(50) NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `receipt_img` MEDIUMTEXT NOT NULL,
  `uploaded_by` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`receipt_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `tp_acc_erp`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tp_acc_erp`.`users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_email_unique` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
