<?php

$DataBaseAccess->command("CREATE TABLE accounts(
	id integer NOT NULL primary key auto_increment,
	name varchar(255) NOT NULL DEFAULT '',
	data json DEFAULT '{}' NOT NULL,
	deleted_at timestamp NULL,
	created_at timestamp NULL default current_timestamp,
	updated_at timestamp NULL default current_timestamp
)");

$DataBaseAccess->command("CREATE TABLE accountmails (
	id integer NOT NULL auto_increment primary key,
    account_id int8 NOT NULL,
	email varchar(255) NULL,
	verified bool DEFAULT false NOT NULL,
	created_at timestamp default CURRENT_TIMESTAMP NULL,
	CONSTRAINT accountmails_email_unique UNIQUE (email)
)");

$DataBaseAccess->command("CREATE TABLE accountpasswords (
	id integer NOT NULL auto_increment primary key,
	account_id int8 NOT NULL,
	password varchar(255) NOT NULL,
	salt varchar(255) NOT NULL,
	tfa bool NOT NULL,
	created_at timestamp default CURRENT_TIMESTAMP NULL,
	updated_at timestamp default CURRENT_TIMESTAMP NULL,
    CONSTRAINT accountpasswords_account_id_unique UNIQUE (account_id)
)");

$DataBaseAccess->command("CREATE TABLE tokens (
	id integer NOT NULL auto_increment primary key,
	token char(64) NOT NULL,
	type_id int4 NOT NULL,
	created_at timestamp default CURRENT_TIMESTAMP NULL
)");

$DataBaseAccess->command("CREATE TABLE accounts_tokens (
	account_id int8 NOT NULL,
	token_id int8 NOT NULL,
	CONSTRAINT accounts_tokens_account_id_token_id_unique UNIQUE (account_id, token_id)
)");

$DataBaseAccess->command("CREATE TABLE accountsessions (
	id integer NOT NULL auto_increment primary key,
	account_id int8 NOT NULL,
	session char(64) NOT NULL,
	tfa bool NOT NULL,
	device varchar(255) NULL,
	created_at timestamp default CURRENT_TIMESTAMP NULL,
	updated_at timestamp default CURRENT_TIMESTAMP NULL
)");

$DataBaseAccess->command("CREATE TABLE accountgroups (
	id integer NOT NULL primary key auto_increment,
	name varchar(255) NOT NULL,
	description varchar(255) NOT NULL
)");

$DataBaseAccess->command("INSERT INTO accountgroups (name,description) VALUES
	('admin','System administrator'),
	('editor','Editor'),
	('member','Basic registered member'),
	('anonymous','Anonymous user')
");

$DataBaseAccess->command("CREATE TABLE accounts_accountgroups (
	account_id int8 NOT NULL,
	group_id int8 NOT NULL,
	CONSTRAINT accounts_accountgroups_account_id_group_id_unique UNIQUE (account_id, group_id)
)");