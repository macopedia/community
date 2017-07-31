CREATE TABLE tx_community_domain_model_relation (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	initiating_user int(11) unsigned DEFAULT '0',
	requested_user int(11) unsigned DEFAULT '0',
	initiation_time int(11) unsigned DEFAULT '0' NOT NULL,
	status int(11) unsigned DEFAULT '1',


	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_community_domain_model_message (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	sender int(11) unsigned DEFAULT '0',
	recipient int(11) unsigned DEFAULT '0',
	tx_community_read tinyint(4) unsigned DEFAULT '0',
	sent tinyint(4) unsigned DEFAULT '0',
	sent_date int(11) unsigned DEFAULT '0' NOT NULL,
	read_date int(11) unsigned DEFAULT '0' NOT NULL,
	subject tinytext,
	message text,
	sender_deleted tinyint(4) unsigned DEFAULT '0',
	recipient_deleted tinyint(4) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE fe_users (
	political_view tinytext,
	religious_view tinytext,
	activities tinytext,
	interests tinytext,
	music tinytext,
	movies tinytext,
	books tinytext,
	quotes tinytext,
	date_of_birth int(11),
	about_me tinytext,
	cellphone varchar(255) DEFAULT '' NOT NULL,
	gender int(11) unsigned DEFAULT '0' NOT NULL,
	profile_image varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_community_domain_model_wallpost (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	sender int(11) unsigned DEFAULT '0',
	recipient int(11) unsigned DEFAULT '0',
	subject varchar(255) DEFAULT '',
	message text,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_community_domain_model_album (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	user int(11) unsigned DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	private tinyint(4) DEFAULT '0' NOT NULL,
	album_type tinyint(4) DEFAULT '0' NOT NULL,
	photos int(11) unsigned DEFAULT '0' NOT NULL,
	main_photo int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_community_domain_model_photo (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	album int(11) unsigned DEFAULT '0' NOT NULL,
	image text NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);