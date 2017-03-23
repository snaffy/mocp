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
$route['default_controller'] = 'Log_reg/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = true;


// LOGIN REGISTER
$route['login']='Log_reg/login';
$route['register'] ='Log_reg/register';

//home
$route['home'] = 'User_home/home';
$route['activeinv'] = 'User_home/activeinv';
$route['profile'] ='User_home/profile';
$route['logout'] ='User_home/logout';
$route['test'] ='User_home/test';
//projects
$route['project'] ='User_projects/project_overview';
$route['project/event'] = 'User_projects/task';
$route['project/event/resources'] ='User_projects/connect_to_gatt';
$route['project/test'] = 'User_projects/test_gantt';
//Budget
$route['project/budget'] = 'User_projects/budget';
//Doceumnts
$route['project/documents'] = 'User_documents/menage_file';
$route['project/documents/transfer'] = 'User_documents/transfer_server';
$route['project/documents/transfer/upload_handler'] = 'User_documents/upload_handler';
$route['project/documents/elfinderconnector'] = 'User_documents/get_elfinder_connector';
//Human Resources
$route['project/hr']='User_projects/manage_hr';
//Resources
$route['resources/projects_data'] = 'Resources/projects_data';
$route['resources/invitations_data'] = 'Resources/invitations_data';
$route['resources/user_in_project_data'] ='Resources/user_in_project_data';