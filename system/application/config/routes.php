<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "home";
$route['scaffolding_trigger'] = "";

//custom routes
$route['(:any)-dentists'] = "dentist/seo_search";
$route['(:any)-dentists/(:num)-miles'] = "dentist/seo_search";
$route['(:any)-dentists/(:num)-miles/index-(:num)-limit-(:num)'] = "dentist/seo_search";
$route['(:any)-dentists/(:any)'] = "dentist/seo_profile";
$route['dentist-search'] = "dentist/search";
$route['article-video-search'] = "article/search";
$route['dental-articles'] = "article";
$route['dental-articles/(:any)-(:num)'] = "article/blogpage/$2";
$route['dental-videos'] = 'video';
$route['dental-articles/(:any)-category-(:num)'] = "article/category/$2";


/* End of file routes.php */
/* Location: ./system/application/config/routes.php */