 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

// /$route['default_controller'] = 'c_login';
$route['default_controller'] = 'c_register';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// === register ===
$route['register/proses-register'] = 'c_register/proses_register';
$route['register/formulir_submit'] = 'c_register/formulir_submit';
$route['formulir-registration/(:any)'] = 'c_register/formulir_registration/$1';
$route['checkDocument'] = 'c_register/checkDocument';
$route['getDataDokument'] = 'c_register/getDataDokument';
$route['downloadPDFFormulir'] = 'c_register/downloadPDFFormulir';
$route['downloadPDFAdmissionStatement'] = 'c_register/downloadPDFAdmissionStatement';
$route['downloadPDFBebasNarkoba'] = 'c_register/downloadPDFBebasNarkoba';
$route['upload_dokument'] = 'c_register/upload_dokument';


$route['fileGet/(:any)'] = 'c_register/fileGet/$1';

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
$route['api/__getTipeSekolah'] = 'api/c_api/getTipeSekolah';
$route['api/__getMajorSekolah'] = 'api/c_api/getMajorSekolah';
$route['api/__getAlamatSekolah'] = 'api/c_api/getAlamatSekolah';
$route['api/__getUkuranJacket'] = 'api/c_api/getUkuranJacket';
$route['api/__getDataPekerjaan'] = 'api/c_api/getDataPekerjaan';
$route['api/__getDataPenghasilan'] = 'api/c_api/getDataPenghasilan';
$route['api/__getDataDokument'] = 'api/c_api/getDataDokument';



//url upload data
$route['register/formupload/(:any)'] = 'c_register/formupload/$1';
$route['register/formupload_submit'] = 'c_register/formupload_submit';


// test url
$route['testing'] = 'c_register/testing';