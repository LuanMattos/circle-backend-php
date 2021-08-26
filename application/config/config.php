<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['sess_cookie_name']		= 'circle_session';
$config['sess_expiration']		= 7200;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= TRUE;
$config['sess_table_name']		= 'circle_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update'] 	= 300;
$config['encryption_key']       = '';
$config['base_url'] = URL_RAIZ();
$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = TRUE;
//$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'SI_';
$config['composer_autoload'] = TRUE;
require_once APPPATH.'vendor/autoload.php';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['allow_get_array'] = TRUE;
$config['log_threshold'] = 1;
$config['log_path'] = 'application/logs/';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['composer_autoload'] = 'vendor/autoload.php';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = '';
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 9200;
$config['sess_save_path'] = sys_get_temp_dir();
//$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = TRUE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

#Cors
$config['origin_prod'] = '';
$config['origin_prod1'] = '';
$config['origin_prod2'] = '';
$config['origin_dev_back'] = 'localhost';
$config['origin_dev_front'] = 'localhost:4200';
$config['elb_ip'] = ['172.31.0.0'];
$config['headers'] = [
    'Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT',
    'Access-Control-Allow-Origin: *',
    'Access-Control-Allow-Headers: Origin, Authorization, Client-Security-Token, Accept-Encoding, X-Auth-Token, X-Requested-With, Content-Type, Accept, x-Access-Token',
    'Content-type: application/json'
];

#Endpoints API Django
$config['drf'] = '172.31.33.133:8000/';
$config['drf_dev'] = 'host.docker.internal:8000/';
$config['password_django'] = 'admin';
$config['username_django'] = 'admin';
$config['password_django_dev'] = 'admin';
$config['username_django_dev'] = 'admin';

$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
$config['email_account_marketing'] = '';

#Amazon SES
$config['email_account'] = '';
$config['host'] = '';
$config['user_name'] = '';
$config['password'] = '';

$config['ip_ignore'] = [];

#Notification E-mail
$config['attempts_access'] = 8;
$config['limit_send_email_monetization_cron'] = 5;

#JWT
$config['leeway_token'] = 6;
$config['expire_token'] = 60;
$config['private_key_jwt'] = "";
$config['public_key_jwt'] = "";


#S3
$config['s3']["accessKey"] = '';
$config['s3']["secretKey"] = '';
$config['s3']["useSSL"] = false;
$config['bucket_name'] = '';
$config['bucket_name_video'] = '';
$config['end_point'] = '';
$config['end_point_video'] = '';
$config['end_point_video_url'] = '';
