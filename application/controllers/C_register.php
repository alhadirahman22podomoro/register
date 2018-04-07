
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_register extends CI_Controller {

    private $GlobalProses = array('urlSiak' => 'http://localhost/siak/');

    function __construct()
    {
        parent::__construct();
        $this->load->library('JWT');
        // $this->load->library('google');
        // $this->load->model('m_auth');
        $this->load->model('register/M_register','m_reg',TRUE);
        $this->load->model('m_api');
        $this->load->model('m_sendemail');
        $this->MoveTableRegister();
    }

    private function setAjaxRequest()
    {
        if (!$this->input->is_ajax_request()) 
        {
            return exit('No direct script access allowed');
        }
        
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
            $this->GlobalProses['url'] = $url; // hanya untuk formulir online
            $this->GlobalProses['headerNav'] = true;
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
                    $content = $this->load->view('register/formulir_registration',$this->GlobalProses,true);
                    break;
                case 'url_upload_dokument':
                    $content = $this->load->view('register/formulir_upload',$this->GlobalProses,true);
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

    public function formulir_registration_edit($url)
    {
        error_reporting(0);
        $this->GlobalProses['url'] = $url;
        $this->GlobalProses['headerNav'] = true;
        try{
            $case = "base_url";
            $key = "UAP)(*";
            $data = $this->jwt->decode($url,$key);
            $checkURL = $this->m_reg->checkURLFormulirRegistration($data);

            if ($checkURL) {
                /*$content = $this->load->view('register/formulir_registration',$this->GlobalProses,true);
                $this->temp($content); */
                $content = $this->load->view('register/page_404',$this->GlobalProses,true);
                $this->temp($content);
            }
            else
            {
                // url page not authorize
                $content = $this->load->view('register/page_404',$this->GlobalProses,true);
                $this->temp($content);
            }
        }
        catch(Exception $e)
        {
            // redirect(base_url());
            $content = $this->load->view('register/page_404',$this->GlobalProses,true);
            $this->temp($content);
        }
        
    }

    public function formulir_upload_document($url)
    {
        error_reporting(0);
        $this->GlobalProses['url'] = $url;
        $this->GlobalProses['headerNav'] = true;
        try{
            $case = "base_url";
            $key = "UAP)(*";
            $data = $this->jwt->decode($url,$key);
            // var_dump($data);
            $checkURL = $this->m_reg->checkURLFormulirRegistration($data);

            if ($checkURL) {
                $case = "url_formulir_registration";
                $checkURL2 = $this->m_reg->checkURLFormulirTelahdiisi();
                if ($checkURL2) {
                    $content = $this->load->view('register/formulir_upload',$this->GlobalProses,true);
                    $this->temp($content); 
                }
                else
                {
                    // url page not authorize
                    $content = $this->load->view('register/page_404',$this->GlobalProses,true);
                    $this->temp($content);
                }
            }
            else
            {
                // url page not authorize
                $content = $this->load->view('register/page_404',$this->GlobalProses,true);
                $this->temp($content);
                // redirect(base_url());
            }
        }
        catch(Exception $e)
        {
            // redirect(base_url());
            $content = $this->load->view('register/page_404',$this->GlobalProses,true);
            $this->temp($content);
        }
    }

    public function jadwal_ujian($url)
    {
        error_reporting(0);
        $this->GlobalProses['url'] = $url;
        $this->GlobalProses['headerNav'] = true;
        try{
            $case = "base_url";
            $key = "UAP)(*";
            $data = $this->jwt->decode($url,$key);
            $checkURL = $this->m_reg->checkURLFormulirRegistration($data);

            if ($checkURL) {
                $case = "url_formulir_registration";
                $checkURL2 = $this->m_reg->checkURLFormulirTelahdiisi();
                if ($checkURL2) {
                    $this->GlobalProses['datadb'] = $this->m_reg->getJadwalUjian();
                    $this->GlobalProses['dataujian'] = $this->m_reg->getDataUjian();
                    $this->GlobalProses['no'] = 1;
                    if (count($this->GlobalProses['datadb']) > 0) {
                        $content = $this->load->view('register/jadwal_ujian',$this->GlobalProses,true);
                        $this->temp($content);
                    }
                    else
                    {
                        $content = $this->load->view('register/page_404',$this->GlobalProses,true);
                        $this->temp($content);
                    }
                }
                else
                {
                    // url page not authorize
                    $content = $this->load->view('register/page_404',$this->GlobalProses,true);
                    $this->temp($content);
                }
            }
            else
            {
                // url page not authorize
                $content = $this->load->view('register/page_404',$this->GlobalProses,true);
                $this->temp($content);
                // redirect(base_url());
            }
        }
        catch(Exception $e)
        {
            // redirect(base_url());
            $content = $this->load->view('register/page_404',$this->GlobalProses,true);
            $this->temp($content);
        }
    }

    public function formulir_registration_offline($url)
    {
        // error_reporting(0);
        try{
            $this->GlobalProses['url'] = $url;
            $this->GlobalProses['headerNav'] = true;
            $case = "base_url";
            $key = "UAP)(*";
            $data = $this->jwt->decode($url,$key);
            $checkURL = $this->m_reg->checkURLFormulirRegistration_offline($data);
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
                    $content = $this->load->view('register/formulir_registration',$this->GlobalProses,true);
                    break;
                case 'url_upload_dokument':
                    $content = $this->load->view('register/formulir_upload',$this->GlobalProses,true);
                    break;
                default:
                     redirect(base_url());
                    break;
            }
            $this->temp($content); 
        }
        catch(Exception $e)
        {
            // print_r($e);
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

    public function formulir_submit_offline()
    {
        $token = $this->input->post('token');
        $key = "UAP)(*";
        $data_arr = (array) $this->jwt->decode($token,$key);
        $email = $data_arr['Email'];
        $uploadFile = $this->uploadFoto($email);
        if (is_array($uploadFile)) {
            $this->m_reg->saveDataFormulir_offline($data_arr,$uploadFile['file_name']);
            $this->load->library('JWT');
            $key = "UAP)(*";
            $url = $this->jwt->encode($this->session->userdata('register_id').";".$this->session->userdata('Email'),$key);

            $url_to = "formulir-registration/";
            $text = 'Dear Candidate,<br><br>
                        Please click link below to get next step Formulir Registration : <br>
                        '.base_url().$url_to.$url;
            $to = $email;
            $subject = "Link Formulir Registration Podomoro University";
            $sendEmail = $this->m_sendemail->sendEmail($to,$subject,null,null,null,null,$text);
            echo json_encode(array('msg' => 'The file has been successfully uploaded','status' => 1,'url' => $url));
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
        $generatePDF = $this->generatePDFFormulir($path);
        echo json_encode($generatePDF);
    }

    private function generatePDFFormulir($path)
    {
        //error_reporting(0);
        $program_study = $this->m_api->getProgramStudy();
        $arr_value = $this->m_reg->getDataFormulirPDf();
        $arr_temp = array('filename' => '');
        $filename = "formulir-pdf.pdf";
        $setX = 15;
        $setY = 28;
        $setJarak = 1; // jarak antar line
        $setJarakX = 40;
        $setJarakY = 6;
        $setJarakYPerRectangle = 9;
        $setjarakCellHeader = 5;
        $setJarakYrectangle = 22.2;

        $setFontIsian = 6;
        $arrLabel1 = array(
                          'Full Name',
                          'Gender',
                          'Identity Card',
                          'Nationality',
                          'Religion',
                          'Place and Date of Birth',
                          'Type Of Residence',
                          'Country',
                          'Province',
                          'Region',
                          'Districts',
                          'District',
                          'Address',
                          'Pos Code',
                          'Phone Number',
                          'Email',
                          'School',
                          'School Type',
                          'School Major',
                          'Country',
                          'Province',
                          'Region',
                          'Address',
                          'Graduation Year',
                          'Receiver KPS',
                          'Jacket Size'
                         );
        $arrLabel2 = array(
                          'Name',
                          'Identity Card',
                          'Place and Date of Birth',
                          'Status',
                          'Phone Number',
                          'Occupation',
                          'Income',
                          'Country',
                          'Province',
                          'Region',
                          'Address',
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
            $this->mypdf->SetAutoPageBreak(true, 0);
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
            //$this->mypdf->Ln($setJarak);
            $this->mypdf->SetFont('Arial','b',12);
            $this->mypdf->SetX(10);
            $this->mypdf->SetTextColor(255,255,255);
            //$this->mypdf->SetFillColor(976,245,458);
            $this->mypdf->Cell(190, 5, 'Study Program', 1, 1, 'L', true);
            // set height rectangle
            $heightRectanglePrody = 7;
            $setXCheckbox = 12;
            $setYCheckbox = 26;
            $splitBagi = 5;
            $split = (int)(count($program_study) / $splitBagi);
            $sisa = count($program_study) % $splitBagi;
            if ($sisa > 0) {
                  $split++;
                  $setJarakYrectangle = $setJarakYrectangle + 1;
            }

            // set height rectangle sesuai dengan jumlah split
            // Rect(float x, float y, float w, float h [, string style])
            // $this->mypdf->Rect(10,24,190,15);
            $heightRectanglePrody = $heightRectanglePrody * $split;
            $setYrectangle = 23;
            $this->mypdf->Rect(10,$setYrectangle,190,$heightRectanglePrody);


            $getRow = 0;
            for ($i=0; $i < $split ; $i++) { 
                if (($sisa > 0) && (($i + 1) == $split) ) {
                                    $splitBagi = $sisa;    
                }
                $SetX1 = $setX;
                $setXCheckbox1 = $setXCheckbox;
                for ($k = 0; $k < $splitBagi; $k++) {
                    if ($arr_value[0] == $program_study[$getRow]['ID']) {
                        $this->mypdf->Image('./images/checkboxcheck.jpg',$setXCheckbox1,$setYCheckbox,3);
                    }
                    else
                    {
                        $this->mypdf->Image('./images/checkbox.jpg',$setXCheckbox1,$setYCheckbox,3);
                    }
                    $this->mypdf->SetXY($SetX1,$setY);
                    $this->mypdf->SetTextColor(0,0,0);
                    $this->mypdf->SetFont('Arial','',$setFontIsian);
                    $this->mypdf->Cell(0, 0, $program_study[$getRow]['Name'], 0, 1, 'L', 0);
                    $getRow++;
                    $setXCheckbox1 = $setXCheckbox1 + $setJarakX;
                    $SetX1 = $SetX1 + $setJarakX;
                }
                $setYCheckbox = $setYCheckbox + $setJarakY;
                $setY = $setY + $setJarakY;
            }

            // Judul di box
            $setJarak = $setJarak + $setjarakCellHeader;
            $this->mypdf->Ln($setJarak);
            $this->mypdf->SetFont('Arial','b',12);
            $this->mypdf->SetX(10);
            $this->mypdf->SetTextColor(255,255,255);
            $this->mypdf->SetFillColor(0,0,0);
            $this->mypdf->Cell(190, 5, 'Part 1 Data of Prospective Students', 1, 1, 'L', true);

            // set rectangle
            $setYrectangle = $setYrectangle + $setJarakYrectangle;
            $heightRectanglePrody = 110;
            $this->mypdf->Rect(10,$setYrectangle,190,$heightRectanglePrody);
            // isian
            $setY = $setY + $setJarakYPerRectangle;
            // number
            $setXNumber = 12;
            $setJarakY = 4;
            $numberIncrement = 1;
            $getRowDB = 1;
            for ($i=0; $i < count($arrLabel1); $i++) { 
                $this->mypdf->SetXY($setXNumber,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, $numberIncrement, 0, 1, 'L', 0);

                // label
                $this->mypdf->SetXY($setX,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, $arrLabel1[$i], 0, 1, 'L', 0);

                // titik dua
                $setXtitik2 = $setX+$setJarakX;
                $this->mypdf->SetXY($setXtitik2,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, ":", 0, 1, 'L', 0);

                // value
                $setXvalue = $setXtitik2 + 2;
                $this->mypdf->SetXY($setXvalue,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                // $this->mypdf->Cell(0, 0, "Value", 1, 1, 'L', 0);
                
                //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
                /*$a = "a";
                for ($k=0; $k < 353; $k++) { 
                   $a .= 'b';
                }*/
                $SetYMultiCell = $setY - 1;
                $this->mypdf->SetXY($setXvalue,$SetYMultiCell);
                $this->mypdf->MultiCell( 140, 2, $arr_value[$getRowDB], 0,'L');

                $setY = $setY + $setJarakY;
                $numberIncrement++;
                $getRowDB++;
            }

            // Judul di box3
            $setjarakCellHeader =1;
            //$setJarak = $setJarak + $setjarakCellHeader;
            
            if ($split > 2) {
                $setJarak = $setJarak - 3;
                $setYrectangle = $setYrectangle + 2;
                $setJarakYPerRectangle = $setJarakYPerRectangle + 4;
            }
            else
            {
                $setJarak = $setJarak;
                $setJarakYPerRectangle = $setJarakYPerRectangle + 6;
            }
            
            $this->mypdf->Ln($setJarak);
            $this->mypdf->SetFont('Arial','b',12);
            $this->mypdf->SetX(10);
            $this->mypdf->SetTextColor(255,255,255);
            $this->mypdf->SetFillColor(0,0,0);
            $this->mypdf->Cell(190, 5, 'Part 2 Data of Your Parent', 1, 1, 'L', true);

            // set rectangle
            $setYrectangle = $setYrectangle + $heightRectanglePrody +1;
            $heightRectanglePrody = 102;
            $this->mypdf->Rect(10,$setYrectangle,190,$heightRectanglePrody);

            // isian
            $setY = $setY + $setJarakYPerRectangle;
            // number
            $numberIncrement = 1;
            $setXNumber = 12;
            $setJarakY = 4;
            $numberIncrement = 1;
            $setXHeaderRec = $setXNumber;
            $setYHeaderRec = $setY - 4;

            // header
            $this->mypdf->SetXY($setXHeaderRec,$setYHeaderRec);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','b',8);
            $this->mypdf->Cell(0, 0, 'Father Data', 0, 1, 'L', 0);

            for ($i=0; $i < count($arrLabel2); $i++) { 
                $this->mypdf->SetXY($setXNumber,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, $numberIncrement, 0, 1, 'L', 0);

                // label
                $this->mypdf->SetXY($setX,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, $arrLabel2[$i], 0, 1, 'L', 0);

                // titik dua
                $setXtitik2 = $setX+$setJarakX;
                $this->mypdf->SetXY($setXtitik2,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, ":", 0, 1, 'L', 0);

                // value
                $setXvalue = $setXtitik2 + 2;
                $this->mypdf->SetXY($setXvalue,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                // $this->mypdf->Cell(0, 0, "Value", 1, 1, 'L', 0);
                
                //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
                /*$a = "a";
                for ($k=0; $k < 353; $k++) { 
                   $a .= 'b';
                }*/
                $SetYMultiCell = $setY - 1;
                $this->mypdf->SetXY($setXvalue,$SetYMultiCell);
                $this->mypdf->MultiCell( 140, 2, $arr_value[$getRowDB], 0,'L');

                $setY = $setY + $setJarakY;
                $numberIncrement++;
                $getRowDB++;
            }

            $setY = $setY + $setJarakY;
            // header
            $setYHeaderRec = $setY - 4;
            $this->mypdf->SetXY($setXHeaderRec,$setYHeaderRec);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','b',8);
            $this->mypdf->Cell(0, 0, 'Mother Data', 0, 1, 'L', 0);

            $numberIncrement = 1;
            for ($i=0; $i < count($arrLabel2); $i++) { 
                $this->mypdf->SetXY($setXNumber,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, $numberIncrement, 0, 1, 'L', 0);

                // label
                $this->mypdf->SetXY($setX,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, $arrLabel2[$i], 0, 1, 'L', 0);

                // titik dua
                $setXtitik2 = $setX+$setJarakX;
                $this->mypdf->SetXY($setXtitik2,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, ":", 0, 1, 'L', 0);

                // value
                $setXvalue = $setXtitik2 + 2;
                $this->mypdf->SetXY($setXvalue,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                // $this->mypdf->Cell(0, 0, "Value", 1, 1, 'L', 0);
                
                //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
                /*$a = "a";
                for ($k=0; $k < 353; $k++) { 
                   $a .= 'b';
                }*/
                $SetYMultiCell = $setY - 1;
                $this->mypdf->SetXY($setXvalue,$SetYMultiCell);
                $this->mypdf->MultiCell( 140, 2, $arr_value[$getRowDB], 0,'L');

                $setY = $setY + $setJarakY;
                $numberIncrement++;
                $getRowDB++;
            }

            // pernyataan
            $SetYMultiCell = $setY - 1;
            $this->mypdf->SetXY(10,$SetYMultiCell);
            $this->mypdf->SetFont('Arial','b',7);
            $pernyataan1 = "I declare to register at Agung Podomoro University and declare all the data I provide is true and accountable.";
            $pernyataan2 = "I submit and follow all the decisions made by Agung Podomoro University.";
            $this->mypdf->MultiCell( 180, 2,$pernyataan1, 0,'L');
            $SetYMultiCell = $SetYMultiCell + 3;
            $this->mypdf->SetXY(10,$SetYMultiCell);
            $this->mypdf->MultiCell( 180, 2,$pernyataan2, 0,'L');

            // Footer
            $setY = $setY + 7;
            $this->mypdf->SetXY(10,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, "Jakarta,".date('d-M-Y'), 0, 1, 'L', 0);

            // signature
            $setYsignature = $setY + 18;
            //Rect(float x, float y, float w, float h [, string style])
            $this->mypdf->Rect(10,$setYsignature,20,0);
            $setYsignature = $setYsignature + 1.5;
            $this->mypdf->SetXY(10,$setYsignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $this->session->userdata('Name'), 0, 1, 'L', 0);

            // foto
            //Rect(float x, float y, float w, float h [, string style])
            $setY = $setY - 2;
            $this->mypdf->Rect(65,$setY,20,26.5);
            // $this->mypdf->Image('./foto_formulir/'.$arr_value[$getRowDB],65,$setY,40,30);
            $PathFileFoto = $this->generateImage('./foto_formulir/'.$arr_value[$getRowDB]);
            $this->mypdf->Image($PathFileFoto,65,$setY);
            //$this->mypdf->Image('./foto_formulir/'.$arr_value[$getRowDB],65,$setY,30,30);

            //signature Petugas
            $setY = $setY + 2;
            $this->mypdf->SetXY(150,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','b',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Officers', 0, 1, 'L', 0);

            $setYsignatureOfficers = $setY +3;
            $this->mypdf->SetXY(150,$setYsignatureOfficers);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Jakarta,_________________', 0, 1, 'L', 0);

            //Rect(float x, float y, float w, float h [, string style])
            $setYsignature = $setYsignature - 1.5;
            $this->mypdf->Rect(152,$setYsignature,20,0);

            


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
            // $this->load->helper('download');
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
            copy("./document/index.html",'./document/'.$namaFolder.'/index.html');
            copy("./document/index.php",'./document/'.$namaFolder.'/index.php');
        }
        return $path = './document/'.$namaFolder;
    }

    private function generateImage($pathFile)
    {
        include_once APPPATH.'vendor/autoload.php';
        $image = new \Gumlet\ImageResize($pathFile);
        $image->resize(75.2, 100);
        $path = $this->BuatFolderSetiapCandidate();
        $newPathFile = $path.'/'.'FotoResize.jpg';
        $image->save($newPathFile);
        return $newPathFile;
    }

    public function downloadPDFAdmissionStatement()
    {
        $path = $this->BuatFolderSetiapCandidate();
        $generatePDF = $this->generatePDFAdmissionStatement($path);
        echo json_encode($generatePDF);
    }

    public function generatePDFAdmissionStatement($path)
    {
        //error_reporting(0);
        $arr_value = $this->m_reg->getDataFormulirPDf();
        $arr_temp = array('filename' => '');
        $filename = "Admission-Statement.pdf";
        $setXAwal = 10;
        $setYAwal = 18;
        $setJarakY = 5;
        $setFontIsian = 8;
        try
        {
            $config=array('orientation'=>'P','size'=>'A4');
            $this->load->library('mypdf',$config);
            $this->mypdf->SetMargins(0,0,0,0);
            $this->mypdf->SetAutoPageBreak(true, 0);
            $this->mypdf->AddPage();
            // Logo
            $this->mypdf->Image('./images/logo_tr.png',10,1,30);
            $this->mypdf->SetFont('Arial','B',10);
            $this->mypdf->Text(167, 5,'FM-UAP/MKT-01-04');
            // Line break
            $this->mypdf->Ln(8);

            $this->mypdf->SetFont('Arial','B',14);
            $this->mypdf->Cell(210, 10, 'Admission Statement', 0, 1, 'C', 0);
            //$this->mypdf->Line(10,16,200,16);

            $this->mypdf->SetFont('Arial','b',8);
            $this->mypdf->SetXY(10,18);
            $this->mypdf->SetTextColor(255,255,255);
            $this->mypdf->SetFillColor(0,0,0);
            $this->mypdf->Cell(190, 5, 'Bacalah dengan seksama sebelum Anda menandatangani', 1, 1, 'L', true);

            // isian
            $setY = $setYAwal + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'No.Formulir', 0, 1, 'L', 0);

            // $setY = $setYAwal + $setJarakY;
            $setX = $setXAwal + 25; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            // $setY = $setYAwal + $setJarakY;
            $setX = $setXAwal + 30; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $this->session->userdata('FormulirCode'), 0, 1, 'L', 0);

            $setY = $setY + $setJarakY;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Nama', 0, 1, 'L', 0);

            // $setY = $setYAwal + $setJarakY;
            $setX = $setXAwal + 25; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            // $setY = $setYAwal + $setJarakY;
            $setX = $setXAwal + 30; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $this->session->userdata('Name'), 0, 1, 'L', 0);

            $setY = $setY + ($setJarakY * 2);
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Saya yang bertanda tangan dibawah ini :', 0, 1, 'L', 0);

            // set x dan y number dan isian
            $setXnumber = $setXAwal;
            $setXisian = $setXnumber + 5;
            $setY = $setY + ($setJarakY * 1);

            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '1', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya tidak akan melakukan setiap dan seluruh perbuatan yang melanggar hukum, membawa,menggunakan serta mengedarkan obat terlarang(Narkoba)/minuman keras. Hak sebagai mahasiswa Universitas Agung Podomoro akan gugur bila tidak lulus dalam test kesehatan/test narkoba.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 3);
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '2', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya bersedia melakukan tes darah/urine yang sewaktu waktu akan dilakukan oleh pihak Universitas Agung Podomoro.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');


            $setY = $setY + $setJarakY;
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '3', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya bersedia mengundurkan diri dari Universitas Agung Podomoro jika saya belum dapat menyerahkan dokumen :";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            // sub isian
            $setXsubIsianMark = $setXisian;
            $setXsubIsian = $setXisian + 3;
            $setY = $setY + 4;
            $this->mypdf->SetXY($setXsubIsianMark,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '*', 0, 1, 'L', 0);

            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Selambat-lambatnya 1(satu) minggu sebelum semester-1 berakhir untuk fotokopi ijasah SMA Nasional(STTB/NEM/DNUN/SKHUN) yang dilegalisir.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXsubIsian,$SetYMultiCell);
            $this->mypdf->MultiCell( 185, 3,$isian, 0,'L');

            $setY = $setY + 8;
            $this->mypdf->SetXY($setXsubIsianMark,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '*', 0, 1, 'L', 0); 

            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Selambat-lambatnya 1(satu) minggu sebelum perkuliahan tahun ajaran 2018-2019 dimulai untuk ijasah Paket C dan surat penyetaraan bagi lulusan luar negri yang dilegalisir.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXsubIsian,$SetYMultiCell);
            $this->mypdf->MultiCell( 185, 3,$isian, 0,'L');

            $setY = $setY + $setJarakY + 2;
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '4', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Jika terdapat dokumen yang tidak sesuai saya bersedia menerima segala konsekuensi yang diberikan oleh Univeristas Agung Podomoro.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            $setY = $setY + $setJarakY;
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '5', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya bersedia untuk memberikan seluruh kelengkapan dokumen yang dibutuhkan sebagai persyaratan pendaftaran mahasiswa Universitas Agung Podomoro. Apabila dalam kurun waktu yang ditentukan, saya tidak memenuhi persyaratan maka saya bersedia menerima konsekuensi dari Universitas Agung Podomoro.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 3);
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '6', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya tidak buta warna (khusus program study Arsitektur dan Desain Produk) dibuktikan dengan Surat Keterangan Tidak Buta Warna dari Dokter Spesialis Mata.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 2);
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '7', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya bersedia dikeluarkan (Drop Out/DO) jika pada akhir semester 4 belum mengumpulkan minimal 40 sks dan IPK besar sama dengan 2,00.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            $setY = $setY + $setJarakY;
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '8', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Biaya studi yang berlaku hanya diterpakan untuk periode 4 tahun pertama (S1 dan/atau D4) jika ada pertambahan semester setelah itu, biaya studi yang digunakan adalah biaya studi pada tahun ajaran terbaru.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 2);
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '9', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Pengembalian dana dilakukan apabila :";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            // sub isian
            $setXsubIsianMark = $setXisian;
            $setXsubIsian = $setXisian + 3;
            $setY = $setY + 4;
            $this->mypdf->SetXY($setXsubIsianMark,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '1.', 0, 1, 'L', 0);

            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya tidak lulus Ujian Nasional(UN), dan saya setuju dipotong biaya administrasi sebesar Rp. 500.000,-";
            $SetYMultiCell = $setY - 1.5;
            $this->mypdf->SetXY($setXsubIsian,$SetYMultiCell);
            $this->mypdf->MultiCell( 185, 3,$isian, 0,'L');

            $setY = $setY + 4;
            $this->mypdf->SetXY($setXsubIsianMark,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '2', 0, 1, 'L', 0); 

            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya diterima di Perguruan Tinggi Negri (PTN) : UI, ITB, UNPAD, UNDIP, IPB, UGM, UNAIR, ITS Surabaya melalui jalur SNMPTN dan SBMPTN (tidak termasuk Ujian Mandiri,Program Diploma & Politeknik Negri) dan saya setuju dipotong biaya administrasi Rp. 1.500.000,-";
            $SetYMultiCell = $setY - 1.5;
            $this->mypdf->SetXY($setXsubIsian,$SetYMultiCell);
            $this->mypdf->MultiCell( 185, 3,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 2);
            $this->mypdf->SetXY($setXnumber,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, '10', 0, 1, 'L', 0);

            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya bersedia mentaati Statuta Universitas Agung Podomoro, Peraturan Tata Tertib Kampus dan atau peraturan lain yang telah atau akan diberlakukan dilingkungan Universitas Agung Podomoro. Saya bersedia dikenakan sanksi apapun apabila informasi yang saya berikan TIDAK BENAR";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Saya menerima,mengerti dan menyetujui semua peraturan yang berlaku di Universitas Agung Podomoro";
            $SetYMultiCell = $setY + 10;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 4,$isian, 0,'L');

            $setY = $setY + 25;
            $this->mypdf->SetFont('Arial','b',8);
            $this->mypdf->SetXY(10,$setY);
            $this->mypdf->SetTextColor(255,255,255);
            $this->mypdf->SetFillColor(0,0,0);
            $this->mypdf->Cell(190, 5, 'Pernyataan pendaftaran adalah perjanjian antara Calon Mahasiswa dan Universitas Agung Podomoro sebagai sebuah institusi.', 1, 1, 'L', true);

            $setYLine = $setY + 15;
            $this->mypdf->Line(10,$setYLine,40,$setYLine);
            $setYNameLine = $setYLine + 2;
            $this->mypdf->SetXY(10,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tempat', 0, 1, 'L', 0);

            $this->mypdf->Line(50,$setYLine,80,$setYLine);
            // $setYNameLine = $setYLine + 2;
            $this->mypdf->SetXY(50,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tanggal', 0, 1, 'L', 0);

            $setY = $setYNameLine + 15;
            $this->mypdf->SetXY(20,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','','6');
            $this->mypdf->Cell(0, 0, 'Materai', 0, 1, 'L', 0);
            $setY = $setY + 2;
            $this->mypdf->SetXY(20,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','','6');
            $this->mypdf->Cell(0, 0, 'Rp. 6000,-', 0, 1, 'L', 0);

            $setYLineSignature = $setY + 15;
            $this->mypdf->Line(10,$setYLineSignature,80,$setYLineSignature);
            $setYLineNameSignature = $setYLineSignature + 2;
            $this->mypdf->SetXY(10,$setYLineNameSignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $this->session->userdata('Name'), 0, 1, 'L', 0);

            $this->mypdf->Line(190,$setYLineSignature,120,$setYLineSignature);
            $setYLineNameSignature = $setYLineSignature + 2;
            $this->mypdf->SetXY(120,$setYLineNameSignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tanda Tangan dan Nama Lengkap Orang Tua / Wali', 0, 1, 'L', 0);

            $path = $path.'/'.$filename;
            $this->mypdf->Output($path,'F');

        }
        catch(Exception $e)
        {
            return $arr_temp['filename'] = $filename;   
        }
       
        return $arr_temp['filename'] = $filename;
    }

    public function downloadPDFBebasNarkoba()
    {
        $path = $this->BuatFolderSetiapCandidate();
        $generatePDF = $this->generatePDFSRTBebasNarkoba($path);
        echo json_encode($generatePDF);
    }

    public function PernyataanKesanggupanSTTB()
    {
        $path = $this->BuatFolderSetiapCandidate();
        $generatePDF = $this->downloadPDFPernyataanKesanggupanSTTB($path);
        echo json_encode($generatePDF);
    }

    public function generatePDFSRTBebasNarkoba($path)
    {
        //error_reporting(0);
        $arr_value = $this->m_reg->getDataFormulirPDf();
        $arr_temp = array('filename' => '');
        $filename = "Surat-Pernyataan-Bebas-Narkoba.pdf";
        $setXAwal = 10;
        $setYAwal = 18;
        $setJarakY = 5;
        $setFontIsian = 8;

        try{
            $config=array('orientation'=>'P','size'=>'A4');
            $this->load->library('mypdf',$config);
            $this->mypdf->SetMargins(0,0,0,0);
            $this->mypdf->SetAutoPageBreak(true, 0);
            $this->mypdf->AddPage();
            // Logo
            $this->mypdf->Image('./images/logo_tr.png',10,1,30);
            // Line break
            $this->mypdf->Ln(8);

            $this->mypdf->SetFont('Arial','B',14);
            $this->mypdf->Cell(210, 10, 'Surat Pernyataan Bebas Diri Narkoba', 0, 1, 'C', 0);

            // isian
            $setY = $setYAwal + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Saya yang bertanda tangan dibawah ini : ', 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Nama', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[1], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tempat, Tanggal Lahir', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[6], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'No.KTP / Passport / Kartu Pelajar', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[3], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Jenis Kelamin', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[2], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Agama', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[5], 0, 1, 'L', 0);

            $setY = $setY + ($setJarakY * 2);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Dengan ini menyatakan dengan sesungguhnya bahwa saya tidak pernah menggunakan narkoba dan terlibat dengan narkoba dalam bentuk apapun, baik sebagai pengguna atau pengedar.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 3);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Demikian surat pernyataan ini saya buat dengan sesungguhnya dan saya bersedia diproses berdsarkan hukum yang berlaku di Republik Indonesia serta bersedia menerima segala tindakan yang diambil oleh Podomoro University dan pemerintah apabila dikemudian hari pernyataan saya terbukti tidak benar.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');


            $setYLine = $setY + 30;
            $this->mypdf->Line(10,$setYLine,40,$setYLine);
            $setYNameLine = $setYLine + 2;
            $this->mypdf->SetXY(10,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tempat', 0, 1, 'L', 0);

            $this->mypdf->Line(50,$setYLine,80,$setYLine);
            // $setYNameLine = $setYLine + 2;
            $this->mypdf->SetXY(50,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tanggal', 0, 1, 'L', 0);

            $this->mypdf->SetXY(140,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Mengetahui', 0, 1, 'L', 0);

            $setY = $setYNameLine + 15;
            $this->mypdf->SetXY(20,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','','6');
            $this->mypdf->Cell(0, 0, 'Materai', 0, 1, 'L', 0);
            $setY = $setY + 2;
            $this->mypdf->SetXY(20,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','','6');
            $this->mypdf->Cell(0, 0, 'Rp. 6000,-', 0, 1, 'L', 0);

            $setYLineSignature = $setY + 15;
            $this->mypdf->Line(10,$setYLineSignature,80,$setYLineSignature);
            $setYLineNameSignature = $setYLineSignature + 2;
            $this->mypdf->SetXY(10,$setYLineNameSignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $this->session->userdata('Name'), 0, 1, 'L', 0);

            $this->mypdf->Line(190,$setYLineSignature,120,$setYLineSignature);
            $setYLineNameSignature = $setYLineSignature + 2;
            $this->mypdf->SetXY(120,$setYLineNameSignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tanda Tangan dan Nama Lengkap Orang Tua / Wali', 0, 1, 'L', 0);
            
            $path = $path.'/'.$filename;
            $this->mypdf->Output($path,'F');

        }
        catch (Exception $e){
            return $arr_temp['filename'] = $filename;
        }

        return $arr_temp['filename'] = $filename;
    }

    public function testing()
    {
        //error_reporting(0);
        //include autoload composer
        include_once APPPATH.'vendor/autoload.php';
        //include APPPATH.'/vendor/gumlet/php-image-resize/lib/ImageResize.php';
        // $image = new \Gumlet\ImageResize('./foto_formulir/2d5b30f708b3c6ad7cd70a43b939a53e.jpg');
        // $image->scale(50);
        // $image->save('image2.jpg');

        $image = new \Gumlet\ImageResize('./foto_formulir/2d5b30f708b3c6ad7cd70a43b939a53e.jpg');
        //$image->resizeToHeight(75);
        //$image->resizeToWidth(113.38582677);
        //$image->resizeToBestFit(75, 113);
        $image->resize(75, 113);
        $image->save('image2.jpg');
    }

    public function upload_dokument()
    {
        $this->setAjaxRequest();
        $input = $this->getInputToken();
        $ID_document = $input['ID_document'];
        $filename = $input['attachName'].'_Uploaded';
        $filename = str_replace(' ', '_', $filename);
        $uploadFile = $this->uploadDokumen($filename);
        if (is_array($uploadFile)) {
            $this->m_reg->saveDataUploadDokumen($ID_document,$uploadFile['file_name']);
            echo json_encode(array('msg' => 'The file has been successfully uploaded','status' => 1,'filename' => $uploadFile['file_name']));
        }
        else
        {
            echo json_encode(array('msg' => $uploadFile,'status' => 0));
        }
        
    }

    public function uploadDokumen($filename)
    {
        $path = $this->BuatFolderSetiapCandidate();
        // upload file
         $config['upload_path']   = $path.'/';
         $config['overwrite'] = TRUE; 
         // $config['allowed_types'] = 'png|jpg|pdf';
         $config['allowed_types'] = '*';  
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

    public function fileShow($filename)
    {   
        $path = $this->BuatFolderSetiapCandidate().'/'.$filename;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext == 'pdf') {
            if (file_exists($path)) {
                    // $file = "path_to_file";
                    $fp = fopen($path, "r") ;
                    header("Cache-Control: maxage=1");
                    header("Pragma: public");
                    header("Content-type: application/pdf");
                    header("Content-Disposition: inline; filename=".$filename."");
                    header("Content-Description: PHP Generated Data");
                    header("Content-Transfer-Encoding: binary");
                    header('Content-Length:' . filesize($path));
                    ob_clean();
                    flush();
                    while (!feof($fp)) {
                       $buff = fread($fp, 1024);
                       print $buff;
                    }
                    exit;
            }
            else
            {
                show_404($log_error = TRUE);
            }
        }
        else
        {
            $imageData = base64_encode(file_get_contents($path));
            echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
        }
    }

    public function downloadPDFPernyataanKesanggupanSTTB($path)
    {
        //error_reporting(0);
        $arr_value = $this->m_reg->getDataFormulirPDf();
        $arr_temp = array('filename' => '');
        $filename = "Surat-Pernyataan-Kesanggupan-Kelengkapan-STTB.pdf";
        $setXAwal = 10;
        $setYAwal = 18;
        $setJarakY = 5;
        $setFontIsian = 8;

        try{
            $config=array('orientation'=>'P','size'=>'A4');
            $this->load->library('mypdf',$config);
            $this->mypdf->SetMargins(0,0,0,0);
            $this->mypdf->SetAutoPageBreak(true, 0);
            $this->mypdf->AddPage();
            // Logo
            $this->mypdf->Image('./images/logo_tr.png',10,1,30);
            // Line break
            $this->mypdf->Ln(8);

            $this->mypdf->SetFont('Arial','B',14);
            $this->mypdf->Cell(210, 10, 'Surat Pernyataan Kesanggupan Kelengkapan STTB', 0, 1, 'C', 0);

            // isian
            $setY = $setYAwal + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Yang bertanda tangan dibawah ini : ', 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Nama Calon Mahasiswa', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[1], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Alamat', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value 
            $setX = $setXAwal + 50; 
            $setXisian = $setX;
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = $arr_value[13]." ".$arr_value[12]." ".$arr_value[11]." ".$arr_value[10]." ".$arr_value[9];
            $SetYMultiCell = $setY - 3;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'KTP No.', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[3], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Nama Orang Tua', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[27]."/".$arr_value[28], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Program Studi', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value
             $nama_program_Study = $this->m_reg->getNamaProgramStudy($arr_value[0]); 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $nama_program_Study, 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Asal Sekolah', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[17], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Alamat Sekolah', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[23]." ".$arr_value[22]." ".$arr_value[21], 0, 1, 'L', 0);

            $setY = $setY + ($setJarakY * 2);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Dengan ini saya, selaku calon Mahasiswa menyetujui seluruh persyaratan yang tercantum dalam Surat Pernyataan Kesanggupan Kelengkapan Dokumen ini untuk menjadi mahasiswa Universitas Agung Podomoro, Calon Mahasiswa diwajibkan untuk memberikan seluruh kelengkapan dokumen yang diminta,termasuk : ";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 4);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Fotokopi Ijazah Sekolah Menegah Tingkat Atas/Ijasah Paket C/Surat Penyetaraan bagi Lulusan Luar Negri yang dilegalisir oleh :";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "* Sekolah yang menerbitkan Ijazah tersebut untuk Ijazah Sekolah Menegah Tingkat Atas/Sekolah Menegah Kejuruan.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "* Suku Dinas Pendidikan Menegah tingkat Kabupaten/Kota setempat untuk Ijazah Paket C dan;";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "* Direktorat Jenderal Pendidikan Menegah Kementrian Pendidikan dan Kebudayaan Republik Indonesia untuk Surat Penyetaraan bagi lulusan Luar Negri sebagai persyaratan pendaftaran di Universitas Agung Podomoro";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 3);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Jangka waktu yang harus dipenuhi untuk melengkapi persyaratan dokumen tersebut diatas adalah : ";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "* Selambat-lambatnya 1 (satu) minggu sebelum semester-1 berakhir untuk fotokopi ijazah SMA Nasional (STTB/NEM/DNUN/SKHUN) yang dilgalisir;";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $year = date('Y');
            $year1 = $year + 1;
            $isian = "* Selambat-lambatnya 1 (satu) minggu sebelum perkuliahan tahun ajaran ".$year."-".$year1." dimulai untuk ijazah Paket C dan Surat Pernyataan bagi lulusan luar negri yang dilegalisir.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 3);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Apabila Calon Mahasiswa tidak memenuhi persyaratan berupa ijazah Sekolah Menegah Tingkat Atas atau Ijazah Paket C atau Surat Penyetaraan tersebut, atau apabila Ijazah Sekolah Menegah Tingkat Atas,Ijazah Paket C atau Surat Penyetaraan tersebut, atau apabila Ijazah Sekolah Menegah Tingkat Atas, Ijazah Paket C atau Surat Penyetaraan tersebut ternyata tidak terdaftar atau tidak memenuhi syarat dari Direktorat Jenderal Pendidikan Menegah Kementrian Pendidikan dan Kebudayaan Republik Indonesia, tepat pada waktu yang telah ditentukan diatas, maka Calon Mahasiswa dengan ini setuju untuk menerima sanksi berupa : ";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 6);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "* Dikeluarkan sebagai mahasiswa Universitas Agung Podomoro";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "* Seluruh biaya yang telah dibayar oleh Calon Mahasiswa tidak dapat ditarik kembali dan menjadi hak Universitas Agung Podomoro sepenuhnya;dan";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "* Tidak akan mengajukan gugatan atau tuntutan dalam bentuk apapun terhadap Universitas Agung Podomoro berkenaan dengan hal - hal tersebut diatas.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 3);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Demikian surat pernyataan ini dibuat dan ditandatangani tanpa ada tekanan dan paksaan dari pihak manapun.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setYLine = $setY + 10;
            $this->mypdf->Line(10,$setYLine,40,$setYLine);
            $setYNameLine = $setYLine + 2;
            $this->mypdf->SetXY(10,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tempat', 0, 1, 'L', 0);

            $this->mypdf->Line(50,$setYLine,80,$setYLine);
            // $setYNameLine = $setYLine + 2;
            $this->mypdf->SetXY(50,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tanggal', 0, 1, 'L', 0);

            $this->mypdf->SetXY(140,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Mengetahui/menyetujui', 0, 1, 'L', 0);

            $setY = $setYNameLine + 15;
            $this->mypdf->SetXY(150,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','','6');
            $this->mypdf->Cell(0, 0, 'Materai', 0, 1, 'L', 0);
            $setY = $setY + 2;
            $this->mypdf->SetXY(150,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','','6');
            $this->mypdf->Cell(0, 0, 'Rp. 6000,-', 0, 1, 'L', 0);

            $setYLineSignature = $setY + 15;
            $this->mypdf->Line(10,$setYLineSignature,80,$setYLineSignature);
            $setYLineNameSignature = $setYLineSignature + 2;
            $this->mypdf->SetXY(10,$setYLineNameSignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $this->session->userdata('Name'), 0, 1, 'L', 0);

            $this->mypdf->Line(190,$setYLineSignature,120,$setYLineSignature);
            $setYLineNameSignature = $setYLineSignature + 2;
            $this->mypdf->SetXY(120,$setYLineNameSignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tanda Tangan dan Nama Lengkap Orang Tua / Wali', 0, 1, 'L', 0);
            
            $path = $path.'/'.$filename;
            $this->mypdf->Output($path,'F');

        }
        catch (Exception $e){
            return $arr_temp['filename'] = $filename;
        }

        return $arr_temp['filename'] = $filename;
    }

    public function downloadPDFPernyataanKelengkapanDokumen()
    {
        $path = $this->BuatFolderSetiapCandidate();
        $generatePDF = $this->generatePDFPernyataanKelengkapanDokumen($path);
        echo json_encode($generatePDF);
    }

    public function generatePDFPernyataanKelengkapanDokumen($path)
    {
        //error_reporting(0);
        $arr_value = $this->m_reg->getDataFormulirPDf();
        $arr_temp = array('filename' => '');
        $filename = "Surat-Pernyataan-Kesanggupan-Kelengkapan-Dokumen.pdf";
        $setXAwal = 10;
        $setYAwal = 18;
        $setJarakY = 5;
        $setFontIsian = 8;

        try{
            $config=array('orientation'=>'P','size'=>'A4');
            $this->load->library('mypdf',$config);
            $this->mypdf->SetMargins(0,0,0,0);
            $this->mypdf->SetAutoPageBreak(true, 0);
            $this->mypdf->AddPage();
            // Logo
            $this->mypdf->Image('./images/logo_tr.png',10,1,30);
            // Line break
            $this->mypdf->Ln(8);

            $this->mypdf->SetFont('Arial','B',14);
            $this->mypdf->Cell(210, 10, 'Surat Pernyataan Kesanggupan Kelengkapan Dokumen', 0, 1, 'C', 0);

            // isian
            $setY = $setYAwal + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Kami Yang bertanda tangan dibawah ini : ', 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Nama Calon Mahasiswa', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[1], 0, 1, 'L', 0);

            // value 
            $setX = $setXAwal + 150; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, "Angkatan : ".date('Y'), 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Program Studi', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value
             $nama_program_Study = $this->m_reg->getNamaProgramStudy($arr_value[0]); 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $nama_program_Study, 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Asal Sekolah', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            // value 
            $setX = $setXAwal + 50; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $arr_value[17], 0, 1, 'L', 0);

            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Kelas', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

            $setX = $setXAwal + 50; 
            $kelas = "Kelas ";
            $jarakX1 = 3;
            $jarakX2 = 20;
            $setXCheckbox1 = $setX;
            $setYCheckbox = $setY - 1.7;
            for ($i=10; $i <= 12 ; $i++) { 
                $this->mypdf->Image('./images/checkbox.jpg',$setXCheckbox1,$setYCheckbox,3);
                // value 
                $setX = $setX + $jarakX1;
                $this->mypdf->SetXY($setX,$setY);
                $this->mypdf->SetTextColor(0,0,0);
                $this->mypdf->SetFont('Arial','',$setFontIsian);
                $this->mypdf->Cell(0, 0, $kelas.$i, 0, 1, 'L', 0);
                $setX = $setX + $jarakX2;
                $setXCheckbox1 = $setX;
            }
            
            $setY = $setY + 10;
            $setX = $setXAwal; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Alamat', 0, 1, 'L', 0);

            $setX = $setXAwal + 45; 
            $this->mypdf->SetXY($setX,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, ':', 0, 1, 'L', 0);

             // value 
            $setX = $setXAwal + 50; 
            $setXisian = $setX;
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = $arr_value[13]." ".$arr_value[12]." ".$arr_value[11]." ".$arr_value[10]." ".$arr_value[9];
            $SetYMultiCell = $setY - 3;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 140, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 3);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Dengan ini kami memahami seluruh persyaratan untuk menjadi mahasiswa Universitas Agung Podomoro, dimana kami selaku mahasiswa wajib memberikan seluruh kelengkapan dokumen sebagai persyaratan pendaftaran sebagai mahasiswa Universitas Agung Podomoro pada Kementrian Riset dan Pendidikan Tinggi.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 4);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Kelengkapan dokumen yang dimaksud adalah :";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "1. Fotokopi Ijazah SMA / Paket C yang dilegalisir atau Surat Penyetaraan";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "2. Fotokopi rapor yang dilegalisir";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "3. Essay mengenai \"I want to be... \" ";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "4. Surat rekomendasi dari sekolah";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "5. Fotokopi Akta Lahir dan KTP";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "6. Admission statement (digabung dengan formulir pendaftaran)";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "7. Pernyataan Bebas Narkoba (digabung dengan formulir pendaftaran)";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "8. Pas Photo terbaru berukuran 3x4 berwarna sebanyak 3 lembar";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "9. Surat keterangan tidak buta warna (khusus program studi Arsitektur dan Desain Produk)";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "10. Portofolio gambar dengan bangunan (khusus program studi Arsitektur)";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 1);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "11. Test TOEFL dengan minimal nilai 400 (khusus program studi Kewirausahaan)";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');


            $setY = $setY + ($setJarakY * 2);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Seluruh kelengkapan dokumen tersebut wajib diberikan sebelum Semester 1 berakhir. Kami wajib mematuhi dan memenuhi seluruh ketentuan dan peraturan yang berlaku di Universitas Agung Podomoro";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');


            $setY = $setY + ($setJarakY * 3);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Apabila dalam kurun waktu yang ditentukan, kami tidak memenuhi persyaratan maka kami bersedia menerima konsekuensi ataupun sanksi yang telah ditentukan oleh Universitas Agung Podomoro.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setY = $setY + ($setJarakY * 3);
            $setXisian = 10;
            // $this->mypdf->SetXY($setXisian,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $isian = "Demikian Surat Pernyataan ini dibuat tanpa ada tekanan dari pihak manapun.";
            $SetYMultiCell = $setY - 2;
            $this->mypdf->SetXY($setXisian,$SetYMultiCell);
            $this->mypdf->MultiCell( 190, 6,$isian, 0,'L');

            $setYLine = $setY + 20;
            $this->mypdf->Line(10,$setYLine,40,$setYLine);
            $setYNameLine = $setYLine + 2;
            $this->mypdf->SetXY(10,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tempat', 0, 1, 'L', 0);

            $this->mypdf->Line(50,$setYLine,80,$setYLine);
            // $setYNameLine = $setYLine + 2;
            $this->mypdf->SetXY(50,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tanggal', 0, 1, 'L', 0);

            $this->mypdf->SetXY(140,$setYNameLine);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Mengetahui/menyetujui', 0, 1, 'L', 0);

            $setY = $setYNameLine + 15;
            $this->mypdf->SetXY(150,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','','6');
            $this->mypdf->Cell(0, 0, 'Materai', 0, 1, 'L', 0);
            $setY = $setY + 2;
            $this->mypdf->SetXY(150,$setY);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','','6');
            $this->mypdf->Cell(0, 0, 'Rp. 6000,-', 0, 1, 'L', 0);

            $setYLineSignature = $setY + 15;
            $this->mypdf->Line(10,$setYLineSignature,80,$setYLineSignature);
            $setYLineNameSignature = $setYLineSignature + 2;
            $this->mypdf->SetXY(10,$setYLineNameSignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, $this->session->userdata('Name'), 0, 1, 'L', 0);

            $this->mypdf->Line(190,$setYLineSignature,120,$setYLineSignature);
            $setYLineNameSignature = $setYLineSignature + 2;
            $this->mypdf->SetXY(120,$setYLineNameSignature);
            $this->mypdf->SetTextColor(0,0,0);
            $this->mypdf->SetFont('Arial','',$setFontIsian);
            $this->mypdf->Cell(0, 0, 'Tanda Tangan dan Nama Lengkap Orang Tua / Wali', 0, 1, 'L', 0);
            
            $path = $path.'/'.$filename;
            $this->mypdf->Output($path,'F');

        }
        catch (Exception $e){
            return $arr_temp['filename'] = $filename;
        }

        return $arr_temp['filename'] = $filename;
    }

}
