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
$route['default_controller'] = 'verificacion';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['invitacion/(:any)'] = 'invitacion/index/$1';

/** rutas por categoria */
$route['disenioMultimedia'] = 'invitacion/index/1';
$route['computacion'] = 'invitacion/index/2';
$route['ingenieria'] = 'invitacion/index/3';
$route['sistemas'] = 'invitacion/index/4';
$route['educacionVirtual'] = 'invitacion/index/5';
$route['videoCertificados'] = 'invitacion/video_informaciones/1';
$route['videoInscripcion'] = 'invitacion/video_informaciones/2';
$route['zoom'] = 'invitacion/video_informaciones/3';
$route['inscripcion-ofimatica'] = 'invitacion/video_informaciones/4';
$route['inscripcion-excelavanzado'] = 'invitacion/video_informaciones/5';
$route['inscripcion-tics'] = 'invitacion/video_informaciones/6';
$route['zoom-ofimatica'] = 'invitacion/video_informaciones/7';
$route['inscripcion-moodle'] = 'invitacion/video_informaciones/8';
$route['inscripcion-after-effects'] = 'invitacion/video_informaciones/9';
$route['team-psg'] = 'invitacion/video_informaciones/10';
$route['inscripcion-photoshop-retoque'] = 'invitacion/video_informaciones/11';
$route['inscripcion-excel'] = 'invitacion/video_informaciones/12';
$route['inscripcion-autocad-2d'] = 'invitacion/video_informaciones/13';
$route['inscripcion-autocad-3d'] = 'invitacion/video_informaciones/14';
$route['inscripcion-routers'] = 'invitacion/video_informaciones/15';
$route['inscripcion-computacion'] = 'invitacion/video_informaciones/16';
$route['inscripcion-videoconferencias'] = 'invitacion/video_informaciones/17';
$route['inscripcion-canva-v1'] = 'invitacion/video_informaciones/18';
$route['informacion-canva-1'] = 'invitacion/video_informaciones/19';
$route['informacion-canva-2'] = 'invitacion/video_informaciones/20';
$route['informacion-maestria-educacion-superior'] = 'invitacion/video_informaciones/21';

$route['inscripcion-router-v4'] = "invitacion/video_informaciones/22";
$route['inscripcion-excel-v5'] = "invitacion/video_informaciones/23";
$route['inscripcion-computacion-v4'] = "invitacion/video_informaciones/24";
$route['inscripcion-ofimatica-b'] = "invitacion/video_informaciones/25";
