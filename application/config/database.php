<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group   = 'default';
$query_builder  = TRUE;

if(ENVIRONMENT === 'production'){
    $hostname = 'www.atos.click';
}else{
    $hostname = 'localhost';
}
$db['default']  = [
	'dsn'	        => '',
	'hostname'      => 'mycircle.click',
	'username'      => 'postgres',
	'port'          => '5432',
	'password'      => 'eFdarksadfw4r54af4fd4a54h2fasfdg',
	'database'      => 'postgres',
	'dbdriver'      => 'postgre',
	'dbprefix'      => 'square',
	'pconnect'      => FALSE,
	'db_debug'      => (ENVIRONMENT !== 'production'),
	'cache_on'      => FALSE,
	'cachedir'      => '',
	'char_set'      => 'utf8',
	'dbcollat'      => 'utf8_general_ci',
	'swap_pre'      => '',
	'encrypt'       => FALSE,
	'compress'      => FALSE,
	'stricton'      => FALSE,
	'failover'      => array(),
	'save_queries'  => TRUE
];

//require_once 'database_chat.php';
//$mongo = new database_chat();
//$config['mongodb'] = $mongo->config_mongo();
