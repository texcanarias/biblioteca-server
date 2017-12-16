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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| REST API Routes
 * @todo Cada una de estas rutas deberían estar integradas dentro de sus controladores.
| -------------------------------------------------------------------------
*/

//----------------------------------------------------------------
// REGISTRO_1_0
//----------------------------------------------------------------
require (__DIR__ .'/../controllers/registro_1_0/routes.php'); 


//----------------------------------------------------------------
// EUSKALIT_EMPRESAS_1_0
//----------------------------------------------------------------
require (__DIR__ .'/../controllers/euskalit_empresas_1_0/routes.php');

//----------------------------------------------------------------
// EUSKALIT_EDICION_EQUIPO_TRABAJO_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_edicion_equipo_trabajo_1_0/routes.php');


//----------------------------------------------------------------
// EUSKALIT_EDICION_DOCUMENTACION_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_edicion_documentacion_1_0/routes.php');

//----------------------------------------------------------------
// EUSKALIT_EDICION_CHECKLIST_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_edicion_checklist_1_0/routes.php');


//----------------------------------------------------------------
// EUSKALIT_EDICION_INDICADOR_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_edicion_indicador_1_0/routes.php');

//----------------------------------------------------------------
// EUSKALIT_EDICION_AREA_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_edicion_area_1_0/routes.php');

//----------------------------------------------------------------
// EUSKALIT_AUDITORIA_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_auditoria_1_0/routes.php');

//----------------------------------------------------------------
// EUSKALIT_AUDITORIA_CHECKLIST_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_auditoria_checklist_1_0/routes.php');

//----------------------------------------------------------------
// EUSKALIT_AUDITORIA_INDICADOR_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_auditoria_indicador_1_0/routes.php');

//----------------------------------------------------------------
// EUSKALIT_AUDITORIA_ACCION_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_auditoria_accion_1_0/routes.php');


//----------------------------------------------------------------
// EUSKALIT_ESTADISTICA_1_0
//----------------------------------------------------------------
require (__DIR__.'/../controllers/euskalit_estadistica_1_0/routes.php');