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

    public function saveToDBRegister($name,$Email,$SchoolName,$priceFormulir,$password)
    {
        $dataSave = array(
                'Name' => $name,
                'Email' => $Email,
                'Password' => $password,
                'SchoolID' => $SchoolName,
                'PriceFormulir' => $priceFormulir,
                'RegisterAT' => date("Y-m-d"),
                        );

        $this->db->insert('db_admission.register', $dataSave);
    }

    public function getDeadline()
    {
        $sql = "select Longtime from db_admission.deadline_register as a where a.active = 1 order by a.CreateAT desc limit 1";
        $query=$this->db->query($sql, array())->result_array();
        return $query[0]['Longtime'];
    }
}
