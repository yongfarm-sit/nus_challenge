-- Add Status column to inventory for future soft delete functionality
ALTER TABLE inventory_items
ADD COLUMN status ENUM('active', 'inactive') NOT NULL DEFAULT 'active';

-- Enable key constraints for payment terms to be referenced by billing table
ALTER TABLE purchase_order ADD INDEX (payment_terms);

CREATE TABLE Billing (
    bill_id INT PRIMARY KEY AUTO_INCREMENT, -- Unique identifier for each bill
    bill_date DATE NOT NULL,                -- Date of the bill
    bill_status VARCHAR(50) NOT NULL,       -- Status of the bill (e.g., 'Paid', 'Pending')
    bill_doc VARCHAR(255),                  -- Document reference for the bill
    bill_addr VARCHAR(255),                 -- Billing address
    due_date DATE,                          -- Due date for the bill
    bill_desc TEXT,                         -- Description or notes about the bill
    billed_amt DECIMAL(10, 2) NOT NULL,     -- Amount billed (referenced from PurchaseOrder)
    vendor_id INT NOT NULL,                 -- Foreign key to Vendors table
    order_id VARCHAR(36) NOT NULL,          -- Foreign key to PurchaseOrder table
    payment_terms VARCHAR(100),             -- Payment terms (referenced from PurchaseOrder)
    
    -- Foreign Key Constraints
    CONSTRAINT fk_billing_vendor FOREIGN KEY (vendor_id)
        REFERENCES vendors(VendorID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_billing_order FOREIGN KEY (order_id)
        REFERENCES purchase_order(order_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_billing_payment_terms FOREIGN KEY (payment_terms)
        REFERENCES purchase_order(payment_terms) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
