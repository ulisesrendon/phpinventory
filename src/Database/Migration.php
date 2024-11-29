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

            // ------------------

            $DataBaseAccess->command("CREATE TABLE fields (
                id integer not null auto_increment primary key,
                type integer NOT NULL,
                name varchar(255) NOT NULL,
                title varchar(255) NOT NULL,
                description varchar(255) NOT NULL,
                config json DEFAULT '{}' NOT NULL,
                deleted_at timestamp(0) NULL,
                CONSTRAINT fields_name_unique UNIQUE (name)
            )");

            $DataBaseAccess->command(<<<'SQL'
                INSERT INTO fields (type,name,title,description,config,deleted_at) VALUES
                    (1,'image_product','Image product','','{}',NULL),
                    (11,'image','Simple image','Representa una dirección web de una imagen','{}',NULL),
                    (1,'container','Container','Contenedor simple','{}',NULL),
                    (4,'header_1','Header #1','Representa un encabezado H1','{}',NULL),
                    (12,'button','Button','Representa un botón','{}',NULL),
                    (12,'hr','Separator bar','Representa una linea separadora','{}',NULL),
                    (5,'text','Text block','Bloque de texto extenso','{}',NULL),
                    (4,'header_3','Header #3','Representa un encabezado H3','{}',NULL),
                    (4,'header_6','Header #6','Representa un encabezado H6','{}',NULL),
                    (1,'galery','Simple image galery','Lista de imagenes para galería de imágenes','{"HTMLTag": "form"}',NULL),
                    (12,'span','Span','Cadena de texto','{}',NULL),
                    (1,'list','Item list','Representa un listado de elementos','{}',NULL),
                    (1,'text_list','Text list','Listado de cadenas de texto','{}',NULL),
                    (4,'header_2','Header #2','Representa un encabezado H2','{}',NULL),
                    (1,'bluelabel','bluelabel','Bloque de texto en forma de etiqueta azul','{}',NULL),
                    (1,'input_number','Input type number','Campo númerico','{}',NULL),
                    (1,'input_text','Input type text','Cadena de texto simple','{}',NULL),
                    (1,'list_checkbox_question','Checkbox list','Pregunta de opción multiple con respuestas visuales','{}',NULL),
                    (1,'accordion','Accordion','Acordeon simple (Titulo/contenido)','{}',NULL),
                    (1,'treatment_block','Treatment Block','Bloque compuesto para lista de tratamientos','{}',NULL),
                    (1,'product_reference','Product item reference','Bloque compuesto para lista de tratamientos','{}',NULL),
                    (1,'product_list','Product list','Listado de productos para con funcionamiento de añadir al carrito','{}',NULL),
                    (1,'list_image_question','list_image_question','Pregunta con respuestas en forma de imagen','{}',NULL),
                    (1,'button_process_answers','button_process_answers','Botón que redirecciona al usuario según sus respuestas','{}',NULL),
                    (1,'list_link_question','List link question','Lista de preguntas con redirección','{}',NULL),
                    (7,'link','URL link','Representa una dirección web','{"default": {"url": "", "text": ""}, "placeholder": "Inserte una dirección web valida"}',NULL),
                    (7,'link_medical_custom','Custom medical link','','{}',NULL),
                    (7,'link_continue','Button link style #continue','Representa una dirección web','{"default": {"url": "", "text": ""}, "placeholder": "Inserte una dirección web valida"}',NULL),
                    (1,'list_checkbox_types','List checkbox types','List checkbox types','{"default": {"color": "", "image": "", "title": "", "description": ""}, "placeholder": "Inserte una lista de opciones con su titulo, descripción e imagen"}',NULL),
                    (1,'list_link','List link','A list of links','{"default": [], "placeholder": "Inserte los enlaces deseados"}',NULL),
                    (1,'link_image','Link image','Link image','{"default": {"alt": "", "url": "", "image": "", "title": ""}, "placeholder": "Bloque de imagen con enlace"}',NULL),
                    (1,'list_link_content','List link content','List link content','{}',NULL),
                    (1,'content_lifestyle','Content lifestyle','Content lifestyle','{}',NULL),
                    (1,'lifestyle_block','Lifestyle block','Lifestyle block','{}',NULL)
            SQL);

            $DataBaseAccess->command("CREATE TABLE field_types (
                    id integer NOT NULL PRIMARY KEY auto_increment,
                    name varchar(255) NOT NULL,
                    deleted_at timestamp(0) NULL,
                    CONSTRAINT field_types_name_unique UNIQUE (name)
                )");

            $DataBaseAccess->command(<<<'SQL'
                INSERT INTO field_types (name) VALUES
                    ('custom'),
                    ('boolean'),
                    ('numeric'),
                    ('string'),
                    ('text'),
                    ('email'),
                    ('url'),
                    ('date'),
                    ('dateTime'),
                    ('json'),
                    ('image'),
                    ('html_element')
            SQL);

            $DataBaseAccess->command("CREATE TABLE content_types (
                id integer NOT NULL primary key auto_increment,
                name varchar(255) NOT NULL,
                title varchar(255) NOT NULL,
                description varchar(255) NOT NULL,
                config json DEFAULT '{}' NOT NULL,
                deleted_at timestamp(0) NULL,
                CONSTRAINT content_types_name_unique UNIQUE (name)
            )");

            $DataBaseAccess->command(<<<'SQL'
                INSERT INTO content_types (name,title,description,config,deleted_at) VALUES
                    ('oxy_intro','Oxy intro','','{}',NULL),
                    ('oxy_sintomas','Oxy sintomas','','{"HTMLTag": "form"}',NULL),
                    ('oxy_opciones','Oxy opciones','','{}',NULL),
                    ('oxy_kit','Oxy kit de tratamiento','','{}',NULL),
                    ('oxy_grave','Oxy grave','','{}',NULL),
                    ('oxy_step_exfolia','Oxy step exfolia','','{}',NULL),
                    ('oxy_step_refuerza','Oxy step refuerza','','{}',NULL),
                    ('oxy_step','Oxy step','','{}',NULL),
                    ('medical_survey','medical_survey','','{}',NULL),
                    ('page','page','','{}',NULL),
                    ('schema_acne_1','Acné schema #1','','{}',NULL),
                    ('schema_acne_2','Acné schema #2','','{}',NULL),
                    ('schema_acne_3','Acné schema #3','','{}',NULL),
                    ('schema_desc_text','Simple page schema','','{}',NULL),
                    ('schema_medical_page','Acne medical page info','','{}',NULL),
                    ('schema_treatment_result','Acné treatment result schema','','{}',NULL),
                    ('constipation_scheme_1','Constipation scheme #1','Constipation scheme #1','{}',NULL),
                    ('constipation_scheme_2','Constipation scheme #2','Constipation scheme #2','{}',NULL),
                    ('constipation_scheme_3','Constipation scheme #3','Constipation scheme #3','{}',NULL),
                    ('constipation_scheme_4','Constipation scheme #4','Constipation scheme #4','{}',NULL),
                    ('constipation_scheme_5','Constipation scheme #5','Constipation scheme #5','{}',NULL),
                    ('process_intestine_scheme','Process Intestine Scheme','Process Intestine Scheme','{}',NULL),
                    ('intestine_scheme_one','intestine scheme one','intestine scheme one','{}',NULL),
                    ('intestine_scheme_two','Intestine scheme two','Intestine scheme two','{}',NULL),
                    ('intestine_scheme_three','Intestine scheme tree','Intestine scheme tree','{}',NULL),
                    ('intestine_medical_schema','intestine medical schema','intestine medical schema','{}',NULL),
                    ('campaign_schema','Campaign schema','Campaign schema','{}',NULL)
            SQL);

            $DataBaseAccess->command("CREATE TABLE content_types_fields (
                id integer NOT NULL primary key auto_increment,
                field_id int8 NOT NULL,
                content_type_id integer NOT NULL,
                parent integer NOT NULL,
                weight integer NOT NULL,
                config json DEFAULT '{}' NOT NULL
            )");

            $DataBaseAccess->command(<<<'SQL'
                INSERT INTO content_types_fields (field_id,content_type_id,parent,weight,config) VALUES
                    (3,1,0,0,'{}'),
                    (1,1,0,0,'{}'),
                    (2,1,5,0,'{}'),
                    (2,1,5,0,'{}'),
                    (11,1,0,0,'{}'),
                    (4,2,0,0,'{}'),
                    (3,2,0,0,'{}'),
                    (1,2,0,0,'{}'),
                    (11,2,0,0,'{}'),
                    (6,2,0,0,'{}'),
                    (1,2,0,0,'{}'),
                    (12,2,0,0,'{}'),
                    (9,2,0,0,'{}'),
                    (5,2,0,0,'{}'),
                    (5,5,0,0,'{}'),
                    (2,5,0,0,'{}'),
                    (6,5,0,0,'{}'),
                    (7,5,0,0,'{}'),
                    (4,5,0,0,'{}'),
                    (11,5,0,0,'{}'),
                    (11,5,21,0,'{}'),
                    (11,5,21,0,'{}'),
                    (2,5,22,0,'{}'),
                    (4,5,22,0,'{}'),
                    (2,5,23,0,'{}'),
                    (4,5,23,0,'{}'),
                    (10,5,23,0,'{}'),
                    (2,2,9,0,'{}'),
                    (2,2,9,0,'{}'),
                    (11,3,84,90,'{}'),
                    (6,3,33,110,'{}'),
                    (15,3,31,120,'{}'),
                    (2,3,31,100,'{}'),
                    (16,3,77,300,'{}'),
                    (2,3,77,300,'{}'),
                    (6,3,77,300,'{}'),
                    (7,3,0,300,'{}'),
                    (14,3,0,300,'{}'),
                    (11,3,39,300,'{}'),
                    (2,3,39,300,'{}'),
                    (6,3,39,300,'{}'),
                    (1,3,0,300,'{}'),
                    (7,3,45,300,'{}'),
                    (11,3,0,300,'{}'),
                    (11,3,45,300,'{}'),
                    (2,3,46,300,'{}'),
                    (5,3,46,300,'{}'),
                    (11,3,45,300,'{}'),
                    (4,3,49,300,'{}'),
                    (4,3,0,300,'{}'),
                    (1,3,0,300,'{}'),
                    (11,3,0,300,'{}'),
                    (7,3,45,300,'{}'),
                    (11,3,0,300,'{}'),
                    (11,3,55,300,'{}'),
                    (2,3,56,300,'{}'),
                    (6,3,56,300,'{}'),
                    (5,3,56,300,'{}'),
                    (11,3,0,300,'{}'),
                    (11,4,0,1000,'{}'),
                    (2,4,61,1000,'{}'),
                    (11,4,0,1000,'{}'),
                    (2,4,64,1000,'{}'),
                    (11,4,0,1000,'{}'),
                    (2,4,67,1000,'{}'),
                    (14,6,0,0,'{}'),
                    (14,6,0,0,'{}'),
                    (14,6,0,0,'{}'),
                    (14,6,0,0,'{}'),
                    (6,3,33,300,'{}'),
                    (6,3,33,300,'{}'),
                    (11,3,84,140,'{}'),
                    (11,3,76,300,'{}'),
                    (6,4,79,900,'{}'),
                    (15,4,0,800,'{}'),
                    (6,4,79,1000,'{}'),
                    (6,4,79,1000,'{}'),
                    (1,4,0,1000,'{}'),
                    (7,4,0,1000,'{}'),
                    (11,3,0,100,'{}'),
                    (11,4,0,900,'{}'),
                    (6,1,0,-1,'{}'),
                    (3,10,0,1000,'{}'),
                    (11,10,0,1000,'{}'),
                    (11,10,0,1000,'{}'),
                    (11,10,0,1000,'{}'),
                    (11,10,0,1000,'{}'),
                    (11,10,0,1000,'{}'),
                    (11,10,0,1000,'{}'),
                    (5,10,0,1000,'{}'),
                    (7,10,88,1000,'{}'),
                    (17,10,88,1000,'{}'),
                    (19,10,88,1000,'{}'),
                    (17,10,88,1000,'{}'),
                    (19,10,88,1000,'{}'),
                    (7,10,89,1000,'{}'),
                    (17,10,89,1000,'{}'),
                    (17,10,89,1000,'{}'),
                    (19,10,89,1000,'{}'),
                    (17,10,89,1000,'{}'),
                    (17,10,89,1000,'{}'),
                    (19,10,89,1000,'{}'),
                    (17,10,89,1000,'{}'),
                    (18,10,89,1000,'{}'),
                    (17,10,89,1000,'{}'),
                    (19,10,89,1000,'{}'),
                    (7,10,90,1000,'{}'),
                    (17,10,90,1000,'{}'),
                    (19,10,90,1000,'{}'),
                    (7,10,91,1000,'{}'),
                    (17,10,91,1000,'{}'),
                    (7,10,92,1000,'{}'),
                    (17,10,92,1000,'{}'),
                    (7,10,93,1000,'{}'),
                    (17,10,93,1000,'{}'),
                    (19,10,93,1000,'{}'),
                    (19,10,92,1000,'{}'),
                    (2,11,0,0,'{}'),
                    (6,11,0,2,'{}'),
                    (13,11,0,3,'{}'),
                    (4,11,0,4,'{}'),
                    (6,12,0,1,'{}'),
                    (25,12,0,2,'{}'),
                    (4,12,0,3,'{}'),
                    (19,13,0,1,'{}'),
                    (20,13,0,2,'{}'),
                    (4,13,0,4,'{}'),
                    (26,13,0,3,'{}'),
                    (6,14,0,0,'{}'),
                    (4,14,0,0,'{}'),
                    (6,15,0,0,'{"group": 2}'),
                    (1,15,0,1,'{"group": 2}'),
                    (2,15,0,2,'{"group": 2}'),
                    (1,15,0,4,'{"group": 2}'),
                    (2,15,0,5,'{"group": 1}'),
                    (7,15,0,6,'{"group": 3}'),
                    (21,15,0,7,'{"group": 3}'),
                    (4,15,0,8,'{}'),
                    (6,16,0,0,'{"group": 1}'),
                    (6,16,0,1,'{"group": 1}'),
                    (23,16,0,2,'{"group": 1}'),
                    (22,16,0,3,'{"group": 1}'),
                    (24,16,0,4,'{"group": 1}'),
                    (17,16,0,5,'{"group": 2}'),
                    (1,16,0,6,'{"group": 2}'),
                    (2,16,0,7,'{"group": 2}'),
                    (1,16,0,9,'{"group": 2}'),
                    (6,16,0,10,'{"group": 3}'),
                    (21,16,0,11,'{"group": 3}'),
                    (4,16,0,12,'{}'),
                    (6,11,0,1,'{}'),
                    (6,12,0,0,'{}'),
                    (6,13,0,0,'{}'),
                    (27,15,0,3,'{"group": 2}'),
                    (27,16,0,8,'{"group": 2}'),
                    (17,17,0,0,'{}'),
                    (28,17,0,0,'{}'),
                    (4,17,0,0,'{}'),
                    (6,18,0,0,'{}'),
                    (6,18,0,1,'{}'),
                    (13,18,0,3,'{}'),
                    (4,18,0,4,'{}'),
                    (6,18,0,2,'{}'),
                    (6,19,0,0,'{}'),
                    (6,19,0,1,'{}'),
                    (6,19,0,2,'{}'),
                    (29,19,0,3,'{}'),
                    (4,19,0,6,'{}'),
                    (6,20,0,0,'{"group": 1}'),
                    (6,20,0,1,'{"group": 1}'),
                    (1,20,0,3,'{"group": 2}'),
                    (2,20,0,4,'{"group": 2}'),
                    (27,20,0,5,'{"group": 2, "default": {"url": "", "text": ""}, "placeholder": "Inserte una dirección web valida"}'),
                    (1,20,0,6,'{"group": 2}'),
                    (4,20,0,8,'{"group": 2}'),
                    (17,21,0,0,'{"group": 1}'),
                    (6,21,0,0,'{"group": 1}'),
                    (6,21,0,0,'{"group": 1}'),
                    (30,21,0,0,'{"group": 1}'),
                    (31,21,0,0,'{"group": 1}'),
                    (6,21,0,0,'{"group": 1}'),
                    (32,21,0,0,'{"group": 1}'),
                    (17,21,0,0,'{"group": 2}'),
                    (1,21,0,0,'{"group": 2}'),
                    (2,21,0,0,'{"group": 2}'),
                    (27,21,0,0,'{"group": 2}'),
                    (1,21,0,0,'{"group": 2}'),
                    (6,21,0,0,'{"group": 3}'),
                    (21,21,0,0,'{"group": 3}'),
                    (4,21,0,0,'{"group": 3}'),
                    (26,19,0,4,'{}'),
                    (2,20,0,2,'{"group": 2}'),
                    (33,22,0,0,'{}'),
                    (2,23,0,0,'{}'),
                    (6,23,0,2,'{}'),
                    (15,23,0,3,'[]'),
                    (13,23,0,4,'{}'),
                    (4,23,0,5,'{}'),
                    (6,23,0,1,'{}'),
                    (2,24,0,0,'{}'),
                    (6,24,0,3,'[]'),
                    (6,24,0,2,'{}'),
                    (13,24,0,4,'[]'),
                    (4,24,0,5,'[]'),
                    (6,24,0,1,'{"default": {"url": "", "text": ""}, "placeholder": "Inserte una dirección web valida"}'),
                    (17,25,0,0,'{"group": 1}'),
                    (6,25,0,1,'{"group": 1}'),
                    (30,25,0,2,'{"group": 1}'),
                    (32,25,0,3,'{"group": 1}'),
                    (17,25,0,6,'{"group": 2}'),
                    (1,25,0,7,'{"group": 2}'),
                    (2,25,0,8,'{"group": 2}'),
                    (27,25,0,9,'{"group": 2}'),
                    (1,25,0,10,'{"group": 2}'),
                    (6,25,0,11,'{"group": 3}'),
                    (21,25,0,12,'{"group": 3}'),
                    (4,25,0,13,'{"group": 3}'),
                    (6,26,0,0,'{}'),
                    (1,26,0,1,'{}'),
                    (2,26,0,2,'{}'),
                    (27,26,0,3,'{}'),
                    (1,26,0,4,'{}'),
                    (2,25,0,4,'{"group": 1}'),
                    (32,25,0,5,'{"group": 1}'),
                    (4,26,0,5,'{}'),
                    (34,20,0,7,'{"group": 3}'),
                    (2,27,0,0,'{}'),
                    (2,27,0,0,'{}'),
                    (33,27,0,0,'{}'),
                    (11,27,0,0,'[]'),
                    (11,27,0,0,'{}'),
                    (11,27,0,0,'{}'),
                    (11,27,0,0,'{}'),
                    (5,3,0,0,'{}'),
                    (5,3,0,0,'{}'),
                    (5,3,0,0,'{}')
            SQL);

            $DataBaseAccess->command("CREATE TABLE contents (
                id integer NOT NULL primary key auto_increment,
                content_type_id int8 NOT NULL,
                name varchar(255) NOT NULL,
                path varchar(255) NOT NULL,
                title varchar(255) NOT NULL,
                description text NOT NULL,
                body json DEFAULT '{}' NOT NULL,
                config json DEFAULT '{}' NOT NULL,
                status int8 NOT NULL,
                deleted_at timestamp(0) NULL,
                created_at timestamp(0) default now()  NULL,
                updated_at timestamp(0) default now() NULL,
                CONSTRAINT contents_name_unique UNIQUE (name),
                CONSTRAINT contents_path_unique UNIQUE (path)
            )");

            $DataBaseAccess->command(require __DIR__.'/contents.php');

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
