create database if not exists simple_seguridad;

use simple_seguridad;

create table if not exists perfiles (
	id int not null AUTO_INCREMENT,
	nombre varchar(50) not null,
	PRIMARY KEY (id),
	UNIQUE KEY nombre (nombre)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE if not exists usuarios (
	id int NOT NULL AUTO_INCREMENT,
	nombre varchar(50) NOT NULL,
	clave varchar(50) NOT NULL,
	tema varchar(50) NOT NULL,
	perfiles_id int not null,
	PRIMARY KEY (id),
	UNIQUE KEY nombre (nombre),
	CONSTRAINT usuarios_ibfk_1 FOREIGN KEY (perfiles_id) REFERENCES perfiles(id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



CREATE TABLE if not exists accesos (
	id int NOT NULL AUTO_INCREMENT,
	perfiles_id int not null,
	permisos varchar(1000) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY idx_accesos_1 (perfiles_id),
	CONSTRAINT accesos_ibfk_1 FOREIGN KEY (perfiles_id) REFERENCES perfiles(id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


insert into perfiles (nombre) values ('Administrador');
insert into usuarios (nombre,clave,perfiles_id) values ('Administrador',md5('simple'),1);

/*
create table if not exists accesos (
	id int not null AUTO_INCREMENT,
	appid varchar(50) not null,
	perfiles_id int not null,
	permiso varchar(200) not null default '',
	PRIMARY KEY (id),
	UNIQUE KEY idx_accesos_1 (appid,perfiles_id,permiso)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
*/
                                                                       


																	   
																	   