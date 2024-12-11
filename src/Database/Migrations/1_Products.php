<?php

$DataBaseAccess->command('CREATE table if not exists products(
    id integer not null auto_increment primary key,
    code varchar(255) null unique,
    title varchar(255) null,
    description varchar(255) null,
    price decimal(10, 2) not null default 0,
    type int not null default 1,
    active boolean not null default false,
    deleted_at timestamp null,
    created_at timestamp null default CURRENT_TIMESTAMP,
    updated_at timestamp null default CURRENT_TIMESTAMP
)');

$DataBaseAccess->command("INSERT INTO 
    products (code, title, price)
    VALUES 
        ('700000001', 'Teclado Kumara Dragon Switches Blue', 1200),
        ('700000002', 'Teclado Kumara Dragon Switches Red', 1170),
        ('700000003', 'Mouse Logitech G505 Hero', 1000)
");
