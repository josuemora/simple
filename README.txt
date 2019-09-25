====================================================
Español

"Simple" por Josue Mora Ureña.

Simple no intenta ser un "Marco de Trabajo" (FrameWork), --o talvez un poco. 
Es un intento de no reescribir código en tareas repetitivas.
Es un intento de crear aplicaciones web para el registro de datos permanentes. --"Crear, Leer, Actualizar y Borrar" (CRUD). 
Es un intento de aplicar el principio KISS (Keep It Simple, Stupid)/(Keep It Short and Simple), --espero no haber realizado lo contrario.
Realizado en PHP, MySql/MariaDB, HTML5, jQuery, jQuery UI, fontawesome-free.
(PHP 5/PHP 7/ MySQL 5/MariaDB 10/jQuery 3.2.1+/jQuery UI 1.12.1+/fontawesome-free-5.0.7+).

URL's Librerias:
	https://fontawesome.com/download
	https://jquery.com/download/
	https://jqueryui.com/download/
	https://github.com/RobinHerbots/Inputmask
	


Usuario: Administrador
Contraseña: simple

***Importante, requiere de las librerias jQuery, fontawesome-free e InputMask.
***Debes configurar los "PATHS" en el archivo ./config/apps.php
***Debes ejecutar los archivos .sql de la carpeta ./core



Estructura y Descripción de Archivos:

/config
	apps.php
		configuracion de PATHS de las librerias de jQuery, fontawesome-free, e InputMask
		configuracion de las Apps con sus modulos de mantenimiento de datos.
		
	db_pdo.php
		configuracion de la conección a la Base de datos MySQL/MariaDB.
		
		

/consultas
	ABC_*.php 
		Scripts que seran llamados via AJAX y responden con estructura de datos XML, y que realizan las operaciones CRUD por cada modulo.
		
	QuerysPorModulo.php
		Script que contiene los Querys por cada modulo integrado en las Apps y que realizan la funcion de lectura de datos para llenar los GRIDS de consulta.

/core
	base.js
		Script con las funciones en jQuey que realizan las acciones de control.
		
	plantilla1.php
		Script que genera una plantilla en HTML5 y codigo jQuery (Vista).
		
	plantilla_listado1.php
		Script que genera una plantilla en HTML5 y codigo jQuery (Vista).
		
	simple_seguridad.sql
		Script para la creacion de las tablas necesarias para la carga de datos de los modulos de seguridad.

	simple_test.sql
		Script para la creacion de las tablas de los modulos de ejemplo.
	
/images

/modulos
	*.php
		Script de cada modulo que puede llamar a plantillas en base a un parametro de tipo array que realiza las acciones de modelo.

/modulos_js
	*.js
		Script en jQuery en caso de ser necesario por cada modulo creado.
/test




