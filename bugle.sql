DROP DATABASE IF EXISTS bugle;
CREATE DATABASE bugle DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL on bugle.* to 'staff@localhost' identified BY 'password';
USE bugle;

CREATE TABLE wifi_machine(
	id INT NOT NULL PRIMARY KEY,
    ip_address int unsigned NOT NULL UNIQUE,
    wifi_machine_name varchar(20) NOT NULL,
    client_status varchar(10) DEFAULT NULL
);