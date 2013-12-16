CREATE TABLE user (
	id SERIAL PRIMARY KEY,
	email VARCHAR(255) NOT NULL UNIQUE,
	facebook_token TEXT,
	token VARCHAR(255) NOT NULL,
	token_expiry TIMESTAMP NOT NULL,
	isAdmin BOOLEAN NOT NULL DEFAULT FALSE
);

INSERT INTO user(email, token, longitude) VALUES
	('Boston', 42.358431, -71.059773),
	('Denver', 39.737567, -104.984718),
	('Edmonton, AB', 53.544389, -113.490927),
	('San Diego', 32.715329, -117.157255),
	('Madison', 43.073052, -89.401230),
	('San Francisco', 37.774929, -122.419416),
	('Washington D.C.', 38.907231, -77.036464);


CREATE TABLE tribe (
	id SERIAL PRIMARY KEY,
	name VARCHAR(250) NOT NULL UNIQUE,
	latitude DECIMAL(10,7) NOT NULL,
	longitude DECIMAL(10,7) NOT NULL
);

INSERT INTO tribe(name, latitude, longitude) VALUES
	('Boston', 42.358431, -71.059773),
	('Denver', 39.737567, -104.984718),
	('Edmonton, AB', 53.544389, -113.490927),
	('San Diego', 32.715329, -117.157255),
	('Madison', 43.073052, -89.401230),
	('San Francisco', 37.774929, -122.419416),
	('Washington D.C.', 38.907231, -77.036464);
	
CREATE TABLE tribe_leader (
	id SERIAL PRIMARY KEY,
	facebook_token TEXT,
	isAdmin BOOLEAN,
);

CREATE TABLE workout_location (
	id SERIAL PRIMARY KEY,
	tribe_id BIGINT UNSIGNED NOT NULL,
	name VARCHAR(250) NOT NULL UNIQUE,
	latitude DECIMAL(10,7) NOT NULL,
	longitude DECIMAL(10,7) NOT NULL,
	FOREIGN KEY (tribe_id) REFERENCES tribe(id)
);

INSERT INTO workout_location(tribe_id, name, latitude, longitude) VALUES
	((SELECT id FROM tribe WHERE name='Boston'), 'Harvard Stadium', 42.3673736, -71.1267865),
	((SELECT id FROM tribe WHERE name='Boston'), 'Clement G. Morgan Park (Cambridge)', 42.3649455, -71.0987097),
	((SELECT id FROM tribe WHERE name='Boston'), 'Summit Ave. (Corey Hill)', 42.3422762, -71.1320228),
	((SELECT id FROM tribe WHERE name='Boston'), 'McLaughlin Playground (Mission Hill)', 42.3281560, -71.1028877),
	((SELECT id FROM tribe WHERE name='Boston'), 'Riverside Press Park (Cambridge)', 42.3622094, -71.1153288),
	((SELECT id FROM tribe WHERE name='Boston'), 'Boston Navy Yard', 42.3742831, -71.053118),
	((SELECT id FROM tribe WHERE name='Washington D.C.'), 'Lincoln Memorial', 38.889321, -77.050166);
