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

CREATE TABLE seguridad_validacion(
ID                  INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_administrador    INT(10) NOT NULL,
claveaut            varchar(60) NOT NULL,
FOREIGN KEY (ID_administrador) REFERENCES administrador(ID) ON DELETE CASCADE
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
ID_publicador 	  	INT(20) NULL,
numero_territorio 	VARCHAR(10),
imagen 				VARCHAR(250),
id_cloud            VARCHAR(250),
entrega 			VARCHAR(10),
devuelta 			VARCHAR(10),
asignado 			TINYINT(1) NOT NULL DEFAULT '0',
ID_publicador_campaind INT(20) NULL,
asignado_campaing 	TINYINT(1) NOT NULL DEFAULT '0',
entrega_campaing 	VARCHAR(10),
devuelta_campaing 	VARCHAR(10),
trabajado_vezultima varchar(10),
FOREIGN KEY (ID_congregacion) REFERENCES congregaciones(ID) ON DELETE CASCADE
);
CREATE TABLE asignado(

)

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
creado 				DATETIME,
FOREIGN KEY (ID_territorio) REFERENCES territorios(ID) ON DELETE CASCADE
);

CREATE TABLE historial(
ID 					INT(60) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_territorio 		INT(30) NOT NULL,
obser_historial 	VARCHAR(2000),
creado 				DATETIME,
FOREIGN KEY (ID_territorio) REFERENCES territorios(ID) ON DELETE CASCADE
);

CREATE TABLE service_year(
ID 					INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_congregacion 	INT(10) NOT NULL,
year            	VARCHAR(20) NOT NULL,
fecha_cierre        VARCHAR(20) NOT NULL,
activo 				TINYINT(1) NOT NULL DEFAULT '1',
FOREIGN KEY (ID_congregacion) REFERENCES congregaciones(ID) ON DELETE CASCADE
);
CREATE TABLE datos_service_year(
ID 					INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_service_year 		INT(10) NOT NULL,
numero_territorios 	VARCHAR(10),
territorios_predicados VARCHAR(10),
FOREIGN KEY (ID_service_year) REFERENCES service_year(ID) ON DELETE CASCADE
);
CREATE TABLE control_service_year(
ID            INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_service_year  INT(10) NOT NULL,
ID_territorio INT(20) NOT NULL,
predicado     TINYINT(1) NOT NULL DEFAULT '0',
FOREIGN KEY (ID_service_year) REFERENCES service_year(ID) ON DELETE CASCADE
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
CREATE TABLE control_territorios_campaing(
ID            INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
ID_campaing   INT(10) NOT NULL,
ID_territorio INT(20) NOT NULL,
predicado     TINYINT(1) NOT NULL DEFAULT '0',
FOREIGN KEY (ID_campaing) REFERENCES campaing(ID) ON DELETE CASCADE
);

DELIMITER //

CREATE PROCEDURE devuelta_terri_campaing(id_campaing INT, id_territorio INT)
BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
	END;

	START TRANSACTION; 

	UPDATE territorios SET ID_publicador_campaing = NULL, asignado_campaing = 0,devuelta_campaing = NOW() WHERE ID = id_territorio;
	UPDATE datos_campaing SET territorios_predicados = territorios_predicados+1 WHERE ID_campaing = id_campaing;
	UPDATE control_territorios_campaing SET predicado = 1 WHERE ID_campaing = id_campaing AND ID_territorio = id_territorio;

	COMMIT;

END//

DELIMITER ;	


