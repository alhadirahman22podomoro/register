<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link href="<?php echo base_url('assets/template/css/custom/style.css'); ?>" rel="stylesheet" type="text/css">
<style type="text/css">
	.lblcustom{
		color: rgba(9, 0, 0, 0.5);
	}
</style>
<div class="col-md-8">
	<!--<div class="page-header">
		<div class="page-title">
			<h3>Register</h3>
		</div>
		<ul class="page-stats">
			<li>
				<div class="summary">
					<h4 class = "tanggal"></h3>
				</div>
			</li>
		</ul>
	</div>-->
	<div class="form">
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      <div class="tab-content">
        <div id="signup">   
          <h1>Form Register</h1>
          <div class="top-row">
            <div class="field-wrap">
              <label class = "lblcustom">
                First Name<span class="req">*</span>
              </label>
              <input required="" autocomplete="off" type="text">
            </div>
         
            <div class="field-wrap">
              <label class = "lblcustom">
                Last Name<span class="req">*</span>
              </label>
              <input required="" autocomplete="off" type="text">
            </div>
          </div>
          <div class="field-wrap">
            <label class = "lblcustom">
              Email Address<span class="req">*</span>
            </label>
            <input required="" autocomplete="off" type="email">
          </div>
          <hr>
		  <p style="color: white;font-weight: bold;">Region : </p>
	      	<div class="form-group">
				<div class="row">
					<div class="col-md-8">
						<select class="select2-select-00 col-md-12 full-width-fix" id="selectWilayah">
							<option></option>
						</select>
					</div>
				</div> <!--.row -->
			</div>							
          <p style="color: white;font-weight: bold;">School Name : </p>
	      	<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<select class="select2-select-00 col-md-12 full-width-fix" id="schoolName">
							<option></option>
						</select>
					</div>
				</div> <!--.row -->
			</div>
			<hr>			
          <button type="button" class="button button-block">Register</button>
        </div>
        <div id="login">   
          <h1>Welcome Back!</h1>
            <div class="field-wrap">
            <label class = "lblcustom">
              Email Address<span class="req">*</span>
            </label>
            <input required="" autocomplete="off" type="email">
          </div>
          
          <div class="field-wrap">
            <label class = "lblcustom">
              Password<span class="req">*</span>
            </label>
            <input required="" autocomplete="off" type="password">
          </div>
          <button class="button button-block">Log In</button>
          	<!-- Single-Sign-On (SSO) -->
			    <div class="single-sign-on">
			        <div align = "center"><span style="color: white;">OR</span></div>
			        <a href="<?php //echo $loginURL; ?>" class="btn btn-google-plus btn-block">
			            <i class="icon-google-plus"></i> Sign in with Google
			        </a>
			    </div>
    		<!-- /Single-Sign-On (SSO) -->
        </div>
        
      </div><!-- tab-content -->
      
	</div>
</div> <!-- exit div col-md-8 -->

<div class="col-md-4">

</div>
<script  src="<?php echo base_url('assets/template/'); ?>js/custom/index.js"></script>	
<script type="text/javascript">
$(document).ready(function() {
    //$('.tanggal').html(moment().format('dddd, Do MMM YYYY h:mm:ss A'));
    var interval = setInterval(function() {
        var momentNow = moment();
        $('.tanggal').html(moment().format('dddd, Do MMM YYYY h:mm:ss A'));
    }, 100);

    loadDataSelectOption();
    $(document).on('change','#selectWilayah',function () {
        loadDataSchool(this.value);
    });


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

    loadData();
    //loadDataSchool();
    setTimeout(function () {
        $('#NotificationModal').modal('hide');
    },2000);

}


function loadData()
{
	var url = base_url_js+'api/__getWilayahURLJson';
    $.get(url,function (data_json) {
        for(var i=0;i<data_json.length;i++){
            //var selected = (i==0) ? 'selected' : '';
            var selected = (data_json[i].RegionName=='Kota Jakarta Pusat') ? 'selected' : '';
            $('#selectWilayah').append('<option value="'+data_json[i].RegionID+'" '+selected+'>'+data_json[i].RegionName+'</option>');
        }
        $('#selectWilayah').select2({
           allowClear: true
        });
        var selectWilayah = $('#selectWilayah').find(':selected').val();
        loadDataSchool(selectWilayah);
    }).done(function () {
        //pageTableSchool();
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
	$.post(url,{token:token},function (data_json) {
        for(var i=0;i<data_json.length;i++){
            var selected = (i==0) ? 'selected' : '';
            //var selected = (data_json[i].RegionName=='Kota Jakarta Pusat') ? 'selected' : '';
            $('#schoolName').append('<option value="'+data_json[i].ID+'" '+selected+'>'+data_json[i].SchoolName+'</option>');
        }
        $('#schoolName').select2({
           allowClear: true
        });
    })

}
</script>