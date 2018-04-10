 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

// /$route['default_controller'] = 'c_login';
$route['default_controller'] = 'c_register';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// === register ===
$route['register/proses-register'] = 'c_register/proses_register';
$route['register/formulir_submit'] = 'c_register/formulir_submit';
$route['login'] = 'c_register/pagelogin';
$route['auth/login'] = 'c_register/authentification_google';
$route['auth/logMeOut'] = 'c_register/logMeOut';
$route['register/formulir_submit_offline'] = 'c_register/formulir_submit_offline';


$route['formulir-registration/(:any)'] = 'C_register_loggin/formulir_registration/$1';
$route['formulir-registration-offline/(:any)'] = 'c_register/formulir_registration_offline/$1';

// to url
$route['formulir-registration-edit/(:any)'] = 'C_register_loggin/formulir_registration_edit/$1';
$route['formulir-upload-document/(:any)'] = 'C_register_loggin/formulir_upload_document/$1';
$route['jadwal-ujian/(:any)'] = 'C_register_loggin/jadwal_ujian/$1';
$route['hasil-ujian/(:any)'] = 'C_register_loggin/hasil_ujian/$1';


$route['checkDocument'] = 'C_register_loggin/checkDocument';
$route['getDataDokument'] = 'C_register_loggin/getDataDokument';
$route['downloadPDFFormulir'] = 'C_register_loggin/downloadPDFFormulir';
$route['downloadPDFAdmissionStatement'] = 'C_register_loggin/downloadPDFAdmissionStatement';
$route['downloadPDFBebasNarkoba'] = 'C_register_loggin/downloadPDFBebasNarkoba';
$route['upload_dokument'] = 'C_register_loggin/upload_dokument';
$route['downloadPDFPernyataanKesanggupanSTTB'] = 'C_register_loggin/PernyataanKesanggupanSTTB';
$route['downloadPDFPernyataanKelengkapanDokumen'] = 'C_register_loggin/downloadPDFPernyataanKelengkapanDokumen';


$route['fileGet/(:any)'] = 'C_register_loggin/fileGet/$1';
$route['fileShow/(:any)'] = 'C_register_loggin/fileShow/$1';

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
$route['api/__getDataSekolah'] = 'api/c_api/getDataSekolah';



//url upload data
$route['register/formupload/(:any)'] = 'c_register/formupload/$1';
$route['register/formupload_submit'] = 'c_register/formupload_submit';


// test url
$route['testing'] = 'c_register/testing';