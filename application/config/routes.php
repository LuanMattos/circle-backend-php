<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = 'Home';
$route['404_override'] = 'Home/error_404';

$route['signup']['POST'] = 'user/register';
$route['userLogin']['POST'] = 'user/login';
$route['validUser/(:any)']['GET'] = 'user/userExists';
$route['search/?(:any)?']['PUT'] = 'user/search/$page';
$route['save_setting']['POST'] = 'user/saveSetting';
$route['upload_img_profile']['POST'] = 'user/uploadImgProfile';
$route['upload_img_cover']['POST'] = 'user/uploadImgCover';
$route['data_user_basic/(:any)']['POST'] = 'user/dataUserBasic';
$route['verify']['POST'] = 'user/verificationCode';

$route['photos/(:any)/?(:any)?']['GET'] = 'photos/index/$id';
$route['photos_upload']['POST'] = 'photos/upload';
$route['get_photo/(:any)']['GET'] = 'photos/getPhoto';
$route['get_photo_id/(:any)']['GET'] = 'photos/getPhotoId';

$route['comments_photo/(:any)/?(:any)?']['GET'] = 'comments/index/$id';
$route['save_comment/(:any)']['PUT'] = 'comments/save';
$route['get_comment_id/(:any)']['GET'] = 'comments/getCommentId';
$route['delete_comment/(:any)']['DELETE'] = 'comments/delete';

$route['add_like']['PUT'] = 'likes/like';


$route['follow/(:any)']['PUT'] = 'Follower/follow/$id';



$route['log_home']['GET'] = 'Home/logHome';






