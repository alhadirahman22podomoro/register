<div id="sidebar" class="sidebar-fixed">
    <div id="sidebar-content">

        <!--=== Navigation ===-->

        <ul id="nav">



            <li class="">
                <a href="#">
                    <i class="fa fa-user-circle"></i>
                    Master Calon Mahasiswa
                </a>
            </li>
            <!--<li class="">
                <a href="#">
                    <i class="fa fa-money"></i>
                    Master Uang Daftar
                </a>
            </li>-->
            <li class="<?php if($this->uri->segment(2)=='master-sma'){echo "current open";} ?>">
                <a href="javascript:void(0);">
                    <i class="icon-edit"></i>
                    Master SMA
                </a>
                <ul class="sub-menu">
                    <li class="<?php if($this->uri->segment(2)=='master-sma' && $this->uri->segment(3) == null ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-sma'); ?>">
                        <i class="icon-angle-right"></i>
                        SMA / SMK
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-sma' && $this->uri->segment(3) == "integration" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-sma/integration'); ?>">
                        <i class="icon-angle-right"></i>
                        Integration
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php if($this->uri->segment(2)=='master-global'){echo "current open";} ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-globe"></i>
                    Master Global
                </a>
                <ul class="sub-menu">
                    <li class="<?php if($this->uri->segment(2)=='master-global' && $this->uri->segment(3) == "agama" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-global/agama'); ?>">
                        <i class="icon-angle-right"></i>
                        Agama
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-global' && $this->uri->segment(3) == "wilayah" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-global/wilayah'); ?>">
                        <i class="icon-angle-right"></i>
                        Wilayah
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-global' && $this->uri->segment(3) == "jenis-tempat-tinggal" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-global/jenis-tempat-tinggal'); ?>">
                        <i class="icon-angle-right"></i>
                        Jenis Tempat Tinggal
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-global' && $this->uri->segment(3) == "pendapatan" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-global/pendapatan'); ?>">
                        <i class="icon-angle-right"></i>
                        Pendapatan
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-global' && $this->uri->segment(3) == "tipe-sekolah" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-global/tipe-sekolah'); ?>">
                        <i class="icon-angle-right"></i>
                        Tipe Sekolah
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-global' && $this->uri->segment(3) == "jurusan-sekolah" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-global/jurusan-sekolah'); ?>">
                        <i class="icon-angle-right"></i>
                        Jurusan Sekolah
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php if($this->uri->segment(2)=='master-config'){echo "current open";} ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-address-book-o"></i>
                    Master Config
                </a>
                <ul class="sub-menu">
                    <li class="<?php if($this->uri->segment(2)=='master-config' && $this->uri->segment(3) == "set-email" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-config/set-email'); ?>">
                        <i class="icon-angle-right"></i>
                        Set Email
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-config' && $this->uri->segment(3) == "email-to" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-config/email-to'); ?>">
                        <i class="icon-angle-right"></i>
                        Set Email To
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-config' && $this->uri->segment(3) == "total-account" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-config/total-account'); ?>">
                        <i class="icon-angle-right"></i>
                        Total Account
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-config' && $this->uri->segment(3) == "lama-pembayaran" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-config/lama-pembayaran'); ?>">
                        <i class="icon-angle-right"></i>
                        Lama Pembayaran
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php if($this->uri->segment(2)=='master-registration'){echo "current open";} ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-address-book-o"></i>
                    Master Registration
                </a>
                <ul class="sub-menu">
                    <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "number-formulir" ){echo "open-default";} ?>">
                        <a href="javascript:void(0);">
                        <i class="icon-angle-right"></i>
                        Number Formulir
                        </a>
                        <ul class="sub-menu">
                            <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "number-formulir" && $this->uri->segment(4) == "online"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/master-registration/number-formulir/online'); ?>">
                                <i class="icon-angle-right"></i>
                                Online
                                </a>
                            </li>
                            <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "number-formulir" && $this->uri->segment(4) == "offline"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/master-registration/number-formulir/offline'); ?>">
                                <i class="icon-angle-right"></i>
                                Offline
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "ujian-masuk-per-prody" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-registration/ujian-masuk-per-prody'); ?>">
                        <i class="icon-angle-right"></i>
                        Ujian Masuk Per Prody
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "sales-koordinator-wilayah" ){echo "current";} ?>">
                        <a href="<?php echo base_url('#'); ?>">
                        <i class="icon-angle-right"></i>
                        Sales Koordinator Wilayah
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "sales-koordinator-kota" ){echo "current";} ?>">
                        <a href="<?php echo base_url('#'); ?>">
                        <i class="icon-angle-right"></i>
                        Sales Koordinator Kota
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "jacket-size" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-registration/jacket-size'); ?>">
                        <i class="icon-angle-right"></i>
                        Jacket Size
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "document-checklist" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-registration/document-checklist'); ?>">
                        <i class="icon-angle-right"></i>
                        Document Checklist
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "harga-formulir" ){echo "open-default";} ?>">
                        <a href="javascript:void(0);">
                        <i class="icon-angle-right"></i>
                        Harga Formulir
                        </a>
                        <ul class="sub-menu">
                            <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "harga-formulir" && $this->uri->segment(4) == "online"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/master-registration/harga-formulir/online'); ?>">
                                <i class="icon-angle-right"></i>
                                Online
                                </a>
                            </li>
                            <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "harga-formulir" && $this->uri->segment(4) == "offline"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/master-registration/harga-formulir/offline'); ?>">
                                <i class="icon-angle-right"></i>
                                Offline
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "biaya-kuliah" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/master-registration/biaya-kuliah'); ?>">
                        <i class="icon-angle-right"></i>
                        Biaya Kuliah
                        </a>
                    </li>
                     <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "program-beasiswa" ){echo "open-default";} ?>">
                        <a href="javascript:void(0);">
                        <i class="icon-angle-right"></i>
                        Program Beasiswa
                        </a>
                        <ul class="sub-menu">
                            <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "program-beasiswa" && $this->uri->segment(4) == "jalur-prestasi-akademik"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/master-registration/program-beasiswa/jalur-prestasi-akademik'); ?>">
                                <i class="icon-angle-right"></i>
                                Jalur Prestasi Akademik
                                </a>
                            </li>
                            <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "program-beasiswa" && $this->uri->segment(4) == "jalur-prestasi-akademik-umum"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/master-registration/program-beasiswa/jalur-prestasi-akademik-umum'); ?>">
                                <i class="icon-angle-right"></i>
                                Jalur Prestasi Akademik Umum
                                </a>
                            </li>
                            <li class="<?php if($this->uri->segment(2)=='master-registration' && $this->uri->segment(3) == "program-beasiswa" && $this->uri->segment(4) == "jalur-prestasi-bidang-or-seni"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/master-registration/program-beasiswa/jalur-prestasi-bidang-or-seni'); ?>">
                                <i class="icon-angle-right"></i>
                                Jalur Prestasi Olah Raga dan Kesenian
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="<?php if($this->uri->segment(2)=='distribusi-formulir'){echo "current open";} ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-list-alt"></i>
                    Distribusi Formulir
                </a>
                <ul class="sub-menu">
                    <li class="<?php if($this->uri->segment(2)=='distribusi-formulir' && $this->uri->segment(3) == "formulir-online" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/distribusi-formulir/formulir-online'); ?>">
                        <i class="icon-angle-right"></i>
                        Formulir Online
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='distribusi-formulir' && $this->uri->segment(3) == "formulir-offline" ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/distribusi-formulir/formulir-offline'); ?>">
                        <i class="icon-angle-right"></i>
                        Formulir Offline
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa'){echo "current open";} ?>">
                <a href="#">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Proses Calon Mahasiswa
                </a>
                <ul class="sub-menu">
                    <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa' && $this->uri->segment(3) == 'jadwal-ujian' ){echo "open-default";} ?>">
                        <a href="javascript:void(0);">
                        <!-- <a href="<?php echo base_url('admission/proses-calon-mahasiswa/set-jadwal-ujian'); ?>"> <i class="icon-angle-right"></i> -->
                        <i class="icon-angle-right"></i>
                        Jadwal Ujian
                        </a>
                        <ul class="sub-menu">
                            <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa' && $this->uri->segment(3) == "jadwal-ujian" && $this->uri->segment(4) == "set-jadwal-ujian"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/proses-calon-mahasiswa/jadwal-ujian/set-jadwal-ujian'); ?>">
                                <i class="icon-angle-right"></i>
                                Set Jadwal Ujian
                                </a>
                            </li>
                            <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa' && $this->uri->segment(3) == "jadwal-ujian" && $this->uri->segment(4) == "daftar-jadwal-ujian"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/proses-calon-mahasiswa/jadwal-ujian/daftar-jadwal-ujian'); ?>">
                                <i class="icon-angle-right"></i>
                                Daftar Jadwal Ujian Calon Mahasiswa
                                </a>
                            </li>
                            <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa' && $this->uri->segment(3) == "jadwal-ujian" && $this->uri->segment(4) == "set-nilai-ujian"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/proses-calon-mahasiswa/jadwal-ujian/set-nilai-ujian'); ?>">
                                <i class="icon-angle-right"></i>
                                Set Nilai Ujian
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa' && $this->uri->segment(3) == 'verifikasi-dokumen' ){echo "current";} ?>">
                        <a href="<?php echo base_url('admission/proses-calon-mahasiswa/verifikasi-dokumen'); ?>">
                        <i class="icon-angle-right"></i>
                        Verifikasi Dokumen
                        </a>
                    </li>
                    <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa' && $this->uri->segment(3) == "check-calon-mahasiswa" ){echo "open-default";} ?>">
                        <a href="javascript:void(0);">
                        <i class="icon-angle-right"></i>
                        Check Calon Mahasiswa
                        </a>
                        <ul class="sub-menu">
                            <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa' && $this->uri->segment(3) == "check-calon-mahasiswa" && $this->uri->segment(4) == "tidak-melakukan-pembayaran"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/proses-calon-mahasiswa/check-calon-mahasiswa/tidak-melakukan-pembayaran'); ?>">
                                <i class="icon-angle-right"></i>
                                Tidak Melakukan Pembayaran
                                </a>
                            </li>
                            <li class="<?php if($this->uri->segment(2)=='proses-calon-mahasiswa' && $this->uri->segment(3) == "check-calon-mahasiswa" && $this->uri->segment(4) == "tidak-melakukan-pembayaran"){echo "current";} ?>">
                                <a href="<?php echo base_url('admission/proses-calon-mahasiswa/check-calon-mahasiswa/tidak-melakukan-pembayaran'); ?>">
                                <i class="icon-angle-right"></i>
                                Bukti Upload Rejected
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="#">
                  <i class="fa fa-exchange" aria-hidden="true"></i>
                    Koreksi Calon Mahasiswa
                </a>
            </li>
        </ul>
        <div class="sidebar-widget align-center">
            <div class="btn-group" data-toggle="buttons" id="theme-switcher">
                <label class="btn active">
                    <input type="radio" name="theme-switcher" data-theme="bright"><i class="fa fa-sun-o"></i> Bright
                </label>
                <label class="btn">
                    <input type="radio" name="theme-switcher" data-theme="dark"><i class="fa fa-moon-o"></i> Dark
                </label>
            </div>
        </div>

    </div>
    <div id="divider" class="resizeable"></div>
</div>
<!-- /Sidebar -->
