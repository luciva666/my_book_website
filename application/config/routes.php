<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'stories';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['auth/register'] = 'auth/register';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';

// API Routes
$route['api/auth/register'] = 'AuthApi/register';
$route['api/auth/login'] = 'AuthApi/login';
$route['api/auth/logout'] = 'AuthApi/logout';
$route['api/auth/profile'] = 'AuthApi/profile';

$route['api/stories'] = 'StoriesApi/index';
$route['api/stories/create'] = 'StoriesApi/create';
$route['api/stories/(:num)'] = 'StoriesApi/view/$1';
$route['api/stories/(:num)/update'] = 'StoriesApi/update/$1';
$route['api/stories/(:num)/delete'] = 'StoriesApi/delete/$1';

$route['api/episodes/(:num)'] = 'EpisodesApi/view/$1';
$route['api/episodes/story/(:num)/create'] = 'EpisodesApi/create/$1';
$route['api/episodes/(:num)/update'] = 'EpisodesApi/update/$1';
$route['api/episodes/(:num)/delete'] = 'EpisodesApi/delete/$1';

