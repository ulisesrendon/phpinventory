<?php

namespace App\Database\Migration;

use Lib\Http\Response;
use Lib\Http\DefaultController;

class Migration extends DefaultController
{

    public function start(array $args = []): bool
    {
        try {
            $this->DataBaseAccess->beginTransaction();

            $this->DataBaseAccess->executeCommand("CREATE table if not exists products(
                id serial4 not null primary key,
                code varchar(255) null unique,
                title varchar(255) null,
                description varchar(255) null,
                price numeric(10, 2) not null default 0,
                active boolean not null default false,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )");

            $this->DataBaseAccess->executeCommand("INSERT INTO 
                products (code, title, price)
                VALUES 
                    ('700000001', 'Teclado Kumara Dragon Switches Blue', 1200),
                    ('700000002', 'Teclado Kumara Dragon Switches Red', 1170),
                    ('700000003', 'Mouse Logitech G505 Hero', 1000)
                ON CONFLICT (code) DO NOTHING
            ");

            $this->DataBaseAccess->executeCommand("CREATE table if not exists product_entries(
                id serial4 not null primary key,
                product_id bigint not null,
                quantity integer not null,
                provider_id integer not null,
                cost numeric(10, 2) not null default 0,
                lot varchar(255) null,
                expiration_date timestamp(0) null,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )");

            $this->DataBaseAccess->executeCommand("INSERT INTO 
                product_entries (product_id, quantity, provider_id, cost)
                VALUES 
                    (1, 10, 1, 800),
                    (1, 2, 2, 700),
                    (2, 10, 1, 790),
                    (3, 15, 3, 650)
            ");

            $this->DataBaseAccess->executeCommand("CREATE table if not exists product_stocks(
                id serial4 not null primary key,
                product_id bigint not null,
                product_entry_id bigint null unique,
                stock integer not null default 0,
                price numeric(10, 2) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )");

            $this->DataBaseAccess->executeCommand("INSERT INTO 
                product_stocks (product_id, product_entry_id, stock)
                VALUES 
                    (1, 1, 10),
                    (1, 2, 2),
                    (2, 3, 10),
                    (3, 4, 15)
            ");

            $this->DataBaseAccess->executeCommand("CREATE table if not exists providers(
                id serial4 not null primary key,
                title varchar(255) null,
                description varchar(255) null,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )");

            $this->DataBaseAccess->executeCommand("INSERT INTO 
                providers (title)
                VALUES 
                    ('Provider #1 el principal'),
                    ('Provider #2 el bueno'),
                    ('Provider #3 el otro')
            ");

            $this->DataBaseAccess->commit();
        } catch (\Exception $e) {
            $this->DataBaseAccess->rollBack();

            Response::json([
                'data' => 'Migration Failed!'
            ], 500);
        }

        Response::json([
            'data' => 'Migration Complete!'
        ]);

        return true;
    }
}