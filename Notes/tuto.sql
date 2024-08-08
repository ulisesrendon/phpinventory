CREATE products IF NOT EXISTS(
    id bigserial not null primary key,
    code varchar(255) null unique,
    title varchar(255) null,
    price numeric(10, 2) not null default 0,
    stock integer not null default 0,
    active boolean not null default false,
    deleted_at timestamp(0) null
);
INSERT INTO products (code, title, price) VALUES 
    ('700000001', 'Teclado Kumara Dragon Switches Blue', 1200),
    ('700000002', 'Teclado Kumara Dragon Switches Red', 1170),
    ('700000003', 'Mouse Logitech G505 Hero', 1000);


INSERT INTO products(code, title, price, active) VALUES($code, $title, $price, $active) RETURNING id;


SELECT id, code, title, price, stock, active FROM products


SELECT exists(SELECT code FROM products WHERE code = $code);


UPDATE products SET title = $title, price = $price, active = $active WHERE id = $id;

UPDATE products SET stock = stock-$quantity WHERE id = $id;


DELETE FROM products WHERE id = $id;
