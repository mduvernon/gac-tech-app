
DROP DATABASE IF EXISTS gac_tech;
CREATE DATABASE IF NOT EXISTS gac_tech DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE gac_tech;

/*Table structure for table produit */

DROP TABLE IF EXISTS ticket;

CREATE TABLE ticket
(
    id              int(11) unsigned NOT NULL AUTO_INCREMENT,
    account         varchar(100) CHARACTER SET utf8 DEFAULT NULL,
    bill            varchar(100) CHARACTER SET utf8 DEFAULT NULL,
    subscriber      varchar(100) CHARACTER SET utf8 DEFAULT NULL,
    date            datetime DEFAULT NULL,
    hour            datetime DEFAULT NULL,
    real_duration   varchar(100) CHARACTER SET utf8 DEFAULT NULL,
    invoice_duration varchar(100) CHARACTER SET utf8 DEFAULT NULL,
    type            varchar(100) CHARACTER SET utf8 DEFAULT NULL,
    PRIMARY KEY (id)
)
    ENGINE=InnoDB
	AUTO_INCREMENT=1
	DEFAULT CHARSET=utf8mb4
	COLLATE=utf8mb4_general_ci;

