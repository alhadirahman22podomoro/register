<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_api extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('m_api');
        $this->load->library('JWT');
        $this->load->library('google');
    }

    public function getInputToken()
    {
        $token = $this->input->post('token');
        $key = "UAP)(*";
        $data_arr = (array) $this->jwt->decode($token,$key);
        return $data_arr;
    }

    public function insertWilayahURLJson()
    {
        $data = $this->input->post('data');
        $generate = $this->m_api->saveDataWilayah($data);
        echo json_encode($generate);
    }

    public function insertSchoolURLJson()
    {
        $data = $this->input->post('data');
        $generate = $this->m_api->saveDataSchool($data);
        echo json_encode($generate);
    }

    public function getWilayahURLJson()
    {
        $generate = $this->m_api->getdataWilayah();
        echo json_encode($generate);
    }

    public function getSMAWilayah()
    {
        $token = $this->input->post('token');
        $key = "UAP)(*";
        $data_arr = (array) $this->jwt->decode($token,$key);

        $result = $this->m_api->__getSMAWilayah($data_arr['wilayah']);

        return print_r(json_encode($result));
    }

    public function getProgramStudy()
    {
        $generate = $this->m_api->getProgramStudy();
        echo json_encode($generate);
    }

    public function getCountry()
    {
        $generate = $this->m_api->getCountry();
        echo json_encode($generate);
    }

    public function getAgama()
    {
        $generate = $this->m_api->getAgama();
        echo json_encode($generate);
    }

    public function getJenisTempatTinggal()
    {
        $generate = $this->m_api->getJenisTempatTinggal();
        echo json_encode($generate);
    }

    public function getProvinsi()
    {
        $generate = $this->m_api->getProvinsi();
        echo json_encode($generate);
    }

    public function getRegion()
    {
        $input = $this->getInputToken();
        $generate = $this->m_api->getRegion($input['selectProvinsi']);
        echo json_encode($generate);
    }

    public function getKecamatan()
    {
        $input = $this->getInputToken();
        $generate = $this->m_api->getKecamatan($input['selectRegion']);
        echo json_encode($generate);
    }

    public function getTipeSekolah()
    {
        $generate = $this->m_api->getTipeSekolah();
        echo json_encode($generate);
    }

    public function getMajorSekolah()
    {
        $generate = $this->m_api->getMajorSekolah();
        echo json_encode($generate);
    }

    public function getAlamatSekolah()
    {
        $input = $this->getInputToken();
        $generate = $this->m_api->getAlamatSekolah($input['selectSchool']);
        echo json_encode($generate);
    }

    public function getUkuranJacket()
    {
        $generate = $this->m_api->getUkuranJacket();
        echo json_encode($generate);
    }

    public function getDataPekerjaan()
    {
        $generate = $this->m_api->getDataPekerjaan();
        echo json_encode($generate);
    }

    public function getDataPenghasilan()
    {
        $generate = $this->m_api->getDataPenghasilan();
        echo json_encode($generate);
    }

}
