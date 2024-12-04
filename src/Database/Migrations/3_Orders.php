<?php

$DataBaseAccess->command('CREATE table if not exists states(
    id integer not null auto_increment primary key,
    name varchar(255) not null unique
)');

$DataBaseAccess->command('CREATE table if not exists orders(
    id integer not null auto_increment primary key,
    customer_id bigint null,
    payment_method_id bigint null,
    address_id bigint null,
    amount_total decimal(10, 2) not null default 0,
    deleted_at timestamp null,
    created_at timestamp null default CURRENT_TIMESTAMP,
    updated_at timestamp null default CURRENT_TIMESTAMP
)');

$DataBaseAccess->command('CREATE table if not exists orderlines(
    id integer not null auto_increment primary key,
    order_id bigint not null,
    product_id bigint not null,
    pieces integer not null,
    amount_by_piece decimal(10, 2) not null default 0,
    amount_total decimal(10, 2) not null default 0
)');

$DataBaseAccess->command('CREATE table if not exists orderstates(
    id integer not null auto_increment primary key,
    state_id bigint not null,
    created_at timestamp null default CURRENT_TIMESTAMP
)');


$DataBaseAccess->command('CREATE table if not exists paymentmethods(
    id integer not null auto_increment primary key,
    name varchar(255) not null unique
)');

$DataBaseAccess->command("INSERT INTO 
    paymentmethods (name)
    VALUES 
        ('Efectivo'),
        ('Transferencia bancaria'),
        ('Paypal'),
        ('Mercadopago')
");

$DataBaseAccess->command("INSERT INTO 
    states (name)
    VALUES 
        ('Cancelado'),
        ('Entregado'),
        ('Pagado'),
        ('Devuelto'),
        ('Intento de entrega')
");