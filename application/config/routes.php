 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

// /$route['default_controller'] = 'c_login';
$route['default_controller'] = 'c_register';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// === register ===
$route['register/proses-register'] = 'c_register/proses_register';

// === AUTH ===
$route['uath/authUserPassword'] = 'c_login/authUserPassword';
$route['auth/authGoogle'] = 'c_login/authGoogle';
// $route['auth/gen_pass'] = 'c_login/gen_pass';
$route['auth/logMeOut'] = 'c_login/logMeOut';

$route['authEmp/(:any)/(:any)'] = 'c_login/genratePassword2/$1/$2';

$route['gen/(:any)/(:any)'] = 'c_login/gen/$1/$2';


$route['db/(:any)'] = 'auth/c_auth/db/$1';


// === Dashboard ===
$route['dashboard'] = 'dashboard/c_dashboard';
$route['profile/(:any)'] = 'dashboard/c_dashboard/profile/$1';


// === api ==
$route['api/__getWilayahURLJson'] = 'api/c_api/getWilayahURLJson';
$route['api/__getSMAWilayah'] = 'api/c_api/getSMAWilayah';