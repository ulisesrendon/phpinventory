<?php

$DataBaseAccess->command("CREATE TABLE fields (
    id integer not null auto_increment primary key,
    type integer NOT NULL,
    name varchar(255) NOT NULL,
    title varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    config json DEFAULT '{}' NOT NULL,
    deleted_at timestamp NULL,
    CONSTRAINT fields_name_unique UNIQUE (name)
)");

$DataBaseAccess->command("CREATE TABLE field_types (
    id integer NOT NULL PRIMARY KEY auto_increment,
    name varchar(255) NOT NULL,
    deleted_at timestamp NULL,
    CONSTRAINT field_types_name_unique UNIQUE (name)
)");

$DataBaseAccess->command("CREATE TABLE content_types (
    id integer NOT NULL primary key auto_increment,
    name varchar(255) NOT NULL,
    title varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    config json DEFAULT '{}' NOT NULL,
    deleted_at timestamp NULL,
    CONSTRAINT content_types_name_unique UNIQUE (name)
)");

$DataBaseAccess->command("CREATE TABLE content_types_fields (
    id integer NOT NULL primary key auto_increment,
    field_id int8 NOT NULL,
    content_type_id integer NOT NULL,
    parent integer NOT NULL,
    weight integer NOT NULL,
    config json DEFAULT '{}' NOT NULL
)");

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
    deleted_at timestamp NULL,
    created_at timestamp default CURRENT_TIMESTAMP  NULL,
    updated_at timestamp default CURRENT_TIMESTAMP NULL,
    CONSTRAINT contents_name_unique UNIQUE (name),
    CONSTRAINT contents_path_unique UNIQUE (path)
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

$DataBaseAccess->command(require __DIR__ . '/sql/content_types.php');
$DataBaseAccess->command(require __DIR__ . '/sql/content_types_fields.php');
$DataBaseAccess->command(require __DIR__ . '/sql/contents.php');
$DataBaseAccess->command(require __DIR__ . '/sql/fields.php');

/*
CREATE TABLE "contentnodes" (
	id varchar(20) NOT NULL PRIMARY KEY,
	content INTEGER null default null,
	parent varchar(20) NULL default null,
	value TEXT null default null,
	properties TEXT NOT NULL DEFAULT ('{}'),
	type varchar(50),
	weigth INTEGER DEFAULT (100)
);
*/