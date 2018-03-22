 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

// /$route['default_controller'] = 'c_login';
$route['default_controller'] = 'c_register';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// === register ===
$route['register/proses-register'] = 'c_register/proses_register';
//$route['register/autoCall'] = 'c_register/MoveTableRegister';

// === AUTH ===
$route['uath/authUserPassword'] = 'c_login/authUserPassword';
$route['auth/authGoogle'] = 'c_login/authGoogle';
// $route['auth/gen_pass'] = 'c_login/gen_pass';
$route['auth/logMeOut'] = 'c_login/logMeOut';

$route['authEmp/(:any)/(:any)'] = 'c_login/genratePassword2/$1/$2';

$route['gen/(:any)/(:any)'] = 'c_login/gen/$1/$2';


$route['db/(:any)'] = 'auth/c_auth/db/$1';

// === api ==
$route['api/__getWilayahURLJson'] = 'api/c_api/getWilayahURLJson';
$route['api/__getSMAWilayah'] = 'api/c_api/getSMAWilayah';
$route['api/__getProgramStudy'] = 'api/c_api/getProgramStudy';
$route['api/__getCountry'] = 'api/c_api/getCountry';
$route['api/__getAgama'] = 'api/c_api/getAgama';
$route['api/__getJenisTempatTinggal'] = 'api/c_api/getJenisTempatTinggal';
$route['api/__getProvinsi'] = 'api/c_api/getProvinsi';
$route['api/__getRegion'] = 'api/c_api/getRegion';
$route['api/__getKecamatan'] = 'api/c_api/getKecamatan';



//url upload data
$route['register/formupload/(:any)'] = 'c_register/formupload/$1';
$route['register/formupload_submit'] = 'c_register/formupload_submit';
$route['formulir-registration/(:any)'] = 'c_register/formulir_registration/$1';

