<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = 'Home';
$route['404_override'] = 'Home/error_404';

$route['signup']['POST'] = 'user/register';
$route['userLogin']['POST'] = 'user/login';
$route['validUser/(:any)']['GET'] = 'user/userExists';
$route['search']['PUT'] = 'user/search';

$route['photos/(:any)/?(:any)?']['GET'] = 'photos/index/$id';
$route['photos_upload']['POST'] = 'photos/upload';
$route['get_photo/(:any)']['GET'] = 'photos/getPhoto';
$route['get_photo_id/(:any)']['GET'] = 'photos/getPhotoId';

$route['comments/(:any)']['POST'] = 'comments/save';
$route['comments_photo/(:any)/?(:any)?']['GET'] = 'comments/index/$id';
$route['save_comment/(:any)']['PUT'] = 'comments/saveComment';
$route['get_comment_id/(:any)']['GET    '] = 'comments/getCommentId';

$route['add_like']['PUT'] = 'likes/like';



