<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public $GlobalProses = array('urlSiak' => 'http://10.1.10.230/siak/');
    function __construct()
    {
        parent::__construct();
        $this->load->library('JWT');
        $this->load->library('google');
        $this->load->model('register/M_register','m_reg',TRUE);
        $this->load->model('m_api');
        $this->load->model('m_sendemail');
        $this->MoveTableRegister();
    }

    public function MoveTableRegister()
    {
        $longtime = $this->m_reg->Longtime();
        $geenerateData = $this->m_reg->prosesMoveTableRegister($longtime);
    }

}

abstract class MyAbstract  extends MY_Controller{
   abstract protected function menu_header();
   abstract protected function crumbs();
   abstract protected function menu_navigation();
   abstract protected function setAjaxRequest();
   abstract protected function loggedIN();
   abstract protected function temp($content);
   abstract protected function getInputToken();

   public function test()
   {
    echo 'test';
   }
}


class Frontend_Controller extends MyAbstract{

    public function __construct()
    {
        parent::__construct();
    }

    public function temp($content){

        $this->GlobalProses['include'] = $this->load->view('template/include3','',true);
        $this->GlobalProses['header'] = $this->menu_header();
        $this->GlobalProses['content'] = $content;
        // $this->GlobalProses['navigation'] = $this->menu_navigation();
        // $this->GlobalProses['crumbs'] = $this->crumbs();
        $this->load->view('template/template',$this->GlobalProses);
    }

    public function menu_header()
    {
        $page = $this->load->view('template/header','',true);
        return $page;
    }

    public function crumbs()
    {
        $page = $this->load->view('template/crumbs','',true);
        return $page;
    }

    public function menu_navigation()
    {
        $page = $this->load->view('page/'.'foldermenu'.'/menu_navigation','',true);
        return $page;
    }

    public function setAjaxRequest()
    {
        if (!$this->input->is_ajax_request()) 
        {
            return exit('No direct script access allowed');
        }
    }

    public function loggedIN()
    {

    }

    public function getInputToken()
    {
        $token = $this->input->post('token');
        $key = "UAP)(*";
        $this->GlobalProses_arr = (array) $this->jwt->decode($token,$key);
        return $this->GlobalProses_arr;
    }

    public function encryptURL($ID_register,$Email)
    {
        $key = "UAP)(*";
        $url = $this->jwt->encode($ID_register.";".$Email,$key);
        return $url;
    }


    public function checkURL($url)
    {
        error_reporting(0);
        try
        {
            $key = "UAP)(*";
            $this->GlobalProses = $this->jwt->decode($url,$key);
            $checkURL = $this->m_reg->checkURLFormulirRegistration($this->GlobalProses);
            return $checkURL;
        }
        catch(Exception $e)
        {
            return false;
        }
        
    }
}


class Backend_Controller extends MyAbstract{

    public function __construct()
    {
        parent::__construct();
        $loggedIN = $this->loggedIN();
        if (!$loggedIN) {
           redirect(base_url());
        }
    }

    public function temp($content){

        $this->GlobalProses['include'] = $this->load->view('template/include3','',true);
        $this->GlobalProses['header'] = $this->menu_header();
        $this->GlobalProses['content'] = $content;
        // $this->GlobalProses['navigation'] = '';
        // $this->GlobalProses['crumbs'] = $this->crumbs();
        $this->load->view('template_backend/template',$this->GlobalProses);
    }

    public function menu_header()
    {
        $page = $this->load->view('template_backend/header','',true);
        return $page;
    }

    public function crumbs()
    {
        $page = $this->load->view('template_backend/crumbs');
        return $page;
    }

    public function menu_navigation()
    {
        $page = $this->load->view('template_backend/menu_navigation','',true);
        return $page;
    }

    public function setAjaxRequest()
    {
        if (!$this->input->is_ajax_request()) 
        {
            return exit('No direct script access allowed');
        }
    }

    public function loggedIN()
    {
        $loggedIN = $this->session->userdata('LoggedIN');
        return $loggedIN;
    }

    public function getInputToken()
    {
        $token = $this->input->post('token');
        $key = "UAP)(*";
        $this->GlobalProses_arr = (array) $this->jwt->decode($token,$key);
        return $this->GlobalProses_arr;
    }

    public function encryptURL($ID_register,$Email)
    {
        $key = "UAP)(*";
        $url = $this->jwt->encode($ID_register.";".$Email,$key);
        return $url;
    }
}
