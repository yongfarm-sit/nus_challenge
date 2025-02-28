-- 1. Table: Supplier
CREATE TABLE IF NOT EXISTS Supplier (
    supplier_id VARCHAR(36) PRIMARY KEY,
    supplier_name VARCHAR(255) NOT NULL,
    contact_info VARCHAR(255),
    address VARCHAR(255)
);

-- 2. Table: User
CREATE TABLE IF NOT EXISTS User (
    user_id VARCHAR(36) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

-- 3. Table: Purchase Order
CREATE TABLE IF NOT EXISTS Purchase_Order (
    order_id VARCHAR(36) PRIMARY KEY,
    supplier_id VARCHAR(36) NOT NULL,
    user_id VARCHAR(36) NOT NULL,
    order_date DATE NOT NULL,
    payment_terms VARCHAR(100),
    expected_delivery DATE,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50),
    billed_amt DECIMAL(10, 2),
    goods_receipts_doc VARCHAR(255),
    FOREIGN KEY (supplier_id) REFERENCES Supplier(supplier_id),
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

-- 4. Table: Inventory Items
CREATE TABLE IF NOT EXISTS Inventory_Items (
    item_id VARCHAR(36) PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    sku VARCHAR(100),
    description TEXT,
    quantity_on_hand INT NOT NULL,
    lower_limit INT NOT NULL,
    ppu DECIMAL(10, 2) NOT NULL,
    category VARCHAR(100)
);

-- 5. Table: PO Items (Purchase Order Items)
CREATE TABLE IF NOT EXISTS PO_Items (
    order_item_id VARCHAR(36) PRIMARY KEY,
    order_id VARCHAR(36) NOT NULL,
    item_id VARCHAR(36) NOT NULL,
    quantity_ordered INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Purchase_Order(order_id),
    FOREIGN KEY (item_id) REFERENCES Inventory_Items(item_id)
);

-- 6. Table: Receipts
CREATE TABLE IF NOT EXISTS Receipts (
    receipt_id VARCHAR(36) PRIMARY KEY,
    vendor_name VARCHAR(255),
    purchase_date DATE,
    total_amount DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(10),
    payment_method VARCHAR(50),
    category VARCHAR(100),
    receipt_img VARCHAR(255),
    uploaded_by VARCHAR(36) NOT NULL,
    FOREIGN KEY (uploaded_by) REFERENCES User(user_id)
);

-- 7. Table: Receipt Items
CREATE TABLE IF NOT EXISTS Receipt_Items (
    item_id VARCHAR(36) PRIMARY KEY,
    receipt_id VARCHAR(36) NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    qty INT NOT NULL,
    ppu DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) GENERATED ALWAYS AS (qty * ppu) STORED,
    FOREIGN KEY (receipt_id) REFERENCES Receipts(receipt_id)
);
