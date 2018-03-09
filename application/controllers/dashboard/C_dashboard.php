<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard extends MY_Controller {



    public function temp($content)
    {
        parent::template($content);
    }

    public function index()
    {
        $data['department'] = "";
        $content = $this->load->view('dashboard/dashboard',$data,true);
        $this->temp($content);
    }

}
