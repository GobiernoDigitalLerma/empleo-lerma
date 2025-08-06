/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.21-21 : Database - proye135_EmpleoLerma
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lerma_empleo` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `lerma_empleo`;

/*Table structure for table `DatosCiudadano` */

DROP TABLE IF EXISTS `DatosCiudadano`;

CREATE TABLE `DatosCiudadano` (
  `id_persona` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genero` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `edo_civil` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lugar_nacimiento` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EntFed` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `municipio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `colonia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CP` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discapacidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `curp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ComSeEnt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto_perfil` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_persona`),
  KEY `datosciudadano_id_foreign` (`id`),
  CONSTRAINT `datosciudadano_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `DatosCiudadano` */

/*Table structure for table `EdoCivil` */

DROP TABLE IF EXISTS `EdoCivil`;

CREATE TABLE `EdoCivil` (
  `IdEdoCivil` int(11) NOT NULL,
  `EdoCivil` varchar(45) NOT NULL,
  PRIMARY KEY (`IdEdoCivil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `EdoCivil` */

insert  into `EdoCivil`(`IdEdoCivil`,`EdoCivil`) values (1,'Soltero(a)'),(2,'Casado(a)'),(3,'Viudo(a)'),(4,'Concubinato');

/*Table structure for table `EntidadFed` */

DROP TABLE IF EXISTS `EntidadFed`;

CREATE TABLE `EntidadFed` (
  `IdEntFed` int(11) NOT NULL,
  `EntFed` varchar(45) NOT NULL,
  PRIMARY KEY (`IdEntFed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `EntidadFed` */

insert  into `EntidadFed`(`IdEntFed`,`EntFed`) values (1,'Aguascalientes'),(2,'Baja California'),(3,'Baja California Sur'),(4,'Campeche'),(5,'Coahuila de Zaragoza'),(6,'Colima'),(7,'Chiapas'),(8,'Chihuahua'),(9,'Ciudad de México'),(10,'Durango'),(11,'Guanajuato'),(12,'Guerrero'),(13,'Hidalgo'),(14,'Jalisco'),(15,'México'),(16,'Michoacán de Ocampo'),(17,'Morelos'),(18,'Nayarit'),(19,'Nuevo León'),(20,'Oaxaca'),(21,'Puebla'),(22,'Querétaro'),(23,'Quintana Roo'),(24,'San Luis Potosí'),(25,'Sinaloa'),(26,'Sonora'),(27,'Tabasco'),(28,'Tamaulipas'),(29,'Tlaxcala'),(30,'Veracruz de Ignacio de la Llave'),(31,'Yucatán'),(32,'Zacatecas');

/*Table structure for table `Escolaridad` */

DROP TABLE IF EXISTS `Escolaridad`;

CREATE TABLE `Escolaridad` (
  `IdEscolaridad` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grado_estudios` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrera_especialidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `situacion_academica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idioma` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dominio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conocimientos_esp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `habilidades_esp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cursos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdEscolaridad`),
  KEY `escolaridad_id_foreign` (`id`),
  CONSTRAINT `escolaridad_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `Escolaridad` */

/*Table structure for table `ExpPuesto` */

DROP TABLE IF EXISTS `ExpPuesto`;

CREATE TABLE `ExpPuesto` (
  `IdExpPuesto` int(11) NOT NULL,
  `ExpPuesto` varchar(45) NOT NULL,
  PRIMARY KEY (`IdExpPuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ExpPuesto` */

insert  into `ExpPuesto`(`IdExpPuesto`,`ExpPuesto`) values (1,'Ninguna'),(2,'6 meses - 1 año'),(3,'1 año - 2 años'),(4,'2 - 3 años'),(5,'3 - 4 años'),(6,'4 - 5 años'),(7,'Más de 5 años');

/*Table structure for table `Motivo` */

DROP TABLE IF EXISTS `Motivo`;

CREATE TABLE `Motivo` (
  `IdMotivo` int(11) NOT NULL,
  `Motivo` varchar(45) NOT NULL,
  PRIMARY KEY (`IdMotivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `Motivo` */

insert  into `Motivo`(`IdMotivo`,`Motivo`) values (1,'Para cambiarse de trabajo'),(2,'Para tener mas de un empleo'),(3,'Nunca ha trabajado'),(4,'Cerró o quebró su fuente de trabajo'),(5,'Ajuste de personal'),(6,'Fue despedido sin causa'),(7,'Se terminó su contrato'),(8,'Se retiró voluntariamente');

/*Table structure for table `Municipio` */

DROP TABLE IF EXISTS `Municipio`;

CREATE TABLE `Municipio` (
  `Municipio` varchar(60) NOT NULL,
  `IdMunicipio` int(11) NOT NULL,
  `EntFed` varchar(60) DEFAULT NULL,
  `IdEntFed` int(11) NOT NULL,
  PRIMARY KEY (`IdMunicipio`),
  KEY `IdEntFed_idx` (`IdEntFed`),
  CONSTRAINT `IdEntFed` FOREIGN KEY (`IdEntFed`) REFERENCES `EntidadFed` (`IdEntFed`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `Municipio` */

insert  into `Municipio`(`Municipio`,`IdMunicipio`,`EntFed`,`IdEntFed`) values ('Aguascalientes',1,'Aguascalientes',1),('Asientos',2,'Aguascalientes',1),('Calvillo',3,'Aguascalientes',1),('Cosío',4,'Aguascalientes',1),('Jesús María',5,'Aguascalientes',1),('Pabellón de Arteaga',6,'Aguascalientes',1),('Rincón de Romos',7,'Aguascalientes',1),('San José de Gracia',8,'Aguascalientes',1),('Tepezalá',9,'Aguascalientes',1),('El Llano',10,'Aguascalientes',1),('San Francisco de los Romo',11,'Aguascalientes',1),('Ensenada',12,'Baja California',2),('Mexicali',13,'Baja California',2),('Tecate',14,'Baja California',2),('Tijuana',15,'Baja California',2),('Playas de Rosarito',16,'Baja California',2),('Comondú',17,'Baja California Sur',3),('Mulegé',18,'Baja California Sur',3),('La Paz',19,'Baja California Sur',3),('Los Cabos',20,'Baja California Sur',3),('Loreto',21,'Baja California Sur',3),('Calkiní',22,'Campeche',4),('Campeche',23,'Campeche',4),('Carmen',24,'Campeche',4),('Champotón',25,'Campeche',4),('Hecelchakán',26,'Campeche',4),('Hopelchén',27,'Campeche',4),('Palizada',28,'Campeche',4),('Tenabo',29,'Campeche',4),('Escárcega',30,'Campeche',4),('Calakmul',31,'Campeche',4),('Candelaria',32,'Campeche',4),('Abasolo',33,'Coahuila de Zaragoza',5),('Acuña',34,'Coahuila de Zaragoza',5),('Allende',35,'Coahuila de Zaragoza',5),('Arteaga',36,'Coahuila de Zaragoza',5),('Candela',37,'Coahuila de Zaragoza',5),('Castaños',38,'Coahuila de Zaragoza',5),('Cuatro Ciénegas',39,'Coahuila de Zaragoza',5),('Escobedo',40,'Coahuila de Zaragoza',5),('Francisco I. Madero',41,'Coahuila de Zaragoza',5),('Frontera',42,'Coahuila de Zaragoza',5),('General Cepeda',43,'Coahuila de Zaragoza',5),('Guerrero',44,'Coahuila de Zaragoza',5),('Hidalgo',45,'Coahuila de Zaragoza',5),('Jiménez',46,'Coahuila de Zaragoza',5),('Juárez',47,'Coahuila de Zaragoza',5),('Lamadrid',48,'Coahuila de Zaragoza',5),('Matamoros',49,'Coahuila de Zaragoza',5),('Monclova',50,'Coahuila de Zaragoza',5),('Morelos',51,'Coahuila de Zaragoza',5),('Múzquiz',52,'Coahuila de Zaragoza',5),('Nadadores',53,'Coahuila de Zaragoza',5),('Nava',54,'Coahuila de Zaragoza',5),('Ocampo',55,'Coahuila de Zaragoza',5),('Parras',56,'Coahuila de Zaragoza',5),('Piedras Negras',57,'Coahuila de Zaragoza',5),('Progreso',58,'Coahuila de Zaragoza',5),('Ramos Arizpe',59,'Coahuila de Zaragoza',5),('Sabinas',60,'Coahuila de Zaragoza',5),('Sacramento',61,'Coahuila de Zaragoza',5),('Saltillo',62,'Coahuila de Zaragoza',5),('San Buenaventura',63,'Coahuila de Zaragoza',5),('San Juan de Sabinas',64,'Coahuila de Zaragoza',5),('San Pedro',65,'Coahuila de Zaragoza',5),('Sierra Mojada',66,'Coahuila de Zaragoza',5),('Torreón',67,'Coahuila de Zaragoza',5),('Viesca',68,'Coahuila de Zaragoza',5),('Villa Unión',69,'Coahuila de Zaragoza',5),('Zaragoza',70,'Coahuila de Zaragoza',5),('Armería',71,'Colima',6),('Colima',72,'Colima',6),('Comala',73,'Colima',6),('Coquimatlán',74,'Colima',6),('Cuauhtémoc',75,'Colima',6),('Ixtlahuacán',76,'Colima',6),('Manzanillo',77,'Colima',6),('Minatitlán',78,'Colima',6),('Tecomán',79,'Colima',6),('Villa de Álvarez',80,'Colima',6),('Acacoyagua',81,'Chiapas',7),('Acala',82,'Chiapas',7),('Acapetahua',83,'Chiapas',7),('Altamirano',84,'Chiapas',7),('Amatán',85,'Chiapas',7),('Amatenango de la Frontera',86,'Chiapas',7),('Amatenango del Valle',87,'Chiapas',7),('Angel Albino Corzo',88,'Chiapas',7),('Arriaga',89,'Chiapas',7),('Bejucal de Ocampo',90,'Chiapas',7),('Bella Vista',91,'Chiapas',7),('Berriozábal',92,'Chiapas',7),('Bochil',93,'Chiapas',7),('El Bosque',94,'Chiapas',7),('Cacahoatán',95,'Chiapas',7),('Catazajá',96,'Chiapas',7),('Cintalapa',97,'Chiapas',7),('Coapilla',98,'Chiapas',7),('Comitán de Domínguez',99,'Chiapas',7),('La Concordia',100,'Chiapas',7),('Copainalá',101,'Chiapas',7),('Chalchihuitán',102,'Chiapas',7),('Chamula',103,'Chiapas',7),('Chanal',104,'Chiapas',7),('Chapultenango',105,'Chiapas',7),('Chenalhó',106,'Chiapas',7),('Chiapa de Corzo',107,'Chiapas',7),('Chiapilla',108,'Chiapas',7),('Chicoasén',109,'Chiapas',7),('Chicomuselo',110,'Chiapas',7),('Chilón',111,'Chiapas',7),('Escuintla',112,'Chiapas',7),('Francisco León',113,'Chiapas',7),('Frontera Comalapa',114,'Chiapas',7),('Frontera Hidalgo',115,'Chiapas',7),('La Grandeza',116,'Chiapas',7),('Huehuetán',117,'Chiapas',7),('Huixtán',118,'Chiapas',7),('Huitiupán',119,'Chiapas',7),('Huixtla',120,'Chiapas',7),('La Independencia',121,'Chiapas',7),('Ixhuatán',122,'Chiapas',7),('Ixtacomitán',123,'Chiapas',7),('Ixtapa',124,'Chiapas',7),('Ixtapangajoya',125,'Chiapas',7),('Jiquipilas',126,'Chiapas',7),('Jitotol',127,'Chiapas',7),('Juárez',128,'Chiapas',7),('Larráinzar',129,'Chiapas',7),('La Libertad',130,'Chiapas',7),('Mapastepec',131,'Chiapas',7),('Las Margaritas',132,'Chiapas',7),('Mazapa de Madero',133,'Chiapas',7),('Mazatán',134,'Chiapas',7),('Metapa',135,'Chiapas',7),('Mitontic',136,'Chiapas',7),('Motozintla',137,'Chiapas',7),('Nicolás Ruíz',138,'Chiapas',7),('Ocosingo',139,'Chiapas',7),('Ocotepec',140,'Chiapas',7),('Ocozocoautla de Espinosa',141,'Chiapas',7),('Ostuacán',142,'Chiapas',7),('Osumacinta',143,'Chiapas',7),('Oxchuc',144,'Chiapas',7),('Palenque',145,'Chiapas',7),('Pantelhó',146,'Chiapas',7),('Pantepec',147,'Chiapas',7),('Pichucalco',148,'Chiapas',7),('Pijijiapan',149,'Chiapas',7),('El Porvenir',150,'Chiapas',7),('Villa Comaltitlán',151,'Chiapas',7),('Pueblo Nuevo Solistahuacán',152,'Chiapas',7),('Rayón',153,'Chiapas',7),('Reforma',154,'Chiapas',7),('Las Rosas',155,'Chiapas',7),('Sabanilla',156,'Chiapas',7),('Salto de Agua',157,'Chiapas',7),('San Cristóbal de las Casas',158,'Chiapas',7),('San Fernando',159,'Chiapas',7),('Siltepec',160,'Chiapas',7),('Simojovel',161,'Chiapas',7),('Sitalá',162,'Chiapas',7),('Socoltenango',163,'Chiapas',7),('Solosuchiapa',164,'Chiapas',7),('Soyaló',165,'Chiapas',7),('Suchiapa',166,'Chiapas',7),('Suchiate',167,'Chiapas',7),('Sunuapa',168,'Chiapas',7),('Tapachula',169,'Chiapas',7),('Tapalapa',170,'Chiapas',7),('Tapilula',171,'Chiapas',7),('Tecpatán',172,'Chiapas',7),('Tenejapa',173,'Chiapas',7),('Teopisca',174,'Chiapas',7),('Tila',175,'Chiapas',7),('Tonalá',176,'Chiapas',7),('Totolapa',177,'Chiapas',7),('La Trinitaria',178,'Chiapas',7),('Tumbalá',179,'Chiapas',7),('Tuxtla Gutiérrez',180,'Chiapas',7),('Tuxtla Chico',181,'Chiapas',7),('Tuzantán',182,'Chiapas',7),('Tzimol',183,'Chiapas',7),('Unión Juárez',184,'Chiapas',7),('Venustiano Carranza',185,'Chiapas',7),('Villa Corzo',186,'Chiapas',7),('Villaflores',187,'Chiapas',7),('Yajalón',188,'Chiapas',7),('San Lucas',189,'Chiapas',7),('Zinacantán',190,'Chiapas',7),('San Juan Cancuc',191,'Chiapas',7),('Aldama',192,'Chiapas',7),('Benemérito de las Américas',193,'Chiapas',7),('Maravilla Tenejapa',194,'Chiapas',7),('Marqués de Comillas',195,'Chiapas',7),('Montecristo de Guerrero',196,'Chiapas',7),('San Andrés Duraznal',197,'Chiapas',7),('Santiago el Pinar',198,'Chiapas',7),('Capitán Luis Ángel Vidal',199,'Chiapas',7),('Rincón Chamula San Pedro',200,'Chiapas',7),('El Parral',201,'Chiapas',7),('Emiliano Zapata',202,'Chiapas',7),('Mezcalapa',203,'Chiapas',7),('Ahumada',204,'Chihuahua',8),('Aldama',205,'Chihuahua',8),('Allende',206,'Chihuahua',8),('Aquiles Serdán',207,'Chihuahua',8),('Ascensión',208,'Chihuahua',8),('Bachíniva',209,'Chihuahua',8),('Balleza',210,'Chihuahua',8),('Batopilas de Manuel Gómez Morín',211,'Chihuahua',8),('Bocoyna',212,'Chihuahua',8),('Buenaventura',213,'Chihuahua',8),('Camargo',214,'Chihuahua',8),('Carichí',215,'Chihuahua',8),('Casas Grandes',216,'Chihuahua',8),('Coronado',217,'Chihuahua',8),('Coyame del Sotol',218,'Chihuahua',8),('La Cruz',219,'Chihuahua',8),('Cuauhtémoc',220,'Chihuahua',8),('Cusihuiriachi',221,'Chihuahua',8),('Chihuahua',222,'Chihuahua',8),('Chínipas',223,'Chihuahua',8),('Delicias',224,'Chihuahua',8),('Dr. Belisario Domínguez',225,'Chihuahua',8),('Galeana',226,'Chihuahua',8),('Santa Isabel',227,'Chihuahua',8),('Gómez Farías',228,'Chihuahua',8),('Gran Morelos',229,'Chihuahua',8),('Guachochi',230,'Chihuahua',8),('Guadalupe',231,'Chihuahua',8),('Guadalupe y Calvo',232,'Chihuahua',8),('Guazapares',233,'Chihuahua',8),('Guerrero',234,'Chihuahua',8),('Hidalgo del Parral',235,'Chihuahua',8),('Huejotitán',236,'Chihuahua',8),('Ignacio Zaragoza',237,'Chihuahua',8),('Janos',238,'Chihuahua',8),('Jiménez',239,'Chihuahua',8),('Juárez',240,'Chihuahua',8),('Julimes',241,'Chihuahua',8),('López',242,'Chihuahua',8),('Madera',243,'Chihuahua',8),('Maguarichi',244,'Chihuahua',8),('Manuel Benavides',245,'Chihuahua',8),('Matachí',246,'Chihuahua',8),('Matamoros',247,'Chihuahua',8),('Meoqui',248,'Chihuahua',8),('Morelos',249,'Chihuahua',8),('Moris',250,'Chihuahua',8),('Namiquipa',251,'Chihuahua',8),('Nonoava',252,'Chihuahua',8),('Nuevo Casas Grandes',253,'Chihuahua',8),('Ocampo',254,'Chihuahua',8),('Ojinaga',255,'Chihuahua',8),('Praxedis G. Guerrero',256,'Chihuahua',8),('Riva Palacio',257,'Chihuahua',8),('Rosales',258,'Chihuahua',8),('Rosario',259,'Chihuahua',8),('San Francisco de Borja',260,'Chihuahua',8),('San Francisco de Conchos',261,'Chihuahua',8),('San Francisco del Oro',262,'Chihuahua',8),('Santa Bárbara',263,'Chihuahua',8),('Satevó',264,'Chihuahua',8),('Saucillo',265,'Chihuahua',8),('Temósachic',266,'Chihuahua',8),('El Tule',267,'Chihuahua',8),('Urique',268,'Chihuahua',8),('Uruachi',269,'Chihuahua',8),('Valle de Zaragoza',270,'Chihuahua',8),('Azcapotzalco',271,'Ciudad de México',9),('Coyoacán',272,'Ciudad de México',9),('Cuajimalpa de Morelos',273,'Ciudad de México',9),('Gustavo A. Madero',274,'Ciudad de México',9),('Iztacalco',275,'Ciudad de México',9),('Iztapalapa',276,'Ciudad de México',9),('La Magdalena Contreras',277,'Ciudad de México',9),('Milpa Alta',278,'Ciudad de México',9),('Álvaro Obregón',279,'Ciudad de México',9),('Tláhuac',280,'Ciudad de México',9),('Tlalpan',281,'Ciudad de México',9),('Xochimilco',282,'Ciudad de México',9),('Benito Juárez',283,'Ciudad de México',9),('Cuauhtémoc',284,'Ciudad de México',9),('Miguel Hidalgo',285,'Ciudad de México',9),('Venustiano Carranza',286,'Ciudad de México',9),('Canatlán',287,'Durango',10),('Canelas',288,'Durango',10),('Coneto de Comonfort',289,'Durango',10),('Cuencamé',290,'Durango',10),('Durango',291,'Durango',10),('General Simón Bolívar',292,'Durango',10),('Gómez Palacio',293,'Durango',10),('Guadalupe Victoria',294,'Durango',10),('Guanaceví',295,'Durango',10),('Hidalgo',296,'Durango',10),('Indé',297,'Durango',10),('Lerdo',298,'Durango',10),('Mapimí',299,'Durango',10),('Mezquital',300,'Durango',10),('Nazas',301,'Durango',10),('Nombre de Dios',302,'Durango',10),('Ocampo',303,'Durango',10),('El Oro',304,'Durango',10),('Otáez',305,'Durango',10),('Pánuco de Coronado',306,'Durango',10),('Peñón Blanco',307,'Durango',10),('Poanas',308,'Durango',10),('Pueblo Nuevo',309,'Durango',10),('Rodeo',310,'Durango',10),('San Bernardo',311,'Durango',10),('San Dimas',312,'Durango',10),('San Juan de Guadalupe',313,'Durango',10),('San Juan del Río',314,'Durango',10),('San Luis del Cordero',315,'Durango',10),('San Pedro del Gallo',316,'Durango',10),('Santa Clara',317,'Durango',10),('Santiago Papasquiaro',318,'Durango',10),('Súchil',319,'Durango',10),('Tamazula',320,'Durango',10),('Tepehuanes',321,'Durango',10),('Tlahualilo',322,'Durango',10),('Topia',323,'Durango',10),('Vicente Guerrero',324,'Durango',10),('Nuevo Ideal',325,'Durango',10),('Abasolo',326,'Guanajuato',11),('Acámbaro',327,'Guanajuato',11),('San Miguel de Allende',328,'Guanajuato',11),('Apaseo el Alto',329,'Guanajuato',11),('Apaseo el Grande',330,'Guanajuato',11),('Atarjea',331,'Guanajuato',11),('Celaya',332,'Guanajuato',11),('Manuel Doblado',333,'Guanajuato',11),('Comonfort',334,'Guanajuato',11),('Coroneo',335,'Guanajuato',11),('Cortazar',336,'Guanajuato',11),('Cuerámaro',337,'Guanajuato',11),('Doctor Mora',338,'Guanajuato',11),('Dolores Hidalgo Cuna de la Independencia Nacional',339,'Guanajuato',11),('Guanajuato',340,'Guanajuato',11),('Huanímaro',341,'Guanajuato',11),('Irapuato',342,'Guanajuato',11),('Jaral del Progreso',343,'Guanajuato',11),('Jerécuaro',344,'Guanajuato',11),('León',345,'Guanajuato',11),('Moroleón',346,'Guanajuato',11),('Ocampo',347,'Guanajuato',11),('Pénjamo',348,'Guanajuato',11),('Pueblo Nuevo',349,'Guanajuato',11),('Purísima del Rincón',350,'Guanajuato',11),('Romita',351,'Guanajuato',11),('Salamanca',352,'Guanajuato',11),('Salvatierra',353,'Guanajuato',11),('San Diego de la Unión',354,'Guanajuato',11),('San Felipe',355,'Guanajuato',11),('San Francisco del Rincón',356,'Guanajuato',11),('San José Iturbide',357,'Guanajuato',11),('San Luis de la Paz',358,'Guanajuato',11),('Santa Catarina',359,'Guanajuato',11),('Santa Cruz de Juventino Rosas',360,'Guanajuato',11),('Santiago Maravatío',361,'Guanajuato',11),('Silao de la Victoria',362,'Guanajuato',11),('Tarandacuao',363,'Guanajuato',11),('Tarimoro',364,'Guanajuato',11),('Tierra Blanca',365,'Guanajuato',11),('Uriangato',366,'Guanajuato',11),('Valle de Santiago',367,'Guanajuato',11),('Victoria',368,'Guanajuato',11),('Villagrán',369,'Guanajuato',11),('Xichú',370,'Guanajuato',11),('Yuriria',371,'Guanajuato',11),('Acapulco de Juárez',372,'Guerrero',12),('Ahuacuotzingo',373,'Guerrero',12),('Ajuchitlán del Progreso',374,'Guerrero',12),('Alcozauca de Guerrero',375,'Guerrero',12),('Alpoyeca',376,'Guerrero',12),('Apaxtla',377,'Guerrero',12),('Arcelia',378,'Guerrero',12),('Atenango del Río',379,'Guerrero',12),('Atlamajalcingo del Monte',380,'Guerrero',12),('Atlixtac',381,'Guerrero',12),('Atoyac de Álvarez',382,'Guerrero',12),('Ayutla de los Libres',383,'Guerrero',12),('Azoyú',384,'Guerrero',12),('Benito Juárez',385,'Guerrero',12),('Buenavista de Cuéllar',386,'Guerrero',12),('Coahuayutla de José María Izazaga',387,'Guerrero',12),('Cocula',388,'Guerrero',12),('Copala',389,'Guerrero',12),('Copalillo',390,'Guerrero',12),('Copanatoyac',391,'Guerrero',12),('Coyuca de Benítez',392,'Guerrero',12),('Coyuca de Catalán',393,'Guerrero',12),('Cuajinicuilapa',394,'Guerrero',12),('Cualác',395,'Guerrero',12),('Cuautepec',396,'Guerrero',12),('Cuetzala del Progreso',397,'Guerrero',12),('Cutzamala de Pinzón',398,'Guerrero',12),('Chilapa de Álvarez',399,'Guerrero',12),('Chilpancingo de los Bravo',400,'Guerrero',12),('Florencio Villarreal',401,'Guerrero',12),('General Canuto A. Neri',402,'Guerrero',12),('General Heliodoro Castillo',403,'Guerrero',12),('Huamuxtitlán',404,'Guerrero',12),('Huitzuco de los Figueroa',405,'Guerrero',12),('Iguala de la Independencia',406,'Guerrero',12),('Igualapa',407,'Guerrero',12),('Ixcateopan de Cuauhtémoc',408,'Guerrero',12),('Zihuatanejo de Azueta',409,'Guerrero',12),('Juan R. Escudero',410,'Guerrero',12),('Leonardo Bravo',411,'Guerrero',12),('Malinaltepec',412,'Guerrero',12),('Mártir de Cuilapan',413,'Guerrero',12),('Metlatónoc',414,'Guerrero',12),('Mochitlán',415,'Guerrero',12),('Olinalá',416,'Guerrero',12),('Ometepec',417,'Guerrero',12),('Pedro Ascencio Alquisiras',418,'Guerrero',12),('Petatlán',419,'Guerrero',12),('Pilcaya',420,'Guerrero',12),('Pungarabato',421,'Guerrero',12),('Quechultenango',422,'Guerrero',12),('San Luis Acatlán',423,'Guerrero',12),('San Marcos',424,'Guerrero',12),('San Miguel Totolapan',425,'Guerrero',12),('Taxco de Alarcón',426,'Guerrero',12),('Tecoanapa',427,'Guerrero',12),('Técpan de Galeana',428,'Guerrero',12),('Teloloapan',429,'Guerrero',12),('Tepecoacuilco de Trujano',430,'Guerrero',12),('Tetipac',431,'Guerrero',12),('Tixtla de Guerrero',432,'Guerrero',12),('Tlacoachistlahuaca',433,'Guerrero',12),('Tlacoapa',434,'Guerrero',12),('Tlalchapa',435,'Guerrero',12),('Tlalixtaquilla de Maldonado',436,'Guerrero',12),('Tlapa de Comonfort',437,'Guerrero',12),('Tlapehuala',438,'Guerrero',12),('La Unión de Isidoro Montes de Oca',439,'Guerrero',12),('Xalpatláhuac',440,'Guerrero',12),('Xochihuehuetlán',441,'Guerrero',12),('Xochistlahuaca',442,'Guerrero',12),('Zapotitlán Tablas',443,'Guerrero',12),('Zirándaro',444,'Guerrero',12),('Zitlala',445,'Guerrero',12),('Eduardo Neri',446,'Guerrero',12),('Acatepec',447,'Guerrero',12),('Marquelia',448,'Guerrero',12),('Cochoapa el Grande',449,'Guerrero',12),('José Joaquín de Herrera',450,'Guerrero',12),('Juchitán',451,'Guerrero',12),('Iliatenco',452,'Guerrero',12),('Acatlán',453,'Hidalgo',13),('Acaxochitlán',454,'Hidalgo',13),('Actopan',455,'Hidalgo',13),('Agua Blanca de Iturbide',456,'Hidalgo',13),('Ajacuba',457,'Hidalgo',13),('Alfajayucan',458,'Hidalgo',13),('Almoloya',459,'Hidalgo',13),('Apan',460,'Hidalgo',13),('El Arenal',461,'Hidalgo',13),('Atitalaquia',462,'Hidalgo',13),('Atlapexco',463,'Hidalgo',13),('Atotonilco el Grande',464,'Hidalgo',13),('Atotonilco de Tula',465,'Hidalgo',13),('Calnali',466,'Hidalgo',13),('Cardonal',467,'Hidalgo',13),('Cuautepec de Hinojosa',468,'Hidalgo',13),('Chapantongo',469,'Hidalgo',13),('Chapulhuacán',470,'Hidalgo',13),('Chilcuautla',471,'Hidalgo',13),('Eloxochitlán',472,'Hidalgo',13),('Emiliano Zapata',473,'Hidalgo',13),('Epazoyucan',474,'Hidalgo',13),('Francisco I. Madero',475,'Hidalgo',13),('Huasca de Ocampo',476,'Hidalgo',13),('Huautla',477,'Hidalgo',13),('Huazalingo',478,'Hidalgo',13),('Huehuetla',479,'Hidalgo',13),('Huejutla de Reyes',480,'Hidalgo',13),('Huichapan',481,'Hidalgo',13),('Ixmiquilpan',482,'Hidalgo',13),('Jacala de Ledezma',483,'Hidalgo',13),('Jaltocán',484,'Hidalgo',13),('Juárez Hidalgo',485,'Hidalgo',13),('Lolotla',486,'Hidalgo',13),('Metepec',487,'Hidalgo',13),('San Agustín Metzquititlán',488,'Hidalgo',13),('Metztitlán',489,'Hidalgo',13),('Mineral del Chico',490,'Hidalgo',13),('Mineral del Monte',491,'Hidalgo',13),('La Misión',492,'Hidalgo',13),('Mixquiahuala de Juárez',493,'Hidalgo',13),('Molango de Escamilla',494,'Hidalgo',13),('Nicolás Flores',495,'Hidalgo',13),('Nopala de Villagrán',496,'Hidalgo',13),('Omitlán de Juárez',497,'Hidalgo',13),('San Felipe Orizatlán',498,'Hidalgo',13),('Pacula',499,'Hidalgo',13),('Pachuca de Soto',500,'Hidalgo',13),('Pisaflores',501,'Hidalgo',13),('Progreso de Obregón',502,'Hidalgo',13),('Mineral de la Reforma',503,'Hidalgo',13),('San Agustín Tlaxiaca',504,'Hidalgo',13),('San Bartolo Tutotepec',505,'Hidalgo',13),('San Salvador',506,'Hidalgo',13),('Santiago de Anaya',507,'Hidalgo',13),('Santiago Tulantepec de Lugo Guerrero',508,'Hidalgo',13),('Singuilucan',509,'Hidalgo',13),('Tasquillo',510,'Hidalgo',13),('Tecozautla',511,'Hidalgo',13),('Tenango de Doria',512,'Hidalgo',13),('Tepeapulco',513,'Hidalgo',13),('Tepehuacán de Guerrero',514,'Hidalgo',13),('Tepeji del Río de Ocampo',515,'Hidalgo',13),('Tepetitlán',516,'Hidalgo',13),('Tetepango',517,'Hidalgo',13),('Villa de Tezontepec',518,'Hidalgo',13),('Tezontepec de Aldama',519,'Hidalgo',13),('Tianguistengo',520,'Hidalgo',13),('Tizayuca',521,'Hidalgo',13),('Tlahuelilpan',522,'Hidalgo',13),('Tlahuiltepa',523,'Hidalgo',13),('Tlanalapa',524,'Hidalgo',13),('Tlanchinol',525,'Hidalgo',13),('Tlaxcoapan',526,'Hidalgo',13),('Tolcayuca',527,'Hidalgo',13),('Tula de Allende',528,'Hidalgo',13),('Tulancingo de Bravo',529,'Hidalgo',13),('Xochiatipan',530,'Hidalgo',13),('Xochicoatlán',531,'Hidalgo',13),('Yahualica',532,'Hidalgo',13),('Zacualtipán de Ángeles',533,'Hidalgo',13),('Zapotlán de Juárez',534,'Hidalgo',13),('Zempoala',535,'Hidalgo',13),('Zimapán',536,'Hidalgo',13),('Acatic',537,'Jalisco',14),('Acatlán de Juárez',538,'Jalisco',14),('Ahualulco de Mercado',539,'Jalisco',14),('Amacueca',540,'Jalisco',14),('Amatitán',541,'Jalisco',14),('Ameca',542,'Jalisco',14),('San Juanito de Escobedo',543,'Jalisco',14),('Arandas',544,'Jalisco',14),('El Arenal',545,'Jalisco',14),('Atemajac de Brizuela',546,'Jalisco',14),('Atengo',547,'Jalisco',14),('Atenguillo',548,'Jalisco',14),('Atotonilco el Alto',549,'Jalisco',14),('Atoyac',550,'Jalisco',14),('Autlán de Navarro',551,'Jalisco',14),('Ayotlán',552,'Jalisco',14),('Ayutla',553,'Jalisco',14),('La Barca',554,'Jalisco',14),('Bolaños',555,'Jalisco',14),('Cabo Corrientes',556,'Jalisco',14),('Casimiro Castillo',557,'Jalisco',14),('Cihuatlán',558,'Jalisco',14),('Zapotlán el Grande',559,'Jalisco',14),('Cocula',560,'Jalisco',14),('Colotlán',561,'Jalisco',14),('Concepción de Buenos Aires',562,'Jalisco',14),('Cuautitlán de García Barragán',563,'Jalisco',14),('Cuautla',564,'Jalisco',14),('Cuquío',565,'Jalisco',14),('Chapala',566,'Jalisco',14),('Chimaltitán',567,'Jalisco',14),('Chiquilistlán',568,'Jalisco',14),('Degollado',569,'Jalisco',14),('Ejutla',570,'Jalisco',14),('Encarnación de Díaz',571,'Jalisco',14),('Etzatlán',572,'Jalisco',14),('El Grullo',573,'Jalisco',14),('Guachinango',574,'Jalisco',14),('Guadalajara',575,'Jalisco',14),('Hostotipaquillo',576,'Jalisco',14),('Huejúcar',577,'Jalisco',14),('Huejuquilla el Alto',578,'Jalisco',14),('La Huerta',579,'Jalisco',14),('Ixtlahuacán de los Membrillos',580,'Jalisco',14),('Ixtlahuacán del Río',581,'Jalisco',14),('Jalostotitlán',582,'Jalisco',14),('Jamay',583,'Jalisco',14),('Jesús María',584,'Jalisco',14),('Jilotlán de los Dolores',585,'Jalisco',14),('Jocotepec',586,'Jalisco',14),('Juanacatlán',587,'Jalisco',14),('Juchitlán',588,'Jalisco',14),('Lagos de Moreno',589,'Jalisco',14),('El Limón',590,'Jalisco',14),('Magdalena',591,'Jalisco',14),('Santa María del Oro',592,'Jalisco',14),('La Manzanilla de la Paz',593,'Jalisco',14),('Mascota',594,'Jalisco',14),('Mazamitla',595,'Jalisco',14),('Mexticacán',596,'Jalisco',14),('Mezquitic',597,'Jalisco',14),('Mixtlán',598,'Jalisco',14),('Ocotlán',599,'Jalisco',14),('Ojuelos de Jalisco',600,'Jalisco',14),('Pihuamo',601,'Jalisco',14),('Poncitlán',602,'Jalisco',14),('Puerto Vallarta',603,'Jalisco',14),('Villa Purificación',604,'Jalisco',14),('Quitupan',605,'Jalisco',14),('El Salto',606,'Jalisco',14),('San Cristóbal de la Barranca',607,'Jalisco',14),('San Diego de Alejandría',608,'Jalisco',14),('San Juan de los Lagos',609,'Jalisco',14),('San Julián',610,'Jalisco',14),('San Marcos',611,'Jalisco',14),('San Martín de Bolaños',612,'Jalisco',14),('San Martín Hidalgo',613,'Jalisco',14),('San Miguel el Alto',614,'Jalisco',14),('Gómez Farías',615,'Jalisco',14),('San Sebastián del Oeste',616,'Jalisco',14),('Santa María de los Ángeles',617,'Jalisco',14),('Sayula',618,'Jalisco',14),('Tala',619,'Jalisco',14),('Talpa de Allende',620,'Jalisco',14),('Tamazula de Gordiano',621,'Jalisco',14),('Tapalpa',622,'Jalisco',14),('Tecalitlán',623,'Jalisco',14),('Tecolotlán',624,'Jalisco',14),('Techaluta de Montenegro',625,'Jalisco',14),('Tenamaxtlán',626,'Jalisco',14),('Teocaltiche',627,'Jalisco',14),('Teocuitatlán de Corona',628,'Jalisco',14),('Tepatitlán de Morelos',629,'Jalisco',14),('Tequila',630,'Jalisco',14),('Teuchitlán',631,'Jalisco',14),('Tizapán el Alto',632,'Jalisco',14),('Tlajomulco de Zúñiga',633,'Jalisco',14),('San Pedro Tlaquepaque',634,'Jalisco',14),('Tolimán',635,'Jalisco',14),('Tomatlán',636,'Jalisco',14),('Tonalá',637,'Jalisco',14),('Tonaya',638,'Jalisco',14),('Tonila',639,'Jalisco',14),('Totatiche',640,'Jalisco',14),('Tototlán',641,'Jalisco',14),('Tuxcacuesco',642,'Jalisco',14),('Tuxcueca',643,'Jalisco',14),('Tuxpan',644,'Jalisco',14),('Unión de San Antonio',645,'Jalisco',14),('Unión de Tula',646,'Jalisco',14),('Valle de Guadalupe',647,'Jalisco',14),('Valle de Juárez',648,'Jalisco',14),('San Gabriel',649,'Jalisco',14),('Villa Corona',650,'Jalisco',14),('Villa Guerrero',651,'Jalisco',14),('Villa Hidalgo',652,'Jalisco',14),('Cañadas de Obregón',653,'Jalisco',14),('Yahualica de González Gallo',654,'Jalisco',14),('Zacoalco de Torres',655,'Jalisco',14),('Zapopan',656,'Jalisco',14),('Zapotiltic',657,'Jalisco',14),('Zapotitlán de Vadillo',658,'Jalisco',14),('Zapotlán del Rey',659,'Jalisco',14),('Zapotlanejo',660,'Jalisco',14),('San Ignacio Cerro Gordo',661,'Jalisco',14),('Acambay de Ruíz Castañeda',662,'México',15),('Acolman',663,'México',15),('Aculco',664,'México',15),('Almoloya de Alquisiras',665,'México',15),('Almoloya de Juárez',666,'México',15),('Almoloya del Río',667,'México',15),('Amanalco',668,'México',15),('Amatepec',669,'México',15),('Amecameca',670,'México',15),('Apaxco',671,'México',15),('Atenco',672,'México',15),('Atizapán',673,'México',15),('Atizapán de Zaragoza',674,'México',15),('Atlacomulco',675,'México',15),('Atlautla',676,'México',15),('Axapusco',677,'México',15),('Ayapango',678,'México',15),('Calimaya',679,'México',15),('Capulhuac',680,'México',15),('Coacalco de Berriozábal',681,'México',15),('Coatepec Harinas',682,'México',15),('Cocotitlán',683,'México',15),('Coyotepec',684,'México',15),('Cuautitlán',685,'México',15),('Chalco',686,'México',15),('Chapa de Mota',687,'México',15),('Chapultepec',688,'México',15),('Chiautla',689,'México',15),('Chicoloapan',690,'México',15),('Chiconcuac',691,'México',15),('Chimalhuacán',692,'México',15),('Donato Guerra',693,'México',15),('Ecatepec de Morelos',694,'México',15),('Ecatzingo',695,'México',15),('Huehuetoca',696,'México',15),('Hueypoxtla',697,'México',15),('Huixquilucan',698,'México',15),('Isidro Fabela',699,'México',15),('Ixtapaluca',700,'México',15),('Ixtapan de la Sal',701,'México',15),('Ixtapan del Oro',702,'México',15),('Ixtlahuaca',703,'México',15),('Xalatlaco',704,'México',15),('Jaltenco',705,'México',15),('Jilotepec',706,'México',15),('Jilotzingo',707,'México',15),('Jiquipilco',708,'México',15),('Jocotitlán',709,'México',15),('Joquicingo',710,'México',15),('Juchitepec',711,'México',15),('Lerma',712,'México',15),('Malinalco',713,'México',15),('Melchor Ocampo',714,'México',15),('Metepec',715,'México',15),('Mexicaltzingo',716,'México',15),('Morelos',717,'México',15),('Naucalpan de Juárez',718,'México',15),('Nezahualcóyotl',719,'México',15),('Nextlalpan',720,'México',15),('Nicolás Romero',721,'México',15),('Nopaltepec',722,'México',15),('Ocoyoacac',723,'México',15),('Ocuilan',724,'México',15),('El Oro',725,'México',15),('Otumba',726,'México',15),('Otzoloapan',727,'México',15),('Otzolotepec',728,'México',15),('Ozumba',729,'México',15),('Papalotla',730,'México',15),('La Paz',731,'México',15),('Polotitlán',732,'México',15),('Rayón',733,'México',15),('San Antonio la Isla',734,'México',15),('San Felipe del Progreso',735,'México',15),('San Martín de las Pirámides',736,'México',15),('San Mateo Atenco',737,'México',15),('San Simón de Guerrero',738,'México',15),('Santo Tomás',739,'México',15),('Soyaniquilpan de Juárez',740,'México',15),('Sultepec',741,'México',15),('Tecámac',742,'México',15),('Tejupilco',743,'México',15),('Temamatla',744,'México',15),('Temascalapa',745,'México',15),('Temascalcingo',746,'México',15),('Temascaltepec',747,'México',15),('Temoaya',748,'México',15),('Tenancingo',749,'México',15),('Tenango del Aire',750,'México',15),('Tenango del Valle',751,'México',15),('Teoloyucan',752,'México',15),('Teotihuacán',753,'México',15),('Tepetlaoxtoc',754,'México',15),('Tepetlixpa',755,'México',15),('Tepotzotlán',756,'México',15),('Tequixquiac',757,'México',15),('Texcaltitlán',758,'México',15),('Texcalyacac',759,'México',15),('Texcoco',760,'México',15),('Tezoyuca',761,'México',15),('Tianguistenco',762,'México',15),('Timilpan',763,'México',15),('Tlalmanalco',764,'México',15),('Tlalnepantla de Baz',765,'México',15),('Tlatlaya',766,'México',15),('Toluca',767,'México',15),('Tonatico',768,'México',15),('Tultepec',769,'México',15),('Tultitlán',770,'México',15),('Valle de Bravo',771,'México',15),('Villa de Allende',772,'México',15),('Villa del Carbón',773,'México',15),('Villa Guerrero',774,'México',15),('Villa Victoria',775,'México',15),('Xonacatlán',776,'México',15),('Zacazonapan',777,'México',15),('Zacualpan',778,'México',15),('Zinacantepec',779,'México',15),('Zumpahuacán',780,'México',15),('Zumpango',781,'México',15),('Cuautitlán Izcalli',782,'México',15),('Valle de Chalco Solidaridad',783,'México',15),('Luvianos',784,'México',15),('San José del Rincón',785,'México',15),('Tonanitla',786,'México',15),('Acuitzio',787,'Michoacán de Ocampo',16),('Aguililla',788,'Michoacán de Ocampo',16),('Álvaro Obregón',789,'Michoacán de Ocampo',16),('Angamacutiro',790,'Michoacán de Ocampo',16),('Angangueo',791,'Michoacán de Ocampo',16),('Apatzingán',792,'Michoacán de Ocampo',16),('Aporo',793,'Michoacán de Ocampo',16),('Aquila',794,'Michoacán de Ocampo',16),('Ario',795,'Michoacán de Ocampo',16),('Arteaga',796,'Michoacán de Ocampo',16),('Briseñas',797,'Michoacán de Ocampo',16),('Buenavista',798,'Michoacán de Ocampo',16),('Carácuaro',799,'Michoacán de Ocampo',16),('Coahuayana',800,'Michoacán de Ocampo',16),('Coalcomán de Vázquez Pallares',801,'Michoacán de Ocampo',16),('Coeneo',802,'Michoacán de Ocampo',16),('Contepec',803,'Michoacán de Ocampo',16),('Copándaro',804,'Michoacán de Ocampo',16),('Cotija',805,'Michoacán de Ocampo',16),('Cuitzeo',806,'Michoacán de Ocampo',16),('Charapan',807,'Michoacán de Ocampo',16),('Charo',808,'Michoacán de Ocampo',16),('Chavinda',809,'Michoacán de Ocampo',16),('Cherán',810,'Michoacán de Ocampo',16),('Chilchota',811,'Michoacán de Ocampo',16),('Chinicuila',812,'Michoacán de Ocampo',16),('Chucándiro',813,'Michoacán de Ocampo',16),('Churintzio',814,'Michoacán de Ocampo',16),('Churumuco',815,'Michoacán de Ocampo',16),('Ecuandureo',816,'Michoacán de Ocampo',16),('Epitacio Huerta',817,'Michoacán de Ocampo',16),('Erongarícuaro',818,'Michoacán de Ocampo',16),('Gabriel Zamora',819,'Michoacán de Ocampo',16),('Hidalgo',820,'Michoacán de Ocampo',16),('La Huacana',821,'Michoacán de Ocampo',16),('Huandacareo',822,'Michoacán de Ocampo',16),('Huaniqueo',823,'Michoacán de Ocampo',16),('Huetamo',824,'Michoacán de Ocampo',16),('Huiramba',825,'Michoacán de Ocampo',16),('Indaparapeo',826,'Michoacán de Ocampo',16),('Irimbo',827,'Michoacán de Ocampo',16),('Ixtlán',828,'Michoacán de Ocampo',16),('Jacona',829,'Michoacán de Ocampo',16),('Jiménez',830,'Michoacán de Ocampo',16),('Jiquilpan',831,'Michoacán de Ocampo',16),('Juárez',832,'Michoacán de Ocampo',16),('Jungapeo',833,'Michoacán de Ocampo',16),('Lagunillas',834,'Michoacán de Ocampo',16),('Madero',835,'Michoacán de Ocampo',16),('Maravatío',836,'Michoacán de Ocampo',16),('Marcos Castellanos',837,'Michoacán de Ocampo',16),('Lázaro Cárdenas',838,'Michoacán de Ocampo',16),('Morelia',839,'Michoacán de Ocampo',16),('Morelos',840,'Michoacán de Ocampo',16),('Múgica',841,'Michoacán de Ocampo',16),('Nahuatzen',842,'Michoacán de Ocampo',16),('Nocupétaro',843,'Michoacán de Ocampo',16),('Nuevo Parangaricutiro',844,'Michoacán de Ocampo',16),('Nuevo Urecho',845,'Michoacán de Ocampo',16),('Numarán',846,'Michoacán de Ocampo',16),('Ocampo',847,'Michoacán de Ocampo',16),('Pajacuarán',848,'Michoacán de Ocampo',16),('Panindícuaro',849,'Michoacán de Ocampo',16),('Parácuaro',850,'Michoacán de Ocampo',16),('Paracho',851,'Michoacán de Ocampo',16),('Pátzcuaro',852,'Michoacán de Ocampo',16),('Penjamillo',853,'Michoacán de Ocampo',16),('Peribán',854,'Michoacán de Ocampo',16),('La Piedad',855,'Michoacán de Ocampo',16),('Purépero',856,'Michoacán de Ocampo',16),('Puruándiro',857,'Michoacán de Ocampo',16),('Queréndaro',858,'Michoacán de Ocampo',16),('Quiroga',859,'Michoacán de Ocampo',16),('Cojumatlán de Régules',860,'Michoacán de Ocampo',16),('Los Reyes',861,'Michoacán de Ocampo',16),('Sahuayo',862,'Michoacán de Ocampo',16),('San Lucas',863,'Michoacán de Ocampo',16),('Santa Ana Maya',864,'Michoacán de Ocampo',16),('Salvador Escalante',865,'Michoacán de Ocampo',16),('Senguio',866,'Michoacán de Ocampo',16),('Susupuato',867,'Michoacán de Ocampo',16),('Tacámbaro',868,'Michoacán de Ocampo',16),('Tancítaro',869,'Michoacán de Ocampo',16),('Tangamandapio',870,'Michoacán de Ocampo',16),('Tangancícuaro',871,'Michoacán de Ocampo',16),('Tanhuato',872,'Michoacán de Ocampo',16),('Taretan',873,'Michoacán de Ocampo',16),('Tarímbaro',874,'Michoacán de Ocampo',16),('Tepalcatepec',875,'Michoacán de Ocampo',16),('Tingambato',876,'Michoacán de Ocampo',16),('Tingüindín',877,'Michoacán de Ocampo',16),('Tiquicheo de Nicolás Romero',878,'Michoacán de Ocampo',16),('Tlalpujahua',879,'Michoacán de Ocampo',16),('Tlazazalca',880,'Michoacán de Ocampo',16),('Tocumbo',881,'Michoacán de Ocampo',16),('Tumbiscatío',882,'Michoacán de Ocampo',16),('Turicato',883,'Michoacán de Ocampo',16),('Tuxpan',884,'Michoacán de Ocampo',16),('Tuzantla',885,'Michoacán de Ocampo',16),('Tzintzuntzan',886,'Michoacán de Ocampo',16),('Tzitzio',887,'Michoacán de Ocampo',16),('Uruapan',888,'Michoacán de Ocampo',16),('Venustiano Carranza',889,'Michoacán de Ocampo',16),('Villamar',890,'Michoacán de Ocampo',16),('Vista Hermosa',891,'Michoacán de Ocampo',16),('Yurécuaro',892,'Michoacán de Ocampo',16),('Zacapu',893,'Michoacán de Ocampo',16),('Zamora',894,'Michoacán de Ocampo',16),('Zináparo',895,'Michoacán de Ocampo',16),('Zinapécuaro',896,'Michoacán de Ocampo',16),('Ziracuaretiro',897,'Michoacán de Ocampo',16),('Zitácuaro',898,'Michoacán de Ocampo',16),('José Sixto Verduzco',899,'Michoacán de Ocampo',16),('Amacuzac',900,'Morelos',17),('Atlatlahucan',901,'Morelos',17),('Axochiapan',902,'Morelos',17),('Ayala',903,'Morelos',17),('Coatlán del Río',904,'Morelos',17),('Cuautla',905,'Morelos',17),('Cuernavaca',906,'Morelos',17),('Emiliano Zapata',907,'Morelos',17),('Huitzilac',908,'Morelos',17),('Jantetelco',909,'Morelos',17),('Jiutepec',910,'Morelos',17),('Jojutla',911,'Morelos',17),('Jonacatepec de Leandro Valle',912,'Morelos',17),('Mazatepec',913,'Morelos',17),('Miacatlán',914,'Morelos',17),('Ocuituco',915,'Morelos',17),('Puente de Ixtla',916,'Morelos',17),('Temixco',917,'Morelos',17),('Tepalcingo',918,'Morelos',17),('Tepoztlán',919,'Morelos',17),('Tetecala',920,'Morelos',17),('Tetela del Volcán',921,'Morelos',17),('Tlalnepantla',922,'Morelos',17),('Tlaltizapán de Zapata',923,'Morelos',17),('Tlaquiltenango',924,'Morelos',17),('Tlayacapan',925,'Morelos',17),('Totolapan',926,'Morelos',17),('Xochitepec',927,'Morelos',17),('Yautepec',928,'Morelos',17),('Yecapixtla',929,'Morelos',17),('Zacatepec',930,'Morelos',17),('Zacualpan de Amilpas',931,'Morelos',17),('Temoac',932,'Morelos',17),('Acaponeta',933,'Nayarit',18),('Ahuacatlán',934,'Nayarit',18),('Amatlán de Cañas',935,'Nayarit',18),('Compostela',936,'Nayarit',18),('Huajicori',937,'Nayarit',18),('Ixtlán del Río',938,'Nayarit',18),('Jala',939,'Nayarit',18),('Xalisco',940,'Nayarit',18),('Del Nayar',941,'Nayarit',18),('Rosamorada',942,'Nayarit',18),('Ruíz',943,'Nayarit',18),('San Blas',944,'Nayarit',18),('San Pedro Lagunillas',945,'Nayarit',18),('Santa María del Oro',946,'Nayarit',18),('Santiago Ixcuintla',947,'Nayarit',18),('Tecuala',948,'Nayarit',18),('Tepic',949,'Nayarit',18),('Tuxpan',950,'Nayarit',18),('La Yesca',951,'Nayarit',18),('Bahía de Banderas',952,'Nayarit',18),('Abasolo',953,'Nuevo León',19),('Agualeguas',954,'Nuevo León',19),('Los Aldamas',955,'Nuevo León',19),('Allende',956,'Nuevo León',19),('Anáhuac',957,'Nuevo León',19),('Apodaca',958,'Nuevo León',19),('Aramberri',959,'Nuevo León',19),('Bustamante',960,'Nuevo León',19),('Cadereyta Jiménez',961,'Nuevo León',19),('El Carmen',962,'Nuevo León',19),('Cerralvo',963,'Nuevo León',19),('Ciénega de Flores',964,'Nuevo León',19),('China',965,'Nuevo León',19),('Doctor Arroyo',966,'Nuevo León',19),('Doctor Coss',967,'Nuevo León',19),('Doctor González',968,'Nuevo León',19),('Galeana',969,'Nuevo León',19),('García',970,'Nuevo León',19),('San Pedro Garza García',971,'Nuevo León',19),('General Bravo',972,'Nuevo León',19),('General Escobedo',973,'Nuevo León',19),('General Terán',974,'Nuevo León',19),('General Treviño',975,'Nuevo León',19),('General Zaragoza',976,'Nuevo León',19),('General Zuazua',977,'Nuevo León',19),('Guadalupe',978,'Nuevo León',19),('Los Herreras',979,'Nuevo León',19),('Higueras',980,'Nuevo León',19),('Hualahuises',981,'Nuevo León',19),('Iturbide',982,'Nuevo León',19),('Juárez',983,'Nuevo León',19),('Lampazos de Naranjo',984,'Nuevo León',19),('Linares',985,'Nuevo León',19),('Marín',986,'Nuevo León',19),('Melchor Ocampo',987,'Nuevo León',19),('Mier y Noriega',988,'Nuevo León',19),('Mina',989,'Nuevo León',19),('Montemorelos',990,'Nuevo León',19),('Monterrey',991,'Nuevo León',19),('Parás',992,'Nuevo León',19),('Pesquería',993,'Nuevo León',19),('Los Ramones',994,'Nuevo León',19),('Rayones',995,'Nuevo León',19),('Sabinas Hidalgo',996,'Nuevo León',19),('Salinas Victoria',997,'Nuevo León',19),('San Nicolás de los Garza',998,'Nuevo León',19),('Hidalgo',999,'Nuevo León',19),('Santa Catarina',1000,'Nuevo León',19),('Santiago',1001,'Nuevo León',19),('Vallecillo',1002,'Nuevo León',19),('Villaldama',1003,'Nuevo León',19),('Abejones',1004,'Oaxaca',20),('Acatlán de Pérez Figueroa',1005,'Oaxaca',20),('Asunción Cacalotepec',1006,'Oaxaca',20),('Asunción Cuyotepeji',1007,'Oaxaca',20),('Asunción Ixtaltepec',1008,'Oaxaca',20),('Asunción Nochixtlán',1009,'Oaxaca',20),('Asunción Ocotlán',1010,'Oaxaca',20),('Asunción Tlacolulita',1011,'Oaxaca',20),('Ayotzintepec',1012,'Oaxaca',20),('El Barrio de la Soledad',1013,'Oaxaca',20),('Calihualá',1014,'Oaxaca',20),('Candelaria Loxicha',1015,'Oaxaca',20),('Ciénega de Zimatlán',1016,'Oaxaca',20),('Ciudad Ixtepec',1017,'Oaxaca',20),('Coatecas Altas',1018,'Oaxaca',20),('Coicoyán de las Flores',1019,'Oaxaca',20),('La Compañía',1020,'Oaxaca',20),('Concepción Buenavista',1021,'Oaxaca',20),('Concepción Pápalo',1022,'Oaxaca',20),('Constancia del Rosario',1023,'Oaxaca',20),('Cosolapa',1024,'Oaxaca',20),('Cosoltepec',1025,'Oaxaca',20),('Cuilápam de Guerrero',1026,'Oaxaca',20),('Cuyamecalco Villa de Zaragoza',1027,'Oaxaca',20),('Chahuites',1028,'Oaxaca',20),('Chalcatongo de Hidalgo',1029,'Oaxaca',20),('Chiquihuitlán de Benito Juárez',1030,'Oaxaca',20),('Heroica Ciudad de Ejutla de Crespo',1031,'Oaxaca',20),('Eloxochitlán de Flores Magón',1032,'Oaxaca',20),('El Espinal',1033,'Oaxaca',20),('Tamazulápam del Espíritu Santo',1034,'Oaxaca',20),('Fresnillo de Trujano',1035,'Oaxaca',20),('Guadalupe Etla',1036,'Oaxaca',20),('Guadalupe de Ramírez',1037,'Oaxaca',20),('Guelatao de Juárez',1038,'Oaxaca',20),('Guevea de Humboldt',1039,'Oaxaca',20),('Mesones Hidalgo',1040,'Oaxaca',20),('Villa Hidalgo',1041,'Oaxaca',20),('Heroica Ciudad de Huajuapan de León',1042,'Oaxaca',20),('Huautepec',1043,'Oaxaca',20),('Huautla de Jiménez',1044,'Oaxaca',20),('Ixtlán de Juárez',1045,'Oaxaca',20),('Heroica Ciudad de Juchitán de Zaragoza',1046,'Oaxaca',20),('Loma Bonita',1047,'Oaxaca',20),('Magdalena Apasco',1048,'Oaxaca',20),('Magdalena Jaltepec',1049,'Oaxaca',20),('Santa Magdalena Jicotlán',1050,'Oaxaca',20),('Magdalena Mixtepec',1051,'Oaxaca',20),('Magdalena Ocotlán',1052,'Oaxaca',20),('Magdalena Peñasco',1053,'Oaxaca',20),('Magdalena Teitipac',1054,'Oaxaca',20),('Magdalena Tequisistlán',1055,'Oaxaca',20),('Magdalena Tlacotepec',1056,'Oaxaca',20),('Magdalena Zahuatlán',1057,'Oaxaca',20),('Mariscala de Juárez',1058,'Oaxaca',20),('Mártires de Tacubaya',1059,'Oaxaca',20),('Matías Romero Avendaño',1060,'Oaxaca',20),('Mazatlán Villa de Flores',1061,'Oaxaca',20),('Miahuatlán de Porfirio Díaz',1062,'Oaxaca',20),('Mixistlán de la Reforma',1063,'Oaxaca',20),('Monjas',1064,'Oaxaca',20),('Natividad',1065,'Oaxaca',20),('Nazareno Etla',1066,'Oaxaca',20),('Nejapa de Madero',1067,'Oaxaca',20),('Ixpantepec Nieves',1068,'Oaxaca',20),('Santiago Niltepec',1069,'Oaxaca',20),('Oaxaca de Juárez',1070,'Oaxaca',20),('Ocotlán de Morelos',1071,'Oaxaca',20),('La Pe',1072,'Oaxaca',20),('Pinotepa de Don Luis',1073,'Oaxaca',20),('Pluma Hidalgo',1074,'Oaxaca',20),('San José del Progreso',1075,'Oaxaca',20),('Putla Villa de Guerrero',1076,'Oaxaca',20),('Santa Catarina Quioquitani',1077,'Oaxaca',20),('Reforma de Pineda',1078,'Oaxaca',20),('La Reforma',1079,'Oaxaca',20),('Reyes Etla',1080,'Oaxaca',20),('Rojas de Cuauhtémoc',1081,'Oaxaca',20),('Salina Cruz',1082,'Oaxaca',20),('San Agustín Amatengo',1083,'Oaxaca',20),('San Agustín Atenango',1084,'Oaxaca',20),('San Agustín Chayuco',1085,'Oaxaca',20),('San Agustín de las Juntas',1086,'Oaxaca',20),('San Agustín Etla',1087,'Oaxaca',20),('San Agustín Loxicha',1088,'Oaxaca',20),('San Agustín Tlacotepec',1089,'Oaxaca',20),('San Agustín Yatareni',1090,'Oaxaca',20),('San Andrés Cabecera Nueva',1091,'Oaxaca',20),('San Andrés Dinicuiti',1092,'Oaxaca',20),('San Andrés Huaxpaltepec',1093,'Oaxaca',20),('San Andrés Huayápam',1094,'Oaxaca',20),('San Andrés Ixtlahuaca',1095,'Oaxaca',20),('San Andrés Lagunas',1096,'Oaxaca',20),('San Andrés Nuxiño',1097,'Oaxaca',20),('San Andrés Paxtlán',1098,'Oaxaca',20),('San Andrés Sinaxtla',1099,'Oaxaca',20),('San Andrés Solaga',1100,'Oaxaca',20),('San Andrés Teotilálpam',1101,'Oaxaca',20),('San Andrés Tepetlapa',1102,'Oaxaca',20),('San Andrés Yaá',1103,'Oaxaca',20),('San Andrés Zabache',1104,'Oaxaca',20),('San Andrés Zautla',1105,'Oaxaca',20),('San Antonino Castillo Velasco',1106,'Oaxaca',20),('San Antonino el Alto',1107,'Oaxaca',20),('San Antonino Monte Verde',1108,'Oaxaca',20),('San Antonio Acutla',1109,'Oaxaca',20),('San Antonio de la Cal',1110,'Oaxaca',20),('San Antonio Huitepec',1111,'Oaxaca',20),('San Antonio Nanahuatípam',1112,'Oaxaca',20),('San Antonio Sinicahua',1113,'Oaxaca',20),('San Antonio Tepetlapa',1114,'Oaxaca',20),('San Baltazar Chichicápam',1115,'Oaxaca',20),('San Baltazar Loxicha',1116,'Oaxaca',20),('San Baltazar Yatzachi el Bajo',1117,'Oaxaca',20),('San Bartolo Coyotepec',1118,'Oaxaca',20),('San Bartolomé Ayautla',1119,'Oaxaca',20),('San Bartolomé Loxicha',1120,'Oaxaca',20),('San Bartolomé Quialana',1121,'Oaxaca',20),('San Bartolomé Yucuañe',1122,'Oaxaca',20),('San Bartolomé Zoogocho',1123,'Oaxaca',20),('San Bartolo Soyaltepec',1124,'Oaxaca',20),('San Bartolo Yautepec',1125,'Oaxaca',20),('San Bernardo Mixtepec',1126,'Oaxaca',20),('San Blas Atempa',1127,'Oaxaca',20),('San Carlos Yautepec',1128,'Oaxaca',20),('San Cristóbal Amatlán',1129,'Oaxaca',20),('San Cristóbal Amoltepec',1130,'Oaxaca',20),('San Cristóbal Lachirioag',1131,'Oaxaca',20),('San Cristóbal Suchixtlahuaca',1132,'Oaxaca',20),('San Dionisio del Mar',1133,'Oaxaca',20),('San Dionisio Ocotepec',1134,'Oaxaca',20),('San Dionisio Ocotlán',1135,'Oaxaca',20),('San Esteban Atatlahuca',1136,'Oaxaca',20),('San Felipe Jalapa de Díaz',1137,'Oaxaca',20),('San Felipe Tejalápam',1138,'Oaxaca',20),('San Felipe Usila',1139,'Oaxaca',20),('San Francisco Cahuacuá',1140,'Oaxaca',20),('San Francisco Cajonos',1141,'Oaxaca',20),('San Francisco Chapulapa',1142,'Oaxaca',20),('San Francisco Chindúa',1143,'Oaxaca',20),('San Francisco del Mar',1144,'Oaxaca',20),('San Francisco Huehuetlán',1145,'Oaxaca',20),('San Francisco Ixhuatán',1146,'Oaxaca',20),('San Francisco Jaltepetongo',1147,'Oaxaca',20),('San Francisco Lachigoló',1148,'Oaxaca',20),('San Francisco Logueche',1149,'Oaxaca',20),('San Francisco Nuxaño',1150,'Oaxaca',20),('San Francisco Ozolotepec',1151,'Oaxaca',20),('San Francisco Sola',1152,'Oaxaca',20),('San Francisco Telixtlahuaca',1153,'Oaxaca',20),('San Francisco Teopan',1154,'Oaxaca',20),('San Francisco Tlapancingo',1155,'Oaxaca',20),('San Gabriel Mixtepec',1156,'Oaxaca',20),('San Ildefonso Amatlán',1157,'Oaxaca',20),('San Ildefonso Sola',1158,'Oaxaca',20),('San Ildefonso Villa Alta',1159,'Oaxaca',20),('San Jacinto Amilpas',1160,'Oaxaca',20),('San Jacinto Tlacotepec',1161,'Oaxaca',20),('San Jerónimo Coatlán',1162,'Oaxaca',20),('San Jerónimo Silacayoapilla',1163,'Oaxaca',20),('San Jerónimo Sosola',1164,'Oaxaca',20),('San Jerónimo Taviche',1165,'Oaxaca',20),('San Jerónimo Tecóatl',1166,'Oaxaca',20),('San Jorge Nuchita',1167,'Oaxaca',20),('San José Ayuquila',1168,'Oaxaca',20),('San José Chiltepec',1169,'Oaxaca',20),('San José del Peñasco',1170,'Oaxaca',20),('San José Estancia Grande',1171,'Oaxaca',20),('San José Independencia',1172,'Oaxaca',20),('San José Lachiguiri',1173,'Oaxaca',20),('San José Tenango',1174,'Oaxaca',20),('San Juan Achiutla',1175,'Oaxaca',20),('San Juan Atepec',1176,'Oaxaca',20),('Ánimas Trujano',1177,'Oaxaca',20),('San Juan Bautista Atatlahuca',1178,'Oaxaca',20),('San Juan Bautista Coixtlahuaca',1179,'Oaxaca',20),('San Juan Bautista Cuicatlán',1180,'Oaxaca',20),('San Juan Bautista Guelache',1181,'Oaxaca',20),('San Juan Bautista Jayacatlán',1182,'Oaxaca',20),('San Juan Bautista Lo de Soto',1183,'Oaxaca',20),('San Juan Bautista Suchitepec',1184,'Oaxaca',20),('San Juan Bautista Tlacoatzintepec',1185,'Oaxaca',20),('San Juan Bautista Tlachichilco',1186,'Oaxaca',20),('San Juan Bautista Tuxtepec',1187,'Oaxaca',20),('San Juan Cacahuatepec',1188,'Oaxaca',20),('San Juan Cieneguilla',1189,'Oaxaca',20),('San Juan Coatzóspam',1190,'Oaxaca',20),('San Juan Colorado',1191,'Oaxaca',20),('San Juan Comaltepec',1192,'Oaxaca',20),('San Juan Cotzocón',1193,'Oaxaca',20),('San Juan Chicomezúchil',1194,'Oaxaca',20),('San Juan Chilateca',1195,'Oaxaca',20),('San Juan del Estado',1196,'Oaxaca',20),('San Juan del Río',1197,'Oaxaca',20),('San Juan Diuxi',1198,'Oaxaca',20),('San Juan Evangelista Analco',1199,'Oaxaca',20),('San Juan Guelavía',1200,'Oaxaca',20),('San Juan Guichicovi',1201,'Oaxaca',20),('San Juan Ihualtepec',1202,'Oaxaca',20),('San Juan Juquila Mixes',1203,'Oaxaca',20),('San Juan Juquila Vijanos',1204,'Oaxaca',20),('San Juan Lachao',1205,'Oaxaca',20),('San Juan Lachigalla',1206,'Oaxaca',20),('San Juan Lajarcia',1207,'Oaxaca',20),('San Juan Lalana',1208,'Oaxaca',20),('San Juan de los Cués',1209,'Oaxaca',20),('San Juan Mazatlán',1210,'Oaxaca',20),('San Juan Mixtepec',1211,'Oaxaca',20),('San Juan Mixtepec',1212,'Oaxaca',20),('San Juan Ñumí',1213,'Oaxaca',20),('San Juan Ozolotepec',1214,'Oaxaca',20),('San Juan Petlapa',1215,'Oaxaca',20),('San Juan Quiahije',1216,'Oaxaca',20),('San Juan Quiotepec',1217,'Oaxaca',20),('San Juan Sayultepec',1218,'Oaxaca',20),('San Juan Tabaá',1219,'Oaxaca',20),('San Juan Tamazola',1220,'Oaxaca',20),('San Juan Teita',1221,'Oaxaca',20),('San Juan Teitipac',1222,'Oaxaca',20),('San Juan Tepeuxila',1223,'Oaxaca',20),('San Juan Teposcolula',1224,'Oaxaca',20),('San Juan Yaeé',1225,'Oaxaca',20),('San Juan Yatzona',1226,'Oaxaca',20),('San Juan Yucuita',1227,'Oaxaca',20),('San Lorenzo',1228,'Oaxaca',20),('San Lorenzo Albarradas',1229,'Oaxaca',20),('San Lorenzo Cacaotepec',1230,'Oaxaca',20),('San Lorenzo Cuaunecuiltitla',1231,'Oaxaca',20),('San Lorenzo Texmelúcan',1232,'Oaxaca',20),('San Lorenzo Victoria',1233,'Oaxaca',20),('San Lucas Camotlán',1234,'Oaxaca',20),('San Lucas Ojitlán',1235,'Oaxaca',20),('San Lucas Quiaviní',1236,'Oaxaca',20),('San Lucas Zoquiápam',1237,'Oaxaca',20),('San Luis Amatlán',1238,'Oaxaca',20),('San Marcial Ozolotepec',1239,'Oaxaca',20),('San Marcos Arteaga',1240,'Oaxaca',20),('San Martín de los Cansecos',1241,'Oaxaca',20),('San Martín Huamelúlpam',1242,'Oaxaca',20),('San Martín Itunyoso',1243,'Oaxaca',20),('San Martín Lachilá',1244,'Oaxaca',20),('San Martín Peras',1245,'Oaxaca',20),('San Martín Tilcajete',1246,'Oaxaca',20),('San Martín Toxpalan',1247,'Oaxaca',20),('San Martín Zacatepec',1248,'Oaxaca',20),('San Mateo Cajonos',1249,'Oaxaca',20),('Capulálpam de Méndez',1250,'Oaxaca',20),('San Mateo del Mar',1251,'Oaxaca',20),('San Mateo Yoloxochitlán',1252,'Oaxaca',20),('San Mateo Etlatongo',1253,'Oaxaca',20),('San Mateo Nejápam',1254,'Oaxaca',20),('San Mateo Peñasco',1255,'Oaxaca',20),('San Mateo Piñas',1256,'Oaxaca',20),('San Mateo Río Hondo',1257,'Oaxaca',20),('San Mateo Sindihui',1258,'Oaxaca',20),('San Mateo Tlapiltepec',1259,'Oaxaca',20),('San Melchor Betaza',1260,'Oaxaca',20),('San Miguel Achiutla',1261,'Oaxaca',20),('San Miguel Ahuehuetitlán',1262,'Oaxaca',20),('San Miguel Aloápam',1263,'Oaxaca',20),('San Miguel Amatitlán',1264,'Oaxaca',20),('San Miguel Amatlán',1265,'Oaxaca',20),('San Miguel Coatlán',1266,'Oaxaca',20),('San Miguel Chicahua',1267,'Oaxaca',20),('San Miguel Chimalapa',1268,'Oaxaca',20),('San Miguel del Puerto',1269,'Oaxaca',20),('San Miguel del Río',1270,'Oaxaca',20),('San Miguel Ejutla',1271,'Oaxaca',20),('San Miguel el Grande',1272,'Oaxaca',20),('San Miguel Huautla',1273,'Oaxaca',20),('San Miguel Mixtepec',1274,'Oaxaca',20),('San Miguel Panixtlahuaca',1275,'Oaxaca',20),('San Miguel Peras',1276,'Oaxaca',20),('San Miguel Piedras',1277,'Oaxaca',20),('San Miguel Quetzaltepec',1278,'Oaxaca',20),('San Miguel Santa Flor',1279,'Oaxaca',20),('Villa Sola de Vega',1280,'Oaxaca',20),('San Miguel Soyaltepec',1281,'Oaxaca',20),('San Miguel Suchixtepec',1282,'Oaxaca',20),('Villa Talea de Castro',1283,'Oaxaca',20),('San Miguel Tecomatlán',1284,'Oaxaca',20),('San Miguel Tenango',1285,'Oaxaca',20),('San Miguel Tequixtepec',1286,'Oaxaca',20),('San Miguel Tilquiápam',1287,'Oaxaca',20),('San Miguel Tlacamama',1288,'Oaxaca',20),('San Miguel Tlacotepec',1289,'Oaxaca',20),('San Miguel Tulancingo',1290,'Oaxaca',20),('San Miguel Yotao',1291,'Oaxaca',20),('San Nicolás',1292,'Oaxaca',20),('San Nicolás Hidalgo',1293,'Oaxaca',20),('San Pablo Coatlán',1294,'Oaxaca',20),('San Pablo Cuatro Venados',1295,'Oaxaca',20),('San Pablo Etla',1296,'Oaxaca',20),('San Pablo Huitzo',1297,'Oaxaca',20),('San Pablo Huixtepec',1298,'Oaxaca',20),('San Pablo Macuiltianguis',1299,'Oaxaca',20),('San Pablo Tijaltepec',1300,'Oaxaca',20),('San Pablo Villa de Mitla',1301,'Oaxaca',20),('San Pablo Yaganiza',1302,'Oaxaca',20),('San Pedro Amuzgos',1303,'Oaxaca',20),('San Pedro Apóstol',1304,'Oaxaca',20),('San Pedro Atoyac',1305,'Oaxaca',20),('San Pedro Cajonos',1306,'Oaxaca',20),('San Pedro Coxcaltepec Cántaros',1307,'Oaxaca',20),('San Pedro Comitancillo',1308,'Oaxaca',20),('San Pedro el Alto',1309,'Oaxaca',20),('San Pedro Huamelula',1310,'Oaxaca',20),('San Pedro Huilotepec',1311,'Oaxaca',20),('San Pedro Ixcatlán',1312,'Oaxaca',20),('San Pedro Ixtlahuaca',1313,'Oaxaca',20),('San Pedro Jaltepetongo',1314,'Oaxaca',20),('San Pedro Jicayán',1315,'Oaxaca',20),('San Pedro Jocotipac',1316,'Oaxaca',20),('San Pedro Juchatengo',1317,'Oaxaca',20),('San Pedro Mártir',1318,'Oaxaca',20),('San Pedro Mártir Quiechapa',1319,'Oaxaca',20),('San Pedro Mártir Yucuxaco',1320,'Oaxaca',20),('San Pedro Mixtepec',1321,'Oaxaca',20),('San Pedro Mixtepec',1322,'Oaxaca',20),('San Pedro Molinos',1323,'Oaxaca',20),('San Pedro Nopala',1324,'Oaxaca',20),('San Pedro Ocopetatillo',1325,'Oaxaca',20),('San Pedro Ocotepec',1326,'Oaxaca',20),('San Pedro Pochutla',1327,'Oaxaca',20),('San Pedro Quiatoni',1328,'Oaxaca',20),('San Pedro Sochiápam',1329,'Oaxaca',20),('San Pedro Tapanatepec',1330,'Oaxaca',20),('San Pedro Taviche',1331,'Oaxaca',20),('San Pedro Teozacoalco',1332,'Oaxaca',20),('San Pedro Teutila',1333,'Oaxaca',20),('San Pedro Tidaá',1334,'Oaxaca',20),('San Pedro Topiltepec',1335,'Oaxaca',20),('San Pedro Totolápam',1336,'Oaxaca',20),('Villa de Tututepec',1337,'Oaxaca',20),('San Pedro Yaneri',1338,'Oaxaca',20),('San Pedro Yólox',1339,'Oaxaca',20),('San Pedro y San Pablo Ayutla',1340,'Oaxaca',20),('Villa de Etla',1341,'Oaxaca',20),('San Pedro y San Pablo Teposcolula',1342,'Oaxaca',20),('San Pedro y San Pablo Tequixtepec',1343,'Oaxaca',20),('San Pedro Yucunama',1344,'Oaxaca',20),('San Raymundo Jalpan',1345,'Oaxaca',20),('San Sebastián Abasolo',1346,'Oaxaca',20),('San Sebastián Coatlán',1347,'Oaxaca',20),('San Sebastián Ixcapa',1348,'Oaxaca',20),('San Sebastián Nicananduta',1349,'Oaxaca',20),('San Sebastián Río Hondo',1350,'Oaxaca',20),('San Sebastián Tecomaxtlahuaca',1351,'Oaxaca',20),('San Sebastián Teitipac',1352,'Oaxaca',20),('San Sebastián Tutla',1353,'Oaxaca',20),('San Simón Almolongas',1354,'Oaxaca',20),('San Simón Zahuatlán',1355,'Oaxaca',20),('Santa Ana',1356,'Oaxaca',20),('Santa Ana Ateixtlahuaca',1357,'Oaxaca',20),('Santa Ana Cuauhtémoc',1358,'Oaxaca',20),('Santa Ana del Valle',1359,'Oaxaca',20),('Santa Ana Tavela',1360,'Oaxaca',20),('Santa Ana Tlapacoyan',1361,'Oaxaca',20),('Santa Ana Yareni',1362,'Oaxaca',20),('Santa Ana Zegache',1363,'Oaxaca',20),('Santa Catalina Quierí',1364,'Oaxaca',20),('Santa Catarina Cuixtla',1365,'Oaxaca',20),('Santa Catarina Ixtepeji',1366,'Oaxaca',20),('Santa Catarina Juquila',1367,'Oaxaca',20),('Santa Catarina Lachatao',1368,'Oaxaca',20),('Santa Catarina Loxicha',1369,'Oaxaca',20),('Santa Catarina Mechoacán',1370,'Oaxaca',20),('Santa Catarina Minas',1371,'Oaxaca',20),('Santa Catarina Quiané',1372,'Oaxaca',20),('Santa Catarina Tayata',1373,'Oaxaca',20),('Santa Catarina Ticuá',1374,'Oaxaca',20),('Santa Catarina Yosonotú',1375,'Oaxaca',20),('Santa Catarina Zapoquila',1376,'Oaxaca',20),('Santa Cruz Acatepec',1377,'Oaxaca',20),('Santa Cruz Amilpas',1378,'Oaxaca',20),('Santa Cruz de Bravo',1379,'Oaxaca',20),('Santa Cruz Itundujia',1380,'Oaxaca',20),('Santa Cruz Mixtepec',1381,'Oaxaca',20),('Santa Cruz Nundaco',1382,'Oaxaca',20),('Santa Cruz Papalutla',1383,'Oaxaca',20),('Santa Cruz Tacache de Mina',1384,'Oaxaca',20),('Santa Cruz Tacahua',1385,'Oaxaca',20),('Santa Cruz Tayata',1386,'Oaxaca',20),('Santa Cruz Xitla',1387,'Oaxaca',20),('Santa Cruz Xoxocotlán',1388,'Oaxaca',20),('Santa Cruz Zenzontepec',1389,'Oaxaca',20),('Santa Gertrudis',1390,'Oaxaca',20),('Santa Inés del Monte',1391,'Oaxaca',20),('Santa Inés Yatzeche',1392,'Oaxaca',20),('Santa Lucía del Camino',1393,'Oaxaca',20),('Santa Lucía Miahuatlán',1394,'Oaxaca',20),('Santa Lucía Monteverde',1395,'Oaxaca',20),('Santa Lucía Ocotlán',1396,'Oaxaca',20),('Santa María Alotepec',1397,'Oaxaca',20),('Santa María Apazco',1398,'Oaxaca',20),('Santa María la Asunción',1399,'Oaxaca',20),('Heroica Ciudad de Tlaxiaco',1400,'Oaxaca',20),('Ayoquezco de Aldama',1401,'Oaxaca',20),('Santa María Atzompa',1402,'Oaxaca',20),('Santa María Camotlán',1403,'Oaxaca',20),('Santa María Colotepec',1404,'Oaxaca',20),('Santa María Cortijo',1405,'Oaxaca',20),('Santa María Coyotepec',1406,'Oaxaca',20),('Santa María Chachoápam',1407,'Oaxaca',20),('Villa de Chilapa de Díaz',1408,'Oaxaca',20),('Santa María Chilchotla',1409,'Oaxaca',20),('Santa María Chimalapa',1410,'Oaxaca',20),('Santa María del Rosario',1411,'Oaxaca',20),('Santa María del Tule',1412,'Oaxaca',20),('Santa María Ecatepec',1413,'Oaxaca',20),('Santa María Guelacé',1414,'Oaxaca',20),('Santa María Guienagati',1415,'Oaxaca',20),('Santa María Huatulco',1416,'Oaxaca',20),('Santa María Huazolotitlán',1417,'Oaxaca',20),('Santa María Ipalapa',1418,'Oaxaca',20),('Santa María Ixcatlán',1419,'Oaxaca',20),('Santa María Jacatepec',1420,'Oaxaca',20),('Santa María Jalapa del Marqués',1421,'Oaxaca',20),('Santa María Jaltianguis',1422,'Oaxaca',20),('Santa María Lachixío',1423,'Oaxaca',20),('Santa María Mixtequilla',1424,'Oaxaca',20),('Santa María Nativitas',1425,'Oaxaca',20),('Santa María Nduayaco',1426,'Oaxaca',20),('Santa María Ozolotepec',1427,'Oaxaca',20),('Santa María Pápalo',1428,'Oaxaca',20),('Santa María Peñoles',1429,'Oaxaca',20),('Santa María Petapa',1430,'Oaxaca',20),('Santa María Quiegolani',1431,'Oaxaca',20),('Santa María Sola',1432,'Oaxaca',20),('Santa María Tataltepec',1433,'Oaxaca',20),('Santa María Tecomavaca',1434,'Oaxaca',20),('Santa María Temaxcalapa',1435,'Oaxaca',20),('Santa María Temaxcaltepec',1436,'Oaxaca',20),('Santa María Teopoxco',1437,'Oaxaca',20),('Santa María Tepantlali',1438,'Oaxaca',20),('Santa María Texcatitlán',1439,'Oaxaca',20),('Santa María Tlahuitoltepec',1440,'Oaxaca',20),('Santa María Tlalixtac',1441,'Oaxaca',20),('Santa María Tonameca',1442,'Oaxaca',20),('Santa María Totolapilla',1443,'Oaxaca',20),('Santa María Xadani',1444,'Oaxaca',20),('Santa María Yalina',1445,'Oaxaca',20),('Santa María Yavesía',1446,'Oaxaca',20),('Santa María Yolotepec',1447,'Oaxaca',20),('Santa María Yosoyúa',1448,'Oaxaca',20),('Santa María Yucuhiti',1449,'Oaxaca',20),('Santa María Zacatepec',1450,'Oaxaca',20),('Santa María Zaniza',1451,'Oaxaca',20),('Santa María Zoquitlán',1452,'Oaxaca',20),('Santiago Amoltepec',1453,'Oaxaca',20),('Santiago Apoala',1454,'Oaxaca',20),('Santiago Apóstol',1455,'Oaxaca',20),('Santiago Astata',1456,'Oaxaca',20),('Santiago Atitlán',1457,'Oaxaca',20),('Santiago Ayuquililla',1458,'Oaxaca',20),('Santiago Cacaloxtepec',1459,'Oaxaca',20),('Santiago Camotlán',1460,'Oaxaca',20),('Santiago Comaltepec',1461,'Oaxaca',20),('Santiago Chazumba',1462,'Oaxaca',20),('Santiago Choápam',1463,'Oaxaca',20),('Santiago del Río',1464,'Oaxaca',20),('Santiago Huajolotitlán',1465,'Oaxaca',20),('Santiago Huauclilla',1466,'Oaxaca',20),('Santiago Ihuitlán Plumas',1467,'Oaxaca',20),('Santiago Ixcuintepec',1468,'Oaxaca',20),('Santiago Ixtayutla',1469,'Oaxaca',20),('Santiago Jamiltepec',1470,'Oaxaca',20),('Santiago Jocotepec',1471,'Oaxaca',20),('Santiago Juxtlahuaca',1472,'Oaxaca',20),('Santiago Lachiguiri',1473,'Oaxaca',20),('Santiago Lalopa',1474,'Oaxaca',20),('Santiago Laollaga',1475,'Oaxaca',20),('Santiago Laxopa',1476,'Oaxaca',20),('Santiago Llano Grande',1477,'Oaxaca',20),('Santiago Matatlán',1478,'Oaxaca',20),('Santiago Miltepec',1479,'Oaxaca',20),('Santiago Minas',1480,'Oaxaca',20),('Santiago Nacaltepec',1481,'Oaxaca',20),('Santiago Nejapilla',1482,'Oaxaca',20),('Santiago Nundiche',1483,'Oaxaca',20),('Santiago Nuyoó',1484,'Oaxaca',20),('Santiago Pinotepa Nacional',1485,'Oaxaca',20),('Santiago Suchilquitongo',1486,'Oaxaca',20),('Santiago Tamazola',1487,'Oaxaca',20),('Santiago Tapextla',1488,'Oaxaca',20),('Villa Tejúpam de la Unión',1489,'Oaxaca',20),('Santiago Tenango',1490,'Oaxaca',20),('Santiago Tepetlapa',1491,'Oaxaca',20),('Santiago Tetepec',1492,'Oaxaca',20),('Santiago Texcalcingo',1493,'Oaxaca',20),('Santiago Textitlán',1494,'Oaxaca',20),('Santiago Tilantongo',1495,'Oaxaca',20),('Santiago Tillo',1496,'Oaxaca',20),('Santiago Tlazoyaltepec',1497,'Oaxaca',20),('Santiago Xanica',1498,'Oaxaca',20),('Santiago Xiacuí',1499,'Oaxaca',20),('Santiago Yaitepec',1500,'Oaxaca',20),('Santiago Yaveo',1501,'Oaxaca',20),('Santiago Yolomécatl',1502,'Oaxaca',20),('Santiago Yosondúa',1503,'Oaxaca',20),('Santiago Yucuyachi',1504,'Oaxaca',20),('Santiago Zacatepec',1505,'Oaxaca',20),('Santiago Zoochila',1506,'Oaxaca',20),('Nuevo Zoquiápam',1507,'Oaxaca',20),('Santo Domingo Ingenio',1508,'Oaxaca',20),('Santo Domingo Albarradas',1509,'Oaxaca',20),('Santo Domingo Armenta',1510,'Oaxaca',20),('Santo Domingo Chihuitán',1511,'Oaxaca',20),('Santo Domingo de Morelos',1512,'Oaxaca',20),('Santo Domingo Ixcatlán',1513,'Oaxaca',20),('Santo Domingo Nuxaá',1514,'Oaxaca',20),('Santo Domingo Ozolotepec',1515,'Oaxaca',20),('Santo Domingo Petapa',1516,'Oaxaca',20),('Santo Domingo Roayaga',1517,'Oaxaca',20),('Santo Domingo Tehuantepec',1518,'Oaxaca',20),('Santo Domingo Teojomulco',1519,'Oaxaca',20),('Santo Domingo Tepuxtepec',1520,'Oaxaca',20),('Santo Domingo Tlatayápam',1521,'Oaxaca',20),('Santo Domingo Tomaltepec',1522,'Oaxaca',20),('Santo Domingo Tonalá',1523,'Oaxaca',20),('Santo Domingo Tonaltepec',1524,'Oaxaca',20),('Santo Domingo Xagacía',1525,'Oaxaca',20),('Santo Domingo Yanhuitlán',1526,'Oaxaca',20),('Santo Domingo Yodohino',1527,'Oaxaca',20),('Santo Domingo Zanatepec',1528,'Oaxaca',20),('Santos Reyes Nopala',1529,'Oaxaca',20),('Santos Reyes Pápalo',1530,'Oaxaca',20),('Santos Reyes Tepejillo',1531,'Oaxaca',20),('Santos Reyes Yucuná',1532,'Oaxaca',20),('Santo Tomás Jalieza',1533,'Oaxaca',20),('Santo Tomás Mazaltepec',1534,'Oaxaca',20),('Santo Tomás Ocotepec',1535,'Oaxaca',20),('Santo Tomás Tamazulapan',1536,'Oaxaca',20),('San Vicente Coatlán',1537,'Oaxaca',20),('San Vicente Lachixío',1538,'Oaxaca',20),('San Vicente Nuñú',1539,'Oaxaca',20),('Silacayoápam',1540,'Oaxaca',20),('Sitio de Xitlapehua',1541,'Oaxaca',20),('Soledad Etla',1542,'Oaxaca',20),('Villa de Tamazulápam del Progreso',1543,'Oaxaca',20),('Tanetze de Zaragoza',1544,'Oaxaca',20),('Taniche',1545,'Oaxaca',20),('Tataltepec de Valdés',1546,'Oaxaca',20),('Teococuilco de Marcos Pérez',1547,'Oaxaca',20),('Teotitlán de Flores Magón',1548,'Oaxaca',20),('Teotitlán del Valle',1549,'Oaxaca',20),('Teotongo',1550,'Oaxaca',20),('Tepelmeme Villa de Morelos',1551,'Oaxaca',20),('Heroica Villa Tezoatlán de Segura y Luna, Cuna de la Indepen',1552,'Oaxaca',20),('San Jerónimo Tlacochahuaya',1553,'Oaxaca',20),('Tlacolula de Matamoros',1554,'Oaxaca',20),('Tlacotepec Plumas',1555,'Oaxaca',20),('Tlalixtac de Cabrera',1556,'Oaxaca',20),('Totontepec Villa de Morelos',1557,'Oaxaca',20),('Trinidad Zaachila',1558,'Oaxaca',20),('La Trinidad Vista Hermosa',1559,'Oaxaca',20),('Unión Hidalgo',1560,'Oaxaca',20),('Valerio Trujano',1561,'Oaxaca',20),('San Juan Bautista Valle Nacional',1562,'Oaxaca',20),('Villa Díaz Ordaz',1563,'Oaxaca',20),('Yaxe',1564,'Oaxaca',20),('Magdalena Yodocono de Porfirio Díaz',1565,'Oaxaca',20),('Yogana',1566,'Oaxaca',20),('Yutanduchi de Guerrero',1567,'Oaxaca',20),('Villa de Zaachila',1568,'Oaxaca',20),('San Mateo Yucutindoo',1569,'Oaxaca',20),('Zapotitlán Lagunas',1570,'Oaxaca',20),('Zapotitlán Palmas',1571,'Oaxaca',20),('Santa Inés de Zaragoza',1572,'Oaxaca',20),('Zimatlán de Álvarez',1573,'Oaxaca',20),('Acajete',1574,'Puebla',21),('Acateno',1575,'Puebla',21),('Acatlán',1576,'Puebla',21),('Acatzingo',1577,'Puebla',21),('Acteopan',1578,'Puebla',21),('Ahuacatlán',1579,'Puebla',21),('Ahuatlán',1580,'Puebla',21),('Ahuazotepec',1581,'Puebla',21),('Ahuehuetitla',1582,'Puebla',21),('Ajalpan',1583,'Puebla',21),('Albino Zertuche',1584,'Puebla',21),('Aljojuca',1585,'Puebla',21),('Altepexi',1586,'Puebla',21),('Amixtlán',1587,'Puebla',21),('Amozoc',1588,'Puebla',21),('Aquixtla',1589,'Puebla',21),('Atempan',1590,'Puebla',21),('Atexcal',1591,'Puebla',21),('Atlixco',1592,'Puebla',21),('Atoyatempan',1593,'Puebla',21),('Atzala',1594,'Puebla',21),('Atzitzihuacán',1595,'Puebla',21),('Atzitzintla',1596,'Puebla',21),('Axutla',1597,'Puebla',21),('Ayotoxco de Guerrero',1598,'Puebla',21),('Calpan',1599,'Puebla',21),('Caltepec',1600,'Puebla',21),('Camocuautla',1601,'Puebla',21),('Caxhuacan',1602,'Puebla',21),('Coatepec',1603,'Puebla',21),('Coatzingo',1604,'Puebla',21),('Cohetzala',1605,'Puebla',21),('Cohuecan',1606,'Puebla',21),('Coronango',1607,'Puebla',21),('Coxcatlán',1608,'Puebla',21),('Coyomeapan',1609,'Puebla',21),('Coyotepec',1610,'Puebla',21),('Cuapiaxtla de Madero',1611,'Puebla',21),('Cuautempan',1612,'Puebla',21),('Cuautinchán',1613,'Puebla',21),('Cuautlancingo',1614,'Puebla',21),('Cuayuca de Andrade',1615,'Puebla',21),('Cuetzalan del Progreso',1616,'Puebla',21),('Cuyoaco',1617,'Puebla',21),('Chalchicomula de Sesma',1618,'Puebla',21),('Chapulco',1619,'Puebla',21),('Chiautla',1620,'Puebla',21),('Chiautzingo',1621,'Puebla',21),('Chiconcuautla',1622,'Puebla',21),('Chichiquila',1623,'Puebla',21),('Chietla',1624,'Puebla',21),('Chigmecatitlán',1625,'Puebla',21),('Chignahuapan',1626,'Puebla',21),('Chignautla',1627,'Puebla',21),('Chila',1628,'Puebla',21),('Chila de la Sal',1629,'Puebla',21),('Honey',1630,'Puebla',21),('Chilchotla',1631,'Puebla',21),('Chinantla',1632,'Puebla',21),('Domingo Arenas',1633,'Puebla',21),('Eloxochitlán',1634,'Puebla',21),('Epatlán',1635,'Puebla',21),('Esperanza',1636,'Puebla',21),('Francisco Z. Mena',1637,'Puebla',21),('General Felipe Ángeles',1638,'Puebla',21),('Guadalupe',1639,'Puebla',21),('Guadalupe Victoria',1640,'Puebla',21),('Hermenegildo Galeana',1641,'Puebla',21),('Huaquechula',1642,'Puebla',21),('Huatlatlauca',1643,'Puebla',21),('Huauchinango',1644,'Puebla',21),('Huehuetla',1645,'Puebla',21),('Huehuetlán el Chico',1646,'Puebla',21),('Huejotzingo',1647,'Puebla',21),('Hueyapan',1648,'Puebla',21),('Hueytamalco',1649,'Puebla',21),('Hueytlalpan',1650,'Puebla',21),('Huitzilan de Serdán',1651,'Puebla',21),('Huitziltepec',1652,'Puebla',21),('Atlequizayan',1653,'Puebla',21),('Ixcamilpa de Guerrero',1654,'Puebla',21),('Ixcaquixtla',1655,'Puebla',21),('Ixtacamaxtitlán',1656,'Puebla',21),('Ixtepec',1657,'Puebla',21),('Izúcar de Matamoros',1658,'Puebla',21),('Jalpan',1659,'Puebla',21),('Jolalpan',1660,'Puebla',21),('Jonotla',1661,'Puebla',21),('Jopala',1662,'Puebla',21),('Juan C. Bonilla',1663,'Puebla',21),('Juan Galindo',1664,'Puebla',21),('Juan N. Méndez',1665,'Puebla',21),('Lafragua',1666,'Puebla',21),('Libres',1667,'Puebla',21),('La Magdalena Tlatlauquitepec',1668,'Puebla',21),('Mazapiltepec de Juárez',1669,'Puebla',21),('Mixtla',1670,'Puebla',21),('Molcaxac',1671,'Puebla',21),('Cañada Morelos',1672,'Puebla',21),('Naupan',1673,'Puebla',21),('Nauzontla',1674,'Puebla',21),('Nealtican',1675,'Puebla',21),('Nicolás Bravo',1676,'Puebla',21),('Nopalucan',1677,'Puebla',21),('Ocotepec',1678,'Puebla',21),('Ocoyucan',1679,'Puebla',21),('Olintla',1680,'Puebla',21),('Oriental',1681,'Puebla',21),('Pahuatlán',1682,'Puebla',21),('Palmar de Bravo',1683,'Puebla',21),('Pantepec',1684,'Puebla',21),('Petlalcingo',1685,'Puebla',21),('Piaxtla',1686,'Puebla',21),('Puebla',1687,'Puebla',21),('Quecholac',1688,'Puebla',21),('Quimixtlán',1689,'Puebla',21),('Rafael Lara Grajales',1690,'Puebla',21),('Los Reyes de Juárez',1691,'Puebla',21),('San Andrés Cholula',1692,'Puebla',21),('San Antonio Cañada',1693,'Puebla',21),('San Diego la Mesa Tochimiltzingo',1694,'Puebla',21),('San Felipe Teotlalcingo',1695,'Puebla',21),('San Felipe Tepatlán',1696,'Puebla',21),('San Gabriel Chilac',1697,'Puebla',21),('San Gregorio Atzompa',1698,'Puebla',21),('San Jerónimo Tecuanipan',1699,'Puebla',21),('San Jerónimo Xayacatlán',1700,'Puebla',21),('San José Chiapa',1701,'Puebla',21),('San José Miahuatlán',1702,'Puebla',21),('San Juan Atenco',1703,'Puebla',21),('San Juan Atzompa',1704,'Puebla',21),('San Martín Texmelucan',1705,'Puebla',21),('San Martín Totoltepec',1706,'Puebla',21),('San Matías Tlalancaleca',1707,'Puebla',21),('San Miguel Ixitlán',1708,'Puebla',21),('San Miguel Xoxtla',1709,'Puebla',21),('San Nicolás Buenos Aires',1710,'Puebla',21),('San Nicolás de los Ranchos',1711,'Puebla',21),('San Pablo Anicano',1712,'Puebla',21),('San Pedro Cholula',1713,'Puebla',21),('San Pedro Yeloixtlahuaca',1714,'Puebla',21),('San Salvador el Seco',1715,'Puebla',21),('San Salvador el Verde',1716,'Puebla',21),('San Salvador Huixcolotla',1717,'Puebla',21),('San Sebastián Tlacotepec',1718,'Puebla',21),('Santa Catarina Tlaltempan',1719,'Puebla',21),('Santa Inés Ahuatempan',1720,'Puebla',21),('Santa Isabel Cholula',1721,'Puebla',21),('Santiago Miahuatlán',1722,'Puebla',21),('Huehuetlán el Grande',1723,'Puebla',21),('Santo Tomás Hueyotlipan',1724,'Puebla',21),('Soltepec',1725,'Puebla',21),('Tecali de Herrera',1726,'Puebla',21),('Tecamachalco',1727,'Puebla',21),('Tecomatlán',1728,'Puebla',21),('Tehuacán',1729,'Puebla',21),('Tehuitzingo',1730,'Puebla',21),('Tenampulco',1731,'Puebla',21),('Teopantlán',1732,'Puebla',21),('Teotlalco',1733,'Puebla',21),('Tepanco de López',1734,'Puebla',21),('Tepango de Rodríguez',1735,'Puebla',21),('Tepatlaxco de Hidalgo',1736,'Puebla',21),('Tepeaca',1737,'Puebla',21),('Tepemaxalco',1738,'Puebla',21),('Tepeojuma',1739,'Puebla',21),('Tepetzintla',1740,'Puebla',21),('Tepexco',1741,'Puebla',21),('Tepexi de Rodríguez',1742,'Puebla',21),('Tepeyahualco',1743,'Puebla',21),('Tepeyahualco de Cuauhtémoc',1744,'Puebla',21),('Tetela de Ocampo',1745,'Puebla',21),('Teteles de Avila Castillo',1746,'Puebla',21),('Teziutlán',1747,'Puebla',21),('Tianguismanalco',1748,'Puebla',21),('Tilapa',1749,'Puebla',21),('Tlacotepec de Benito Juárez',1750,'Puebla',21),('Tlacuilotepec',1751,'Puebla',21),('Tlachichuca',1752,'Puebla',21),('Tlahuapan',1753,'Puebla',21),('Tlaltenango',1754,'Puebla',21),('Tlanepantla',1755,'Puebla',21),('Tlaola',1756,'Puebla',21),('Tlapacoya',1757,'Puebla',21),('Tlapanalá',1758,'Puebla',21),('Tlatlauquitepec',1759,'Puebla',21),('Tlaxco',1760,'Puebla',21),('Tochimilco',1761,'Puebla',21),('Tochtepec',1762,'Puebla',21),('Totoltepec de Guerrero',1763,'Puebla',21),('Tulcingo',1764,'Puebla',21),('Tuzamapan de Galeana',1765,'Puebla',21),('Tzicatlacoyan',1766,'Puebla',21),('Venustiano Carranza',1767,'Puebla',21),('Vicente Guerrero',1768,'Puebla',21),('Xayacatlán de Bravo',1769,'Puebla',21),('Xicotepec',1770,'Puebla',21),('Xicotlán',1771,'Puebla',21),('Xiutetelco',1772,'Puebla',21),('Xochiapulco',1773,'Puebla',21),('Xochiltepec',1774,'Puebla',21),('Xochitlán de Vicente Suárez',1775,'Puebla',21),('Xochitlán Todos Santos',1776,'Puebla',21),('Yaonáhuac',1777,'Puebla',21),('Yehualtepec',1778,'Puebla',21),('Zacapala',1779,'Puebla',21),('Zacapoaxtla',1780,'Puebla',21),('Zacatlán',1781,'Puebla',21),('Zapotitlán',1782,'Puebla',21),('Zapotitlán de Méndez',1783,'Puebla',21),('Zaragoza',1784,'Puebla',21),('Zautla',1785,'Puebla',21),('Zihuateutla',1786,'Puebla',21),('Zinacatepec',1787,'Puebla',21),('Zongozotla',1788,'Puebla',21),('Zoquiapan',1789,'Puebla',21),('Zoquitlán',1790,'Puebla',21),('Amealco de Bonfil',1791,'Querétaro',22),('Pinal de Amoles',1792,'Querétaro',22),('Arroyo Seco',1793,'Querétaro',22),('Cadereyta de Montes',1794,'Querétaro',22),('Colón',1795,'Querétaro',22),('Corregidora',1796,'Querétaro',22),('Ezequiel Montes',1797,'Querétaro',22),('Huimilpan',1798,'Querétaro',22),('Jalpan de Serra',1799,'Querétaro',22),('Landa de Matamoros',1800,'Querétaro',22),('El Marqués',1801,'Querétaro',22),('Pedro Escobedo',1802,'Querétaro',22),('Peñamiller',1803,'Querétaro',22),('Querétaro',1804,'Querétaro',22),('San Joaquín',1805,'Querétaro',22),('San Juan del Río',1806,'Querétaro',22),('Tequisquiapan',1807,'Querétaro',22);

/*Table structure for table `PerfilLaboral` */

DROP TABLE IF EXISTS `PerfilLaboral`;

CREATE TABLE `PerfilLaboral` (
  `id_perfil` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_RS` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `titulo_puesto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `funciones_actividades` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salario_mensual` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_empleo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_separacion` date DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_perfil`),
  KEY `perfillaboral_id_foreign` (`id`),
  CONSTRAINT `perfillaboral_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `PerfilLaboral` */

/*Table structure for table `PuestoDeseado` */

DROP TABLE IF EXISTS `PuestoDeseado`;

CREATE TABLE `PuestoDeseado` (
  `IdPuestoDeseado` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `puesto_deseado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ocupacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `experiencia_puesto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_empleo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salario_mensual` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispo_viajar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dispo_radicar_fuera` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdPuestoDeseado`),
  KEY `puestodeseado_id_foreign` (`id`),
  CONSTRAINT `puestodeseado_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `PuestoDeseado` */

/*Table structure for table `SituacionLaboral` */

DROP TABLE IF EXISTS `SituacionLaboral`;

CREATE TABLE `SituacionLaboral` (
  `IdSituacionLab` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `trabajo_actual` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `motivo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_busquedaempleo` date DEFAULT NULL,
  `disponibilidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdSituacionLab`),
  KEY `situacionlaboral_id_foreign` (`id`),
  CONSTRAINT `situacionlaboral_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `SituacionLaboral` */

/*Table structure for table `TipoEmpleo` */

DROP TABLE IF EXISTS `TipoEmpleo`;

CREATE TABLE `TipoEmpleo` (
  `IdTipoEmpleo` int(11) NOT NULL,
  `TipoEmpleo` varchar(45) NOT NULL,
  PRIMARY KEY (`IdTipoEmpleo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `TipoEmpleo` */

insert  into `TipoEmpleo`(`IdTipoEmpleo`,`TipoEmpleo`) values (1,'Tiempo completo'),(2,'Becarios'),(3,'Medio día'),(4,'Nocturna'),(5,'Fines de semana'),(6,'Estudiantes');

/*Table structure for table `UltimoGrado` */

DROP TABLE IF EXISTS `UltimoGrado`;

CREATE TABLE `UltimoGrado` (
  `IdUltimoGrado` int(11) NOT NULL,
  `UltimoGrado` varchar(100) NOT NULL,
  PRIMARY KEY (`IdUltimoGrado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `UltimoGrado` */

insert  into `UltimoGrado`(`IdUltimoGrado`,`UltimoGrado`) values (1,'Sin instrucción'),(2,'Sabe Leer y Escribir'),(3,'Primaria'),(4,'Secuendaria/Sec. Tecnica'),(5,'Carrera Comercial'),(6,'Carrera Técnica'),(7,'Profesional técnico'),(8,'Prepa o vocacional'),(9,'T. Superior Universitario'),(10,'Licenciatura'),(11,'Maestría'),(12,'Doctorado');

/*Table structure for table `curriculumusers` */

DROP TABLE IF EXISTS `curriculumusers`;

CREATE TABLE `curriculumusers` (
  `id_curriculum` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `objetivo_prof` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `experiencia_prof` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area_especialidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `habilidades` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `educacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idiomas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cursos_y_certificaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_curriculum`),
  KEY `curriculumusers_id_foreign` (`id`),
  CONSTRAINT `curriculumusers_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `curriculumusers` */

/*Table structure for table `datos_empresas` */

DROP TABLE IF EXISTS `datos_empresas`;

CREATE TABLE `datos_empresas` (
  `id_empresa` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_RS` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `colonia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CP` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `municipio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RFC` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagina_electronica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actividad_economica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_empleados` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ComoSeEnt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto_perfil` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_empresa`),
  KEY `datos_empresas_id_foreign` (`id`),
  CONSTRAINT `datos_empresas_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `datos_empresas` */

/*Table structure for table `fechas` */

DROP TABLE IF EXISTS `fechas`;

CREATE TABLE `fechas` (
  `id_fecha` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `periodico_ofertas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `portal_empleo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `feria_empleo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `radio_mexiquense` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_vacante` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_fecha`),
  KEY `fechas_id_vacante_foreign` (`id_vacante`),
  CONSTRAINT `fechas_id_vacante_foreign` FOREIGN KEY (`id_vacante`) REFERENCES `vacantes` (`id_vacante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `fechas` */

/*Table structure for table `idioma` */

DROP TABLE IF EXISTS `idioma`;

CREATE TABLE `idioma` (
  `IdIdioma` int(11) NOT NULL,
  `Idioma` varchar(45) NOT NULL,
  PRIMARY KEY (`IdIdioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `idioma` */

insert  into `idioma`(`IdIdioma`,`Idioma`) values (1,'Inglés'),(2,'Francés'),(3,'Portugués'),(4,'Ruso'),(5,'Italiano'),(6,'Japonés');

/*Table structure for table `informacion_contactos` */

DROP TABLE IF EXISTS `informacion_contactos`;

CREATE TABLE `informacion_contactos` (
  `id_contacto` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_contacto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medio_preferente_contacto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dias_entrevista` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `horario_entrevista_inicial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `horario_entrevista_final` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_vacante` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_contacto`),
  KEY `informacion_contactos_id_vacante_foreign` (`id_vacante`),
  CONSTRAINT `informacion_contactos_id_vacante_foreign` FOREIGN KEY (`id_vacante`) REFERENCES `vacantes` (`id_vacante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `informacion_contactos` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (188,'2014_10_12_000000_create_users_table',1),(189,'2014_10_12_100000_create_password_resets_table',1),(190,'2020_06_17_195831_curriculum_users',1),(191,'2020_06_24_035710_datos_ciudadano',1),(192,'2020_06_24_234242_escolaridad',1),(193,'2020_06_24_234548_puesto_deseado',1),(194,'2020_06_24_235505_situacion_laboral',1),(195,'2020_06_24_235606_perfil_laboral',1),(196,'2020_07_03_062716_usercv',1),(197,'2020_07_07_051540_create_datos_empresas_table',1),(198,'2020_07_07_051753_create_vacantes_table',1),(199,'2020_07_07_052009_create_requisitos_vacantes_table',1),(200,'2020_07_07_052205_create_informacion_contactos_table',1),(201,'2020_07_07_052530_create_fechas_table',1),(202,'2020_07_21_053544_create_postulacions_table',1),(203,'2020_08_11_195744_create_recientes_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `postulaciones` */

DROP TABLE IF EXISTS `postulaciones`;
CREATE TABLE `postulaciones` (
  `id_postulacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_persona` bigint(20) unsigned NOT NULL,
  `id_vacante` bigint(20) unsigned NOT NULL,
  `id_empresa` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_postulacion`),
  KEY `postulaciones_id_usuario_foreign` (`id_usuario`),
  KEY `postulaciones_id_persona_foreign` (`id_persona`),
  KEY `postulaciones_id_vacante_foreign` (`id_vacante`),
  KEY `postulaciones_id_empresa_foreign` (`id_empresa`),
  CONSTRAINT `postulaciones_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `datos_empresas` (`id_empresa`),
  CONSTRAINT `postulaciones_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `DatosCiudadano` (`id_persona`),
  CONSTRAINT `postulaciones_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`),
  CONSTRAINT `postulaciones_id_vacante_foreign` FOREIGN KEY (`id_vacante`) REFERENCES `vacantes` (`id_vacante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `postulaciones` */

/*Table structure for table `recientes` */

DROP TABLE IF EXISTS `recientes`;

CREATE TABLE `recientes` (
  `id_reciente` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_reciente` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_reciente`),
  KEY `recientes_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `recientes_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `recientes` */

/*Table structure for table `requisitos_vacantes` */

DROP TABLE IF EXISTS `requisitos_vacantes`;

CREATE TABLE `requisitos_vacantes` (
  `id_requisitos` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `personas_con_discapacidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mencione_discapacidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adultos_mayores` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `causa_origina_vacante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `escolaridad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrera_especialidad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `situacion_academica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `experiencia_MinRequerida` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `minima_edad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxima_edad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idioma` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `computacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disponibilidad_viajar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disponibilidad_RadicarFuera` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prestaciones_ofrecidas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_vacante` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_requisitos`),
  KEY `requisitos_vacantes_id_vacante_foreign` (`id_vacante`),
  CONSTRAINT `requisitos_vacantes_id_vacante_foreign` FOREIGN KEY (`id_vacante`) REFERENCES `vacantes` (`id_vacante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `requisitos_vacantes` */

/*Table structure for table `situacionacad` */

DROP TABLE IF EXISTS `situacionacad`;

CREATE TABLE `situacionacad` (
  `IdSituacionAcad` int(11) NOT NULL,
  `SituacionAcad` varchar(45) NOT NULL,
  PRIMARY KEY (`IdSituacionAcad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `situacionacad` */

insert  into `situacionacad`(`IdSituacionAcad`,`SituacionAcad`) values (1,'Estudiante'),(2,'Diploma o certificado'),(3,'Trunca'),(4,'Pasante'),(5,'Titulado');

/*Table structure for table `usercv` */

DROP TABLE IF EXISTS `usercv`;

CREATE TABLE `usercv` (
  `id_cv` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_cv` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cv`),
  KEY `usercv_id_foreign` (`id`),
  CONSTRAINT `usercv_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `usercv` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_user` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

/*Table structure for table `vacantes` */

DROP TABLE IF EXISTS `vacantes`;

CREATE TABLE `vacantes` (
  `id_vacante` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titulo_puesto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion_breve` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FunActi_realizar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conocimientos_requeridos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `habilidades_requeridos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccioncompleta` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_empleo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salario_mensual` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lugar_vacante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dias_laboral` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hora_entrada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `numero_plazas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vigencia_vacante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_empresa` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_vacante`),
  UNIQUE KEY `vacantes_slug_unique` (`slug`),
  KEY `vacantes_id_empresa_foreign` (`id_empresa`),
  CONSTRAINT `vacantes_id_empresa_foreign` FOREIGN KEY (`id_empresa`) REFERENCES `datos_empresas` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `vacantes` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
