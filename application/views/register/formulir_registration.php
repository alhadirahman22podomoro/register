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
								<div class="panel-heading">
									<h3 class="panel-title">Study Program / Program Studi</h3>
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
								<div class="panel-heading">
									<h3 class="panel-title">Part 1 Data of Prospective Students / Bagian 1 Data Calon Mahasiswa</h3>
								</div>
								<div class="panel-body">
									<div class="form-horizontal">
										<div class="form-group">
										    <label class="col-lg-3 control-label">Full Name / Nama Lengkap</label>
										    <div class="col-md-6">
										      <input type="text" name="weight" placeholder="Input Full Name..." id = "FullName" value = "<?php echo $this->session->userdata('Name') ?>">
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Gender / Jenis Kelamin</label>
										    <div class="col-md-8">
										      	<label class="radio-inline">
								              		<input type="radio" name="radio" value = "L"> Male / Pria
								            	</label>
								            	<label class="radio-inline">
								              		<input type="radio" name="radio" value = "P"> Female / Wanita
								            	</label>
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Identity Card / NIK</label>
										    <div class="col-md-3">
										      <input type="text" name="weight" placeholder="Input Identiy Card..." id = "FullName" maxlength="16">
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Nationality / Kewarganegaraan</label>
										    <div class="col-md-2">
										        <label class="checkbox-inline">
										             <input type="checkbox" class = "Nationality" name="radio" id = "NationalityWNI"> WNI
										        </label>
										        <label class="checkbox-inline">
										             <input type="checkbox" class = "Nationality" name="radio" id = "NationalityWNA"> WNA
										        </label>
										    </div>
										    <div class="help-block" id ="pageSelectCountry"> 

										    </div>
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Religion / Agama</label>
										    <div class="col-md-6" id = Agama>
										      
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Place and Date of Birth / Tempat dan Tanggal Lahir</label>
										    <div class="col-md-2">
										      <input type="text" name="weight" placeholder="Input Place of Birth..." id = "TempatLahir" >
										    </div>
										    <div class="col-md-2">
										      <input type="text" name="regular" id= "Tgl_lahir" data-date-format="yyyy-mm-dd">
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Type of Residence / Jenis Tempat Tinggal</label>
										    <div class="col-md-6" id = JenisTempatTinggal>
										      
										    </div>
										    <!--<div class="help-block"> grams</div>-->  
										</div>
										<div class="panel panel-primary">
											<div class="panel-heading">
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
												    <label class="col-lg-3 control-label">Province / Provinsi</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectProvinsi">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Region / Kota dan Kabupaten</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectRegion">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Districts / Kecamatan</label>
												    	<div class="col-md-6">
												    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectKecamatan">
												    	    <option></option>
												    	  </select>
												    	</div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">District / Kelurahan</label>
												    <div class="col-md-6">
												      <input type="text" name="weight" placeholder="Input District..." id = "Kelurahan">
												    </div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
												<div class="form-group">
												    <label class="col-lg-3 control-label">Address / Alamat</label>
												    <div class="col-md-8">
														<textarea rows="3" cols="5" name="textarea" class="limited form-control" data-limit="150" maxlength="150" id = "Alamat"></textarea>
														<span id="chars">150</span> characters remaining
												    </div>
												    <!--<div class="help-block"> grams</div>-->  
												</div>
											</div><!-- exit panel body -->
										</div><!-- exit panel primary -->
										<div class="form-group">
										    <label class="col-lg-3 control-label">Phone Number / No Hp</label>
										    	<div class="col-md-6">
										    	  <input type="text" name="weight" placeholder="Input Phone Number..." id = "Kelurahan">
										    	</div>
										    <div class="help-block"> ex : +6281111111442</div> 
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">Email</label>
										    	<div class="col-md-6">
										    	  <input type="text" name="weight" placeholder="Input Phone Number..." id = "Email" value = "<?php echo $this->session->userdata('Email') ?>">
										    	</div>
										</div>
										<div class="form-group">
										    <label class="col-lg-3 control-label">School / Sekolah</label>
										    	<div class="col-md-6">
										    	  <select class="select2-select-00 col-md-12 full-width-fix" id="selectSchool">
										    	    <option value ="<?php echo $this->session->userdata('SchoolID') ?>" selected = "selected"><?php echo $this->session->userdata('SchoolName') ?></option>
										    	  </select>
										    	</div>
										</div>
									</div>
								</div>
							</div>
    					</div>
                	</div><!-- exit contain -->
                </div>
            </div>
        </div>  
    </section>
</div>

<script type="text/javascript">
  $(document).ready(function() {
  	  $('#FullName').prop('disabled', true);
  	  $('#Email').prop('disabled', true);
  	  $('#selectSchool').select2({
  	     //allowClear: true
  	  });
  	  
  	  console.log(selectSchool);
      loadDataFromServer();
      $("#Tgl_lahir").datepicker({
		    dateFormat: 'yy-mm-dd',
		});
  });

  $(document).on('keyup','#Alamat', function () {
  	var maxLength = 150;
  	var length = $(this).val().length;
  	var length = maxLength-length;
  	$('#chars').text(length);
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

    $(document).on('change','#NationalityWNI', function () {
		$("#pageSelectCountry").empty();
    });

    $(document).on('change','#selectProvinsi',function () {
        var selectProvinsi = $('#selectProvinsi').find(':selected').val();
        loadRegion(selectProvinsi);
    });

    $(document).on('change','#selectRegion',function () {
        var selectRegion = $('#selectRegion').find(':selected').val();
        loadKecamatan(selectRegion);
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
  	  setTimeout(function () {
  	      $('#NotificationModal').modal('hide');
  	  },1000);  
  }

	function loadCountry()
	{
		// provinsi
		  var url = base_url_js+'api/__getCountry';
		  $.get(url,function (data_json) {
		      for(var i=0;i<data_json.length;i++){
		          var selected = (i==0) ? 'selected' : '';
		          $('#selectNegara').append('<option value="'+data_json[i].ctr_code+'" '+selected+'>'+data_json[i].ctr_name+'</option>');
		      }
		      $('#selectNegara').select2({
		         //allowClear: true
		      });
		  })
		  $('#selectNegara').prop('disabled', true);
	}

  function loadDataProvRegionKecamatan()
  {
  	// provinsi
  	  var url = base_url_js+'api/__getProvinsi';
	  $.get(url,function (data_json) {
	      for(var i=0;i<data_json.length;i++){
	          var selected = (i==0) ? 'selected' : '';
	          $('#selectProvinsi').append('<option value="'+data_json[i].ProvinceID+'" '+selected+'>'+data_json[i].ProvinceName+'</option>');
	      }
	      $('#selectProvinsi').select2({
	         //allowClear: true
	      });

	      var selectProvinsi = $('#selectProvinsi').find(':selected').val();
	      loadRegion(selectProvinsi);
	  })
  }

  function loadRegion(selectProvinsi)
  {
  	  var url = base_url_js+'api/__getRegion';
  	  var data = {
  	            selectProvinsi : selectProvinsi
  	        };
  	  var token = jwt_encode(data,"UAP)(*");
  	  $('#selectRegion').empty()
	  $.post(url,{token:token},function (data_json) {
	      for(var i=0;i<data_json.length;i++){
	          var selected = (i==0) ? 'selected' : '';
	          $('#selectRegion').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
	      }
	      $('#selectRegion').select2({
	         //allowClear: true
	      });
	      var selectRegion = $('#selectRegion').find(':selected').val();
	      loadKecamatan(selectRegion);
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
	  	      						'<input type="checkbox" class = "chkJenisTempatTinggal" name="radio" value = "'+data_json[getRow].ID+'">&nbsp'+ data_json[getRow].JenisTempatTinggal+
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
	  	      						'<input type="checkbox" class = "chkAgama" name="radio" value = "'+data_json[getRow].IDReligion+'">&nbsp'+ data_json[getRow].Religion+
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
	  	      						'<input type="checkbox" class = "chkProStudy" name="radio" value = "'+data_json[getRow].ID+'">&nbsp'+ data_json[getRow].Name+
	  	      					 '</td>'
  	      						);
  	      		getRow++;
  	      	}
  	      	$('#a'+i).append('</tr>');
  	      }
  	      $('#tablechkProStudy').append('</table>');
  	  })
  }

</script>

