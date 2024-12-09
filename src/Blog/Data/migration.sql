CREATE TABLE contentnodes (
	id varchar(20) NOT NULL PRIMARY KEY,
	content INTEGER null default null,
	parent varchar(20) NULL default null,
	value TEXT null default null,
	properties TEXT NOT NULL DEFAULT ('{}'),
	type varchar(150),
	weigth INTEGER DEFAULT (100)
);

CREATE TABLE contents (
	id varchar(20) NOT NULL PRIMARY KEY,
	path varchar(255) NULL default null,
    title varchar(255) NULL default null,
	properties TEXT NOT NULL DEFAULT ('{}'),
	active boolean NOT NULL DEFAULT false,
	type varchar(150) not null default 'page',
    CONSTRAINT contents_path_unique UNIQUE (path)
);

CREATE TABLE collections (
	id varchar(20) NOT NULL PRIMARY KEY,
	title varchar(20) NULL default null,
	properties TEXT NOT NULL DEFAULT ('{}'),
	type varchar(150),
	weigth INTEGER DEFAULT (100)
);

CREATE TABLE collections_contents (
	content_id varchar(20) not null,
	collection_id varchar(20) not null,
	weigth INTEGER DEFAULT (100),
    PRIMARY KEY (content_id, collection_id),
    CONSTRAINT collections_contents_content_id_collection_id_unique UNIQUE (content_id, collection_id)
);