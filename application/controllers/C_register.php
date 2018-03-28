
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
            $case = "base_url";
            $key = "UAP)(*";
            $data = $this->jwt->decode($url,$key);
            $checkURL = $this->m_reg->checkURLFormulirRegistration($data);
            // check apakah sudah pernah isi formulir
            # jika sudah pernah arahkan ke url print formulir sekaligus download pdfnya.
            # Buat dua tab, satu tab untuk view formulir, satu tab lagi untuk upload attachment
            # jika belum pernah arahkan ke url isi formulir
            if ($checkURL) {
                $case = "url_formulir_registration";
                $checkURL2 = $this->m_reg->checkURLFormulirTelahdiisi();
                if ($checkURL2) {
                    // jika upload dokumen berhasil maka send email to user dan matikan link ini redirect ke url telah berhasil registrasi
                    $case = "url_upload_dokument";
                }
                else
                {
                    $case = "url_formulir_registration";
                }
            }
            switch ($case) {
                case 'base_url':
                    redirect(base_url());
                    break;
                case 'url_formulir_registration':
                    $content = $this->load->view('register/formulir_registration','',true);
                    break;
                case 'url_upload_dokument':
                    $content = $this->load->view('register/formulir_upload','',true);
                    break;
                default:
                    redirect(base_url());
                    break;
            }
            $this->temp($content); 
        }
        catch(Exception $e)
        {
            redirect(base_url());
        }
        
    }

    public function formulir_submit()
    {
        $token = $this->input->post('token');
        $key = "UAP)(*";
        $data_arr = (array) $this->jwt->decode($token,$key);
        $uploadFile = $this->uploadFoto($this->session->userdata('Email'));
        if (is_array($uploadFile)) {
            $this->m_reg->saveDataFormulir($data_arr,$uploadFile['file_name']);
            echo json_encode(array('msg' => 'The file has been successfully uploaded','status' => 1));
        }
        else
        {
            echo json_encode(array('msg' => 'The file did not upload successfully','status' => 0));
        }
    }

    public function uploadFoto($email)
    {
         // upload file
         $filename = md5($email);
         $config['upload_path']   = './foto_formulir/';
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

    public function checkDocument()
    {
        $chkTableregister_formulir = $this->m_reg->chkTableregister_formulir();
        echo json_encode($chkTableregister_formulir);
    }

    public function getDataDokument()
    {
        $generate = $this->m_reg->getDataDokumentRegister($this->session->userdata('ID_register_formulir'));

        echo json_encode($generate);
    }

    public function downloadPDFFormulir()
    {
        $path = $this->BuatFolderSetiapCandidate();
        $generatePDF = $this->generatePDF($path);
        echo json_encode($generatePDF);
    }

    private function generatePDF($path)
    {
        //error_reporting(0);
        $program_study = $this->m_api->getProgramStudy();
        $arr_temp = array('filename' => '');
        $filename = "formulir-pdf.pdf";
        $setXCheckbox = 12;
        $setYCheckbox = 27;
        $setX = 15;
        $setY = 29;
        $setJarak = 1; // jarak antar line
        $setJarakX = 40;
        $setJarakY = 6;
        $arrLabel1 = array(
                          'Study Program',
                          'Full Name',
                          'Gender',
                          'Identity Card',
                          'Nationality',
                          'Religion',
                          'Place and Date of Birth',
                          'Type Of Residence',
                          'Phone Number',
                          'Email'
                         );
        $arrLabel2 = array(
                          'Country',
                          'Province',
                          'Region',
                          'Districts',
                          'District',
                          'Address',
                          'Pos Code',
                         );
        $arrLabel3 = array(
                          'School',
                          'School Type',
                          'School Major',
                          'Country',
                          'Province',
                          'Region',
                          'Address',
                          'Graduation Year',
                         );

        try
        {
            $config=array('orientation'=>'P','size'=>'A4');
            $this->load->library('mypdf',$config);
            $this->mypdf->SetMargins(0,0,0,0);
            $this->mypdf->AddPage();
            // Logo
            $this->mypdf->Image('./images/logo_tr.png',1,1,30);
            $this->mypdf->SetFont('Arial','B',10);
            $this->mypdf->Text(150, 5, 'Formulir Number : '.$this->session->userdata('FormulirCode'));
            // Line break
            $this->mypdf->Ln(8);

            $this->mypdf->SetFont('Arial','B',14);
            $this->mypdf->Cell(210, 10, 'New Student Registration Form', 0, 1, 'C', 0);
            $this->mypdf->Line(10,16,200,16); // setX,set H atau Y,panjang,set H atau Y penghubung
            // Rect(float x, float y, float w, float h [, string style])
            //$this->mypdf->Rect(10,18,190,120);
            //$this->mypdf->Rect(105,18,0,120);// garis tengah

            // Judul di box
            $this->mypdf->Ln($setJarak);
            $this->mypdf->SetFont('Arial','b',12);
            $this->mypdf->SetX(10);
            $this->mypdf->SetTextColor(255,255,255);
            $this->mypdf->Cell(190, 5, 'Study Program', 1, 1, 'L', true);
            $this->mypdf->SetFillColor(976,245,458);

            // Rect(float x, float y, float w, float h [, string style])
            $this->mypdf->Rect(10,24,190,15);


            $splitBagi = 5;
            $split = (int)(count($program_study) / $splitBagi);
            $sisa = count($program_study) % $splitBagi;
            if ($sisa > 0) {
                  $split++;
            }

            $getRow = 0;
            for ($i=0; $i < $split ; $i++) { 
                if (($sisa > 0) && ((i + 1) == $split) ) {
                                    $splitBagi = $sisa;    
                }
                $SetX1 = $setX;
                $setXCheckbox1 = $setXCheckbox;
                for ($k = 0; $k < $splitBagi; $k++) {
                    $this->mypdf->Image('./images/checkbox.jpg',$setXCheckbox1,$setYCheckbox,3);
                    $this->mypdf->SetXY($SetX1,$setY);
                    $this->mypdf->SetTextColor(0,0,0);
                    $this->mypdf->SetFont('Arial','',6);
                    $this->mypdf->Cell(0, 0, $program_study[$getRow]['Name'], 0, 1, 'L', 0);
                    $getRow++;
                    $setXCheckbox1 = $setXCheckbox1 + $setJarakX;
                    $SetX1 = $SetX1 + $setJarakX;
                }
                $setYCheckbox = $setYCheckbox + $setJarakY;
                $setY = $setY + $setJarakY;
            }

            // Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
            /*$this->mypdf->Image('./images/checkbox.jpg',$setXCheckbox,$setYCheckbox,3);
            $this->mypdf->SetXY(15,29);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',8);
            $this->mypdf->Cell(0, 0, 'Study Program', 0, 1, 'L', 0);
            
            $setXCheckbox = $setXCheckbox + 25;
            $this->mypdf->Image('./images/checkbox.jpg',$setXCheckbox,$setYCheckbox,3);
            $this->mypdf->SetXY(40,29);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',8);
            $this->mypdf->Cell(0, 0, 'Study Program', 0, 1, 'L', 0);

            $setYCheckbox = $setYCheckbox + 6;
            $this->mypdf->Image('./images/checkbox.jpg',12,$setYCheckbox,3);
            $this->mypdf->SetXY(15,35);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',8);
            $this->mypdf->Cell(0, 0, 'Study Program', 0, 1, 'L', 0);*/

           


            $path = $path.'/'.$filename;
            $this->mypdf->Output($path,'F');

            return $arr_temp['filename'] = $filename;   
        }
        catch(Exception $e)
        {
            return $arr_temp['filename'] = $filename;   
        }
       
        return $arr_temp['filename'] = $filename;   
    }

    public function fileGet($file)
    {
        //check session ID_register_formulir ada atau tidak
        // check session token untuk download

        // Check File exist atau tidak
        $namaFolder = $this->session->userdata('Email');
        if (file_exists('./document/'.$namaFolder.'/'.$file)) {
            //$this->load->helper('download');
            // $data   = file_get_contents('./document/'.$namaFolder.'/'.$file);
            // $name   = $file;
            // force_download($name, $data); // script download file
            $this->showFile($file);
        }
        else
        {
            show_404($log_error = TRUE);
        }
    }

    private function showFile($file)
    {
        $namaFolder = $this->session->userdata('Email');
        header("Content-type: application/pdf"); 
        header("Content-disposition: inline;     
        filename=".basename('document/'.$namaFolder.'/'.$file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        $filePath = readfile('document/'.$namaFolder.'/'.$file);
    }


    private function BuatFolderSetiapCandidate()
    {
        $namaFolder = $this->session->userdata('Email');
        if (!file_exists('./document/'.$namaFolder)) {
            mkdir('./document/'.$namaFolder, 0777, true);
        }
        return $path = './document/'.$namaFolder;
    }

}
