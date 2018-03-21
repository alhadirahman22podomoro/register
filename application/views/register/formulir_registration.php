<style type="text/css">
	.pageContain{
		border-style: solid;
		border-color: red;
	}
	.row {
	    margin-right: 0px;
	    margin-left: 0px;
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
						   <div class= "judul">Formulir Pendaftaran Mahasiswa Baru</div>
    					</div>
    					<br>
    					<div class = row>
    						<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">Study Program / Program Studi</h3>
								</div>
								<div class="panel-body">
									<div class="col-md-8">
										<select class="select2-select-00 col-md-8 full-width-fix" id="program_study">
		                                  <option></option>
	                                	</select>
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
      loadDataSelectOption();
  });

  function loadDataSelectOption()
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
  	  setTimeout(function () {
  	      $('#NotificationModal').modal('hide');
  	  },1000);  
  }

  function loadDataProgram_study()
  {
  	  var url = base_url_js+'api/__getProgramStudy';
  	  $.get(url,function (data_json) {
  	      for(var i=0;i<data_json.length;i++){
  	          var selected = (i==0) ? 'selected' : '';
  	          //var selected = (data_json[i].RegionName=='Kota Jakarta Pusat') ? 'selected' : '';
  	          $('#program_study').append('<option value="'+data_json[i].ID+'" '+selected+'>'+data_json[i].Name+'</option>');
  	      }
  	      $('#program_study').select2({
  	         //allowClear: true
  	      });
  	      var selectWilayah = $('#program_study').find(':selected').val();
  	  })
  }

</script>

