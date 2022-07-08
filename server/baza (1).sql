/*
SQLyog Community
MySQL - 10.4.11-MariaDB : Database - stanovi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`stanovi` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `stanovi`;

/*Table structure for table `kategorija` */

DROP TABLE IF EXISTS `kategorija`;

CREATE TABLE `kategorija` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kategorija` */

insert  into `kategorija`(`id`,`naziv`) values 
(1,'garsonjera'),
(2,'jednosoban'),
(3,'jednoiposoban'),
(4,'dvosoban'),
(5,'trosoban'),
(6,'kuca'),
(7,'vila');

/*Table structure for table `stan` */

DROP TABLE IF EXISTS `stan`;

CREATE TABLE `stan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kvadratura` int(11) DEFAULT NULL,
  `ulica` bigint(20) unsigned DEFAULT NULL,
  `kategorija` bigint(20) unsigned DEFAULT NULL,
  `broj` int(11) DEFAULT NULL,
  `sprat` int(11) DEFAULT NULL,
  `slika` varchar(255) DEFAULT NULL,
  `cena` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ulica` (`ulica`),
  KEY `kategorija` (`kategorija`),
  CONSTRAINT `stan_ibfk_1` FOREIGN KEY (`ulica`) REFERENCES `ulica` (`id`),
  CONSTRAINT `stan_ibfk_2` FOREIGN KEY (`kategorija`) REFERENCES `kategorija` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `stan` */

insert  into `stan`(`id`,`kvadratura`,`ulica`,`kategorija`,`broj`,`sprat`,`slika`,`cena`) values 
(1,78,1,5,5,3,'./img/Capture.PNG',15000.00),
(2,90,4,5,50,3,'./img/Capture.PNG',1200000.00),
(3,32,7,2,50,6,'./img/концептуални модел.PNG',4200.00),
(4,50,1,1,12,8,'./img/zlatibor.jpg',4200.00),
(5,85,1,1,3,8,'./img/primjer.jpg',4200.00);

/*Table structure for table `ulica` */

DROP TABLE IF EXISTS `ulica`;

CREATE TABLE `ulica` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ulica` */

insert  into `ulica`(`id`,`naziv`) values 
(1,'bulevar kralja aleksandra'),
(2,'vojvode stepe'),
(4,'maksima gorkog'),
(5,'bulevar zorana djindjica'),
(6,'nemanjina'),
(7,'Makenzijeva'),
(8,'bulevar oslobodjenja'),
(10,'jove ilica');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
