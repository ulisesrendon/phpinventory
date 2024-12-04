<?php

$DataBaseAccess->command('CREATE table if not exists providers(
    id integer not null auto_increment primary key,
    title varchar(255) null,
    description varchar(255) null,
    deleted_at timestamp null,
    created_at timestamp null default CURRENT_TIMESTAMP,
    updated_at timestamp null default CURRENT_TIMESTAMP
)');

$DataBaseAccess->command("INSERT INTO 
    providers (title)
    VALUES 
        ('Provider #1 el principal'),
        ('Provider #2 el bueno'),
        ('Provider #3 el otro')
");

// -- entries structures
$DataBaseAccess->command('CREATE table if not exists entries(
    id integer not null auto_increment primary key,
    folio varchar(255) null,
    provider_id bigint not null,
    amount_total decimal(10, 2) not null default 0,
    deleted_at timestamp null,
    created_at timestamp null default CURRENT_TIMESTAMP,
    updated_at timestamp null default CURRENT_TIMESTAMP
)');

$DataBaseAccess->command('CREATE table if not exists entries_products(
    id integer not null auto_increment primary key,
    product_id bigint not null,
    product_entry_id bigint null unique,
    stock integer not null default 0,
    price decimal(10, 2) null,
    created_at timestamp null default CURRENT_TIMESTAMP,
    updated_at timestamp null default CURRENT_TIMESTAMP
)');

$DataBaseAccess->command('INSERT INTO 
    entries_products (product_id, product_entry_id, stock)
    VALUES 
        (1, 1, 10),
        (1, 2, 2),
        (2, 3, 10),
        (3, 4, 15)
');

$DataBaseAccess->command('CREATE table if not exists entrylines(
    id integer not null auto_increment primary key,
    entry_id bigint not null,
    product_id bigint not null,
    pieces integer not null,
    cost decimal(10, 2) not null default 0,
    lot varchar(255) null,
    expiration_date timestamp null
)');

$DataBaseAccess->command('INSERT INTO 
    entries (folio, provider_id, amount_total)
    VALUES 
        (\'1234210\', 1, 800),
        (\'123-32421\', 2, 1490),
        (\'2H4-28HD2\', 3, 650)
');

$DataBaseAccess->command('INSERT INTO 
    entrylines (entry_id, product_id, pieces, cost)
    VALUES 
        (1, 1, 10, 800),
        (2, 1, 2, 700),
        (2, 2, 10, 790),
        (3, 3, 15, 650)
');