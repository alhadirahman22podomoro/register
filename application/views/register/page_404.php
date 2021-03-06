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
    #block_error{
            margin-left: 10px;
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
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="<?php echo base_url().'formulir-registration-edit/'.$url ?>">Formulir</a>
                        </li>
                        <li class="current">
                            <a href="<?php echo base_url().'formulir-upload-document/'.$url ?>">Upload Document</a>
                        </li>
                                <li class="current">
                            <a href="<?php echo base_url().'jadwal-ujian/'.$url ?>" title="">Exam Schedule</a>
                        </li>
                        <li class="current">
                            <a href="<?php echo base_url().'hasil-ujian/'.$url ?>" title="">Exam Results</a>
                        </li>
                    </ul>
                    <div class = "pageContain">
                        <div id="block_error" >
                                <div>
                                 <h2>Error 404. &nbspOops you've have encountered an error</h2>
                                <p>
                                It apperrs that Either something went wrong or the page doesn't exist anymore..<br />
                                This website is temporarily unable to service your request as it has exceeded it’s resource limit. Please check back shortly.
                                </p>
                                <p>
                                Click to Home <a href="<?php echo base_url() ?>">Home</a>.
                                If you have any questions, please contact our Technical Support (it@podomorouniversity.ac.id) department.
                                </p>
                                </div>
                        </div>
                    </div><!-- exit contain -->
                </div>
            </div>
        </div>  
    </section>
</div>
