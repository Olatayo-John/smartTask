<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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

//common
$route['default_controller'] = 'pages';
$route['/'] = 'pages';

$route['home'] = 'pages/index';
$route['account'] = 'pages/account';
$route['dashboard'] = 'dashboard';

$route['logout'] = 'pages/logout';



//admin
$route['adminlogin'] = 'admin/login';
$route['logs'] = 'admin/logs';
$route['clear-activity'] = 'admin/clear_activityLogs';
$route['clear-feedbacks'] = 'admin/clear_feedbackLogs';



//settings
$route['settings'] = 'settings/index';
$route['save-settings'] = 'settings/save';
$route['reset-settings'] = 'settings/reset';



//user
$route['userlogin'] = 'user/login';



//pages
$route['emailverify/(:any)'] = 'pages/emailverify/$1';
$route['verifyemail/(:any)'] = 'pages/emailverify/$1';
$route['support'] = 'pages/support';



$route['404_override'] = 'pages/fof';
$route['translate_uri_dashes'] = FALSE;