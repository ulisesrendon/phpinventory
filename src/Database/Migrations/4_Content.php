<?php

$DataBaseAccess->command("CREATE TABLE config (
	name varchar(100) NOT NULL,
	value TEXT NULL,
	CONSTRAINT config_name_unique UNIQUE KEY (name)
)");

$DataBaseAccess->command("INSERT INTO config (name,value) VALUES ('site_url','http://phpinventory.localhost')");

$DataBaseAccess->command("CREATE TABLE contentnodes (
	id varchar(255) NOT NULL PRIMARY KEY,
	content varchar(255) null default null,
	parent varchar(255) NULL default null,
	value TEXT null default null,
	properties TEXT NOT NULL DEFAULT ('{}'),
	type varchar(150),
	weigth INTEGER DEFAULT (100)
)");

$DataBaseAccess->command("CREATE TABLE contents (
	id varchar(255) NOT NULL PRIMARY KEY,
	path varchar(255) NULL default null,
    title varchar(255) NULL default null,
	properties TEXT NOT NULL DEFAULT ('{}'),
	active boolean NOT NULL DEFAULT false,
	type varchar(150) not null default 'page',
    CONSTRAINT contents_path_unique UNIQUE (path)
)");

$DataBaseAccess->command("CREATE TABLE collections_contents (
	content_id varchar(255) not null,
	collection_id varchar(255) not null,
	weigth INTEGER DEFAULT (100),
    PRIMARY KEY (content_id, collection_id),
    CONSTRAINT collections_contents_content_id_collection_id_unique UNIQUE (content_id, collection_id)
)");

$DataBaseAccess->command("CREATE TABLE collections (
	id varchar(255) NOT NULL PRIMARY KEY,
	title varchar(255) NULL default null,
	properties TEXT NOT NULL DEFAULT ('{}'),
	type varchar(150),
	weigth INTEGER DEFAULT (100)
)");

$DataBaseAccess->command("INSERT INTO contents (id,path,title,properties,active,type) VALUES
    ('df056abc-dca6-41b1-9662-6b3b47e583ca','blog/lorem.html','Lorem ipsum','{}',true,'page'),
    ('6eee6539-7743-4b18-b70a-b9121d801783','page/demo.html','Demo page','{}',true,'page'),
    ('6886548b-a022-4aa0-ab36-6cc43f248a7b','https://google.com','Ir a google','{}',true,'link')
");

$DataBaseAccess->command("INSERT INTO collections_contents (content_id,collection_id,weigth) VALUES
    ('df056abc-dca6-41b1-9662-6b3b47e583ca','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',100),
    ('6eee6539-7743-4b18-b70a-b9121d801783','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',100),
    ('6886548b-a022-4aa0-ab36-6cc43f248a7b','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',100),
    ('df056abc-dca6-41b1-9662-6b3b47e583ca','8287c329-7873-4b4d-b6a8-08dd457b747c',100),
    ('6eee6539-7743-4b18-b70a-b9121d801783','8287c329-7873-4b4d-b6a8-08dd457b747c',100)
");

$DataBaseAccess->command(<<<SQL
    INSERT INTO collections (id,title,properties,type,weigth) VALUES
        ('f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11','main-nav','{
        "template": "templates/nav.template.php"
    }','1',100),
        ('8287c329-7873-4b4d-b6a8-08dd457b747c','main-content','{}','2',100),
        ('fd56200e-0a28-40d9-9877-39cf33b31b92','cat1','{}','2',100)
SQL);

$DataBaseAccess->command(require __DIR__ . '/sql/content_data.php');