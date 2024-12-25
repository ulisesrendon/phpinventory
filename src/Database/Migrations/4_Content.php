<?php

$DataBaseAccess->command('CREATE TABLE config (
	name varchar(100) NOT NULL,
	value TEXT NULL,
	autoload boolean NOT NULL default true,
	CONSTRAINT config_name_unique UNIQUE KEY (name)
)');

$DataBaseAccess->command("INSERT INTO config (name,value) VALUES
	('site_url','http://phpinventory.localhost'),
	('site_name','Stradow'),
	('site_description','Lorem ipsum dolor sit amet'),
	('staticpath','public/static'),
	('assetspath','content/neuralpin/')
");

$DataBaseAccess->command("CREATE TABLE contentnodes (
	id varchar(255) NOT NULL PRIMARY KEY,
	content varchar(255) null default null,
	value TEXT null default null,
	properties json NOT NULL DEFAULT ('{}'),
	type varchar(150),
	parent varchar(255) NULL default null,
	weight INTEGER DEFAULT (100)
)");

$DataBaseAccess->command("CREATE TABLE contents (
	id varchar(255) NOT NULL PRIMARY KEY,
	path varchar(255) NULL default null,
    title varchar(255) NULL default null,
	properties json NOT NULL DEFAULT ('{}'),
	active boolean NOT NULL DEFAULT false,
	type varchar(150) not null default 'page',
	parent varchar(255) NULL default null,
	weight INTEGER DEFAULT (100),
    CONSTRAINT contents_path_unique UNIQUE (path)
)");

$DataBaseAccess->command('CREATE TABLE collections_contents (
	content_id varchar(255) not null,
	collection_id varchar(255) not null,
	weight INTEGER DEFAULT (100),
	parent varchar(255) NULL default null,
    PRIMARY KEY (content_id, collection_id),
    CONSTRAINT collections_contents_content_id_collection_id_unique UNIQUE (content_id, collection_id)
)');

$DataBaseAccess->command("CREATE TABLE collections (
	id varchar(255) NOT NULL PRIMARY KEY,
	title varchar(255) NULL default null,
	properties json NOT NULL DEFAULT ('{}'),
	type varchar(150),
	parent varchar(255) NULL default null,
	weight INTEGER DEFAULT (100)
)");

$DataBaseAccess->command(<<<'SQL'
    INSERT INTO contents (id,path,title,properties,active,type) VALUES
        ('cd101622-dedd-4f79-9607-8d15254b4106','index','Inicio','{}',true,'page'),
        ('4949f55d-7162-432e-8962-1597696ef4ec','acercade','Página acerca de','{}',true,'page'),
        ('6eee6539-7743-4b18-b70a-b9121d801783','contacto','Página de contacto','{}',true,'page'),
        ('d495aefe-2d01-4b8d-995d-af5a377f3f4b','sitemap.xml','Sitemap XML','{"template": "templates/sitemap.template.php","prettify": false}',true,'xml'),
        ('56b4405d-0a99-4c61-8ce1-56bb94705ee3','blog/index','Blog','{}',true,'blog'),
        ('df056abc-dca6-41b1-9662-6b3b47e583ca','blog/article-1','Lorem ipsum','{}',true,'blog'),
        ('ee9c86f2-8e07-4168-9ab2-e04f3d3ebf09','blog/article-2','Lorem ipsum','{}',true,'blog'),
        ('6886548b-a022-4aa0-ab36-6cc43f248a7b','https://facebook.com','Página en Facebook','{}',true,'link'),
        ('e5cd836e-3150-4252-b815-587458767dc7','https://x.com','Página en X','{}',true,'link')
SQL);

$DataBaseAccess->command("INSERT INTO collections_contents(content_id,collection_id,weight) VALUES
    ('cd101622-dedd-4f79-9607-8d15254b4106','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',100),
    ('4949f55d-7162-432e-8962-1597696ef4ec','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',101),
    ('6eee6539-7743-4b18-b70a-b9121d801783','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',103),
    ('56b4405d-0a99-4c61-8ce1-56bb94705ee3','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',102),
    ('6886548b-a022-4aa0-ab36-6cc43f248a7b','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',104),
    ('e5cd836e-3150-4252-b815-587458767dc7','f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11',105),
    ('6886548b-a022-4aa0-ab36-6cc43f248a7b','174f184d-edc2-46d8-a3f6-6e757554900a',100),
    ('e5cd836e-3150-4252-b815-587458767dc7','174f184d-edc2-46d8-a3f6-6e757554900a',100),
    ('df056abc-dca6-41b1-9662-6b3b47e583ca','8287c329-7873-4b4d-b6a8-08dd457b747c',100),
    ('ee9c86f2-8e07-4168-9ab2-e04f3d3ebf09','8287c329-7873-4b4d-b6a8-08dd457b747c',100),
    ('cd101622-dedd-4f79-9607-8d15254b4106','66d1708c-2e67-4a87-8754-383104f7bb17',100),
    ('4949f55d-7162-432e-8962-1597696ef4ec','66d1708c-2e67-4a87-8754-383104f7bb17',100),
    ('6eee6539-7743-4b18-b70a-b9121d801783','66d1708c-2e67-4a87-8754-383104f7bb17',100),
    ('df056abc-dca6-41b1-9662-6b3b47e583ca','66d1708c-2e67-4a87-8754-383104f7bb17',100),
    ('ee9c86f2-8e07-4168-9ab2-e04f3d3ebf09','66d1708c-2e67-4a87-8754-383104f7bb17',100),
    ('df056abc-dca6-41b1-9662-6b3b47e583ca','ac7beaa3-5388-4a83-b24a-4540579761a8',100),
    ('ee9c86f2-8e07-4168-9ab2-e04f3d3ebf09','ac7beaa3-5388-4a83-b24a-4540579761a8',100)
");

$DataBaseAccess->command(<<<'SQL'
    INSERT INTO collections (id,title,properties,type,weight) VALUES
        ('66d1708c-2e67-4a87-8754-383104f7bb17','sitemap','{"template": "templates/sitemap-collection.template.php"}','category',100),
        ('ac7beaa3-5388-4a83-b24a-4540579761a8','blog','{}','category',100),
        ('f596b3c9-a1fa-4d3d-be13-fd7d0ef29d11','main-nav','{"template": "templates/nav.template.php"}','nav',100),
        ('174f184d-edc2-46d8-a3f6-6e757554900a','comunity-nav','{}','nav',100),
        ('8287c329-7873-4b4d-b6a8-08dd457b747c','cat1','{}','category',100),
        ('fd56200e-0a28-40d9-9877-39cf33b31b92','cat2','{}','category',100)
SQL);

$DataBaseAccess->command(require __DIR__.'/sql/content_data.php');
