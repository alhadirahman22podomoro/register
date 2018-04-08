<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_register extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getPriceFormulir()
    {
        $price_formulir = $this->price_formulir();
        $count_account = $this->count_account();
        $getAllPriceFormulir = $this->getAllPriceFormulir();
        // get account by loop
        if (count($getAllPriceFormulir) == 0) {
            $price_formulir = $price_formulir + 1;
        }
        else
        {
            for ($i=1; $i <= $count_account; $i++) { 
                $price_formulir = $price_formulir + 1;
                if (!in_array((string)$price_formulir, $getAllPriceFormulir)) {
                    break;
                }
            }
        }
        
        return $price_formulir;
    }

    public function price_formulir()
    {
        $sql = "select PriceFormulir from db_admission.price_formulir as a where a.active = 1 order by a.CreateAT desc limit 1";
        $query=$this->db->query($sql, array())->result_array();
        return $query[0]['PriceFormulir'];
    }

    public function count_account()
    {
        $sql = "select CountAccount from db_admission.count_account as a where a.active = 1 order by a.CreateAT desc limit 1";
        $query=$this->db->query($sql, array())->result_array();
        return $query[0]['CountAccount'];
    }

    public function getAllPriceFormulir()
    {
        $arr_temp = array();
        $sql = "select a.PriceFormulir from db_admission.register as a where a.StatusReg = 0";
        $query=$this->db->query($sql, array())->result();
        foreach ($query as $key) {
            $arr_temp[] = $key->PriceFormulir;
        }
        return $arr_temp;
    }

    public function saveToDBRegister($name,$Email,$SchoolName,$priceFormulir,$momenUnix,$StatusReg = 0)
    {
        $dataSave = array(
                'Name' => $name,
                'Email' => $Email,
                'MomenUnix' => $momenUnix,
                'SchoolID' => $SchoolName,
                'PriceFormulir' => $priceFormulir,
                'RegisterAT' => date("Y-m-d"),
                'StatusReg' => $StatusReg
                        );

        $this->db->insert('db_admission.register', $dataSave);
    }

    public function Longtime()
    {
        $sql = "select Longtime from db_admission.deadline_register as a where a.active = 1 order by a.CreateAT desc limit 1";
        $query=$this->db->query($sql, array())->result_array();
        return $query[0]['Longtime'];
    }

    public function alreadyExistingEmail($Email)
    {
        $arr = array('errorMSG' => '');
        $sql = "select count(*) as total from db_admission.register as a where a.Email = ? ";
        $query=$this->db->query($sql, array($Email))->result_array();
        if ($query[0]['total'] > 0) {
            $arr['errorMSG'] = "Your email has been registered on the database";
        }
        return $arr;
    }

    public function checkURL($email,$momentUnix)
    {
        $sql = "select * from db_admission.register as a where a.Email = ? and a.MomenUnix = ?
                and( a.ID not in (select a.RegisterID from db_admission.register_verification as a) 
                or (a.ID in (select a.RegisterID from db_admission.register_verification as a where a.FileUpload is NULL) ) )";
        $query=$this->db->query($sql, array($email,$momentUnix))->result_array();
        if (count($query) > 0) {
            $this->session->set_userdata('register_id',$query[0]['ID']);
            $this->session->set_userdata('Name',$query[0]['Name']);
            $this->session->set_userdata('Email',$query[0]['Email']);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function saveDataToVerification($filename)
    {
        // check data sudah di insert atau belum pada table register_verification
        $check = $this->checkDataregister_id_register_verification();
        if ($check) {
            $dataSave = array(
                    'RegisterID' => $this->session->userdata('register_id'),
                    'FileUpload' => $filename,
                    'CreateAT' => date("Y-m-d"),
                            );

            $this->db->insert('db_admission.register_verification', $dataSave);
        }
        else
        {
            $sql = "update db_admission.register_verification set FileUpload = ?,CreateAT = ? where RegisterID = ?";
            $query=$this->db->query($sql, array($filename,date("Y-m-d"),$this->session->userdata('register_id')));
        }
        
    }

    public function checkDataregister_id_register_verification()
    {
        $sql = "select count(*) as total from db_admission.register_verification where RegisterID = ?";
        $query=$this->db->query($sql, array($this->session->userdata('register_id')))->result_array();
        if ($query[0]['total'] ==0) {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function prosesMoveTableRegister($Longtime)
    {
        $this->load->model('m_api');
        $registerID = "";
        $sql = "select a.ID,DATE_ADD(a.RegisterAT, INTERVAL ? DAY) as date_add from db_admission.register as a
                where a.ID not in (select a.RegisterID from db_admission.register_verification as a)";
        $query=$this->db->query($sql, array($Longtime))->result();
        $count = 1;
        foreach ($query as $key) {
            $id = $key->ID;
            $date = $key->date_add;
            $date = $this->m_api->passHariLibur($date);
            $date = date('Y-m-d', strtotime($date));
            $dateNow = date("Y-m-d");
            $dateDiffDate = $this->m_api->dateDiffInteger($dateNow, $date);
            if ($dateDiffDate < 0) { // filtering yang melewati expired
                if (count($query) == 1) {
                    $registerID .= $id;
                }
                else
                {
                    if ($count == 1) {
                        $registerID .= $id.",";
                    }
                    else if(count($query) == $count)    
                    {
                        $registerID .= $id;
                    }
                    else
                    {
                        $registerID .= $id.",";
                    }
                }

            }

            $count++;
        }

        $temp = explode(",", $registerID);
        $counttemp = count($temp);
        if ($temp[$counttemp-1] == "" || $temp[$counttemp-1] == null) {
            $registerID = "";
            for ($i=0; $i < $counttemp-1; $i++) { 
               if ($i == $counttemp-2) {
                   $registerID .= $temp[$i];
               }
               else
               {
                    $registerID .= $temp[$i].",";
               }
            }
        }

        if ($registerID != "") {
            $this->MoveTableRegister($registerID);
        }
        
    }

    public function MoveTableRegister($ID)
    {
        $sql = "insert into db_admission.register_deleted (RegisterID,Name,Email,MomenUnix,SchoolID,PriceFormulir,RegisterAT,DeletedAT)
                select a.*,CURDATE() from db_admission.register as a where a.ID in (".$ID.")
            ";
        $query=$this->db->query($sql, array());
        $sql = "delete from db_admission.register where ID in (".$ID.")";
        $query=$this->db->query($sql, array());
    }

    public function checkURLFormulirRegistration($data)
    {
        $arr_temp = explode(";", $data);
        $checkQuery = $this->checkDatatoDB($arr_temp[0],$arr_temp[1]);
        if ($checkQuery) {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function caribasedprimary($tabel,$fieldPrimary,$valuePrimary)
    {
        $sql = "select * from ".$tabel." where ".$fieldPrimary." = ?"; 
        $query=$this->db->query($sql, array($valuePrimary));
        return $query->result_array();
    }

    public function checkURLFormulirRegistration_offline($data)
    {
        $arr_temp = explode(";", $data);
        $FormulirCode = $arr_temp[0];
        $Years = $arr_temp[1];
        $checkQuery = $this->checkDatatoDB_offline($FormulirCode,$Years);

        $RegisterID= '';
        $RegVerificationID = '';
        $ID_register_verified = '';
        if ($checkQuery) {
            //check apakah formulir code sudah pernah digunakan atau tidak
            $check = $this->caribasedprimary('db_admission.register_verified','FormulirCode',$FormulirCode);
            if (count($check) > 0) {
                $ID_register_verified = $check[0]['ID'];
                $RegVerificationID = $check[0]['RegVerificationID'];
                $check2 = $this->caribasedprimary('db_admission.register_verification','ID',$RegVerificationID);
                $RegisterID = $check2[0]['RegisterID'];
                $check3 = $this->caribasedprimary('db_admission.register','ID',$RegisterID);
                $email = $check3[0]['Email'];
                $this->checkDatatoDB($RegisterID,$email);
            }
            $this->session->set_userdata('FormulirCode',$FormulirCode);
            $this->updateStatusFormulir($FormulirCode);
            return true;
        }
        else
        {
            return false;
        }

    }

    public function updateStatusFormulir($FormulirCode)
    {
        $sql = "update db_admission.formulir_number_offline_m set Status = 1 where FormulirCode = ?";
        $query=$this->db->query($sql, array($FormulirCode));
    }

    public function checkDatatoDB_offline($FormulirCode,$Years)
    {
        $sql = "select count(*) as total from db_admission.formulir_number_offline_m where FormulirCode = ? and Years = ?";
        $query=$this->db->query($sql, array($FormulirCode,$Years))->result_array();
        $total = $query[0]['total'];
        if ($total > 0) {
            return true;
        }
        else
        {
            return false;
        }
    } 

    public function checkDatatoDB($ID_register,$email)
    {
        $sql = "select a.ID,a.Name,a.Email,a.SchoolID,b.SchoolName,a.PriceFormulir,a.RegisterAT,c.FileUpload,c.CreateAT as uploadAT,c.ID as ver_id,d.FormulirCode,d.VerificationAT,e.name as VerificationBY,
                d.ID as verified_id
            from db_admission.register as a LEFT JOIN db_admission.school as b
            on a.SchoolID = b.ID
            JOIN db_admission.register_verification as c
            on a.ID = c.RegisterID
            join db_admission.register_verified as d
            on c.ID = d.RegVerificationID
            LEFT JOIN db_employees.employees as e
            on e.NIP = d.VerificationBY
            where a.ID = ? and a.Email = ?
            ";
        $query=$this->db->query($sql, array($ID_register,$email))->result_array();
        if (count($query) > 0) {
            $this->session->set_userdata('register_id',$query[0]['ID']);
            $this->session->set_userdata('Name',$query[0]['Name']);
            $this->session->set_userdata('Email',$query[0]['Email']);
            $this->session->set_userdata('SchoolID',$query[0]['SchoolID']);
            $this->session->set_userdata('SchoolName',$query[0]['SchoolName']);
            $this->session->set_userdata('FormulirCode',$query[0]['FormulirCode']);
            $this->session->set_userdata('ID_register_verified',$query[0]['verified_id']);
            return true;
        }
        else
        {
            return false;
        }    
    }

    public function saveDataFormulir($arr,$namaFile)
    {
        $arrValue = $this->getValueArr($arr,$namaFile);
        $GetCol = $this->getCol();
        $arr_save = array();
        $j = 0;
        for ($i=1; $i < count($GetCol); $i++) { 
            $arr_save[$GetCol[$i]] = $arrValue[$j];
            $j++;
        }

        $this->db->insert('db_admission.register_formulir', $arr_save);

        // check schedule ujian
        $query = $this->caribasedprimary('db_admission.register_formulir','ID_register_verified',$this->session->userdata('ID_register_verified'));
        $ID_register_formulir = $query[0]['ID'];
        $ID_program_study = $query[0]['ID_program_study'];
        $checkScheduleUjian = $this->checkScheduleUjian($ID_program_study);
        if (count($checkScheduleUjian) > 0) {
            $sql2 = 'select count(*) as total from db_admission.ujian_perprody_m where ID_ProgramStudy = ? limit 1';
            $query2=$this->db->query($sql2, array($ID_program_study))->result_array();
            $limit = $query2[0]['total'];
            $sql = 'select a.ID,DATE(a.DateTimeTest) as tanggal from db_admission.register_jadwal_ujian as a
                    join db_admission.ujian_perprody_m as b
                    on a.ID_ujian_perprody = b.ID
                    where b.ID_ProgramStudy = ? and datediff(DATE_ADD(DATE(a.DateTimeTest), INTERVAL 2 DAY), DATE(a.DateTimeTest)) >= 2
                    order by a.ID,DATE(a.DateTimeTest) asc 
                    limit '.$limit;
            $query=$this->db->query($sql, array($ID_program_study))->result_array();
            for ($i=0; $i < count($query); $i++) { 
              try
              {
                  $dataSave = array(
                          'ID_register_jadwal_ujian' => $query[$i]['ID'],
                          'ID_register_formulir' => $ID_register_formulir,
                  );
                  $this->db->insert('db_admission.register_formulir_jadwal_ujian', $dataSave);
                
              }
              catch(Exception $e)
              {
                continue;
              }
            }        
        }
        
    }

    public function checkScheduleUjian($ID_program_study)
    {
        $sql = "select C.Name,a.ID_ujian_perprody,DATE(a.DateTimeTest) as tanggal
                ,CONCAT((EXTRACT(HOUR FROM a.DateTimeTest)),':',(EXTRACT(MINUTE FROM a.DateTimeTest))) as jam,
                a.Lokasi from db_admission.register_jadwal_ujian as a 
                join db_admission.ujian_perprody_m as b
                on a.ID_ujian_perprody = b.ID
                join db_academic.program_study as c
                on c.ID = b.ID_ProgramStudy
                where datediff(DATE_ADD(DATE(a.DateTimeTest), INTERVAL 2 DAY), DATE(a.DateTimeTest)) >= 2
                and b.ID_ProgramStudy = ?
                GROUP BY C.Name,DATE(a.DateTimeTest)
                ORDER by DATE(a.DateTimeTest) asc
                limit 1";
        $query=$this->db->query($sql, array($ID_program_study))->result_array();
        return $query;        

    }

    public function saveDataFormulir_offline($arr,$namaFile)
    {
        // save data to register
        $arr_return = array();
        $Name = $arr['FullName'];
        $Email = $arr['Email'];
        $SchoolID = $arr['SchoolID'];
        $getPriceFormulir = $this->getPriceFormulir_offline();
        $this->saveToDBRegister($Name,$Email,$SchoolID,$getPriceFormulir,'',1);
        $getData = $this->caribasedprimary('db_admission.register','Email',$Email);
        $RegisterID = $getData[0]['ID'];
        // save data to register_verification
        $this->saveDataToVerification_offline($RegisterID);
        $getData = $this->caribasedprimary('db_admission.register_verification','RegisterID',$RegisterID);
        $RegVerificationID = $getData[0]['ID'];
        $FormulirCode = $arr['FormulirCode'];
        // save data to register_verified
        $this->saveDataRegisterVerified($RegVerificationID,$FormulirCode);
        $getData = $this->caribasedprimary('db_admission.register_verified','RegVerificationID',$RegVerificationID);
        $ID_register_verified = $getData[0]['ID'];
        // save data to register_formulir
        $arr_return = $arr_return + array('ID_register_verified' => $ID_register_verified);
        $arr_return = $arr_return + $arr;
        $this->saveDataFormulir2($arr_return,$namaFile);
        $this->session->set_userdata('register_id',$RegisterID);
        $this->session->set_userdata('Name',$Name);
        $this->session->set_userdata('Email',$Email);
        $this->session->set_userdata('SchoolID',$SchoolID);
        $getData = $this->caribasedprimary('db_admission.school','ID',$SchoolID);
        $SchoolName = $getData[0]['SchoolName'];
        $this->session->set_userdata('SchoolName',$SchoolName);
        $this->session->set_userdata('FormulirCode',$FormulirCode);
        $this->session->set_userdata('ID_register_verified',$ID_register_verified);

         // check schedule ujian
        $query = $this->caribasedprimary('db_admission.register_formulir','ID_register_verified',$this->session->userdata('ID_register_verified'));
        $ID_register_formulir = $query[0]['ID'];
        $ID_program_study = $query[0]['ID_program_study'];
        $checkScheduleUjian = $this->checkScheduleUjian($ID_program_study);
        if (count($checkScheduleUjian) > 0) {
            $sql2 = 'select count(*) as total from db_admission.ujian_perprody_m where ID_ProgramStudy = ? limit 1';
            $query2=$this->db->query($sql2, array($ID_program_study))->result_array();
            $limit = $query2[0]['total'];
            $sql = 'select a.ID,DATE(a.DateTimeTest) as tanggal from db_admission.register_jadwal_ujian as a
                    join db_admission.ujian_perprody_m as b
                    on a.ID_ujian_perprody = b.ID
                    where b.ID_ProgramStudy = ? and datediff(DATE_ADD(DATE(a.DateTimeTest), INTERVAL 2 DAY), DATE(a.DateTimeTest)) >= 2
                    order by a.ID,DATE(a.DateTimeTest) asc 
                    limit '.$limit;
            $query=$this->db->query($sql, array($ID_program_study))->result_array();
            for ($i=0; $i < count($query); $i++) { 
              try
              {
                  $dataSave = array(
                          'ID_register_jadwal_ujian' => $query[$i]['ID'],
                          'ID_register_formulir' => $ID_register_formulir,
                  );
                  $this->db->insert('db_admission.register_formulir_jadwal_ujian', $dataSave);
                
              }
              catch(Exception $e)
              {
                continue;
              }
            }        
        }

    }

    public function getValueArr2($data,$namaFile)
    {
        $arr_temp = array();
        $result  = array();
        foreach ($data as $key => $value) {
            $arr_temp[] = $value;
        }

        for ($i=0; $i < count($arr_temp) - 7; $i++) { 
            $result[] = $arr_temp[$i];
        }
        
        array_push($result, $namaFile);
        return $result;
    }

    public function saveDataFormulir2($arr,$namaFile)
    {
        $arrValue = $this->getValueArr2($arr,$namaFile);
        $GetCol = $this->getCol();
        $arr_save = array();
        $j = 0;
        for ($i=1; $i < count($GetCol); $i++) { 
            $arr_save[$GetCol[$i]] = $arrValue[$j];
            $j++;
        }

        $this->db->insert('db_admission.register_formulir', $arr_save);
        
    }

    public function saveDataRegisterVerified($RegVerificationID,$FormulirCode)
    {
     // $getFormulirCode = $this->getFormulirCode('online');
     $dataSave = array(
             'RegVerificationID' => $RegVerificationID,
             'FormulirCode' => $FormulirCode,
             // 'VerificationBY' => $this->session->userdata('NIP'),
             // 'VerificationAT' => date('Y-m-d H:i:s'),
                     );
     $this->db->insert('db_admission.register_verified', $dataSave);
    }

    public function saveDataToVerification_offline($RegisterID)
    {
        // check data sudah di insert atau belum pada table register_verification
        $check = $this->checkDataregister_id_register_verification_offline($RegisterID);
        if ($check) {
            $dataSave = array(
                    'RegisterID' => $RegisterID,
                    'FileUpload' => '',
                    'CreateAT' => date("Y-m-d"),
                            );

            $this->db->insert('db_admission.register_verification', $dataSave);
        }
    }

    public function checkDataregister_id_register_verification_offline($RegisterID)
    {
        $sql = "select count(*) as total from db_admission.register_verification where RegisterID = ?";
        $query=$this->db->query($sql, array($RegisterID))->result_array();
        if ($query[0]['total'] ==0) {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getPriceFormulir_offline()
    {
        $price_formulir = $this->price_formulir_offline();
        /*$count_account = $this->count_account();
        $getAllPriceFormulir = $this->getAllPriceFormulir_offline();
        // get account by loop
        if (count($getAllPriceFormulir) == 0) {
            $price_formulir = $price_formulir + 1;
        }
        else
        {
            for ($i=1; $i <= $count_account; $i++) { 
                $price_formulir = $price_formulir + 1;
                if (!in_array((string)$price_formulir, $getAllPriceFormulir)) {
                    break;
                }
            }
        }*/
        
        return $price_formulir;
    }

    public function getAllPriceFormulir_offline()
    {
        $arr_temp = array();
        $sql = "select a.PriceFormulir from db_admission.register as a where a.StatusReg = 0";
        $query=$this->db->query($sql, array())->result();
        foreach ($query as $key) {
            $arr_temp[] = $key->PriceFormulir;
        }
        return $arr_temp;
    }

    public function price_formulir_offline()
    {
        $sql = "select PriceFormulir from db_admission.price_formulir_offline as a where a.active = 1 order by a.CreateAT desc limit 1";
        $query=$this->db->query($sql, array())->result_array();
        return $query[0]['PriceFormulir'];
    }    

    private function getValueArr($data,$namaFile)
    {
        $arr_temp = array();
        $result  = array();
        foreach ($data as $key => $value) {
            $arr_temp[] = $value;
        }

        for ($i=0; $i < count($arr_temp) - 3; $i++) { 
            $result[] = $arr_temp[$i];
        }

        array_push($result, $namaFile);
        return $result;
    }

    private function getCol()
    {
        $arr_temp = array();
        $COLUMNS = $this->getColumnTable("db_admission.register_formulir");
        $arr_temp = $COLUMNS['field'];
        return $arr_temp;
    } 

    public function getColumnTable($table)
    {
        $arr = array();
        $sql = "SHOW COLUMNS FROM ".$table; 
        $query=$this->db->query($sql, array())->result();
        $temp = array();
        foreach ($query as $key) {
            $temp[] = $key->Field;
        }
        $arr = array('query' => $query,'field' => $temp); 
        return $arr;
    }

    public function checkURLFormulirTelahdiisi()
    {
        $sql = "select count(*) as total from db_admission.register_formulir where ID_register_verified = ?
            ";
        $query=$this->db->query($sql, array($this->session->userdata('ID_register_verified')))->result_array();
        if ($query[0]['total'] > 0) {
            $getIDRegisterFormulir = $this->getIDRegisterFormulir($this->session->userdata('ID_register_verified'));
            $this->session->set_userdata('ID_register_formulir',$getIDRegisterFormulir);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function chkTableregister_formulir()
    {
        $arr = array('result' => null,'count' => 0);
        $DataDocument = $this->getDocument();
        // $getIDRegisterFormulir = $this->getIDRegisterFormulir($this->session->userdata('ID_register_verified'));
        // $this->session->set_userdata('ID_register_formulir',$getIDRegisterFormulir);
        $getIDRegisterFormulir = $this->session->userdata('ID_register_formulir');
        $getDataRegisterDokument_IDDoc = $this->getDataRegisterDokument_IDDoc($getIDRegisterFormulir);
        $arr_temp = array();
        for ($i=0; $i < count($DataDocument['ID_reg_doc_checklist']); $i++) { 
            $ID_reg_doc_checklist = $DataDocument['ID_reg_doc_checklist'][$i];
            if (!in_array($ID_reg_doc_checklist, $getDataRegisterDokument_IDDoc)) {
                $arr_temp[] = $ID_reg_doc_checklist;
            }
        }

        if (count($arr_temp) > 0) {
            $this->saveDataFormulirDokument($getIDRegisterFormulir,$arr_temp);
            $arr['result'] = 'Add';
            $arr['count'] = count($arr_temp);
        }

        return $arr;

    }

    private function saveDataFormulirDokument($ID_register_formulir,$arrID_reg_doc_checklist)
    {
        for ($i=0; $i < count($arrID_reg_doc_checklist); $i++) { 
            $dataSave = array(
                    'ID_register_formulir' => $ID_register_formulir,
                    'ID_reg_doc_checklist' => $arrID_reg_doc_checklist[$i],
                            );

            $this->db->insert('db_admission.register_document', $dataSave);
        }
    }

    private function getDataRegisterDokument_IDDoc($ID_register_formulir)
    {
        $sql = "select ID_reg_doc_checklist from db_admission.register_document where ID_register_formulir = ?
            ";
        $query=$this->db->query($sql, array($ID_register_formulir))->result();
        $arr_temp = array();
        foreach ($query as $key) {
            $arr_temp[] = $key->ID_reg_doc_checklist;
        }
        return $arr_temp;
    }

    private function getIDRegisterFormulir($ID_register_verified)
    {
        $sql = "select ID from db_admission.register_formulir where ID_register_verified = ?
            ";
        $query=$this->db->query($sql, array($ID_register_verified))->result_array();
        return $query[0]['ID'];
    }

    private function getDocument()
    {
        $this->load->model('m_api');
        $DataDocument = $this->m_api->getDataDokument();
        $arr_temp = array('ID_reg_doc_checklist' => array(),'DataDocument' => array());
        for ($i=0; $i < count($DataDocument); $i++) { 
            $arr_temp['ID_reg_doc_checklist'][$i] = $DataDocument[$i]['ID'];
        }
        $arr_temp['DataDocument'] = $DataDocument;
        return $arr_temp;
    }

    public function getDataDokumentRegister($ID_register_formulir)
    {
        $sql = "select a.ID,a.ID_register_formulir,a.ID_reg_doc_checklist,a.Status,a.Attachment,b.DocumentChecklist,
                b.Required from db_admission.register_document as a
                join db_admission.reg_doc_checklist as b
                on b.ID = a.ID_reg_doc_checklist
                where b.Active = 1 and a.ID_register_formulir = ?
            ";
        $query=$this->db->query($sql, array($ID_register_formulir))->result_array();
        return $query;
    }

    public function getDataFormulirPDf()
    {
        $sql = "select a.ID_program_study,d.Name,a.Gender,a.IdentityCard,e.ctr_name as Nationality,f.Religion,concat(a.PlaceBirth,',',a.DateBirth) as PlaceDateBirth,g.JenisTempatTinggal,
            h.ctr_name as CountryAddress,i.ProvinceName as ProvinceAddress,j.RegionName as RegionAddress,k.DistrictName as DistrictsAddress,
            a.District as DistrictAddress,a.Address,a.ZipCode,a.PhoneNumber,d.Email,n.SchoolName,l.sct_name_id as SchoolType,m.SchoolMajor,e.ctr_name as SchoolCountry,
            n.ProvinceName as SchoolProvince,n.CityName as SchoolRegion,n.SchoolAddress,a.YearGraduate,IF(a.KPSReceiverStatus = 'YA',CONCAT('No KPS : ',a.NoKPS),'Tidak') as KPSReceiver,
            o.JacketSize,a.FatherName,a.FatherNIK,CONCAT(a.FatherPlaceBirth,',',a.FatherDateBirth) as FatherPlaceDateBirth,a.FatherStatus,a.FatherPhoneNumber,p.ocu_name as FatherOccupation,q.Income as FatherIncome,
            r.ctr_name as FatherCountry,s.ProvinceName as FatherProvince,t.RegionName as FatherRegion,a.FatherAddress,
            a.MotherName,a.MotherNik,CONCAT(a.MotherPlaceBirth,',',a.MotherDateBirth) as MotherPlaceDateBirth,a.MotherStatus,a.MotherPhoneNumber,u.ocu_name  as MotherOccupation,v.Income as MotherIncome,
            w.ctr_name as MotherCountry,x.ProvinceName as MotherProvince,y.RegionName as MotherRegion,a.MotherAddress,a.UploadFoto
                    from db_admission.register_formulir as a
                    JOIN db_admission.register_verified as b 
                    ON a.ID_register_verified = b.ID
                    JOIN db_admission.register_verification as c
                    ON b.RegVerificationID = c.ID
                    JOIN db_admission.register as d
                    ON c.RegisterID = d.ID
                    JOIN db_admission.country as e
                    ON a.NationalityID = e.ctr_code
                    JOIN db_employees.religion as f
                    ON a.ReligionID = f.IDReligion
                    JOIN db_admission.register_jtinggal_m as g
                    ON a.ID_register_jtinggal_m = g.ID
                    JOIN db_admission.country as h
                    ON a.ID_country_address = h.ctr_code
                    JOIN db_admission.province as i
                    ON a.ID_province = i.ProvinceID
                    JOIN db_admission.region as j
                    ON a.ID_region = j.RegionID
                    JOIN db_admission.district as k
                    ON a.ID_districts = k.DistrictID
                    JOIN db_admission.school_type as l
                    ON l.sct_code = a.ID_school_type
                    JOIN db_admission.register_major_school as m
                    ON m.ID = a.ID_register_major_school
                    JOIN db_admission.school as n
                    ON n.ID = d.SchoolID
                    JOIN db_admission.register_jacket_size_m as o
                    ON o.ID = a.ID_register_jacket_size_m
                    JOIN db_admission.occupation as p
                    ON p.ocu_code = a.Father_ID_occupation
                    JOIN db_admission.register_income_m as q
                    ON q.ID = a.Father_ID_register_income_m
                    JOIN db_admission.country as r
                    ON r.ctr_code = a.FatherAddress_ID_country
                    JOIN db_admission.province as s
                    ON s.ProvinceID = a.FatherAddress_ID_province
                    JOIN db_admission.region as t
                    ON t.RegionID = a.FatherAddress_ID_region
                    JOIN db_admission.occupation as u
                    ON u.ocu_code = a.Mother_ID_occupation
                    JOIN db_admission.register_income_m as v
                    ON v.ID = a.Mother_ID_register_income_m
                    JOIN db_admission.country as w
                    ON w.ctr_code = a.MotherAddress_ID_country
                    JOIN db_admission.province as x
                    ON x.ProvinceID = a.MotherAddress_ID_province
                    JOIN db_admission.region as y
                    ON y.RegionID = a.MotherAddress_ID_region
                    where a.ID = ?";
        $query=$this->db->query($sql, array($this->session->userdata('ID_register_formulir')))->result_array();
        $arr_temp = array();
        foreach ($query as $key => $value) {
            $arr_temp[] = $value;
        }
        //$arr_temp = $arr_temp[0];
        $values = array_values($arr_temp[0]);
        return $values;
    }

    public function saveDataUploadDokumen($ID,$filename)
    {
        $status = 'Progress Checking';
        $sql = "update db_admission.register_document set Status = ?,Attachment = ? where ID = ?";
        $query=$this->db->query($sql, array($status,$filename,$ID));
    }

    public function getNamaProgramStudy($ID_program_study)
    {
        $sql = "select * from db_academic.program_study where ID = ?";
        $query=$this->db->query($sql, array($ID_program_study))->result_array();
        return $query[0]['Name'];
    }

    public function getJadwalUjian()
    {
        $sql = 'select C.Name as prody,a.ID_ujian_perprody,DATE(a.DateTimeTest) as tanggal
                ,CONCAT((EXTRACT(HOUR FROM a.DateTimeTest)),":",(EXTRACT(MINUTE FROM a.DateTimeTest))) as jam,
                a.Lokasi,
                h.Name as NameCandidate,h.Email,i.SchoolName,f.FormulirCode,e.ID as ID_register_formulir
                from db_admission.register_jadwal_ujian as a 
                join db_admission.ujian_perprody_m as b
                on a.ID_ujian_perprody = b.ID
                join db_academic.program_study as c
                on c.ID = b.ID_ProgramStudy
                join db_admission.register_formulir_jadwal_ujian as d
                ON a.ID = d.ID_register_jadwal_ujian
                JOIN db_admission.register_formulir as e
                on e.ID = d.ID_register_formulir
                join db_admission.register_verified as f
                on e.ID_register_verified = f.ID
                join db_admission.register_verification as g
                on g.ID = f.RegVerificationID
                join db_admission.register as h
                on h.ID = g.RegisterID
                join db_admission.school as i
                on i.ID = h.SchoolID
                where e.ID = ?
                GROUP BY C.Name,DATE(a.DateTimeTest),e.ID';
        $query=$this->db->query($sql, array($this->session->userdata('ID_register_formulir')))->result_array();
        return $query;
    }

    public function getDataUjian()
    {
        $query = $this->caribasedprimary('db_admission.register_formulir','ID_register_verified',$this->session->userdata('ID_register_verified'));
        $ID_program_study = $query[0]['ID_program_study'];
        $sql = 'select a.ID,b.Name as NamaProgramStudy,a.NamaUjian,a.Bobot,a.Active,a.CreateAT from db_admission.ujian_perprody_m as a join db_academic.program_study as b on a.ID_ProgramStudy = b.ID where a.ID_ProgramStudy = ?';
        $query=$this->db->query($sql, array($ID_program_study))->result_array();
        return $query;
    }

}
