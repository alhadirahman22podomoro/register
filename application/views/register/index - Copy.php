<style type="text/css">
	.form-label-left{
        width:150px;
    }
    .form-line{
        padding-top:12px;
        padding-bottom:12px;
    }
    .form-label-right{
        width:150px;
    }
    body, html{
        margin:0;
        padding:0;
        background:#fff;
    }

    .form-all{
        margin:0px auto;
        padding-top:0px;
        width:690px;
        color:#555 !important;
        font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Verdana, sans-serif;
        font-size:14px;
    }
    .form-radio-item label, .form-checkbox-item label, .form-grading-label, .form-header{
        color: false;
    }
</style>
<style type="text/css" id="form-designer-style">
    /* Injected CSS Code */
/*PREFERENCES STYLE*/
    .form-all {
      font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Verdana, Tahoma, sans-serif, sans-serif;
    }
    .form-all .qq-upload-button,
    .form-all .form-submit-button,
    .form-all .form-submit-reset,
    .form-all .form-submit-print {
      font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Verdana, Tahoma, sans-serif, sans-serif;
    }
    .form-all .form-pagebreak-back-container,
    .form-all .form-pagebreak-next-container {
      font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Verdana, Tahoma, sans-serif, sans-serif;
    }
    .form-header-group {
      font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Verdana, Tahoma, sans-serif, sans-serif;
    }
    .form-label {
      font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Verdana, Tahoma, sans-serif, sans-serif;
    }
  
    .form-label.form-label-auto {
      
    display: inline-block;
    float: left;
    text-align: left;
  
    }
  
    .form-line {
      margin-top: 12px 36px 12px 36px px;
      margin-bottom: 12px 36px 12px 36px px;
    }
  
    .form-all {
      width: 590px;
    }
  
    .form-label-left,
    .form-label-right,
    .form-label-left.form-label-auto,
    .form-label-right.form-label-auto {
      width: 75px;
    }
  
    .form-all {
      font-size: 14pxpx
    }
    .form-all .qq-upload-button,
    .form-all .qq-upload-button,
    .form-all .form-submit-button,
    .form-all .form-submit-reset,
    .form-all .form-submit-print {
      font-size: 14pxpx
    }
    .form-all .form-pagebreak-back-container,
    .form-all .form-pagebreak-next-container {
      font-size: 14pxpx
    }
  
    .supernova .form-all, .form-all {
      background-color: ;
      border: 1px solid transparent;
    }
  
    .form-all {
      color: Black;
    }
    .form-header-group .form-header {
      color: Black;
    }
    .form-header-group .form-subHeader {
      color: Black;
    }
    .form-label-top,
    .form-label-left,
    .form-label-right,
    .form-html,
    .form-checkbox-item label,
    .form-radio-item label {
      color: Black;
    }
    .form-sub-label {
      color: 1a1a25;
    }
  
    .supernova {
      background-color: undefined;
    }
    .supernova body {
      background: transparent;
    }
  
    .form-textbox,
    .form-textarea,
    .form-radio-other-input,
    .form-checkbox-other-input,
    .form-captcha input,
    .form-spinner input {
      background-color: undefined;
    }
  
    .supernova {
      background-image: none;
    }
    #stage {
      background-image: none;
    }
  
    .form-all {
      background-image: none;
    }
  
  .ie-8 .form-all:before { display: none; }
  .ie-8 {
    margin-top: auto;
    margin-top: initial;
  }
  
  /*PREFERENCES STYLE*//*__INSPECT_SEPERATOR__*/
    /* Injected CSS Code */
</style>
<div class="col-md-8">
	<div class="page-header">
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
	</div>
	<div class="widget box">
		<div class="widget-header">
			<h4><i class="icon-reorder"></i> Form Registration</h4>
		</div>
		<div class="widget-content">
			<div class="form-horizontal row-border">
				<div class="form-group">
					<label class="col-md-2 control-label">Name:</label>
					<div class="col-md-10"><input type="text" name="regular" class="form-control"></div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">Multiple inputs:</label>
					<div class="col-md-10">
						<div class="row">
							<div class="col-md-4">
								<input type="text" name="regular" class="form-control"><span class="help-block">Left aligned helper</span>
							</div>
							<div class="col-md-4">
								<input type="text" name="regular" class="form-control"><span class="help-block align-center">Centered helper</span>
							</div>
							<div class="col-md-4">
								<input type="text" name="regular" class="form-control"><span class="help-block align-right">Right aligned helper</span>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">Predefined width:</label>
					<div class="col-md-10">
						<input class="form-control input-width-mini" type="text" placeholder=".input-width-mini" style="display: block;">
						<input class="form-control input-width-small" type="text" placeholder=".input-width-small" style="display: block; margin-top: 6px;">
						<input class="form-control input-width-medium" type="text" placeholder=".input-width-medium" style="display: block; margin-top: 6px;">
						<input class="form-control input-width-large" type="text" placeholder=".input-width-large" style="display: block; margin-top: 6px;">
						<input class="form-control input-width-xlarge" type="text" placeholder=".input-width-xlarge" style="display: block; margin-top: 6px;">
						<input class="form-control input-width-xxlarge" type="text" placeholder=".input-width-xxlarge" style="display: block; margin-top: 6px;">
						<input class="form-control input-block-level" type="text" placeholder=".input-block-level" style="display: block; margin-top: 6px;">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">Select:</label>
					<div class="col-md-10">
						<div class="row">
							<div class="col-md-4">
								<select class="form-control" name="select">
									<option value="opt1">col-md-4</option>
									<option value="opt2">Option 2</option>
									<option value="opt3">Option 3</option>
								</select>
							</div>
						</div> <!--.row -->

						<div class="row next-row">
							<div class="col-md-6">
								<select class="form-control" name="select">
									<option value="opt1">col-md-6</option>
									<option value="opt2">Option 2</option>
									<option value="opt3">Option 3</option>
								</select>
							</div>
						</div> <!--.row -->

						<div class="row next-row">
							<div class="col-md-8">
								<select class="form-control" name="select">
									<option value="opt1">col-md-8</option>
									<option value="opt2">Option 2</option>
									<option value="opt3">Option 3</option>
								</select>
							</div>
						</div> <!--.row -->

						<div class="row next-row">
							<div class="col-md-12">
								<select class="form-control" name="select">
									<option value="opt1">col-md-12</option>
									<option value="opt2">Option 2</option>
									<option value="opt3">Option 3</option>
								</select>
							</div>
						</div> <!--.row -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- exit div col-md-8 -->

<div class="col-md-4">

</div>	
<script type="text/javascript">
$(document).ready(function() {
    //$('.tanggal').html(moment().format('dddd, Do MMM YYYY h:mm:ss A'));
    var interval = setInterval(function() {
        var momentNow = moment();
        $('.tanggal').html(moment().format('dddd, Do MMM YYYY h:mm:ss A'));
    }, 100);

});
</script>