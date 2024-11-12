<?php

namespace App\Database\Migration;

use App\Shared\Controller\DefaultController;
use Neuralpin\HTTPRouter\Response;

class Migration extends DefaultController
{
    public function start()
    {
        try {
            $this->DataBaseAccess->command('CREATE table if not exists products(
                id integer not null auto_increment primary key,
                code varchar(255) null unique,
                title varchar(255) null,
                description varchar(255) null,
                price decimal(10, 2) not null default 0,
                active boolean not null default false,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )');

            $this->DataBaseAccess->command("INSERT INTO 
                products (code, title, price)
                VALUES 
                    ('700000001', 'Teclado Kumara Dragon Switches Blue', 1200),
                    ('700000002', 'Teclado Kumara Dragon Switches Red', 1170),
                    ('700000003', 'Mouse Logitech G505 Hero', 1000)
            ");

            $this->DataBaseAccess->command('CREATE table if not exists entries(
                id integer not null auto_increment primary key,
                folio varchar(255) null,
                provider_id bigint not null,
                amount_total decimal(10, 2) not null default 0,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )');

            $this->DataBaseAccess->command('CREATE table if not exists entrylines(
                id integer not null auto_increment primary key,
                entry_id bigint not null,
                product_id bigint not null,
                pieces integer not null,
                cost decimal(10, 2) not null default 0,
                lot varchar(255) null,
                expiration_date timestamp(0) null
            )');

            $this->DataBaseAccess->command(query: 'INSERT INTO 
                entries (folio, provider_id, amount_total)
                VALUES 
                    (\'1234210\', 1, 800),
                    (\'123-32421\', 2, 1490),
                    (\'2H4-28HD2\', 3, 650)
            ');

            $this->DataBaseAccess->command('INSERT INTO 
                entrylines (entry_id, product_id, pieces, cost)
                VALUES 
                    (1, 1, 10, 800),
                    (2, 1, 2, 700),
                    (2, 2, 10, 790),
                    (3, 3, 15, 650)
            ');

            $this->DataBaseAccess->command('CREATE table if not exists product_stocks(
                id integer not null auto_increment primary key,
                product_id bigint not null,
                product_entry_id bigint null unique,
                stock integer not null default 0,
                price decimal(10, 2) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )');

            $this->DataBaseAccess->command('INSERT INTO 
                product_stocks (product_id, product_entry_id, stock)
                VALUES 
                    (1, 1, 10),
                    (1, 2, 2),
                    (2, 3, 10),
                    (3, 4, 15)
            ');

            $this->DataBaseAccess->command('CREATE table if not exists providers(
                id integer not null auto_increment primary key,
                title varchar(255) null,
                description varchar(255) null,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )');

            $this->DataBaseAccess->command("INSERT INTO 
                providers (title)
                VALUES 
                    ('Provider #1 el principal'),
                    ('Provider #2 el bueno'),
                    ('Provider #3 el otro')
            ");

            $this->DataBaseAccess->command('CREATE table if not exists providers(
                id integer not null auto_increment primary key,
                title varchar(255) null,
                description varchar(255) null,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )');


            $this->DataBaseAccess->command('CREATE table if not exists orders(
                id integer not null auto_increment primary key,
                customer_id bigint not null,
                payment_method_id bigint not null,
                address_id bigint not null,
                amount_total decimal(10, 2) not null default 0,
                deleted_at timestamp(0) null,
                created_at timestamp(0) null default now(),
                updated_at timestamp(0) null default now()
            )');

            $this->DataBaseAccess->command('CREATE table if not exists orderlines(
                id integer not null auto_increment primary key,
                order_id bigint not null,
                product_id bigint not null,
                pieces integer not null,
                amount_by_piece decimal(10, 2) not null default 0,
                amount_total decimal(10, 2) not null default 0
            )');

            $this->DataBaseAccess->command('CREATE table if not exists orderstates(
                id integer not null auto_increment primary key,
                state_id bigint not null,
                created_at timestamp(0) null default now()
            )');

            $this->DataBaseAccess->command('CREATE table if not exists states(
                id integer not null auto_increment primary key,
                name varchar(255) not null unique
            )');

            $this->DataBaseAccess->command('CREATE table if not exists paymentmethods(
                id integer not null auto_increment primary key,
                name varchar(255) not null unique
            )');

            $this->DataBaseAccess->command("INSERT INTO 
                states (name)
                VALUES 
                    ('Cancelado'),
                    ('Entregado'),
                    ('Pagado'),
                    ('Devuelto'),
                    ('Intento de entrega'),
            ");

            $this->DataBaseAccess->command("INSERT INTO 
                paymentmethods (name)
                VALUES 
                    ('Efectivo'),
                    ('Transferencia bancaria'),
                    ('Paypal'),
                    ('Mercadopago')
            ");

        } catch (\Exception $e) {
            return Response::json([
                'data' => 'Migration Failed! - Data may be corrupt',
            ], 500);
        }

        return Response::json([
            'data' => 'Migration Complete!',
        ]);

    }
}