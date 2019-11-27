
drop database simple_test;



create database if not exists simple_test default charset=utf8;

use simple_test;


CREATE TABLE if not exists grupos (
  id int unsigned NOT NULL AUTO_INCREMENT,
  grado int NOT NULL,
  salon varchar(10) NOT NULL,
  turno varchar(20) NOT NULL,
  cache varchar(3000) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  UNIQUE KEY grado_salon_turno (grado,salon,turno)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE if not exists alumnos (
  id int unsigned NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  paterno varchar(100) NOT NULL,
  materno varchar(100) NOT NULL,
  grupos_id int unsigned NOT NULL,
  sexo char(1) NOT NULL DEFAULT 'm',
  usalentes char(1) NOT NULL DEFAULT 'n',
  enfermedad char(1) NOT NULL DEFAULT 'n',
  capacidaddiferente char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (id),
  KEY nombre (nombre),
  KEY paterno (paterno),
  KEY materno (materno),
  KEY grupos_id (grupos_id),
  CONSTRAINT alumnos_ibfk_1 FOREIGN KEY (grupos_id) REFERENCES grupos (id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE if not exists clientes (
  id int unsigned NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE if not exists productos (
  id int unsigned NOT NULL AUTO_INCREMENT,
  descripcion varchar(100) NOT NULL,
  precio decimal(10,2) not null default 0.00,
  PRIMARY KEY (id),
  UNIQUE KEY descripcion (descripcion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE if not exists ventas (
  id int unsigned NOT NULL AUTO_INCREMENT,
  clientes_id int(10) unsigned NOT NULL,
  fecha date NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT ventas_ibfk_1 FOREIGN KEY (clientes_id) REFERENCES clientes (id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE if not exists detventas (
  id int unsigned NOT NULL AUTO_INCREMENT,
  ventas_id int unsigned NOT NULL,
  productos_id int unsigned not null,
  cantidad decimal(10,2) not null default 0.00,
  precio decimal(10,2) not null default 0.00,
  PRIMARY KEY (id),
  CONSTRAINT detventas_ibfk_1 FOREIGN KEY (ventas_id) REFERENCES ventas (id) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT detventas_ibfk_2 FOREIGN KEY (productos_id) REFERENCES productos (id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE if not exists ventas2 (
  id int unsigned NOT NULL AUTO_INCREMENT,
  clientes_id int(10) unsigned NOT NULL,
  fecha date NOT NULL,
  cache varchar(3000) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  CONSTRAINT ventas2_ibfk_1 FOREIGN KEY (clientes_id) REFERENCES clientes (id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE if not exists detventas2 (
  ren int unsigned NOT NULL default 1,
  ventas_id int unsigned NOT NULL,
  productos_id int unsigned not null,
  cantidad decimal(10,2) not null default 0.00,
  precio decimal(10,2) not null default 0.00,
  PRIMARY KEY (ventas_id,ren),
  CONSTRAINT detventas2_ibfk_1 FOREIGN KEY (ventas_id) REFERENCES ventas2 (id) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT detventas2_ibfk_2 FOREIGN KEY (productos_id) REFERENCES productos (id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE USER 'simple'@'localhost' IDENTIFIED BY '12345';
grant select,insert,update,delete on simple_test.* to 'simple'@'localhost';
grant select,insert,update,delete on simple_seguridad.* to 'simple'@'localhost';
FLUSH PRIVILEGES;

