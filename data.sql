CREATE VIEW vw_order_summary AS
SELECT
    o.order_id,
    o.order_date,
    u.username,
    u.email,
    pm.name AS payment_method,
    o.total_amount,
    o.status
FROM
    orders o
JOIN
    users u ON o.user_id = u.user_id
JOIN
    payment_methods pm ON o.payment_method_id = pm.id;
-- #################################################################################################

CREATE VIEW vw_product_details AS
SELECT
    p.product_id,
    p.nama AS product_name,
    p.description,
    p.price,
    p.stok_quantity,
    k.kategori_name,
    b.brand_name,
    p.gambar
FROM
    product p
JOIN
    kategori k ON p.category_id = k.kategori_id
JOIN
    brand b ON p.brand_id = b.brand_id;


-- #################################################################################################

-- prosedur untuk menambahakan produk baru ke dalam tabel produk 
DELIMITER $$

CREATE PROCEDURE sp_add_new_product(
    IN p_nama VARCHAR(100),
    IN p_description TEXT,
    IN p_price BIGINT,
    IN p_stok_quantity INT,
    IN p_category_id BIGINT,
    IN p_brand_id BIGINT,
    IN p_gambar VARCHAR(255)
)
BEGIN
    INSERT INTO product (nama, description, price, stok_quantity, category_id, brand_id, gambar)
    VALUES (p_nama, p_description, p_price, p_stok_quantity, p_category_id, p_brand_id, p_gambar);
END$$

DELIMITER ;



-- Prosedur untuk menambahkan produk baru ke dalam tabel produk
CALL sp_add_new_product(
    'Canon EOS M50', 
    'Kamera mirrorless serbaguna dengan kualitas gambar tinggi.', 
    8500000, 
    15, 
    2, 
    2, 
    'canon_m50.jpg'
);


-- #################################################################################################


-- Fungsi buat menghitung total nominal belanja  berdasarkan user_id 
DELIMITER $$

CREATE FUNCTION fn_calculate_total_sales_by_user(p_user_id BIGINT)
RETURNS BIGINT
DETERMINISTIC
BEGIN
    DECLARE total_sales BIGINT;
    
    SELECT COALESCE(SUM(total_amount), 0)
    INTO total_sales
    FROM orders
    WHERE user_id = p_user_id;
    
    RETURN total_sales;
END$$

-- setelah di buat fungsi diatas, untuk menggunakannya kita bisa memanggilnya gunain sql kaya ini
DELIMITER ;
SELECT fn_calculate_total_sales_by_user(8); 

-- #################################################################################################







-- Trigger ini buat mencatat perubahan data user, misal user "adel" mengubah alamat, nomor telepon, email, atau password., nah triger ini nanti mencatat perubahan di tabel user_audit_log
DELIMITER $$

CREATE TRIGGER trg_log_user_data_changes
AFTER UPDATE ON users
FOR EACH ROW
BEGIN
    -- Log perubahan alamat
    IF OLD.address <> NEW.address THEN
        INSERT INTO user_audit_log (user_id, action, old_value, new_value)
        VALUES (OLD.user_id, 'UPDATE_ADDRESS', OLD.address, NEW.address);
    END IF;

    -- Log perubahan nomor telepon
    IF OLD.phone_number <> NEW.phone_number THEN
        INSERT INTO user_audit_log (user_id, action, old_value, new_value)
        VALUES (OLD.user_id, 'UPDATE_PHONE', OLD.phone_number, NEW.phone_number);
    END IF;

    -- Log perubahan email
    IF OLD.email <> NEW.email THEN
        INSERT INTO user_audit_log (user_id, action, old_value, new_value)
        VALUES (OLD.user_id, 'UPDATE_EMAIL', OLD.email, NEW.email);
    END IF;

     -- Log perubahan password (hanya mencatat bahwa password diubah, bukan nilainya)
    IF OLD.password <> NEW.password THEN
        INSERT INTO user_audit_log (user_id, action, old_value, new_value)
        VALUES (OLD.user_id, 'UPDATE_PASSWORD', 'PASSWORD_CHANGED', 'PASSWORD_CHANGED');
    END IF;
END$$

DELIMITER ;