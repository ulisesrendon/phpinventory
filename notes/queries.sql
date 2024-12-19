CREATE TABLE products(
    id serial,
    name varchar(70) not null,
    price numeric(10,2),
    category_id integer
);
CREATE TABLE combos(
    id serial,
    name varchar(100)
);
CREATE TABLE combos_products(
    combo_id integer not null,
    product_id integer not null
);
CREATE TABLE sales(
    id serial,
    created_at timestamp default CURRENT_TIMESTAMP,
    customer_name varchar(70) not null,
    customer_email varchar(70) not null,
    customer_address varchar(100) not null
);
CREATE TABLE lines(
    product_id integer not null,
    quantity integer not null,
    sale_id integer not null
);

CREATE TABLE categories(
    id serial,
    name varchar(70) not null
);

INSERT INTO categories(name) values
    ('Bebidas'),
    ('Postres'),
    ('Sandwiches'),
    ('Hamburguesas'),
    ('Ensaladas')
;

INSERT INTO products(name, price, category_id) values
    ('Café', 39, 1),
    ('Sandwich', 45.5, 3),
    ('Rebanada de pastel', 59.99, null),
    ('Ensalada', 70.5, 5),
    ('Croissant', 43, 3),
    ('Vaso de leche', 42, 1),
    ('Hotcakes', 67, 2)
;

INSERT INTO combos(name) values
    ('Desayuno simple'),
    ('Desayuno completo 1'),
    ('Desayuno completo 2'),
    ('Combo pastel 1'),
    ('Combo pastel 2'),
    ('Combo cena 1'),
    ('Combo cena 2')
;

INSERT INTO combos_products(combo_id, product_id) values
    (1, 1),
    (1, 2),
    (2, 1),
    (2, 2),
    (2, 4),
    (3, 1),
    (3, 5),
    (3, 3),
    (4, 1),
    (4, 3),
    (5, 6),
    (5, 3)
;

INSERT INTO sales(created_at, customer_name, customer_email, customer_address) values
    ('2025-07-01 08:00', 'Luis Perez', 'luisperes@somemail.com', 'Calle En algún lugar #1, Ciudad La mancha, cp 00001, No quiero acordarme'),
    ('2025-07-01 09:00', 'Maria Alvarez', 'mariaalvarez@somemail.com', 'Calle En algún lugar #2, Ciudad La mancha, cp 00002, No quiero acordarme'),
    ('2025-07-01 11:00', 'Angela Rodríguez', 'angelarodri@somemail.com', 'Calle En algún lugar #3, Ciudad La mancha, cp 00002, No quiero acordarme'),
    ('2025-07-01 09:00', 'Jose Reyes', 'joereyes@somemail.com', 'Calle En algún lugar #4, Ciudad La mancha, cp 00004, No quiero acordarme'),
    ('2025-07-02 09:30', 'Luis Perez', 'luisperes@somemail.com', 'Calle En algún lugar #1, Ciudad La mancha, cp 00004, No quiero acordarme'),
    ('2025-07-02 10:00', 'Pedro Mendez', 'pedromendez@somemail.com', 'Calle En algún lugar #7, Ciudad La mancha, cp 00004, No quiero acordarme')
;

INSERT INTO lines(product_id, quantity, sale_id) values
    (1, 1, 1),
    (2, 2, 1),
    (1, 1, 2),
    (2, 1, 2),
    (4, 1, 2),
    (1, 1, 3),
    (5, 1, 3),
    (4, 1, 3),
    (3, 2, 4),
    (6, 2, 4),
    (3, 3, 5),
    (6, 3, 5),
    (1, 2, 6),
    (2, 2, 6)
;

-- Check categories-products relationship
select 
categories.name,
products.name
from categories
join products on categories.id = products.category_id

select 
categories.name,
products.name
from categories
left join products on categories.id = products.category_id

select 
categories.name,
products.name
from categories
right join products on categories.id = products.category_id

select 
categories.name,
products.name
from categories
full join products on categories.id = products.category_id



select 
combos.name,
combos_products.product_id
from combos
left join combos_products on combos.id = combos_products.combo_id

select 
products.id,
products.name,
lines.quantity,
lines.sale_id
from products 
left join lines on lines.product_id = products.id


-- ----
SELECT p.id, p.name, p.price, c.name AS category_name
FROM products p
LEFT JOIN categories c ON p.category_id = c.id;

SELECT cp.combo_id, c.name AS combo_name, p.name AS product_name
FROM combos_products cp
JOIN combos c ON cp.combo_id = c.id
JOIN products p ON cp.product_id = p.id;

SELECT s.id, s.created_at, s.customer_name, s.customer_email, s.customer_address, l.product_id, l.quantity
FROM sales s
JOIN lines l ON s.id = l.sale_id;

SELECT p.id, p.name, SUM(l.quantity) AS total_quantity_sold
FROM products p
JOIN lines l ON p.id = l.product_id
GROUP BY p.id, p.name;

SELECT c.id, c.name, SUM(l.quantity) AS total_quantity_sold
FROM categories c
JOIN products p ON c.id = p.category_id
JOIN lines l ON p.id = l.product_id
GROUP BY c.id, c.name;