/*
SQLyog Ultimate v11.52 (64 bit)
MySQL - 5.5.25 : Database - jc_test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `photo` */

CREATE TABLE `photo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `photo` */

insert  into `photo`(`id`,`title`,`content`) values (1,'photo1',''),(2,'photo2','');

/*Table structure for table `product` */

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`title`,`description`) values (4,'prod1','daada\r\n'),(5,'prod2','dadasdada');

/*Table structure for table `product_category` */

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_ibfk_1` (`parent_id`),
  CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `product_category` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `product_category` */

insert  into `product_category`(`id`,`parent_id`,`title`) values (1,NULL,'all'),(2,1,'garden'),(3,1,'transport'),(4,3,'avto'),(5,3,'moto');

/*Table structure for table `product_has_photo` */

CREATE TABLE `product_has_photo` (
  `product_id` int(11) NOT NULL,
  `photo_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`photo_id`),
  KEY `fk_product_has_photo_photo1_idx` (`photo_id`),
  KEY `fk_product_has_photo_product1_idx` (`product_id`),
  CONSTRAINT `fk_product_has_photo_photo1` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_product_has_photo_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `product_has_photo` */

insert  into `product_has_photo`(`product_id`,`photo_id`) values (4,1),(4,2),(5,2);

/*Table structure for table `product_has_product_category` */

CREATE TABLE `product_has_product_category` (
  `product_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`product_category_id`),
  KEY `fk_product_has_product_category_product_category1_idx` (`product_category_id`),
  KEY `fk_product_has_product_category_product_idx` (`product_id`),
  CONSTRAINT `fk_product_has_product_category_product_category1` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_product_has_product_category_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `product_has_product_category` */

insert  into `product_has_product_category`(`product_id`,`product_category_id`) values (4,2),(4,4),(5,5);

/*Table structure for table `product_has_sale` */

CREATE TABLE `product_has_sale` (
  `product_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`sale_id`),
  KEY `sale_id` (`sale_id`),
  CONSTRAINT `product_has_sale_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `product_has_sale_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `product_has_sale` */

insert  into `product_has_sale`(`product_id`,`sale_id`) values (4,2),(5,2);

/*Table structure for table `sale` */

CREATE TABLE `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `sale` */

insert  into `sale`(`id`,`title`,`content`) values (2,'NewYear','25%');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
