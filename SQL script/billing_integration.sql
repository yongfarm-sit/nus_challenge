-- Add Status column to inventory for future soft delete functionality
ALTER TABLE inventory_items
ADD COLUMN status ENUM('active', 'inactive') NOT NULL DEFAULT 'active';

-- Enable key constraints for payment terms to be referenced by billing table
ALTER TABLE purchase_order ADD INDEX (payment_terms);

CREATE TABLE IF NOT EXISTS Vendors (
    VendorID INT AUTO_INCREMENT PRIMARY KEY,
    CompanyName VARCHAR(100) NOT NULL,
    DisplayName VARCHAR(100) DEFAULT NULL,
    ContactEmail VARCHAR(100) DEFAULT NULL,
    MobileNumber VARCHAR(20) DEFAULT NULL,
    FaxNumber VARCHAR(20) DEFAULT NULL,
    Address VARCHAR(255) DEFAULT NULL
);

CREATE TABLE Bills (
    vendor_id INT,
    bill_id VARCHAR(36) PRIMARY KEY,
    bill_no VARCHAR(36) NOT NULL,
    bill_date DATE NOT NULL,
    bill_status ENUM('Pending', 'Paid') NOT NULL DEFAULT 'Pending',
    due_date DATE,
    total_amount DECIMAL(10,2),
    payment_term VARCHAR(100),
    billing_address VARCHAR(255),
    memo TEXT,
    attachment VARCHAR(255) NULL,
    
    -- Foreign Key Constraints
    CONSTRAINT fk_billing_vendor FOREIGN KEY (vendor_id)
        REFERENCES vendors(VendorID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Bill_Item (
    bill_id VARCHAR(36),
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100),
    description TEXT,
    qty INT,
    unit_price DECIMAL(10,2),
    total_price DECIMAL(10,2),

    -- Foreign key constraints
    CONSTRAINT fk_bill FOREIGN KEY (bill_id)
        REFERENCES bills(bill_id) ON DELETE CASCADE ON UPDATE CASCADE
)