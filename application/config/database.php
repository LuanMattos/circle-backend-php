<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group   = 'default';
$query_builder  = TRUE;
if(ENVIRONMENT === 'production'){
    $hostname = 'squaredb1.cowcxqaftukz.us-east-2.rds.amazonaws.com';
    $pass = 'F4D3Ro8Ud3VVH61K74Vlp31HKyCmd3Tp1g5N';
    $username = 'postgres';
}else{
    $hostname = '192.168.80.1';
    $pass = 'postgres';
      $username = 'postgres';
}


$db['default']  = [
	'dsn'	        => '',
	'hostname'      => $hostname,
	'username'      => $username,
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
