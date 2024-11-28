<?php

namespace Stradow\Database;

use Neuralpin\HTTPRouter\Response;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap/environment.php';
define('DB_CONFIG', require __DIR__ . '/../../config/database.php');
require __DIR__ . '/../../bootstrap/databaseAccess.php';


class Migration
{    
    public static function start()
    {
        $DataBaseAccess = Container::get(DataBaseAccess::class);

        try {
            // -- Product structures
            $DataBaseAccess->command('CREATE table if not exists products(
                id integer not null auto_increment primary key,
                code varchar(255) null unique,
                title varchar(255) null,
                description varchar(255) null,
                price decimal(10, 2) not null default 0,
                type int not null default 1,
                active boolean not null default false,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )');

            $DataBaseAccess->command("INSERT INTO 
                products (code, title, price)
                VALUES 
                    ('700000001', 'Teclado Kumara Dragon Switches Blue', 1200),
                    ('700000002', 'Teclado Kumara Dragon Switches Red', 1170),
                    ('700000003', 'Mouse Logitech G505 Hero', 1000)
            ");

            $DataBaseAccess->command('CREATE table if not exists providers(
                id integer not null auto_increment primary key,
                title varchar(255) null,
                description varchar(255) null,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
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
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )');

            $DataBaseAccess->command('CREATE table if not exists entries_products(
                id integer not null auto_increment primary key,
                product_id bigint not null,
                product_entry_id bigint null unique,
                stock integer not null default 0,
                price decimal(10, 2) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
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
                expiration_date timestamp(0) null
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

            // -- Order structures
            $DataBaseAccess->command('CREATE table if not exists orders(
                id integer not null auto_increment primary key,
                customer_id bigint null,
                payment_method_id bigint null,
                address_id bigint null,
                amount_total decimal(10, 2) not null default 0,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
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
                created_at timestamp(0) null default now()
            )');

            $DataBaseAccess->command('CREATE table if not exists states(
                id integer not null auto_increment primary key,
                name varchar(255) not null unique
            )');

            $DataBaseAccess->command('CREATE table if not exists paymentmethods(
                id integer not null auto_increment primary key,
                name varchar(255) not null unique
            )');

            $DataBaseAccess->command("INSERT INTO 
                states (name)
                VALUES 
                    ('Cancelado'),
                    ('Entregado'),
                    ('Pagado'),
                    ('Devuelto'),
                    ('Intento de entrega')
            ");

            $DataBaseAccess->command("INSERT INTO 
                paymentmethods (name)
                VALUES 
                    ('Efectivo'),
                    ('Transferencia bancaria'),
                    ('Paypal'),
                    ('Mercadopago')
            ");

        } catch (\Exception $e) {
            // return Response::json([
            //     'data' => 'Migration Failed! - Data may be corrupt',
            // ], 500);

            file_put_contents('php://output', 'Migration Failed! - Data may be corrupt');
        }

        // return Response::json([
        //     'data' => 'Migration Complete!',
        // ]);

        file_put_contents('php://output', 'Migration Complete!');

    }
}
