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
$route['default_controller'] = 'PlatformController';
$route['404_override'] = 'NotFound/index';;
$route['translate_uri_dashes'] = FALSE;


//*****FUNCIONES API***** 
//TEST
$route['api/test/pdf']['get'] = 'Test/pdf';
$route['api/test/uploadFile']['post'] = 'Test/uploadFile';

//Login
$route['api/login']['get'] = 'IniciarSesion/login';
$route['api/getLogo']['get'] = 'IniciarSesion/getLogo';
$route['api/getLogoUser']['get'] = 'IniciarSesion/getLogoUser';
$route['api/login/recover']['get'] = 'IniciarSesion/recoverPassword';
$route['api/login/password']['put'] = 'IniciarSesion/setPassword';

//Token
$route['api/tokens/validate']['get'] = 'IniciarSesion/validateToken';


//Geocercas y Puntos de interes
$route['api/geofences']['get'] = 'GeofenceManager/geofences';
$route['api/geofences/(:num)']['get'] = 'GeofenceManager/geofence/$1';
$route['api/geofences']['post'] = 'GeofenceManager/geofence';
$route['api/geofences/(:num)']['put'] = 'GeofenceManager/geofence/$1';
$route['api/geofences/(:num)']['delete'] = 'GeofenceManager/geofence/$1';
$route['api/geofences/(:num)/devices/near']['get'] = 'GeofenceManager/geofenceDevicesNear/$1';
$route['api/geofences/(:num)/behavior/(:num)']['put'] = 'GeofenceManager/geofenceBehavior/$1/$2';
$route['api/geofences/(:num)/devices/(:num)']['post'] = 'GeofenceManager/deviceToGeofence/$1/$2';
$route['api/geofences/(:num)/devices']['get'] = 'GeofenceManager/devicesFromGeofence/$1';
$route['api/geofences/(:num)/devices/(:num)']['delete'] = 'GeofenceManager/deviceFromGeofence/$1/$2';
$route['api/geofences/(:num)/subscribers/emails']['post'] = 'GeofenceManager/geofenceEmailSubscribers/$1';
$route['api/geofences/(:num)/subscribers/emails']['get'] = 'GeofenceManager/geofenceEmailSubscribers/$1';
$route['api/geofences/(:num)/subscribers/emails/(:num)']['delete'] = 'GeofenceManager/geofenceEmailSubscribers/$1/$2';

//Configuraciones
$route['api/configuration/eventpassword']['put'] = 'ConfigurationController/eventPassword';
$route['api/configuration/eventpassword/exists']['get'] = 'ConfigurationController/eventPasswordExists';
$route['api/configuration/eventpassword/expiration']['get'] = 'ConfigurationController/eventPasswordExpiration';
$route['api/configuration/eventpassword/validate']['get'] = 'ConfigurationController/validateEventPassword';
$route['api/configuration/account']['get'] =  'AccountManager/account';
$route['api/configuration/account/logo']['post'] =  'AccountManager/logo';
$route['api/configuration/account']['put'] =  'AccountManager/account';
$route['api/configuration/uploadFile']['post'] = 'AccountManager/uploadFile';


//Rutas
$route['api/routes']['post'] = 'RoutesManager/routes';

//Permisos
$route['api/permissions']['get'] = 'PermissionsManager/permissions';

//Cuentas y Usuarios
$route['api/accounts']['post'] = 'AccountManager/createAccount';
$route['api/accounts']['get'] = 'AccountManager/accounts';
$route['api/accounts/(:num)']['get'] = 'AccountManager/account/$1';
$route['api/accounts/(:num)']['put'] = 'AccountManager/account/$1';

$route['api/accounts/(:num)']['delete'] = 'AccountManager/account/$1';


$route['api/accounts/contacts']['post'] = 'AccountManager/contact';
$route['api/contact/(:num)']['put'] = 'AccountManager/contact/$1';
$route['api/accounts/contacts/(:num)']['post'] = 'AccountManager/contact/$1';
$route['api/accounts/contacts/(:num)']['delete'] = 'AccountManager/contact/$1';
$route['api/accounts/(:num)/status']['put'] = 'AccountManager/accountStatus/$1';


$route['api/users']['post'] = 'UsersManager/createUser';
$route['api/users']['get'] = 'UsersManager/getUsers';
$route['api/users/(:num)']['get'] = 'UsersManager/getUser/$1';
$route['api/users/(:num)']['put'] = 'UsersManager/updateUser/$1';
$route['api/users/(:num)']['delete'] = 'UsersManager/user/$1';
$route['api/users/(:num)/devices']['post'] = 'DeviceManager/suscribeUserToDevices/$1';
$route['api/users/(:num)/devices/(:num)']['delete'] = 'DeviceManager/unsuscribeUserFromDevices/$1/$2';
$route['api/users/(:num)/status']['put'] = 'UsersManager/userStatus/$1';

//Flotillas
$route['api/fleets']['post'] = 'FleetsManager/fleets';
$route['api/fleets']['get'] = 'FleetsManager/fleets';
$route['api/fleets/(:num)']['get'] = 'FleetsManager/fleet/$1';
$route['api/fleets/(:num)']['put'] = 'FleetsManager/fleet/$1';
$route['api/fleets/(:num)']['delete'] = 'FleetsManager/fleet/$1';

//Dispositivos
$route['api/devices']['get'] = 'LocateDevices/getDeviceList';
$route['api/devices/(:num)']['get'] = 'LocateDevices/getDeviceInfo/$1';
$route['api/devices']['post'] = 'DeviceManager/devices';
$route['api/devices/(:num)']['put'] = 'DeviceManager/updateDevice/$1';
$route['api/devices/(:num)/fleets']['put'] = 'DeviceManager/updateDeviceFleet/$1';
$route['api/devices/store']['get'] = 'DeviceManager/getDeviceStore';
$route['api/devices/(:num)/sim/(:num)/store/(:num)']['delete'] = 'DeviceManager/deleteDevice/$1/$2/$3';
$route['api/devices/sim/(:num)']['get'] = 'DeviceManager/getSimsDevice/$1';

//Sims
$route['api/sims']['post'] = 'SimsManager/createSims';
$route['api/sims/store']['get'] = 'SimsManager/getSimStore';
$route['api/sims/(:num)']['get'] = 'SimsManager/getSims/$1';
$route['api/sims/(:num)']['put'] = 'SimsManager/updateSims/$1';
$route['api/sims/store/(:num)']['delete'] = 'SimsManager/deleteSims/$1';

//Reportes
$route['api/reports/historical']['get'] = 'ReportManager/reportHistorical';
$route['api/reports/geofences']['get'] = 'ReportManager/geofenceReport';
$route['api/reports/alerts']['get'] = 'ReportManager/alertReport';
$route['api/reports/routes/basic']['get'] = 'ReportManager/basicRouteReport';

$route['api/reports/distance']['get'] = 'ReportManager/distanceReport';
$route['api/reports/distance/export']['get'] = 'ReportManager/distanceReportFile';
$route['api/reports/enginehours']['get'] = 'ReportManager/engineHoursReport';
$route['api/reports/enginehours/export']['get'] = 'ReportManager/engineHoursReportFile';
$route['api/reports/ralenti']['get'] = 'ReportManager/ralentiReport';
$route['api/reports/ralenti/export']['get'] = 'ReportManager/ralentiReportFile';
$route['api/reports/users/login']['get'] = 'ReportManager/userLoginReport';
$route['api/reports/users/login/export']['get'] = 'ReportManager/userLoginReportFile';
$route['api/reports/stops']['get'] = 'ReportManager/stoppedReport';
$route['api/reports/stops/export']['get'] = 'ReportManager/stoppedReportFile';
$route['api/reports/speed']['get'] = 'ReportManager/speedReport';
$route['api/reports/speed/export']['get'] = 'ReportManager/speedReportFile';
$route['api/reports/battery']['get'] = 'ReportManager/batteryReport';
$route['api/reports/battery/export']['get'] = 'ReportManager/batteryReportFile';
$route['api/reports/noreports']['get'] = 'ReportManager/noReportReport';
$route['api/reports/noreports/export']['get'] = 'ReportManager/noReportReportFile';




//Catalogos
$route['api/catalogs/timezones']['get'] = 'CatalogsManager/timezones';
$route['api/catalogs/markers']['get'] = 'CatalogsManager/markers';
$route['api/catalogs/legalstatus']['get'] = 'CatalogsManager/legalstatus';
$route['api/catalogs/devices/factories']['get'] = 'CatalogsManager/deviceFactories';
$route['api/catalogs/devices/factories/(:num)/models']['get'] = 'CatalogsManager/deviceModels/$1';
$route['api/catalogs/devices/reports/types']['get'] = 'CatalogsManager/deviceReportTypes';
$route['api/catalogs/sims/carriers']['get'] = 'CatalogsManager/simCarriers';
$route['api/catalogs/sims/plan']['get'] = 'CatalogsManager/simPlans';
$route['api/catalogs/people']['get'] = 'CatalogsManager/peopleTypes';
$route['api/catalogs/products/factories']['get'] = 'CatalogsManager/productFactories';
$route['api/catalogs/products/factories/(:num)/models']['get'] = 'CatalogsManager/productModels/$1';
$route['api/catalogs/products/states']['get'] = 'CatalogsManager/productStates';
$route['api/catalogs/products/types']['get'] = 'CatalogsManager/productTypes';
$route['api/catalogs/transfers/types']['get'] = 'CatalogsManager/transferTypes';

//Productos
$route['api/store/summary']['get'] = 'StoreManager/summary';
$route['api/store']['get'] = 'StoreManager/products';

//Productos Genericos
$route['api/products/generic']['post'] = 'GenericProductManager/products';
$route['api/products/generic/(:num)']['get'] = 'GenericProductManager/product/$1';
$route['api/products/generic']['get'] = 'GenericProductManager/products';
$route['api/products/generic/(:num)']['put'] = 'GenericProductManager/product/$1';
$route['api/products/generic/(:num)']['delete'] = 'GenericProductManager/product/$1';


//Kits
$route['api/kits']['post'] = 'KitManager/kit';
$route['api/kits/(:num)']['get'] = 'KitManager/kit/$1';
$route['api/kits']['get'] = 'KitManager/kits';
$route['api/kits/(:num)']['put'] = 'KitManager/kit/$1';
$route['api/kits/(:num)']['delete'] = 'KitManager/kit/$1';

//Transacciones
$route['api/transactions']['post'] = 'TransactionManager/transaction';
$route['api/transactions']['get'] = 'TransactionManager/transactions';
$route['api/transactions/(:num)']['get'] = 'TransactionManager/transaction/$1';

//Transferencias
$route['api/transfers']['post'] = 'TransferManager/transfer';
$route['api/transfers']['get'] = 'TransferManager/transfers';
$route['api/transfers/(:num)']['get'] = 'TransferManager/transfer/$1';
$route['api/transfers/(:num)/finalize']['put'] = 'TransferManager/finalizeTransfer/$1';
$route['api/transfers/(:num)']['delete'] = 'TransferManager/transfer/$1';



