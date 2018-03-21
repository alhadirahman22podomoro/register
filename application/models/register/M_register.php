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
        $sql = "select a.PriceFormulir from db_admission.register as a";
        $query=$this->db->query($sql, array())->result();
        foreach ($query as $key) {
            $arr_temp[] = $key->PriceFormulir;
        }
        return $arr_temp;
    }

    public function saveToDBRegister($name,$Email,$SchoolName,$priceFormulir,$momenUnix)
    {
        $dataSave = array(
                'Name' => $name,
                'Email' => $Email,
                'MomenUnix' => $momenUnix,
                'SchoolID' => $SchoolName,
                'PriceFormulir' => $priceFormulir,
                'RegisterAT' => date("Y-m-d"),
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
            $this->session->set_userdata('SchoolID',$query[0]['Email']);
            $this->session->set_userdata('SchoolName',$query[0]['Email']);
            $this->session->set_userdata('FormulirCode',$query[0]['FormulirCode']);
            return true;
        }
        else
        {
            return false;
        }    
    }  
}
