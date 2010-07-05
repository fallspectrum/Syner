CREATE TABLE pending_users (
	id INTEGER UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	username VARCHAR(15) NOT NULL,
	email VARCHAR(30) UNIQUE NOT NULL,
	password_hash VARCHAR(64) NOT NULL,
	activation_id VARCHAR(64)  NOT NULL 
) CHARACTER SET utf8;

CREATE TABLE users ( 
	id INTEGER UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	username VARCHAR(15) UNIQUE NOT NULL,
	email VARCHAR(30) UNIQUE NOT NULL,
	password_hash VARCHAR(64) NOT NULL,
	full_name VARCHAR(30),
	use_alias BOOLEAN NOT NULL DEFAULT 1, 
	default_location VARCHAR(30),
	privilege TINYINT UNSIGNED NOT NULL DEFAULT 1
) CHARACTER SET utf8;

CREATE TABLE tag_names ( 
	id MEDIUMINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(30) UNIQUE
) CHARACTER SET utf8;

CREATE TABLE tagged_topics ( 
	tag_id MEDIUMINT UNSIGNED NOT NULL,
	topic_id INTEGER UNSIGNED NOT NULL
) CHARACTER SET utf8;

CREATE TABLE locations ( 
        location_abbreviation VARCHAR(30) PRIMARY KEY UNIQUE NOT NULL,   #instead of using nested sets it will be much easier to update if we have a string showing the parents. For example "global-usa-ca" means that this location is in the usa, and its name abbreviation is ca.
	name VARCHAR(30) NOT NULL #name of the location. From the example above, California.
) CHARACTER SET utf8;

CREATE TABLE topics ( 
	id INTEGER UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) UNIQUE,
	date_created TIMESTAMP NOT NULL,
	subscription_count INTEGER NOT NULL,
	for_count INTEGER UNSIGNED NOT NULL,
	against_count INTEGER UNSIGNED NOT NULL,
	location_id VARCHAR(30) NOT NULL
) CHARACTER SET utf8;

CREATE TABLE topic_subscriptions ( 
	topic_id INTEGER UNSIGNED NOT NULL,
	user_id INTEGER UNSIGNED NOT NULL,
	comment VARCHAR(250),
	siding SMALLINT NOT NULL,
	date TIMESTAMP NOT NULL
) CHARACTER SET utf8;

CREATE TABLE solutions ( 
	id INTEGER UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	title VARCHAR(30),
	votes_for INTEGER NOT NULL,
	topic_id INTEGER UNSIGNED NOT NULL
) CHARACTER SET utf8;

CREATE TABLE solution_votes ( 
	solution_id MEDIUMINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	user_id INTEGER NOT NULL
) CHARACTER SET utf8;

#this table is used to hold the current content for each topic page
CREATE TABLE topic_contents (
	topic_id INTEGER UNSIGNED NOT NULL,
	content TEXT NOT NULL,
	user_id INTEGER UNSIGNED NOT NULL
) CHARACTER SET utf8;

CREATE TABLE topic_content_revisions (  
	id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	topic_id INTEGER UNSIGNED NOT NULL,
	content TEXT NOT NULL,
	user_id INTEGER UNSIGNED NOT NULL,
	old_title VARCHAR(100)
) CHARACTER SET utf8;

CREATE TABLE solution_content_revisions (  
	id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	solution_id INTEGER UNSIGNED NOT NULL,
	content TEXT NOT NULL,
	user_id INTEGER UNSIGNED NOT NULL
) CHARACTER SET utf8;

CREATE TABLE ci_sessions (
	session_id varchar(40) DEFAULT "0" NOT NULL,
	ip_address varchar(16) DEFAULT "0" NOT NULL,
	user_agent varchar(50) NOT NULL,
	last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	user_data text NOT NULL,
	PRIMARY KEY (session_id)
) CHARACTER SET utf8;