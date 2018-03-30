
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

}
