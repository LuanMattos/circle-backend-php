<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group   = 'default';
$query_builder  = TRUE;
if(ENVIRONMENT === 'production'){
    $hostname = '172.31.17.131';
    $pass = 'J3K6051ER4u824VQP2A3I81QLO6uCCCg51zZ29H3V2KKlAWiJ3';
}else{
    $hostname = '192.168.100.49';
    $pass = 'eFdarksadfw4r54af4fd4a54h2fasfdg';
}
$db['default']  = [
	'dsn'	        => '',
	'hostname'      => $hostname,
	'username'      => 'square_db1',
	'port'          => '5432',
	'password'      => $pass,
	'database'      => 'postgres',
	'dbdriver'      => 'postgre',
	'dbprefix'      => 'square.',
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
