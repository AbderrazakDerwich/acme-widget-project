CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product VARCHAR(50) NOT NULL,
    code VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    UNIQUE KEY (product)
);

INSERT IGNORE INTO products (product, code, price) VALUES
('Red Widget', 'R01', 32.95),
('Green Widget', 'G01', 24.95),
('Blue Widget', 'B01', 7.95);