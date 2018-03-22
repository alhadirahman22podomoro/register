<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_api extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function saveDataWilayah($arr)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600); //600 seconds = 10 minutes
        $data = $arr['data'];
        $arr_temp = array();
        $sql ="select RegionID from db_admission.region";
        $query=$this->db->query($sql, array())->result();
        foreach ($query as $key) {
            $arr_temp[] =  $key->RegionID;
        }

        $kode_wilayah_arr = array();
        for ($i=0; $i < count($data); $i++) {
            // find data in array
            $kode_wilayah = $data[$i]['kode_wilayah'];
            $kode_wilayah_arr[] = $kode_wilayah;
            if (!in_array($kode_wilayah, $arr_temp)) {
                $dataSave = array(
                        'RegionID' => $data[$i]['kode_wilayah'],
                        'RegionName' => $data[$i]['nama'],
                        'RegionCodeMst' => $data[$i]['mst_kode_wilayah']
                );

                $this->db->insert('db_admission.region', $dataSave);
            }
            
        }

        return $kode_wilayah_arr;
    }

    public function saveDataSchool($arr)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600); //600 seconds = 10 minutes
        $data = $arr['data'];
        $arr_temp = array();
        $sql ="select SchoolID from db_admission.school";
        $query=$this->db->query($sql, array())->result();
        foreach ($query as $key) {
            $arr_temp[] =  $key->SchoolID;
        }

        $kode_school_arr = array();
        for ($i=0; $i < count($data); $i++) {
            // find data in array
            $kode_school = $data[$i]['id'];
            $kode_school_arr[] = $kode_school;
            if (!in_array($kode_school, $arr_temp)) {
                $dataSave = array(
                        'ProvinceID' => $data[$i]['kode_prop'],
                        'ProvinceName' => $data[$i]['propinsi'],
                        'CityID' => $data[$i]['kode_kab_kota'],
                        'CityName' => $data[$i]['kabupaten_kota'],
                        'DistrictID' => $data[$i]['kode_kec'],
                        'DistrictName' => $data[$i]['kecamatan'],
                        'SchoolID' => $data[$i]['id'],
                        'npsn' => $data[$i]['npsn'],
                        'SchoolName' => $data[$i]['sekolah'],
                        'SchoolType' => $data[$i]['bentuk'],
                        'Status' => $data[$i]['status'],
                        'SchoolAddress' => $data[$i]['alamat_jalan'],
                        'Latitude' => $data[$i]['lintang'],
                        'Longitude' => $data[$i]['bujur'],
                );

                $this->db->insert('db_admission.school', $dataSave);
            }
            
        }

        //return $kode_school_arr;
        return "Done";
    }

    public function getdataWilayah()
    {
        $sql = "select * from db_admission.region";
        $query=$this->db->query($sql, array())->result_array();
        return $query;
    }

    public function __getSMAWilayah($kode_wilayah)
    {
        $sql = "select * from db_admission.school as a where a.CityID = ? ";
        $query=$this->db->query($sql, array($kode_wilayah))->result_array();
        return $query;
    }

    public function sendEmail($to,$subject,$text = array(null,null))
    {   
        $arr = array(
            'status' => 1,
            'msg'=>''
            );
        $config_email = $this->loadEmailConfig();
        $getDeadline = $this->getDeadline();
        $max_execution_time = 630;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', $max_execution_time); //60 seconds = 1 minutes

        $url = base_url().'register/formupload/'.$text[0];
        $this->load->library('email', $config_email['setting']);
        $msg = '<div style="margin:0;padding:10px 0;background-color:#ebebeb;font-size:14px;line-height:20px;font-family:Helvetica,sans-serif;width:100%;text-align:center">
                <div class="adM">
                <br>
                </div>
                <table style="width:600px;margin:0 auto;background-color:#ebebeb" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                <td></td>
                <td style="background-color:#fff;padding:0 30px;color:#333;vertical-align:top">
                <br>';
        $SHeader = '<div style="font-family:Proxima Nova Semi-bold,Helvetica,sans-serif;font-weight:bold;font-size:24px;line-height:24px;color:#2196f3">';
        $EHeader = '</div>';
        $msg .= $config_email['text'];
        $msg .= '<br><br><br>
                <p style="color:#EB6936;"><i>*) Do not reply, this email is sent automatically</i> </p>

                </div>

                </td>
                <td></td>
                </tr>
                <tr>
                <td colspan="3">
                <div style="background-color:#fff;border-top:1px solid #ddd; ">';
        $payment = "Rp. ".number_format($text[1],2,",",".");
        $msg = str_replace('[#payment]', $payment, $msg);
        $deadline = $getDeadline;
        $msg = str_replace('[#deadline]', $deadline, $msg);
        $msg = str_replace('[#url]', $url, $msg);
        $msg = str_replace("[#styleheader1]", $SHeader, $msg);
        $msg = str_replace("[#styleheader2]", $EHeader, $msg);


        $this->email->set_newline("\r\n");
        $this->email->from('it@podomorouniversity.ac.id','IT Podomoro');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($msg);
        //var_dump($this->email->send());
        if($this->email->send())
        {
          $arr['status'] = 1;
          $arr['msg'] = "Email Send";
        }
        else
        {
            $arr['status'] = 0;
            $arr['msg'] = $this->email->print_debugger();
        }
        return $arr;
    }

    public function loadEmailConfig()
    {
        $config_email_db = $this->config_email_db();
        return $config_email_db;
    }

    public function config_email_db()
    {
        $sql = "select * from db_admission.email_set as a limit 1";
        $query=$this->db->query($sql, array())->result_array();
        $config = array('setting' => array(
                                    'protocol' => 'smtp',
                                    'smtp_host' => $query[0]['smtp_host'],
                                    'smtp_port' => $query[0]['smtp_port'],
                                    'smtp_user' => $query[0]['email'], 
                                    'smtp_pass' => $query[0]['pass'],
                                    'mailtype' => 'html',
                                    'charset' => 'iso-8859-1',
                                    'wordwrap' => TRUE
                        ),
                        'text' => $query[0]['text'],
          
        );
        return $config;
    }

    public function getDeadline()
    {
        $date = date("Y-m-d");
        $this->load->model('register/M_register','m_reg',TRUE);
        $longtime = $this->m_reg->Longtime();
        $getDeadline = date('Y-m-d', strtotime($date. ' + '.$longtime.' days'));
        $getDeadline = $this->passHariLibur($getDeadline);
        return $getDeadline;

    }

    public function passHariLibur($date)
    {
        // check hari libur,
        // jika hari libur sabtu expirednya hingga hari senin malam
        // jika hari liburnya minggu expirednya hingga hari selasa malam
        $day = $this->checkhari($date);
        $add = 2;
        switch ($day) {
            case "Saturday":
            case "Sunday":
                $date = date('Y-m-d', strtotime($date. ' + '.$add.' days'));
                break;
            default:
                $date = $date;
        }
        $date = date('F j, Y',strtotime($date));
        return $date;
    }

    public function checkhari($date)
    {
        $day = date('l', strtotime($date));
        return $day; 
    }

    public function dateDiffInteger($start, $end) {

        $start_ts = strtotime($start);

        $end_ts = strtotime($end);

        $diff = $end_ts - $start_ts;

        return round($diff / 86400);

    }

    public function getProgramStudy()
    {
        $sql = "select * from db_academic.program_study where status = 1";
        $query=$this->db->query($sql, array())->result_array();
        return $query;
    }

    public function getCountry()
    {
        $sql = "select * from db_admission.country where ctr_active = 1";
        $query=$this->db->query($sql, array())->result_array();
        return $query;
    }

    public function getAgama()
    {
        $sql = "select * from db_employees.religion";
        $query=$this->db->query($sql, array())->result_array();
        return $query;
    }

    public function getJenisTempatTinggal()
    {
        $sql = "select * from db_admission.register_jtinggal_m";
        $query=$this->db->query($sql, array())->result_array();
        return $query;
    }

    public function getProvinsi()
    {
        $sql = "select * from db_admission.province";
        $query=$this->db->query($sql, array())->result_array();
        return $query;
    }

    public function getRegion($selectProvinsi)
    {
        $sql = "select a.RegionID,b.RegionName from db_admission.province_region as a, db_admission.region as b
where a.RegionID = b.RegionID and a.ProvinceID = ?";
        $query=$this->db->query($sql, array($selectProvinsi))->result_array();
        return $query;
    }

    public function getKecamatan($selectRegion)
    {
        $sql = "select a.DistrictID,b.DistrictName from db_admission.region_district as a, db_admission.district as b
where a.DistrictID = b.DistrictID and a.RegionID = ?";
        $query=$this->db->query($sql, array($selectRegion))->result_array();
        return $query;
    }


}
