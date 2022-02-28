/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.17 : Database - _wshop_test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE
DATABASE IF NOT EXISTS `gac_tech` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE
`wshop_api`;

/*Table structure for table `produit` */

DROP TABLE IF EXISTS `ticket`;

CREATE TABLE `ticket`
(
    `id`              int(11) unsigned NOT NULL AUTO_INCREMENT,
    `account`         varchar(100) CHARACTER SET utf8 NOT NULL,
    `bill`            varchar(100) CHARACTER SET utf8 NOT NULL,
    `subscriber`      varchar(100) CHARACTER SET utf8 NOT NULL,
    `date`            datetime DEFAULT NULL,
    `hour`            datetime DEFAULT NULL,
    `real_duration`   varchar(100) CHARACTER SET utf8 NOT NULL, ,
    `volume_duration` varchar(100) CHARACTER SET utf8 NOT NULL, ,
    `type`            varchar(100) CHARACTER SET utf8 NOT NULL, ,
    PRIMARY KEY (`id`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

