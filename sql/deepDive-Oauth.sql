CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- auto_increment tells mySQL to number them {1, 2, 3, ...}
	-- not null means the attribute is required!
	profileId BINARY(16) NOT NULL,
	profileImage VARCHAR(128),
	profileOauthToken VARCHAR(64) NOT NULL,
	profileUsername VARCHAR(32) NOT NULL,
	-- to make sure duplicate data cannot exist, create a unique index
	UNIQUE(profileUsername),
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);