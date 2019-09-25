<?php

$config_apps = array();

$config_apps['jquery-ui_temas_dir_url'] = '/jquery-ui-themes-1.12.1/themes/';
$config_apps['jquery-ui_temas_archivo'] = 'jquery-ui.css';
$config_apps['jquery-ui_url'] = '/jquery-ui-1.12.1/jquery-ui.min.js';
$config_apps['jquery_url'] = '/jquery-ui-1.12.1/jquery-3.4.1.min.js';

//$config_apps['fontawesome-free_url'] = '/fontawesome-free-5.1.0-web/css/all.css';
//$config_apps['fontawesome-free_url'] = '/fontawesome-free-5.0.7/web-fonts-with-css/css/fontawesome-all.min.css';
//$config_apps['fontawesome-free_url'] = '/fontawesome-free-5.6.3-web/css/all.css';
//$config_apps['fontawesome-free_url'] = '/fontawesome-free-5.8.2-web/css/all.css';
$config_apps['fontawesome-free_url'] = '/fontawesome-free-5.11.2-web/css/all.css';


$config_apps['libs_css_url'][] = 'config/misCSS.css';


//$config_apps['libs_js_url'][] = '/inputmask-3.3.11/dist/jquery.inputmask.bundle.js';
//$config_apps['libs_js_url'][] = '/inputmask-3.3.11/dist/inputmask/bindings/inputmask.binding.js';
$config_apps['libs_js_url'][] = '/inputmask-4.x/dist/jquery.inputmask.bundle.js';
$config_apps['libs_js_url'][] = '/inputmask-4.x/dist/inputmask/bindings/inputmask.binding.js';
$config_apps['libs_js_url'][] = 'config/datepicker_es.js';
$config_apps['libs_js_url'][] = 'config/misMask.js';
$config_apps['libs_js_url'][] = 'config/misCompleta.js';


$config_apps['dir_modulos_php'] = 'modulos/';
$config_apps['dir_modulos_js'] = 'modulos_js/';




$aApps = array();

$aApps[] = array ("appid"=>"App003","appdesc"=>"Facturación","appicon"=>"fa fa-users","modulos"=>array("clientes","productos","ventas","ventas2"));

$aApps[] = array ("appid"=>"home000","appdesc"=>"Home","appicon"=>"fa fa-home","modulos"=>array("alumnos")); 

$aApps[] = array ("appid"=>"App001","appdesc"=>"Catálogos","appicon"=>"fa fa-graduation-cap","modulos"=>array("grupos")); 

$aApps[] = array ("appid"=>"App002","appdesc"=>"Catálogos Administrador","appicon"=>"fa fa-users","modulos"=>array("alumnos","grupos"));




?>