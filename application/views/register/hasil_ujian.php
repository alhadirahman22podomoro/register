<script type="text/javascript" src="<?php echo base_url();?>assets/datepicker/bootstrap-datepicker.js"></script>
<link href="<?php echo base_url();?>assets/datepicker/datepicker.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
    .pageContain{
        border-style: solid;
        border-color: red;
    }
    .row {
        margin-right: 10px;
        margin-left: 10px;
    }
    body
    {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #555555;
        font-size: 13px;
    }
    .judul
    {
        text-align: center;
        font-weight: bold;
        text-decoration: underline;
        font-size: 20px;
    }
    .panel-heading div {
                margin-top: -18px;
                font-size: 15px;
            }
            .panel-heading div span{
                margin-left:5px;
            }
            .panel-body{
                /*display: none;*/
            }
    .form-horizontal .control-label {
        text-align: left;
    }
    .required{
        color: #c3222d;
    }

    #foto{
        height: 114px;
    }

    .ng-button { background:green; color: white; text-decoration:none; padding:6px;
                transition:1s; height: 25px; box-shadow: 1px 1px 1px 1px black; border: 1px solid black;
                border-radius: 20px;
    }
    .ng-button:hover { 
        background:black; color:white; text-decoration:none; border:1px solid;
        border-radius: 0px;
    }
    #toast-container>.toast-error {
        width: 500px;
    }

    .dropdown-menu {
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
        -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.07);
        -moz-box-shadow: 0 2px 5px rgba(0, 0, 0, 0.07);
        box-shadow: 0 2px 11px #04c;
        font-size: 13px;
        text-align: left;
        background-color: #ffffff;
    }
    #isi{
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 10px;
    }
       
</style>
<div class="container">
    <header>
        <!--<h1>Formulir Registration</h1>-->
    </header>
    <section>       
        <div id="container_demo" >
            <div id="wrapper" style="width: 90%;">
                <div id="login" class="animate form">
                    <?php $this->load->view('template_backend/crumbs') ?>
                    <div class = "pageContain">
                        <div id = 'isi'>
                            <?php if (count($datadb) > 0 ): ?>
                                <div id = "tblData1" class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-checkable tableData">
                                        <caption><strong>Jadwal Ujian</strong></caption>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Sekolah</th>
                                                <th>Formulir Code</th>
                                                <th>Prody</th>
                                                <th>Tanggal</th>
                                                <th>Jam</th>
                                                <th>Lokasi</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <?php for ($i = 0; $i < count($datadb); $i++): ?>
                                             <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $datadb[$i]['NameCandidate'] ?></td>
                                                <td><?php echo $datadb[$i]['Email'] ?></td>
                                                <td><?php echo $datadb[$i]['SchoolName'] ?></td>
                                                <td><?php echo $datadb[$i]['FormulirCode'] ?></td>
                                                <td><?php echo $datadb[$i]['prody'] ?></td>
                                                <td><?php echo $datadb[$i]['tanggal'] ?></td>
                                                <td><?php echo $datadb[$i]['jam'] ?></td>
                                                <td><?php echo $datadb[$i]['Lokasi'] ?></td>
                                             </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id = "tblData2" class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-checkable tableData">
                                        <caption><strong><?php echo $dataujian[0]['NamaProgramStudy'] ?></strong></caption>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Ujian</th>
                                                <th>Bobot</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php $jml_bobot = 0 ?> 
                                            <?php $Nilai_bobot = 0 ?> 
                                            <?php $Indeks_Nilai = '' ?> 
                                            <?php for ($i = 0; $i < count($hasil_ujian); $i++): ?>
                                             <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $hasil_ujian[$i]['NamaUjian'] ?></td>
                                                <td><?php echo $hasil_ujian[$i]['Bobot'] ?></td>
                                                <td><?php echo $hasil_ujian[$i]['Value'] ?></td>
                                             </tr>
                                             <?php $jml_bobot = $jml_bobot + $hasil_ujian[$i]['Bobot'] ?>
                                             <?php $Nilai_bobot = $Nilai_bobot + ( ($hasil_ujian[$i]['Value'] * $hasil_ujian[$i]['Bobot']) ) ?>
                                            <?php endfor; ?>
                                            <?php $nilai = $Nilai_bobot / $jml_bobot; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <p><?php echo 'Jumlah Bobot : '.$jml_bobot ?></p>
                                    <p><?php echo 'Nilai * Bobot : '.$Nilai_bobot ?></p>
                                    <p><?php echo 'Nilai Akhir : '.number_format((float)$nilai, 2, '.', '') ?></p>
                                    <p><?php echo 'Status : '.$kelulusan[0]['Kelulusan'] ?></p>
                                </div>          
                            <?php else: ?>
                            <div align = 'center'>No Result Data...</div>       
                            <?php endif ?>
                        </div>
                    </div><!-- exit contain -->
                </div>
            </div>
        </div>  
    </section>
</div>
