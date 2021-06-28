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
$config['encryption_key']       = '$argon2i$v=19$m=65536,t=4,p=1$ek1lVDhZdUx2RUs5U0VYTw$uOrHYACaxNoP5t4+ZAngaYPRpWcbUwIoFHI2bE1qsgc';
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
$config['log_threshold'] = 4;
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
$config['origin_prod'] = 'mycircle.click';
$config['origin_prod1'] = 'circle-73cde.web.app';
$config['origin_prod2'] = 'circle-73cde.firebaseapp.com';
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
$config['drf'] = 'host.docker.internal:8000/';
$config['password_django'] = 'admin';
$config['username_django'] = 'admin';

$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
$config['email_account_marketing'] = 'account@mycircle.click';

#Amazon SES
$config['email_account'] = 'account@mycircle.click';
$config['host'] = 'email-smtp.us-west-2.amazonaws.com';
$config['user_name'] = 'AKIA4CJF77WXLTBFC7XR';
$config['password'] = 'BLgU+PcHTYjSFHsFj6eIE3WDDo46vtntzh6RJVqXrtYS';

$config['ip_ignore'] = ['45.167.104.17','187.71.137.242'];

#Notification E-mail
$config['attempts_access'] = 8;
$config['limit_send_email_monetization_cron'] = 5;

#JWT
$config['leeway_token'] = 6;
$config['expire_token'] = 60;
$config['private_key_jwt'] = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
-----END RSA PRIVATE KEY-----
EOD;
$config['public_key_jwt'] = 'teste';
//$config['public_key_jwt'] = <<<EOD
//-----BEGIN PUBLIC KEY-----
//MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
//4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
//0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
//ehde/zUxo6UvS7UrBQIDAQAB
//-----END PUBLIC KEY-----
//EOD;

#S3
$config['s3']["accessKey"] = 'AKIA4CJF77WXHXLOKX74';
$config['s3']["secretKey"] = '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';
$config['s3']["useSSL"] = false;
$config['bucket_name'] = 'circle-photo';
$config['bucket_name_video'] = 'circle-video';
$config['end_point'] = 's3.sa-east-1.amazonaws.com';
$config['end_point_video'] = 's3.sa-east-1.amazonaws.com';
$config['end_point_video_url'] = 's3-sa-east-1.amazonaws.com';
