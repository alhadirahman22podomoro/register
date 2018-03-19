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
                and a.ID not in (select a.RegisterID from db_admission.register_verification as a)";
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
        $dataSave = array(
                'RegisterID' => $this->session->userdata('register_id'),
                'FileUpload' => $filename,
                'CreateAT' => date("Y-m-d"),
                        );

        $this->db->insert('db_admission.register_verification', $dataSave);
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
}
