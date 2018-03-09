<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();



        if($this->session->userdata('loggedIn')){
            
        } else {
            redirect(base_url());
        }
        $this->load->library('JWT');
        $this->load->library('google');
    }

    public function template($content)
    {

        $data['include'] = $this->load->view('template/include','',true);

        $data['header'] = $this->menu_header();
        $data['crumbs'] = $this->crumbs();

        $data['content'] = $content;
        $this->load->view('template/template',$data);

    }

    public function blank_temp($content){
        $data['include'] = $this->load->view('template/include','',true);
        $data['content'] = $content;
        $this->load->view('template/blank',$data);
    }


    private function menu_header(){
        $exp_name = explode(" ",$this->session->userdata('Name'));
        $data['name']= (count($exp_name)>0) ? $exp_name[0] : $this->session->userdata('Name');
        $page = $this->load->view('template/header',$data,true);
        return $page;
    }
   
    private function crumbs(){
        $data['crumbs_departement'] = $this->session->userdata('departementNavigation');
        $data['segment'] = $this->uri->segment_array();
        $page = $this->load->view('template/crumbs',$data,true);
        return $page;
    }


}
