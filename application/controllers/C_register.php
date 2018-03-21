
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_register extends CI_Controller {

    private $GlobalProses = array('urlSiak' => 'http://localhost/siak/');

    function __construct()
    {
        parent::__construct();
        $this->load->library('JWT');
        $this->load->library('google');
        $this->load->model('m_auth');
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

    public function getInputToken()
    {
        $token = $this->input->post('token');
        $key = "UAP)(*";
        $data_arr = (array) $this->jwt->decode($token,$key);
        return $data_arr;
    }

    private function menu_header(){
        //$exp_name = explode(" ",$this->session->userdata('Name'));
        //$data['name']= (count($exp_name)>0) ? $exp_name[0] : $this->session->userdata('Name');
        $page = $this->load->view('template/header','',true);
        return $page;
    }

    public function temp($content){

        $data['include'] = $this->load->view('template/include3','',true);
        $data['header'] = $this->menu_header();
        $data['content'] = $content;
        $this->load->view('template/template',$data);
    }

    public function index()
    {
        $content = $this->load->view('register/index','',true);
        $this->temp($content);
    }

    public function proses_register()
    {
        if (!$this->input->is_ajax_request()) 
        {
            exit('No direct script access allowed');
        }
        else
        {
            $this->GlobalProses['errorMSG'] = "";
            $alreadyExistingEmail = $this->alreadyExistingEmail();
            if ($this->GlobalProses['errorMSG'] == "") {
                $priceFormulir = $this->getPriceFormulir();
                //$password = $this->getPasswordRegister();
                $getUrlEncrypt = $this->input->post('token');
                $momenUnix = $this->getMomenUnix();
                $sendEmail = $this->sendEmailtoUser($priceFormulir,$getUrlEncrypt);
                $this->GlobalProses['statusEmail'] = $sendEmail['status'];
                $this->GlobalProses['msgEmail'] = $sendEmail['msg'];
                if ($this->GlobalProses['statusEmail'] == 1) {
                    $saveData = $this->saveToDBRegister($priceFormulir,$momenUnix);
                }
            }
            return print_r(json_encode($this->GlobalProses));
        }
    }

    public function getMomenUnix()
    {
        $input = $this->getInputToken();
        return $input['momentUnix'];
    }

    public function alreadyExistingEmail()
    {
        $input = $this->getInputToken();
        $alreadyExistingEmail = $this->m_reg->alreadyExistingEmail($input['Email']);
        $this->GlobalProses['errorMSG'] = $alreadyExistingEmail['errorMSG'];
        return $alreadyExistingEmail;
    }

    public function getPriceFormulir()
    {
        $priceFormulir = $this->m_reg->getPriceFormulir();
        return $priceFormulir;
    }

    public function getPasswordRegister()
    {
        $password = rand();
        $this->GlobalProses['clearPassword'] = $password;
        $input = $this->getInputToken();
        $password = $this->genratePassword($input['Email'],$password);
        return $password;
    }

    public function sendEmailtoUser($priceFormulir,$getUrlEncrypt)
    {
        $input = $this->getInputToken();
        $to = $input['Email'];
        $subject = "Podomoro University Registration";
        $text = array($getUrlEncrypt,$priceFormulir);
        $sendEmail = $this->m_api->sendEmail($to,$subject,$text);
        return $sendEmail;
    }

    public function saveToDBRegister($priceFormulir,$momenUnix)
    {
        $input = $this->getInputToken();
        $name = ucwords($input['Firstname']). " ".ucwords($input['Lastname']);
        $saveToDBRegister = $this->m_reg->saveToDBRegister($name,$input['Email'],$input['SchoolName'],$priceFormulir,$momenUnix);
        $this->GlobalProses['statusDB'] = "The data has been saved to db";
    }

    public function formupload($url)
    {
        $checkURL = $this->checkURL($url);
        if ($checkURL) {
            $content = $this->load->view('register/form_upload','',true);
            $this->temp($content);    

        }
        else
        {
            redirect(base_url());
        }
    }

    public function checkURL($url)
    {
        error_reporting(0);
        try{
            $key = "UAP)(*";
            $data_arr = (array) $this->jwt->decode($url,$key);
            $email = $data_arr['Email'];
            $momenUnix = $data_arr['momentUnix'];
            $queryCheckUrl= $this->m_reg->checkURL($email,$momenUnix);
            return $queryCheckUrl;
        }   
        catch(Exception $e)
        {
            return false;
        }
        
        return true;
    }

    public function formupload_submit()
    {
        if (!$this->input->is_ajax_request()) 
        {
            exit('No direct script access allowed');
        }
        else
        {
            $uploadFile = $this->uploadFile($this->session->userdata('Email'));
            if (is_array($uploadFile)) {
                $this->m_reg->saveDataToVerification($uploadFile['file_name']);
                $url_toVerifikasiFinance = "finance/penerimaan-pembayaran/verifikasi-pembayaran/registration_online";
                $text = 'Dear Team,<br><br>
                            You have notification by Registration Online, Please check in url below :<br>
                            '.$this->GlobalProses['urlSiak'].$url_toVerifikasiFinance.'    
                        ';
                $to = $this->m_sendemail->getToEmail('Notify Upload Payment');
                $subject = "Notify Upload Payment Registration Online";
                $sendEmail = $this->m_sendemail->sendEmail($to,$subject,null,null,null,null,$text);
                echo json_encode(array('msg' => 'The file has been successfully uploaded','status' => 1));
            }
            else
            {
                echo json_encode(array('msg' => 'The file did not upload successfully','status' => 0));
            }

        }
    }

    public function uploadFile($email)
    {
         // upload file
         $filename = md5($email);
         $config['upload_path']   = './upload/';
         $config['overwrite'] = TRUE; 
         $config['allowed_types'] = 'png|PNG|jpg|JPG|jpeg|jpeg'; 
         $config['file_name'] = $filename;
         //$config['max_size']      = 100; 
         //$config['max_width']     = 300; 
         //$config['max_height']    = 300;  
         $this->load->library('upload', $config);
            
         if ( ! $this->upload->do_upload('fileData')) {
            return $error = $this->upload->display_errors(); 
            //$this->load->view('upload_form', $error); 
         }
            
         else { 
           return $data =  $this->upload->data(); 
            //$this->load->view('upload_success', $data); 
         }
    }

    public function formulir_registration($url)
    {
        error_reporting(0);
        try{
            $key = "UAP)(*";
            $data = $this->jwt->decode($url,$key);
            $checkURL = $this->m_reg->checkURLFormulirRegistration($data);
            $content = $this->load->view('register/formulir_registration','',true);
            $this->temp($content); 
        }
        catch(Exception $e)
        {
            redirect(base_url());
        }
        
    }

    public function authGoogle(){
        if(isset($_GET['code'])){

            try{
                //authenticate user
                $this->google->getAuthenticate();

                //get user info from google
                $gpInfo = $this->google->getUserInfo();

                //preparing data for database insertion
                $userData['oauth_provider'] = 'google';
                $userData['oauth_uid'] 		= $gpInfo['id'];
                $userData['first_name'] 	= $gpInfo['given_name'];
                $userData['last_name'] 		= $gpInfo['family_name'];
                $userData['email'] 			= $gpInfo['email'];
                $userData['gender'] 		= !empty($gpInfo['gender'])?$gpInfo['gender']:'';
                $userData['locale'] 		= !empty($gpInfo['locale'])?$gpInfo['locale']:'';
                $userData['profile_url'] 	= !empty($gpInfo['link'])?$gpInfo['link']:'';
                $userData['picture_url'] 	= !empty($gpInfo['picture'])?$gpInfo['picture']:'';


                // Cek Userdata
                $dataUser = $this->m_auth->__getUserByEmailPU($userData['email'] );

                if(count($dataUser)>0) {
                    $this->setSession($dataUser[0]['ID'],$dataUser[0]['NIP']);
                    redirect(base_url('dashboard'));
                } else {
                    redirect(base_url());
                }

            } catch (Exception $err){
                redirect(base_url());
            }


        }
    }

    public function authUserPassword(){
        $token = $this->input->post('token');
        $key = "L06M31N";
        $data_arr = (array) $this->jwt->decode($token,$key);

        if(count($data_arr)>0){

            $NIP = $data_arr['nip'];
            $Password = $this->genratePassword($NIP,$data_arr['password']);

            $dataUser = $this->m_auth->__getauthUserPassword($NIP,$Password);

            if(count($dataUser)>0){
                $this->setSession($dataUser[0]['ID'],$dataUser[0]['NIP']);
                return print_r(1);
            } else {
                return print_r(0);
            }
        } else {
            return print_r(0);
        }
    }

    private function genratePassword($NIP,$Password){

        $plan_password = $NIP.''.$Password;
        $pas = md5($plan_password);
        $pass = sha1('jksdhf832746aiH{}{()&(*&(*'.$pas.'HdfevgyDDw{}{}{;;*766&*&*');

        return $pass;
    }



    public function logMeOut(){
        $this->session->sess_destroy();
        return 1;
    }

    public function gen($NIP,$Password){
        $plan_password = $NIP.''.$Password;
        $pas = md5($plan_password);
        $pass = sha1('jksdhf832746aiH{}{()&(*&(*'.$pas.'HdfevgyDDw{}{}{;;*766&*&*');

        print_r($pass);
    }


    public function genratePassword2($NIP,$Password){

        $plan_password = $NIP.''.$Password;
        $pas = md5($plan_password);
        $pass = sha1('jksdhf832746aiH{}{()&(*&(*'.$pas.'HdfevgyDDw{}{}{;;*766&*&*');

        print_r($pass);
    }

}
