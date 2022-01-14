CREATE TABLE lotoplusdb.users (
	user_id INT(10) auto_increment NOT NULL,
	name varchar(40) NOT NULL,
	surname varchar(60) NOT NULL,
	username varchar(30) NOT NULL,
	password varchar(100) NOT NULL,
	email varchar(100) NOT NULL,
	phone INT(9) NOT NULL,
	birth_date DATE NOT NULL,
	profits DECIMAL(10,0) NULL,
	user_img varchar(200) NULL,
	account_type VARCHAR(20) NULL,
	marketing BOOL NULL,
	db_admin BOOL NULL,
	verified BOOL NULL,
	PRIMARY KEY ('user_id')
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;
