
CREATE TABLE secret_key(
secret_key 				VARCHAR(70) NOT NULL
);

CREATE TABLE congregaciones(
ID 					INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
nombre 				VARCHAR(30) NOT NULL,
provincia 			VARCHAR(30) NOT NULL,
localidad 			VARCHAR(30) NOT NULL
);

CREATE TABLE administrador(
ID 					INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_congregacion 	INT(10) NOT NULL,
nombre 				VARCHAR(20) NOT NULL,
apellidos 			VARCHAR(20) NOT NULL,
nombre_usuario 		VARCHAR(20) NOT NULL,
password 			VARCHAR(60) NOT NULL,
email 				VARCHAR(50) NOT NULL,
activo 				TINYINT(1) DEFAULT '0' NOT NULL,
FOREIGN KEY (ID_congregacion) REFERENCES congregaciones(ID) ON DELETE CASCADE
);

CREATE TABLE publicadores(
ID 					INT(30) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_congregacion 	INT(10) NOT NULL,
nombre 				VARCHAR(10) NOT NULL,
apellidos			VARCHAR(10) NOT NULL,
email				VARCHAR(30),
telefono 			VARCHAR(30),
FOREIGN KEY (ID_congregacion) REFERENCES congregaciones(ID) ON DELETE CASCADE
);

CREATE TABLE territorios(
ID 					INT(30) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_congregacion 	INT(10) NOT NULL,
ID_publicador 	  	INT(20) NOT NULL,
numero_territorio 	VARCHAR(10),
imagen 				VARCHAR(50),
entrega 			VARCHAR(10),
devuelta 			VARCHAR(10),
asignado 			TINYINT(1) NOT NULL DEFAULT '0',
asignado_campaing 	TINYINT(1) NOT NULL DEFAULT '0',
entrega_campaing 	VARCHAR(10),
devuelta_campaing 	VARCHAR(10),
FOREIGN KEY (ID_publicador) REFERENCES publicadores(ID) ON DELETE CASCADE
);

CREATE TABLE zona(
ID 					INT(30) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_territorio 		INT(30) NOT NULL,
zona 				VARCHAR(20),
FOREIGN KEY (ID_territorio) REFERENCES territorios(ID) ON DELETE CASCADE
);

CREATE TABLE observaciones(
ID 					INT(40) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_territorio 		INT(30) NOT NULL,
observacion 		VARCHAR(2000),
creado 				DATETIME (CURRENT_TIMESTAMP),
FOREIGN KEY (ID_territorio) REFERENCES territorios(ID) ON DELETE CASCADE
);

CREATE TABLE historial(
ID 					INT(60) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_territorio 		INT(30) NOT NULL,
obser_historial 	VARCHAR(2000),
creado 				DATETIME CURRENT_TIMESTAMP,
FOREIGN KEY (ID_territorio) REFERENCES territorios(ID) ON DELETE CASCADE
);

CREATE TABLE service_year(
ID 					INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_congregacion 	INT(10) NOT NULL,
comienzo 			VARCHAR(10) NOT NULL,
fin 				VARCHAR(10) NOT NULL,
activo 				TINYINT(1) NOT NULL DEFAULT '1',
numero_territorios 	VARCHAR(10),
territorios_predicados VARCHAR(10),
FOREIGN KEY (ID_congregacion) REFERENCES congregaciones(ID) ON DELETE CASCADE
);

CREATE TABLE campaing(
ID 					INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_congregacion 	INT(10) NOT NULL,
nombre_campaing 	VARCHAR(20) NOT NULL,
activa 				TINYINT(1) NOT NULL DEFAULT '1',
fecha_apertura 		VARCHAR(20) NOT NULL,
fecha_cierre 		VARCHAR(20) NOT NULL,
observaciones_campaing VARCHAR(20) NOT NULL,
FOREIGN KEY (ID_congregacion) REFERENCES congregaciones(ID) ON DELETE CASCADE
);

CREATE TABLE datos_campaing(
ID 					INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_campaing 		INT(10) NOT NULL,
numero_territorios 	VARCHAR(10),
territorios_predicados VARCHAR(10),
FOREIGN KEY (ID_campaing) REFERENCES campaing(ID) ON DELETE CASCADE
);

