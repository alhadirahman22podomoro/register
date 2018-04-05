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
</style>
<div class="container">
    <header>
        <!--<h1>Formulir Registration</h1>-->
    </header>
    <section>       
        <div id="container_demo" >
            <div id="wrapper" style="width: 90%;">
                <div id="login" class="animate form">
                	<div class = "pageContain">
    					<div class="row">
						    <div class="col-xs-6 col-md-4">
						      <img src="<?php echo base_url('images/logo_tr.png'); ?>" alt="Podomoro University" style="max-width: 40%;"/>
						    </div>
						    <div class="col-xs-6 col-md-4">
						      
						    </div>
						    <div class="col-xs-6 col-md-4">
								<b>Formulir Number / Nomor Formulir : <?php echo $this->session->userdata('FormulirCode') ?></b>					    	
						    </div>
    					</div>
    					<div class="row">
						   <div class= "judul">New Student Registration Form / Formulir Pendaftaran Mahasiswa Baru</div>
    					</div>
    					<br>
    					<div class = row>
    						<div class="panel panel-primary">
								<div class="panel-heading" style="border-radius: 0px;">
									<h3 class="panel-title">Study Program / Program Studi <span class="required">*</span></h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
									    <div id="program_study">
									    </div>
									</div>
								</div>
							</div>
    					</div>
    					<div class = row>
    						<div class="panel panel-primary">
								<div class="panel-heading" style="border-radius: 0px;">
									<h3 class="panel-title">Part 1 Data of Prospective Students / Bagian 1 Data Calon Mahasiswa</h3>
								</div>
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
										    <label class="col-lg-3 control-label">Full Name / Nama Lengkap </label>
										    <div class="col-md-6">
										      <input type="text" name="weight" placeholder="Input Full Name..." id = "FullName" value = "<?php echo $this->session->userdata('Name') ?>">
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Gender / Jenis Kelamin <span class="required">*</span></label>
										    <div class="col-md-8">
										      	<label class="radio-inline">
								              		<input type="radio" name="radioGender" value = "L" class = "gender"> Male / Pria
								            	</label>
								            	<label class="radio-inline">
								              		<input type="radio" name="radioGender" value = "P" class = "gender"> Female / Wanita
								            	</label>
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Identity Card / NIK <span class="required">*</span></label>
										    <div class="col-md-3">
										      <input type="text" name="weight" placeholder="Input Identity Card..." id = "IdentityCard" maxlength="16">
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Nationality / Kewarganegaraan <span class="required">*</span></label>
										    <div class="col-md-2">
										        <label class="checkbox-inline">
										             <input type="checkbox" class = "Nationality" name="radioNationality" id = "NationalityWNI" value = "WNI"> WNI
										        </label>
										        <label class="checkbox-inline">
										             <input type="checkbox" class = "Nationality" name="radioNationality" id = "NationalityWNA" value = "WNA"> WNA
										        </label>
										    </div>
										    <div class="help-block" id ="pageSelectCountry"> 

										    </div>
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Religion / Agama <span class="required">*</span></label>
										    <div class="col-md-6" id = Agama>
										      
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Place and Date of Birth / Tempat dan Tanggal Lahir <span class="required">*</span></label>
										    <div class="col-md-2">
										    	
										      <input type="text" name="weight" placeholder="Input Place of Birth..." id = "TempatLahir" >
										    </div>
										    <div class="col-md-2">
										    	  Years
										    	  <select class="select2-select-00 col-md-12 full-width-fix tahun_lahir" id="Tahun_lahir">
										    	    <option></option>
										    	  </select>
										    </div>
										    <div class="col-md-2">
										    	  Month
										    	  <select class="select2-select-00 col-md-12 full-width-fix bulan_lahir" id="Bulan_lahir">
										    	    <option></option>
										    	  </select>
										    </div>
										    <div class="col-md-2">
										    	  Days
										    	  <select class="select2-select-00 col-md-12 full-width-fix dd_lahir" id="DD_lahir">
										    	    <option></option>
										    	  </select>
										    </div>
										    
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Type of Residence / Jenis Tempat Tinggal <span class="required">*</span></label>
										    <div class="col-md-6" id = JenisTempatTinggal>
										      
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="panel panel-primary">
											<div class="panel-heading" style="border-radius: 0px;">
												<h3 class="panel-title">Your Address / Alamat Anda</h3>
											</div>
											<div class="panel-body">
												<div class="form-group">
												    <label class="col-lg-3 control-label">Country / Negara</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectNegara">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Province / Provinsi <span class="required">*</span></label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectProvinsi">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Region / Kota dan Kabupaten <span class="required">*</span></label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectRegion">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Districts / Kecamatan <span class="required">*</span></label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectKecamatan">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">District / Kelurahan <span class="required">*</span></label>
												    <div class="col-md-6">
												      <input type="text" name="weight" placeholder="Input District..." id = "Kelurahan">
												    </div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Address / Alamat <span class="required">*</span></label>
												    <div class="col-md-8">
														<textarea rows="3" cols="5" name="textarea" class="limited form-control" data-limit="150" maxlength="150" id = "Alamat"></textarea>
														<span id="chars">150</span> characters remaining
												    </div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Pos Code / Kode Pos</label>
												    <div class="col-md-3">
												      <input type="text" name="weight" placeholder="Input Pos Code..." id = "KodePos">
												    </div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
											</div><!-- exit panel body -->
										</div><!-- exit panel primary -->
										<div class="form-group">
										    <label class="col-lg-3 control-label">Phone Number / No Hp <span class="required">*</span></label>
										    	<div class="col-md-3">
										    	  <input type="text" name="weight" placeholder="Input Phone Number..." id = "noHP">
										    	</div>
										    <div class="help-block"> ex : +6281111111442</div> 
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Email</label>
										    	<div class="col-md-6">
										    	  <input type="text" name="weight" placeholder="Input Email..." id = "Email" value = "<?php echo $this->session->userdata('Email') ?>">
										    	</div>
										</div>
										<div class="panel panel-primary">
											<div class="panel-heading" style="border-radius: 0px;">
												<h3 class="panel-title">Your School / Sekolah Anda</h3>
											</div>
											<div class="panel-body">
												<?php if ($this->uri->segment(1) == 'formulir-registration-offline'): ?>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Select Region</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectWilayah">
												    	    <option></option>
												    	  </select>
												    	</div>
												</div>
												<?php endif ?>
												<div class="form-group">
												    <label class="col-lg-3 control-label">School / Sekolah</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectSchool">
												    	    <option value ="<?php echo $this->session->userdata('SchoolID') ?>" selected = "selected"><?php echo $this->session->userdata('SchoolName') ?></option>
												    	  </select>
												    	</div>
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">School Type / Tipe Sekolah <span class="required">*</span></label>
												    <div class="col-md-6" id = TipeSekolah>
												      
												    </div>	
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">School Major / Jurusan Sekolah <span class="required">*</span></label>
												    <div class="col-md-6" id = SchoolMajor>
												      
												    </div>	
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Country / Negara</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectNegaraSchool">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Province / Provinsi</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectProvinsiSchool">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Region / Kota dan Kabupaten</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectRegionSchool">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Address / Alamat</label>
												    <div class="col-md-8">
														<textarea rows="3" cols="5" name="textarea" class="limited form-control" id = "AlamatSchool"></textarea>
												    </div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Graduation Year / Tahun Lulus <span class="required">*</span></label>
												    <div class="col-md-3">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectTahunLulus">
												    	    <option></option>
												    	  </select>
												    </div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
											</div>
										</div><!-- exit div panel primary -->
										<div class="form-group">
										    <label class="col-lg-3 control-label">Receiver KPS / Penerima KPS <span class="required">*</span></label>
										    <div class="col-md-3" id ="pagePenerimaKPS">
										    	  
										    </div>
										    <div class="hide" id ="pageInputNOkPS"> 
										    	<div class="col-md-4">
										    		<input type="text" name="weight" placeholder="Input KPS Number..." id = "NoKPS">
										    	</div>
										    </div>
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Jacket Size / Ukuran Jacket <span class="required">*</span></label>
										    <div class="col-md-6" id = UkuranJacket>
										      
										    </div>	
										</div>
									</div>
								</div>
							</div><!-- exit panel primary -->
    					</div><!-- exit row -->
    					<div class = "row">
    						<div class="panel panel-primary">
								<div class="panel-heading" style="border-radius: 0px;">
									<h3 class="panel-title">Part 2 Data of Your Parent / Bagian 2 Data Orang Tua atau Wali</h3>
								</div>
								<div class="panel-body">
									<div class = "panel panel-primary">
										<div class = "panel-heading" style="border-radius: 0px;">
											<h3 class="panel-title">Father's Data / Data Ayah</h3>
										</div>
										<div class = "panel-body">
											<div class="form-horizontal">
												<div class = "form-group">
													<label class = "col-lg-3 control-label">Name / Nama <span class="required">*</span></label>
													<div class = "col-md-6">
														<input type="text" name="" placeholder="Input Name..." id = "NamaAyah">
													</div>
												</div>
												<div class = "form-group">
													<label class = "col-lg-3 control-label">Identity Card / NIK <span class="required">*</span></label>
													<div class = "col-md-3">
														<input type="text" name="" placeholder="Input Identity Card..." id = "NikAyah">
													</div>
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Place and Date of Birth / Tempat dan Tanggal Lahir <span class="required">*</span></label>
												    <div class="col-md-2">
												      <input type="text" name="weight" placeholder="Input Place of Birth..." id = "TempatLahirAyah" >
												    </div>
												    <div class="col-md-2">
												    	  Years
												    	  <select class="select2-select-00 col-md-12 full-width-fix tahun_lahir" id="Tahun_lahirAyah">
												    	    <option></option>
												    	  </select>
												    </div>
												    <div class="col-md-2">
												    	  Month
												    	  <select class="select2-select-00 col-md-12 full-width-fix bulan_lahir" id="Bulan_lahirAyah">
												    	    <option></option>
												    	  </select>
												    </div>
												    <div class="col-md-2">
												    	  Days
												    	  <select class="select2-select-00 col-md-12 full-width-fix dd_lahir" id="DD_lahirAyah">
												    	    <option></option>
												    	  </select>
												    </div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Status <span class="required">*</span></label>
													<div class="col-md-6">
												        <label class="checkbox-inline">
												             <input class="statusAyah" name="statusAyah" id="HidupAyah" type="checkbox" value = "Alive">Still Alive / Masih Hidup
												        </label>
												        <label class="checkbox-inline">
												             <input class="statusAyah" name="statusAyah" id="MeninggalAyah" type="checkbox" value = "Died"> Died / Meninggal
												        </label>
												    </div>
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Phone Number / No Hp <span class="required">*</span></label>
												    	<div class="col-md-3">
												    	  <input type="text" name="weight" placeholder="Input Phone Number..." id = "noHPAyah">
												    	</div>
												    <div class="help-block"> ex : +6281111111442</div> 
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Occupation / Pekerjaan <span class="required">*</span></label>
													<div class="col-md-6" id = "pagePekerjaanAyah">
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Income / Penghasilan <span class="required">*</span></label>
													<div class="col-md-6" id ="pagePenghasilanAyah">
														
													</div>
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Whether the address is the same as your address ? / Apakah alamat ini sama dengan alamat anda ? <span class="required">*</span></label>
												    <div class="col-md-12">
												      	<label class="radio-inline">
										              		<input type="radio" name="radioAlamatAyah" value = "Ya" id = "AlamatAyahSama" class = "radioAlamatAyah"> Yes
										            	</label>
										            	<label class="radio-inline">
    									              		<input type="radio" name="radioAlamatAyah" value = "Tidak" id = "AlamatAyahTdkSama" class = "radioAlamatAyah"> No
    									            	</label>
        										    </div>
												</div>
												<div id ="AlamatAyah" class = "hide">
													<div class="form-group">
													    <label class="col-lg-3 control-label">Country / Negara</label>
													    	<div class="col-md-6">
													    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectNegaraAyah">
													    	    <option></option>
													    	  </select>
													    	</div>
													    <!--<div class="help-block"> grams</div>-->  
													</div>
													<div class="form-group">
													    <label class="col-lg-3 control-label">Province / Provinsi <span class="required">*</span></label>
													    	<div class="col-md-6">
													    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectProvinsiAyah">
													    	    <option></option>
													    	  </select>
													    	</div>
													    <!--<div class="help-block"> grams</div>-->  
													</div>
													<div class="form-group">
													    <label class="col-lg-3 control-label">Region / Kota dan Kabupaten <span class="required">*</span></label>
													    	<div class="col-md-6">
													    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectRegionAyah">
													    	    <option></option>
													    	  </select>
													    	</div>
													    <!--<div class="help-block"> grams</div>-->  
													</div>
													<div class="form-group">
													    <label class="col-lg-3 control-label">Address / Alamat <span class="required">*</span></label>
													    <div class="col-md-8">
															<textarea rows="3" cols="5" name="textarea" class="limited form-control" data-limit="150" maxlength="150" id = "AlamatAyahtextarea"></textarea>
															<span id="charsAyah">150</span> characters remaining
													    </div>
													    <!--<div class="help-block"> grams</div>-->  
													</div>
												</div>
											</div>
										</div><!-- exit panel body -->
									</div><!-- exit panel primary -->
									<div class = "panel panel-primary">
										<div class = "panel-heading" style="border-radius: 0px;">
											<h3 class="panel-title">Mother's Data / Data Ibu</h3>
										</div>
										<div class = "panel-body">
											<div class="form-horizontal">
												<div class = "form-group">
													<label class = "col-lg-3 control-label">Name / Nama <span class="required">*</span></label>
													<div class = "col-md-6">
														<input type="text" name="" placeholder="Input Name..." id = "NamaIbu">
													</div>
												</div>
												<div class = "form-group">
													<label class = "col-lg-3 control-label">Identity Card / NIK <span class="required">*</span></label>
													<div class = "col-md-3">
														<input type="text" name="" placeholder="Input Identity Card..." id = "NikIbu">
													</div>
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Place and Date of Birth / Tempat dan Tanggal Lahir <span class="required">*</span></label>
												    <div class="col-md-2">
												      <input type="text" name="weight" placeholder="Input Place of Birth..." id = "TempatLahirIbu" >
												    </div>
												    <div class="col-md-2">
												    	  Years
												    	  <select class="select2-select-00 col-md-12 full-width-fix tahun_lahir" id="Tahun_lahirIbu">
												    	    <option></option>
												    	  </select>
												    </div>
												    <div class="col-md-2">
												    	  Month
												    	  <select class="select2-select-00 col-md-12 full-width-fix bulan_lahir" id="Bulan_lahirIbu">
												    	    <option></option>
												    	  </select>
												    </div>
												    <div class="col-md-2">
												    	  Days
												    	  <select class="select2-select-00 col-md-12 full-width-fix dd_lahir" id="DD_lahirIbu">
												    	    <option></option>
												    	  </select>
												    </div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Status <span class="required">*</span></label>
													<div class="col-md-6">
												        <label class="checkbox-inline">
												             <input class="statusIbu" name="statusIbu" id="HidupIbu" type="checkbox" value ="Alive">Still Alive / Masih Hidup
												        </label>
												        <label class="checkbox-inline">
												             <input class="statusIbu" name="statusIbu" id="MeninggalIbu" type="checkbox" value = "Died"> Died / Meninggal
												        </label>
												    </div>
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Phone Number / No Hp <span class="required">*</span></label>
												    	<div class="col-md-3">
												    	  <input type="text" name="weight" placeholder="Input Phone Number..." id = "noHPIbu">
												    	</div>
												    <div class="help-block"> ex : +6281111111442</div> 
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Occupation / Pekerjaan <span class="required">*</span></label>
													<div class="col-md-6" id = "pagePekerjaanIbu">
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-lg-3 control-label">Income / Penghasilan <span class="required">*</span></label>
													<div class="col-md-6" id ="pagePenghasilanIbu">
														
													</div>
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Whether the address is the same as your address ? / Apakah alamat ini sama dengan alamat anda ? <span class="required">*</span></label>
												    <div class="col-md-12">
												      	<label class="radio-inline">
										              		<input type="radio" name="radioAlamatIbu" value = "Ya" id = "AlamatIbuSama" class = "radioAlamatIbu"> Yes
										            	</label>
										            	<label class="radio-inline">
    									              		<input type="radio" name="radioAlamatIbu" value = "Tidak" id = "AlamatIbuTdkSama" class = "radioAlamatIbu"> No
    									            	</label>
        										    </div>
												</div>
												<div id ="AlamatIbu" class = "hide">
													<div class="form-group">
													    <label class="col-lg-3 control-label">Country / Negara</label>
													    	<div class="col-md-6">
													    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectNegaraIbu">
													    	    <option></option>
													    	  </select>
													    	</div>
													    <!--<div class="help-block"> grams</div>-->  
													</div>
													<div class="form-group">
													    <label class="col-lg-3 control-label">Province / Provinsi <span class="required">*</span></label>
													    	<div class="col-md-6">
													    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectProvinsiIbu">
													    	    <option></option>
													    	  </select>
													    	</div>
													    <!--<div class="help-block"> grams</div>-->  
													</div>
													<div class="form-group">
													    <label class="col-lg-3 control-label">Region / Kota dan Kabupaten <span class="required">*</span></label>
													    	<div class="col-md-6">
													    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectRegionIbu">
													    	    <option></option>
													    	  </select>
													    	</div>
													    <!--<div class="help-block"> grams</div>-->  
													</div>
													<div class="form-group">
													    <label class="col-lg-3 control-label">Address / Alamat <span class="required">*</span></label>
													    <div class="col-md-8">
															<textarea rows="3" cols="5" name="textarea" class="limited form-control" data-limit="150" maxlength="150" id = "AlamatIbutextarea"></textarea>
															<span id="charsIbu">150</span> characters remaining
													    </div>
													    <!--<div class="help-block"> grams</div>-->  
													</div>
												</div>
											</div>
										</div><!-- exit panel body -->
									</div><!-- exit panel primary -->
									<p style="font-weight: bold;">
										I declare to register at Agung Podomoro University and declare all the data I provide is true and accountable / <br>
										Saya menyatakan mendaftar di Universitas Agung Podomoro dan menyatakan seluruh data yang saya berikan adalah benar dan dapat dipertanggung jawabkan.
									</p>
									<p style="font-weight: bold;">
										I submit and follow all the decisions made by Agung Podomoro University / <br>
										Saya tunduk dan mengikuti seluruh keputusan yang telah ditetapkan oleh Universitas Agung Podomoro
									</p>
									<div class="form-horizontal">
										<div class = "form-group">
											<label class = "col-lg-3 control-label">Upload Foto 3x4<span class="required">*</span></label>
											<div class = "col-md-6">
												<input type="file" id="imgInp" name="uploadfile">
											</div>
										</div>
										<div class = "col-md-3">
										</div>
										<div class = "col-md-3">
											<img id="foto" src="#" alt="your image" />
										</div>
									</div>		
								</div>	<!-- exit panel body -->
							</div><!-- exit panel body -->	
							<div class ="form-group">
								<div align="right">
									<button class="btn btn-inverse btn-notification" id="btn-proses">Proses</button>
									<!--<button class="ng-button hide" id="btn-formulir" data-sbmt = "">Download Formulir</button>-->
								</div>
							</div> 	
    					</div><!-- exit row -->
                	</div><!-- exit contain -->
                </div>
            </div>
        </div>  
    </section>
</div>

<script type="text/javascript">

	$(document).ready(function() {
		  // $('#FullName').prop('disabled', true);
		  // $('#Email').prop('disabled', true);
		  // $('#selectSchool').prop('disabled', true);
		  $('#selectSchool').select2({
		     //allowClear: true
		  });
	    loadDataFromServer();
	});

  function loadDataFromServer()
  {
  	$('#NotificationModal .modal-header').addClass('hide');
  	  $('#NotificationModal .modal-body').html('<center>' +
  	      '                    <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>' +
  	      '                    <br/>' +
  	      '                    Loading Data . . .' +
  	      '                </center>');
  	  $('#NotificationModal .modal-footer').addClass('hide');
  	  $('#NotificationModal').modal({
  	      'backdrop' : 'static',
  	      'show' : true
  	  });

  	  loadDataProgram_study();
  	  loadDataAgama();
  	  loadJenisTempatTinggal();
  	  loadDataProvRegionKecamatan();
  	  loadCountry();
  	  loadTipeSekolah();
  	  loadMajorSekolah();
  	  <?php if ($this->uri->segment(1) != 'formulir-registration-offline'): ?>
  	  loadAlamatSekolah();
  	  <?php endif ?>
  	  loadTahunLulus();
  	  loadPenerimaKPS();
  	  loadUkuranJacket();
  	  loadTahunLahir();
  	  loadBulanLahir()
  	  // function untuk data master orang tua
  	  loadDataPekerjaan();
  	  loadDataPenghasilan();
  	  <?php if ($this->uri->segment(1) == 'formulir-registration-offline'): ?>
  	  	loadDataRegionSchool();
  	  <?php endif ?>

  	  setTimeout(function () {
  	      $('#NotificationModal').modal('hide');
  	  },3000);  
  }

  function loadDataRegionSchool()
  {
  	var url = base_url_js+'api/__getWilayahURLJson';
  	    $.get(url,function (data_json) {
  	        for(var i=0;i<data_json.length;i++){
  	            //var selected = (i==0) ? 'selected' : '';
  	            var selected = (data_json[i].RegionName=='Kota Jakarta Pusat') ? 'selected' : '';
  	            $('#selectWilayah').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
  	        }
  	        $('#selectWilayah').select2({
  	           //allowClear: true
  	        });
  	        var selectWilayah = $('#selectWilayah').find(':selected').val();
  	        loadDataSchool(selectWilayah);
  	    }).done(function () {
  	      
  	    });
  }

  function loadDataSchool(selectWilayah)
  {
    //var selectWilayah = $('#selectWilayah').find(':selected').val();
    var url = base_url_js+"api/__getSMAWilayah";
    var data = {
              wilayah : selectWilayah
          };
    var token = jwt_encode(data,"UAP)(*");
    $('#selectSchool').empty()
    $.post(url,{token:token},function (data_json) {
          for(var i=0;i<data_json.length;i++){
              var selected = (i==0) ? 'selected' : '';
              //var selected = (data_json[i].RegionName=='Kota Jakarta Pusat') ? 'selected' : '';
              $('#selectSchool').append('<option value="'+data_json[i].ID+'" '+selected+'>'+data_json[i].SchoolName+'</option>');
          }
          $('#selectSchool').select2({
             //allowClear: true
          });
    }).done(function () {
      loadAlamatSekolah();
    });

  }

  function loadDataPenghasilan()
  {
  	  var url = base_url_js+'api/__getDataPenghasilan';
	  $.get(url,function (data_json) {
	  	  var splitBagi = 2;
	      var split = parseInt(data_json.length / splitBagi);
	      var sisa = data_json.length % splitBagi;
	      if (sisa > 0) {
	            split++;
	      }
	      var getRow = 0;
	      $('#pagePenghasilanAyah').append('<table class="table" id ="tablechkPenghasilanAyah">');
	      $('#pagePenghasilanIbu').append('<table class="table" id ="tablechkPenghasilanIbu">');
	      for (var i = 0; i < split; i++) {
	      	if ((sisa > 0) && ((i+1) == split) ) {
	      	                    splitBagi = sisa;
	      	}
	      	$('#tablechkPenghasilanAyah').append('<tr id = "PenghasilanAyah'+i+'">');
	      	$('#tablechkPenghasilanIbu').append('<tr id = "PenghasilanIbu'+i+'">');
	      	for (var k = 0; k < splitBagi; k++) {
	      		$('#PenghasilanAyah'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkPenghasilanAyah" name="chkPenghasilanAyah" value = "'+data_json[getRow].ID+'">&nbsp'+ data_json[getRow].Income+
	  	      					 '</td>'
	      						);
	      		$('#PenghasilanIbu'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkPenghasilanIbu" name="chkPenghasilanIbu" value = "'+data_json[getRow].ID+'">&nbsp'+ data_json[getRow].Income+
	  	      					 '</td>'
	      						);
	      		getRow++;
	      	}
	      	$('#PenghasilanAyah'+i).append('</tr>');
	      	$('#PenghasilanIbu'+i).append('</tr>');
	      }
	      $('#PenghasilanAyah'+i).append('</table>');
	      $('#PenghasilanIbu'+i).append('</table>');
	  })
  }

  function loadDataPekerjaan()
  {
  	  var url = base_url_js+'api/__getDataPekerjaan';
	  $.get(url,function (data_json) {
	  	  var splitBagi = 3;
	      var split = parseInt(data_json.length / splitBagi);
	      var sisa = data_json.length % splitBagi;
	      if (sisa > 0) {
	            split++;
	      }
	      var getRow = 0;
	      $('#pagePekerjaanAyah').append('<table class="table" id ="tablechkPekerjaanAyah">');
	      $('#pagePekerjaanIbu').append('<table class="table" id ="tablechkPekerjaanIbu">');
	      for (var i = 0; i < split; i++) {
	      	if ((sisa > 0) && ((i+1) == split) ) {
	      	                    splitBagi = sisa;
	      	}
	      	$('#tablechkPekerjaanAyah').append('<tr id = "PekerjaanAyah'+i+'">');
	      	$('#tablechkPekerjaanIbu').append('<tr id = "PekerjaanIbu'+i+'">');
	      	for (var k = 0; k < splitBagi; k++) {
	      		$('#PekerjaanAyah'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkPekerjaanAyah" name="chkPekerjaanAyah" value = "'+data_json[getRow].ocu_code+'">&nbsp'+ data_json[getRow].ocu_name+
	  	      					 '</td>'
	      						);
	      		$('#PekerjaanIbu'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkPekerjaanIbu" name="chkPekerjaanIbu" value = "'+data_json[getRow].ocu_code+'">&nbsp'+ data_json[getRow].ocu_name+
	  	      					 '</td>'
	      						);
	      		getRow++;
	      	}
	      	$('#PekerjaanAyah'+i).append('</tr>');
	      	$('#PekerjaanIbu'+i).append('</tr>');
	      }
	      $('#PekerjaanAyah').append('</table>');
	      $('#PekerjaanIbu').append('</table>');
	  })
  }

  function loadUkuranJacket()
  {
  	  var url = base_url_js+'api/__getUkuranJacket';
	  $.get(url,function (data_json) {
	  	  var splitBagi = 5;
	      var split = parseInt(data_json.length / splitBagi);
	      var sisa = data_json.length % splitBagi;
	      if (sisa > 0) {
	            split++;
	      }
	      var getRow = 0;
	      $('#UkuranJacket').append('<table class="table" id ="tablechkUkuranJacket">');
	      for (var i = 0; i < split; i++) {
	      	if ((sisa > 0) && ((i+1) == split) ) {
	      	                    splitBagi = sisa;
	      	}
	      	$('#tablechkUkuranJacket').append('<tr id = "UkuranJacket'+i+'">');
	      	for (var k = 0; k < splitBagi; k++) {
	      		$('#UkuranJacket'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkUkuranJacket" name="chkUkuranJacket" value = "'+data_json[getRow].ID+'">&nbsp'+ data_json[getRow].JacketSize+
	  	      					 '</td>'
	      						);
	      		getRow++;
	      	}
	      	$('#UkuranJacket'+i).append('</tr>');
	      }
	      $('#UkuranJacket').append('</table>');
	  })
  }

  function loadPenerimaKPS()
  {
    $('#pagePenerimaKPS').append('<table class="table" id ="tablechkPenerimaKPS">');
    for (var i = 0; i < 1; i++) {
    	$('#tablechkPenerimaKPS').append('<tr id = "PenerimaKPS'+i+'">');
    	for (var k = 0; k < 2; k++) {
    		if (k == 0) {
	    		$('#PenerimaKPS'+i).append('<td>'+
		      						'<input type="checkbox" class = "chkPenerimaKPS" name="chkPenerimaKPS" value = "Tidak" id = "PenerimaKPSTDK">&nbsp No' +
		      					 '</td>'
	    						);
    		}
    		else
    		{
    			$('#PenerimaKPS'+i).append('<td>'+
		      						'<input type="checkbox" class = "chkPenerimaKPS" name="chkPenerimaKPS" value = "Ya" id = "PenerimaKPSYA">&nbsp Yes' +
		      					 '</td>'
	    						);
    		}
    		
    	}
    	$('#PenerimaKPS'+i).append('</tr>');
    }
    $('#tablechkPenerimaKPS').append('</table>');
  }

  function loadTahunLulus()
  {
  	var thisYear = (new Date()).getFullYear();
  	var startTahun = parseInt(thisYear) - parseInt(5);
  	var selisih = parseInt(thisYear) - parseInt(startTahun);
  	for (var i = 0; i <= selisih; i++) {
  	    var selected = (i==0) ? 'selected' : '';
  	    $('#selectTahunLulus').append('<option value="'+ ( parseInt(startTahun) + parseInt(i) ) +'" '+selected+'>'+( parseInt(startTahun) + parseInt(i) )+'</option>');
  	}
  	$('#selectTahunLulus').select2({
  	  // allowClear: true
  	});
  }

  function loadTahunLahir()
  {
  	var thisYear = (new Date()).getFullYear();
  	var startTahun = parseInt(thisYear) - parseInt(120);
  	var selisih = parseInt(thisYear) - parseInt(startTahun);
  	for (var i = 0; i <= selisih; i++) {
  	    var selected = (i==0) ? 'selected' : '';
  	    $('.tahun_lahir').append('<option value="'+ ( parseInt(startTahun) + parseInt(i) ) +'" '+selected+'>'+( parseInt(startTahun) + parseInt(i) )+'</option>');
  	}
  	$('.tahun_lahir').select2({
  	  // allowClear: true
  	});

  }

  function loadBulanLahir()
  {
  	var month = {
  		01 : 'Jan',
  		02 : 'Feb',
  		03 : 'Mar',
  		04 : 'April',
  		05 : 'Mei',
  		06 : 'Jun',
  		07 : 'Jul',
  		08 : 'Aug',
  		09 : 'Sep',
  		10 : 'Okt',
  		11 : 'Nov',
  		12 : 'Des'
  	}

  	for(var key in month) {
  		var selected = (key==1) ? 'selected' : '';
  		var getKey = key.toString();
  		if (getKey.length == 1) {
  			var value = '0' + getKey;
  		}
  		else
  		{
  			var value = key;
  		}
  		$('.bulan_lahir').append('<option value="'+ value +'" '+selected+'>'+month[key]+'</option>');
  	}

  	$('.bulan_lahir').select2({
  	  // allowClear: true
  	});

  	var tahun = $("#Tahun_lahir").find(':selected').val();
  	var bulan = $("#Bulan_lahir").find(':selected').val();
  	//moment("2012-02", "YYYY-MM").daysInMonth()
  	loadCountDays(tahun,bulan,'#DD_lahir');
  	loadCountDays(tahun,bulan,'#DD_lahirAyah');
  	loadCountDays(tahun,bulan,'#DD_lahirIbu');
  	
  }

  function loadAlamatSekolah()
  {
  	var selectSchool = $('#selectSchool').find(':selected').val();
  	var url = base_url_js+'api/__getAlamatSekolah';
  	var data = {
  	            selectSchool : selectSchool
  	        };
  	var token = jwt_encode(data,"UAP)(*");
  	$.post(url,{token:token},function (data_json) {
  	    $("#selectProvinsiSchool option").filter(function() {
  	       //may want to use $.trim in here
  	       return $(this).val() == data_json[0]['ProvinceID']; 
  	    }).prop("selected", true);

  	    $('#selectProvinsiSchool').prop('disabled', true);
  	    $('#selectProvinsiSchool').select2({
  	       //allowClear: true
  	    });

  	    var selectProvinsiSchool = $('#selectProvinsiSchool').find(':selected').val();
  	    loadRegionSchool(selectProvinsiSchool,data_json[0]['CityID']);
  	    $("#AlamatSchool").val(data_json[0]['SchoolAddress']);
  	    $('#AlamatSchool').prop('disabled', true);

  	}).done(function () {
	    setTimeout(function () {
	        
	    },500);
	});

  }

  function loadMajorSekolah()
  {
  	  var url = base_url_js+'api/__getMajorSekolah';
	  $.get(url,function (data_json) {
	  	  var splitBagi = 3;
	      var split = parseInt(data_json.length / splitBagi);
	      var sisa = data_json.length % splitBagi;
	      if (sisa > 0) {
	            split++;
	      }
	      var getRow = 0;
	      $('#SchoolMajor').append('<table class="table" id ="tablechkSchoolMajor">');
	      for (var i = 0; i < split; i++) {
	      	if ((sisa > 0) && ((i+1) == split) ) {
	      	                    splitBagi = sisa;    
	      	}
	      	$('#tablechkSchoolMajor').append('<tr id = "SchoolMajor'+i+'">');
	      	for (var k = 0; k < splitBagi; k++) {
	      		$('#SchoolMajor'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkSchoolMajor" name="chkSchoolMajor" value = "'+data_json[getRow].ID+'">&nbsp'+ data_json[getRow].SchoolMajor+
	  	      					 '</td>'
	      						);
	      		getRow++;
	      	}
	      	$('#SchoolMajor'+i).append('</tr>');
	      }
	      $('#tablechkSchoolMajor').append('</table>');
	  })
  }

  function loadTipeSekolah()
  {
  	  var url = base_url_js+'api/__getTipeSekolah';
	  $.get(url,function (data_json) {
	  	  var splitBagi = 3;
	      var split = parseInt(data_json.length / splitBagi);
	      var sisa = data_json.length % splitBagi;
	      if (sisa > 0) {
	            split++;
	      }
	      var getRow = 0;
	      $('#TipeSekolah').append('<table class="table" id ="tablechkTipeSekolah">');
	      for (var i = 0; i < split; i++) {
	      	if ((sisa > 0) && ((i+1) == split) ) {
	      	                    splitBagi = sisa;    
	      	}
	      	$('#tablechkTipeSekolah').append('<tr id = "TipeSekolah'+i+'">');
	      	for (var k = 0; k < splitBagi; k++) {
	      		$('#TipeSekolah'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkTipeSekolah" name="chkTipeSekolah" value = "'+data_json[getRow].sct_code+'">&nbsp'+ data_json[getRow].sct_name_id+
	  	      					 '</td>'
	      						);
	      		getRow++;
	      	}
	      	$('#TipeSekolah'+i).append('</tr>');
	      }
	      $('#tablechkTipeSekolah').append('</table>');

	      autocheckDariNamaSekolah();
	  })
  }

  function autocheckDariNamaSekolah()
  {
  	var selectSchool = $('#selectSchool').find(':selected').text();
  	var getSubstr3 = selectSchool.substring(0, 3);
  	if (getSubstr3 == "SMA") {
  		$('.chkTipeSekolah[value=1]').prop('checked', true);
  	}

  	if (getSubstr3 == "SMK") {
  		$('.chkTipeSekolah[value=4]').prop('checked', true);
  	}

  }

	function loadCountry()
	{
		// provinsi
		  var url = base_url_js+'api/__getCountry';
		  $.get(url,function (data_json) {
		      for(var i=0;i<data_json.length;i++){
		          var selected = (i==0) ? 'selected' : '';
		          $('#selectNegara').append('<option value="'+data_json[i].ctr_code+'" '+selected+'>'+data_json[i].ctr_name+'</option>');
		          $('#selectNegaraSchool').append('<option value="'+data_json[i].ctr_code+'" '+selected+'>'+data_json[i].ctr_name+'</option>');
		          $('#selectNegaraAyah').append('<option value="'+data_json[i].ctr_code+'" '+selected+'>'+data_json[i].ctr_name+'</option>');
		          $('#selectNegaraIbu').append('<option value="'+data_json[i].ctr_code+'" '+selected+'>'+data_json[i].ctr_name+'</option>');
		      }
		      $('#selectNegara').select2({
		         //allowClear: true
		      });

		      $('#selectNegaraSchool').select2({
		         //allowClear: true
		      });
		      $('#selectNegaraAyah').select2({
		         //allowClear: true
		      });

		      $('#selectNegaraIbu').select2({
		         //allowClear: true
		      });
		  })
		  $('#selectNegara').prop('disabled', true);
		  $('#selectNegaraSchool').prop('disabled', true);
		  $('#selectNegaraAyah').prop('disabled', true);
		  $('#selectNegaraIbu').prop('disabled', true);
	}

  function loadDataProvRegionKecamatan(paramater = null,set_default = null)
  {
  	// provinsi
  	  var url = base_url_js+'api/__getProvinsi';
	  $.get(url,function (data_json) {
      	  switch(paramater)
      	  {
      	   case  null :
      	         break;
      	   case  "ayah" :
      	   		 $("#selectProvinsiAyah").empty();
      	         break;
      	   case  "ibu" :
      	   		 $("#selectProvinsiIbu").empty();
      	         break;
      	  }
	  	  
	      for(var i=0;i<data_json.length;i++){
	      	  switch(paramater)
	      	  {
	      	   case  null :
	      	         var selected = (i==0) ? 'selected' : '';
	      	         $('#selectProvinsi').append('<option value="'+data_json[i].ProvinceID+'" '+selected+'>'+data_json[i].ProvinceName+'</option>');

	      	         $('#selectProvinsiSchool').append('<option value="'+data_json[i].ProvinceID+'" '+selected+'>'+data_json[i].ProvinceName+'</option>');
	      	         break;
	      	   case  "ayah" :
	      	   		 if (set_default == null) {
  	   		 	      var value = $('#selectProvinsi').find(':selected').val();
  	   		 	      var selected = (value==data_json[i].ProvinceID) ? 'selected' : '';
  	   		 			 $('#selectProvinsiAyah').append('<option value="'+data_json[i].ProvinceID+'" '+selected+'>'+data_json[i].ProvinceName+'</option>');
	      	   		 }
	      	   		 else
	      	   		 {
  	   		 	      var selected = (i==0) ? 'selected' : '';
  	   		 	      var selected = (value==data_json[i].ProvinceID) ? 'selected' : '';
  	   		 			 $('#selectProvinsiAyah').append('<option value="'+data_json[i].ProvinceID+'" '+selected+'>'+data_json[i].ProvinceName+'</option>');
	      	   		 }
	      	         break;
	      	   case  "ibu" :
 	      	   		 if (set_default == null) {
   	   		 	      var value = $('#selectProvinsi').find(':selected').val();
   	   		 	      var selected = (value==data_json[i].ProvinceID) ? 'selected' : '';
   	   		 			 $('#selectProvinsiIbu').append('<option value="'+data_json[i].ProvinceID+'" '+selected+'>'+data_json[i].ProvinceName+'</option>');
 	      	   		 }
 	      	   		 else
 	      	   		 {
   	   		 	      var selected = (i==0) ? 'selected' : '';
   	   		 	      var selected = (value==data_json[i].ProvinceID) ? 'selected' : '';
   	   		 			 $('#selectProvinsiIbu').append('<option value="'+data_json[i].ProvinceID+'" '+selected+'>'+data_json[i].ProvinceName+'</option>');
 	      	   		 }
	      	         break;
	      	  }
	          
	      }

	      switch(paramater)
	      {
	       case  null :
	                $('#selectProvinsi').select2({
	             	         //allowClear: true
	             	});

         	        $('#selectProvinsiSchool').select2({
         	         //allowClear: true
         	        });
         	        var selectProvinsi = $('#selectProvinsi').find(':selected').val();
         	        loadRegion(selectProvinsi);
         	    break;    
	       case  "ayah" :
        		 	$('#selectProvinsiAyah').select2({
       	   				//allowClear: true
       				});
	       			if (set_default == null) {
						var selectProvinsiAyah = $('#selectProvinsiAyah').find(':selected').val();
						loadRegion(selectProvinsiAyah,'ayah');
	       			}
	       			else
	       			{
	       				var selectProvinsiAyah = $('#selectProvinsiAyah').find(':selected').val();
	       				loadRegion(selectProvinsiAyah,'ayah',set_default);
	       			}
	             break;
	       case  "ibu" :
         		 	$('#selectProvinsiIbu').select2({
        	   				//allowClear: true
        				});
 	       			if (set_default == null) {
 						var selectProvinsiIbu = $('#selectProvinsiIbu').find(':selected').val();
 						loadRegion(selectProvinsiIbu,'ibu');
 	       			}
 	       			else
 	       			{
 	       				var selectProvinsiIbu = $('#selectProvinsiIbu').find(':selected').val();
 	       				loadRegion(selectProvinsiIbu,'ibu',set_default);
 	       			}
	             break;
	      }
	      
	  })
  }

  function loadRegionSchool(selectProvinsi,ID_City = null)
  {
  	  var url = base_url_js+'api/__getRegion';
  	  var data = {
  	            selectProvinsi : selectProvinsi
  	        };
  	  var token = jwt_encode(data,"UAP)(*");
  	  $('#selectRegionSchool').empty();
	  $.post(url,{token:token},function (data_json) {
	      for(var i=0;i<data_json.length;i++){
	          var selected = (i==0) ? 'selected' : '';
	          $('#selectRegionSchool').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
	      }

	      if (ID_City != null) {
	      	$("#selectRegionSchool option").filter(function() {
	      	   //may want to use $.trim in here
	      	   return $(this).val() == ID_City; 
	      	}).prop("selected", true);

	      	$('#selectRegionSchool').prop('disabled', true);
	      	
	      }

	      $('#selectRegionSchool').select2({
	         //allowClear: true
	      });
	  })
  }

  function loadRegion(selectProvinsi,parameter = null, set_default = null)
  {
  	  var url = base_url_js+'api/__getRegion';
  	  var data = {
  	            selectProvinsi : selectProvinsi
  	        };
  	  var token = jwt_encode(data,"UAP)(*");
  	  if (parameter == null) {
  	  	$('#selectRegion').empty();
  	  }
	  $.post(url,{token:token},function (data_json) {
	      for(var i=0;i<data_json.length;i++){
  	  	      switch(parameter)
  	  	      {
  	  	       case  null :
  	  	                var selected = (i==0) ? 'selected' : '';
  	  	                $('#selectRegion').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
  	           	    break;    
  	  	       case  "ayah" :
  	  	       			if (set_default == null) {
 	  	       		 	 var value = $('#selectRegion').find(':selected').val();
		      	         var selected = (value==data_json[i].RegionID) ? 'selected' : '';
		      	   		 $('#selectRegionAyah').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
  	  	       			}
  	  	       			else
  	  	       			{
  	  	       				var selected = (i==0) ? 'selected' : '';
  	  	       				$('#selectRegionAyah').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
  	  	       			}
  	  	             break;
  	  	       case  "ibu" :
   	  	       			if (set_default == null) {
  	  	       		 	 var value = $('#selectRegion').find(':selected').val();
 		      	         var selected = (value==data_json[i].RegionID) ? 'selected' : '';
 		      	   		 $('#selectRegionIbu').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
   	  	       			}
   	  	       			else
   	  	       			{
   	  	       				var selected = (i==0) ? 'selected' : '';
   	  	       				$('#selectRegionIbu').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
   	  	       			}
  	  	             break;
  	  	      }
  	          
	      }

  	      switch(parameter)
  	      {
  	       case  null :
  	                $('#selectRegion').select2({
  	                   //allowClear: true
  	                });
  	                var selectRegion = $('#selectRegion').find(':selected').val();
  	                loadKecamatan(selectRegion);
           	    break;    
  	       case  "ayah" :
  	       			$('#selectRegionAyah').select2({
  	       			   //allowClear: true
  	       			});
  	             break;
  	       case  "ibu" :
  	             	$('#selectRegionIbu').select2({
  	             	   //allowClear: true
  	             	});
  	             break;
  	      }
	  })
  }

  function loadKecamatan(selectRegion)
  {
  	  var url = base_url_js+'api/__getKecamatan';
  	  var data = {
  	            selectRegion : selectRegion
  	        };
  	  var token = jwt_encode(data,"UAP)(*");
  	  $('#selectKecamatan').empty()
	  $.post(url,{token:token},function (data_json) {
	      for(var i=0;i<data_json.length;i++){
	          var selected = (i==0) ? 'selected' : '';
	          $('#selectKecamatan').append('<option value="'+data_json[i].DistrictID+'" '+selected+'>'+data_json[i].DistrictName+'</option>');
	      }
	      $('#selectKecamatan').select2({
	         //allowClear: true
	      });
	      var selectKecamatan = $('#selectKecamatan').find(':selected').val();
	  })
  }

  function loadJenisTempatTinggal()
  {
  	  var url = base_url_js+'api/__getJenisTempatTinggal';
	  $.get(url,function (data_json) {
	  	  var splitBagi = 3;
	      var split = parseInt(data_json.length / splitBagi);
	      var sisa = data_json.length % splitBagi;
	      if (sisa > 0) {
	            split++;
	      }
	      var getRow = 0;
	      $('#JenisTempatTinggal').append('<table class="table" id ="tablechkJenisTempatTinggal">');
	      for (var i = 0; i < split; i++) {
	      	if ((sisa > 0) && ((i+1) == split) ) {
	      	                    splitBagi = sisa;
	      	}
	      	$('#tablechkJenisTempatTinggal').append('<tr id = "JenisTempatTinggal'+i+'">');
	      	for (var k = 0; k < splitBagi; k++) {
	      		$('#JenisTempatTinggal'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkJenisTempatTinggal" name="chkJenisTempatTinggal" value = "'+data_json[getRow].ID+'">&nbsp'+ data_json[getRow].JenisTempatTinggal+
	  	      					 '</td>'
	      						);
	      		getRow++;
	      	}
	      	$('#JenisTempatTinggal'+i).append('</tr>');
	      }
	      $('#JenisTempatTinggal').append('</table>');
	  })
  }

  function loadDataAgama()
  {
  	  var url = base_url_js+'api/__getAgama';
	  $.get(url,function (data_json) {
	  	  var splitBagi = 3;
	      var split = parseInt(data_json.length / splitBagi);
	      var sisa = data_json.length % splitBagi;
	      if (sisa > 0) {
	            split++;
	      }
	      var getRow = 0;
	      $('#Agama').append('<table class="table" id ="tablechkAgama">');
	      for (var i = 0; i < split; i++) {
	      	if ((sisa > 0) && ((i+1) == split) ) {
	      	                    splitBagi = sisa;    
	      	}
	      	$('#tablechkAgama').append('<tr id = "agama'+i+'">');
	      	for (var k = 0; k < splitBagi; k++) {
	      		$('#agama'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkAgama" name="chkAgama" value = "'+data_json[getRow].IDReligion+'">&nbsp'+ data_json[getRow].Religion+
	  	      					 '</td>'
	      						);
	      		getRow++;
	      	}
	      	$('#agama'+i).append('</tr>');
	      }
	      $('#tablechkAgama').append('</table>');
	  })
  }

  function loadDataProgram_study()
  {
  	  var url = base_url_js+'api/__getProgramStudy';
  	  $.get(url,function (data_json) {
  	      var split = parseInt(data_json.length / 5);
  	      var sisa = data_json.length % 5;
  	      var splitBagi = 5;
  	      if (sisa > 0) {
  	            split++;
  	      }
  	      var getRow = 0;
  	      $('#program_study').append('<table class="table" id ="tablechkProStudy">');
  	      for (var i = 0; i < split; i++) {
  	      	if ((sisa > 0) && ((i + 1) == split) ) {
  	      	                    splitBagi = sisa;    
  	      	}
  	      	$('#tablechkProStudy').append('<tr id = "a'+i+'">');
  	      	for (var k = 0; k < splitBagi; k++) {
  	      		$('#a'+i).append('<td>'+
	  	      						'<input type="checkbox" class = "chkProStudy" name="chkProStudy" value = "'+data_json[getRow].ID+'">&nbsp'+ data_json[getRow].Name+
	  	      					 '</td>'
  	      						);
  	      		getRow++;
  	      	}
  	      	$('#a'+i).append('</tr>');
  	      }
  	      $('#tablechkProStudy').append('</table>');
  	  })
  }

  function loadCountDays(tahun,bulan,elementTarget)
  {
  		$(elementTarget).empty();
  		var countDays = moment(tahun+"-"+bulan, "YYYY-MM").daysInMonth()
  		// get dd 
  	  	for (var i = 1; i <= countDays ; i++) {
  			var selected = (i==1) ? 'selected' : '';
  					var getKey = i.toString();
  					if (getKey.length == 1) {
  						var value = '0' + getKey;
  					}
  					else
  					{
  						var value = i;
  					}
  			  		$(elementTarget).append('<option value="'+ value +'" '+selected+'>'+value+'</option>');
  		}
  		$(elementTarget).select2({
  		  	  // allowClear: true
  		});
  }

  $(document).on('change','#selectWilayah',function () {
      loadDataSchool(this.value);
  });

  $(document).on('change','#selectSchool',function () {
      loadAlamatSekolah();
  });

  $(document).on('change','#Bulan_lahir', function () {
  	var tahun = $("#Tahun_lahir").find(':selected').val();
  	var bulan = $(this).find(':selected').val();
  	//moment("2012-02", "YYYY-MM").daysInMonth()
  	loadCountDays(tahun,bulan,'#DD_lahir');
  	
  });

  $(document).on('change','#Bulan_lahirAyah', function () {
  	var tahun = $("#Tahun_lahirAyah").find(':selected').val();
  	var bulan = $(this).find(':selected').val();
  	//moment("2012-02", "YYYY-MM").daysInMonth()
  	loadCountDays(tahun,bulan,'#DD_lahirAyah');
  	
  });

  $(document).on('change','#Bulan_lahirIbu', function () {
  	var tahun = $("#Tahun_lahirIbu").find(':selected').val();
  	var bulan = $(this).find(':selected').val();
  	//moment("2012-02", "YYYY-MM").daysInMonth()
  	loadCountDays(tahun,bulan,'#DD_lahirIbu');
  	
  });

    function getCheckbox(name)
    {
    	var valuee = "";
    	$('input[name="'+name+'"]:checked').each(function() {
    	   valuee = this.value;
    	});

    	return valuee;
    }

    $(document).on('keyup','#Alamat', function () {
    	var maxLength = 150;
    	var length = $(this).val().length;
    	var length = maxLength-length;
    	$('#chars').text(length);
    });

    $(document).on('keyup','#AlamatAyahtextarea', function () {
    	var maxLength = 150;
    	var length = $(this).val().length;
    	var length = maxLength-length;
    	$('#charsAyah').text(length);
    });

    $(document).on('click','#AlamatAyahSama', function () {
    	// show data
    	var ayah = "ayah";
    	loadDataProvRegionKecamatan(ayah);
    	var value = $("#Alamat").val();
    	$("#AlamatAyahtextarea").val(value);
    	var length = $("#AlamatAyahtextarea").val().length;
    	var lengthRemainingAyah = 150-length;
    	$('#charsAyah').text(lengthRemainingAyah);
    	$("#AlamatAyah").removeClass("hide");
    });

    $(document).on('click','#AlamatIbuSama', function () {
    	// show data
    	var ibu = "ibu";
    	loadDataProvRegionKecamatan(ibu);
    	var value = $("#Alamat").val();
    	$("#AlamatIbutextarea").val(value);
    	var length = $("#AlamatIbutextarea").val().length;
    	var lengthRemainingAyah = 150-length;
    	$('#charsIbu').text(lengthRemainingAyah);
    	$("#AlamatIbu").removeClass("hide");
    });

    $(document).on('click','#AlamatIbuTdkSama', function () {
    	// show data
    	//$("#AlamatAyah").addClass("hide");
    	var ibu = "ibu";
    	loadDataProvRegionKecamatan(ibu,'not null');
    	$("#AlamatIbu").removeClass("hide");
    });

    $(document).on('click','#AlamatAyahTdkSama', function () {
    	// show data
    	//$("#AlamatAyah").addClass("hide");
    	var ayah = "ayah";
    	loadDataProvRegionKecamatan(ayah,'not null');
    	$("#AlamatAyah").removeClass("hide");
    });

    $(document).on('click','.chkProStudy', function () {
    	$('input.chkProStudy').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.Nationality', function () {
    	$('input.Nationality').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkAgama', function () {
    	$('input.chkAgama').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.statusAyah', function () {
    	$('input.statusAyah').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.statusIbu', function () {
    	$('input.statusIbu').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkPenerimaKPS', function () {
    	$('input.chkPenerimaKPS').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkUkuranJacket', function () {
    	$('input.chkUkuranJacket').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkSchoolMajor', function () {
    	$('input.chkSchoolMajor').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkPekerjaanAyah', function () {
    	$('input.chkPekerjaanAyah').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkPekerjaanIbu', function () {
    	$('input.chkPekerjaanIbu').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkPenghasilanAyah', function () {
    	$('input.chkPenghasilanAyah').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkPenghasilanIbu', function () {
    	$('input.chkPenghasilanIbu').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkTipeSekolah', function () {
    	$('input.chkTipeSekolah').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('click','.chkJenisTempatTinggal', function () {
    	$('input.chkJenisTempatTinggal').prop('checked', false);
    	$(this).prop('checked',true);
    });

    $(document).on('change','#NationalityWNA', function () {
    	if(this.checked) {
    	    loading_page("#pageSelectCountry");
    	  	var url = base_url_js+'api/__getCountry';
    	  	$.get(url,function (data_json) {
    	  	  setTimeout(function () {
      	  	  $("#pageSelectCountry").html('<div class="col-md-3">'+
    	  	  	  							   '<select class="select2-select-00 full-width-fix " id="selectCountry">'+
    	  	  	  							   '<option></option>'+
    	  	  	  							   '</select>'+
    	  	  	  							'</div>'   
      	  	  							  );
      	      for(var i=1;i<data_json.length;i++){
      	          var selected = (i==3) ? 'selected' : '';
      	          
      	          $('#selectCountry').append('<option value="'+data_json[i].ctr_code+'" '+selected+'>'+data_json[i].ctr_name+'</option>');
      	      }
      	      $('#selectCountry').select2({
      	         //allowClear: true
      	      });
    	  	  },1000); 
    	    })
    	}

    });

    $(document).on('change','#PenerimaKPSYA', function () {
    	if(this.checked) {
    	    $("#pageInputNOkPS").removeClass("hide");
    	}

    });

    $(document).on('change','#PenerimaKPSTDK', function () {
    	if(this.checked) {
    	    $("#pageInputNOkPS").addClass("hide");
    	}

    });

      $(document).on('change','#NationalityWNI', function () {
  		$("#pageSelectCountry").empty();
      });

      $(document).on('change','#selectProvinsi',function () {
          var selectProvinsi = $('#selectProvinsi').find(':selected').val();
          loadRegion(selectProvinsi);
      });

      $(document).on('change','#selectProvinsiSchool',function () {
          var selectProvinsi = $('#selectProvinsiSchool').find(':selected').val();
          loadRegionSchool(selectProvinsi);
      });

      $(document).on('change','#selectRegion',function () {
          var selectRegion = $('#selectRegion').find(':selected').val();
          loadKecamatan(selectRegion);
      });

  // settting toastr	
  toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "0",
      "hideDuration": "0",
      "timeOut": "0",
      "extendedTimeOut":"0",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
  };

  $(document).on('click','#btn-proses', function () {
  	loading_button('#btn-proses');
  	var DataArr = getDataInput();
  	 if (varlidationInput(DataArr)) {
 		console.log("Validation ok");
 		toastr.clear();
 		setTimeout(function () {
 	     processData(DataArr);
 	 	},1000);
  	 }
  	 else
  	 {
  	 	$('#btn-proses').prop('disabled',false).html('Proses'); 
  	 }

  	 /*if (true) {
  	 	console.log("Validation ok");
  	 	toastr.clear();
  	 	setTimeout(function () {
  	      processData(DataArr);
  	  	},1000); 
  	 	
  	 }*/
  });

  function varlidationInput(data)
  {
  	var toatString = "";
  	var result = "";
  	for(var key in data) {
  	   switch(key)
  	   {
  	    case  "IdentityCard" :
  	    case  "FatherNIK" :
  	    case  "MotherNik" :
  	    	  result = Validation_exactLenght_Character(16,data[key],key);
  	    	  if (result['status'] == 0) {
  	    	    toatString += result['messages'] + "<br>";
  	    	  }	
  	          break;
  	    case "Address" :
  	    case "District":
  	    case "PlaceBirth": 
  	    case "FatherPlaceBirth": 
  	    case "MotherPlaceBirth": 
  	    case "FatherAddress": 
  	    case "MotherAddress": 
    	   	  result = Validation_leastCharacter(3,data[key],key);
    	   	  if (result['status'] == 0) {
    	   	    toatString += result['messages'] + "<br>";
    	   	  }	
    	      break;
    	 case "file_validation" :
    	 	  if (!data[key]) {
    	 	  	toatString += "File Upload error" + "<br>";
    	 	  }
    	      break; 
    	 case "NoKPS":
    	 case "YourZipCode":

    	 	   break;
  	    default :
  	          result = Validation_required(data[key],key);
  	          if (result['status'] == 0) {
  	            toatString += result['messages'] + "<br>";
  	          }       
  	   }
  	}

  	if (toatString != "") {
  	  toastr.error(toatString, 'Failed!!');
  	  return false;
  	}
  	return true;
  }

  function processData(DataArr)
  {
  	var form_data = new FormData();
  	var fileData = document.getElementById("imgInp").files[0];
  	<?php if ($this->uri->segment(1) != 'formulir-registration-offline'): ?>
  	var url = base_url_js + "register/formulir_submit";
  	<?php else: ?>
  	var url = base_url_js + "register/formulir_submit_offline";
  	<?php endif ?>
  	var token = jwt_encode(DataArr,"UAP)(*");
  	form_data.append('token',token);
  	form_data.append('fileData',fileData);
  	$.ajax({
  	  type:"POST",
  	  url:url,
  	  data: form_data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
  	  contentType: false,       // The content type used when sending data to the server.
  	  cache: false,             // To unable request pages to be cached
  	  processData:false,
  	  dataType: "json",
  	  success:function(data)
  	  {
  	    if(data.status == 1) {
  	    	toastr.options.fadeOut = 100000;
  	    	toastr.success(data.msg, 'Success!');
  	    }
  	    else
  	    {
  	    	toastr.options.fadeOut = 100000;
  	    	toastr.error(data.msg, 'Failed!!');
  	    }
    	setTimeout(function () {
         toastr.clear();
     	},1000);

 		setTimeout(function () {
 	     $('#btn-proses').prop('disabled',false).html('Proses');
 	     window.location.reload();  
 	 	},1000);
  	  },
  	  error: function (data) {
  	    toastr.error("Connection Error, Please try again", 'Error!!');
  	    $('#btn-proses').prop('disabled',false).html('Proses');  
  	  }
  	})
  }

  function getDataInput()
  {
  	 var data = {};
  	 <?php if ($this->uri->segment(1) != 'formulir-registration-offline'): ?>
  	 var ID_register_verified = "<?php echo $this->session->userdata('ID_register_verified') ?>";
  	 <?php endif ?>
  	 var ID_program_study = getCheckbox('chkProStudy');
  	 var Gender = $('input[name=radioGender]:checked').val(); 
  	 var IdentityCard = $("#IdentityCard").val().trim();
  	 var NationalityID = (getCheckbox('radioNationality') == "WNI") ? '001' : $('#selectCountry').find(':selected').val();
  	 var ReligionID = getCheckbox('chkAgama');
  	 var PlaceBirth = $("#TempatLahir").val().trim();
  	 var DateBirth = $("#Tahun_lahir").val()+"-"+$("#Bulan_lahir").val()+"-"+$("#DD_lahir").val();
  	 var ID_register_jtinggal_m = getCheckbox('chkJenisTempatTinggal');
  	 var ID_country_address = $('#selectNegara').find(':selected').val();
  	 var ID_province = $('#selectProvinsi').find(':selected').val()
  	 var ID_region = $('#selectRegion').find(':selected').val()
  	 var ID_districts = $('#selectKecamatan').find(':selected').val();
  	 var District = $("#Kelurahan").val().trim();
  	 var Address = $("#Alamat").val().trim();
  	 var ZipCode = $('#KodePos').val();
  	 var PhoneNumber = $("#noHP").val();
  	 var ID_school_type = getCheckbox('chkTipeSekolah');
  	 var ID_register_major_school = getCheckbox('chkSchoolMajor');
  	 var YearGraduate = $('#selectTahunLulus').find(':selected').val();
  	 var KPSReceiverStatus = getCheckbox('chkPenerimaKPS');
  	 var NoKPS = (KPSReceiverStatus == "Ya") ? $('#NoKPS').val().trim() : '';
  	 var ID_register_jacket_size_m = getCheckbox('chkUkuranJacket');

  	 var FatherName = $("#NamaAyah").val().trim();
  	 var FatherNIK = $("#NikAyah").val().trim();
  	 var FatherPlaceBirth = $("#TempatLahirAyah").val().trim();
  	 var FatherDateBirth = $("#Tahun_lahirAyah").val()+"-"+$("#Bulan_lahirAyah").val()+"-"+$("#DD_lahirAyah").val();
  	 var FatherStatus = getCheckbox('statusAyah');
  	 var FatherPhoneNumber = $("#noHPAyah").val();
  	 var Father_ID_occupation = getCheckbox('chkPekerjaanAyah');
  	 var Father_ID_register_income_m = getCheckbox('chkPenghasilanAyah');
  	 var FatherAddress_ID_country = $("#selectNegaraAyah").find(':selected').val();
  	 var FatherAddress_ID_province = $("#selectProvinsiAyah").find(':selected').val();
  	 var FatherAddress_ID_region = $("#selectRegionAyah").find(':selected').val();
  	 var FatherAddress = $("#AlamatAyahtextarea").val();

  	 var MotherName = $('#NamaIbu').val().trim();
  	 var MotherNik = $("#NikIbu").val().trim();
  	 var MotherPlaceBirth = $("#TempatLahirIbu").val().trim();
  	 var MotherDateBirth = $("#Tahun_lahirIbu").val()+"-"+$("#Bulan_lahirIbu").val()+"-"+$("#DD_lahirIbu").val();
  	 var MotherStatus = getCheckbox('statusIbu');
  	 var MotherPhoneNumber = $("#noHPIbu").val();
  	 var Mother_ID_occupation = getCheckbox('chkPekerjaanIbu');
  	 var Mother_ID_register_income_m = getCheckbox('chkPenghasilanIbu');
  	 var MotherAddress_ID_country = $("#selectNegaraIbu").find(':selected').val();
  	 var MotherAddress_ID_province = $("#selectProvinsiIbu").find(':selected').val();
  	 var MotherAddress_ID_region = $("#selectRegionIbu").find(':selected').val();
  	 var MotherAddress = $("#AlamatAyahtextarea").val().trim();


  	 var radioAlamatAyah = $('input[name=radioAlamatAyah]:checked').val(); 
  	 var radioAlamatIbu = $('input[name=radioAlamatIbu]:checked').val(); 

  	 <?php if ($this->uri->segment(1) == 'formulir-registration-offline'): ?>
		var Email = $('#Email').val().trim();
		var selectSchool = $('#selectSchool').find(':selected').val();
		var FullName = $('#FullName').val();
	<?php endif ?>	
  	 data = {
  	 	<?php if ($this->uri->segment(1) != 'formulir-registration-offline'): ?>
  	 	     ID_register_verified :ID_register_verified,
  	 	<?php endif ?>
  	 	     ID_program_study :ID_program_study,
  	 	     Gender :Gender,
  	 	     IdentityCard :IdentityCard,
  	 	     NationalityID :NationalityID,
  	 	     ReligionID :ReligionID,
  	 	     PlaceBirth :PlaceBirth,
  	 	     DateBirth :DateBirth,
  	 	     TypeofResidence  :ID_register_jtinggal_m,
  	 	     YourCountryAddress :ID_country_address,
  	 	     YourProvince :ID_province,
  	 	     YourRegion :ID_region,
  	 	     YourDistricts :ID_districts,
  	 	     YourDistrict :District,
  	 	     YourAddress :Address,
  	 	     YourZipCode :ZipCode,
  	 	     PhoneNumber : PhoneNumber,
  	 	     YourSchool_type : ID_school_type,
  	 	     SchoolMajor : ID_register_major_school,
  	 	     YearGraduate : YearGraduate,
  	 	     KPSReceiverStatus : KPSReceiverStatus,
  	 	     NoKPS : NoKPS,
  	 	     JacketSize : ID_register_jacket_size_m,
  	 	     FatherName : FatherName,
  	 	     FatherNIK : FatherNIK,
  	 	     FatherPlaceBirth : FatherPlaceBirth,
  	 	     FatherDateBirth : FatherDateBirth,
  	 	     FatherStatus : FatherStatus,
  	 	     FatherPhoneNumber : FatherPhoneNumber,
  	 	     FatherOccupation : Father_ID_occupation,
  	 	     FatherIncome : Father_ID_register_income_m,
  	 	     FatherAddressCountry : FatherAddress_ID_country,
  	 	     FatherAddressProvince : FatherAddress_ID_province,
  	 	     FatherAddressRegion : FatherAddress_ID_region,
  	 	     FatherAddress : FatherAddress,
  	 	     MotherName : MotherName,
  	 	     MotherNik : MotherNik,
  	 	     MotherPlaceBirth : MotherPlaceBirth,
  	 	     MotherDateBirth : MotherDateBirth,
  	 	     MotherStatus : MotherStatus,
  	 	     MotherPhoneNumber : MotherPhoneNumber,
  	 	     MotherOccupation : Mother_ID_occupation,
  	 	     MotherIncome_m : Mother_ID_register_income_m,
  	 	     MotherAddressCountry : MotherAddress_ID_country,
  	 	     MotherAddressProvince : MotherAddress_ID_province,
  	 	     MotherAddressRegion : MotherAddress_ID_region ,
  	 	     MotherAddress : MotherAddress,
  	 	     ChoicesAlamatAyah : radioAlamatAyah,
  	 	     ChoicesAlamatIbu : radioAlamatIbu,
  	 	     file_validation : file_validation(),
	          <?php if ($this->uri->segment(1) == 'formulir-registration-offline'): ?>
	     		Email : Email,
	     		SchoolID : selectSchool,
	     		FullName : FullName,
	     		FormulirCode : "<?php echo $this->session->userdata('FormulirCode') ?>",
	     	 <?php endif ?>
  	 };	
  	 return data;
  }



  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#foto').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }


  function file_validation()
  {
  	try{
  		var name = document.getElementById("imgInp").files[0].name;
  		var ext = name.split('.').pop().toLowerCase();
  		if(jQuery.inArray(ext, ['png','jpg','jpeg']) == -1) 
  		{
  		  toastr.error("Invalid Image File", 'Failed!!');
  		  return false;
  		}
  		var oFReader = new FileReader();
  		oFReader.readAsDataURL(document.getElementById("imgInp").files[0]);
  		var f = document.getElementById("imgInp").files[0];
  		var fsize = f.size||f.fileSize;
  		if(fsize > 500000) // 500kb
  		{
  		 toastr.error("Image File Size is very big", 'Failed!!');
  		 return false;
  		}

  	}
  	catch(err)
  	{
  		return false;
  	}
      return true;
  }

  $(document).on('change','#imgInp',function () {
  	if (file_validation()) {
  		readURL(this);
  	}	
      
  });

</script>

