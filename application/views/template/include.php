<!--=== CSS ===-->

<!-- Bootstrap -->
<link href="<?php echo base_url('assets/template/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />

<!-- jQuery UI -->
<!--<link href="plugins/jquery-ui/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />-->
<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/>
<![endif]-->

<!-- Theme -->
<link href="<?php echo base_url('assets/template/css/main.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/template/css/plugins.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/template/css/responsive.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/template/css/icons.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/template/plugins/animate/animate.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/template/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php  echo base_url('assets/template/css/fontawesome/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/template/css/fontawesome4/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>">
<!--[if IE 7]>
<link rel="stylesheet" href="assets/css/fontawesome/font-awesome-ie7.min.css">
<![endif]-->

<!--[if IE 8]>
<link href="assets/css/ie8.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

<!-- Dari Adi -->
<link href="<?php echo base_url('assets/template/css/jotforms/formCss.css'); ?>" rel="stylesheet" type="text/css">
<link type="text/css" media="print" rel="stylesheet" href="<?php echo base_url('assets/template/css/jotforms/printForm.css'); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/template/css/jotforms/nova.css'); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/template/css/jotforms/566a91c2977cdfcd478b4567.css'); ?>">


<style media="screen">

    .project-switcher {
        background-color : #0f1f4b;
    }
    .dropdown-menu li a:hover {
        background: #0f1f4b;
    }

    #ui-datepicker-div {
        z-index : 1041 !important;
    }

    #sidebar ul#nav ul.sub-menu li.current a {
        color: #ffffff;
        background: #083f8882;
    }

    #sidebar ul#nav ul.sub-menu li.current a i {
        color: #ffffff;
    }

    #sidebar ul#nav > li.current {
        background: #083f8894;
    }

    #sidebar ul#nav > li.current > a {
        border-right: 10px solid #b30011;
    }

    #sidebar ul#nav > li.current > a , #sidebar ul#nav > li.current > a > .fa {
        color: #ffffff;
        text-shadow : none;
    }

    #sidebar ul#nav li a:hover {
        background: #083f8814;
    }

    .theme-dark #content {
        background-color : #ffffff;
    }


    /*Custom Button*/
    .btn-default-danger {
        background: #fff !important;
        color: #bd362f !important;;
        border: 1px solid #bd362f !important;;
    }

    .btn-default-danger:hover {
        background: #bd362f  !important;;
        color: #ffffff  !important;;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;

    }

    /* BTN SUCCESS */
    .btn-default-success {
        background: #fff  !important;;
        color: #51a351  !important;;
        border: 1px solid #51a351  !important;;
    }
    .btn-default-success:hover {
        background: #51a351  !important;;
        color: #ffffff  !important;;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;

    }
    .btn-default-success:hover .caret {
        border-top-color: #ffffff !important;
    }
    .btn-default-success .caret {
        border-top-color: #51a351 !important;
    }

    /* BTN SUCCESS CLOSE */

    .btn-default-primary {
        color: #3968c6  !important;;
        background: #ffffff !important;;
        border: 1px solid #3968c6 !important;;
    }
    .btn-default-primary:hover {
        background: #3968c6 !important;;
        color: #ffffff !important;;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;

    }

    /*.dropdown-menu {*/
        /*min-width: 100%;*/
    /*}*/

    .left-margin {
        margin-left: 5px;
    }

    .right-margin {
        margin-right: 5px;
    }

    .td-center, .th-center , .tr-center {
        text-align: center;
    }


    /* Untuk datatable */
    .filter-prodi {
        width: 250px;
        float: right;
        margin-right: 10px;
    }

</style>

<!--=== JavaScript ===-->

<script type="text/javascript" src="<?php echo base_url('assets/template/js/libs/jquery-1.10.2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/template/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/js/libs/lodash.compat.min.js'); ?>"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="assets/js/libs/html5shiv.js"></script>
<![endif]-->

<!-- Smartphone Touch Events -->
<!--
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/event.swipe/jquery.event.move.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/event.swipe/jquery.event.swipe.js"></script>
-->

<!-- General -->
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/libs/breakpoints.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/respond/respond.min.js"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/cookie/jquery.cookie.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/toastr/toastr.min.js"></script>

<!-- Page specific plugins -->
<!-- Charts -->
<!--[if lt IE 9]>
<script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/flot/jquery.flot.tooltip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/flot/jquery.flot.time.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/flot/jquery.flot.growraf.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/easy-pie-chart/jquery.easy-pie-chart.min.js"></script> -->

<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/daterangepicker/moment.min.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url('assets/template/'); ?><!--plugins/daterangepicker/moment_id.js"></script>-->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/blockui/jquery.blockUI.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/fullcalendar/fullcalendar.min.js"></script>

<!-- Noty -->
<!--<script type="text/javascript" src="--><?php //echo base_url('assets/template/'); ?><!--plugins/noty/jquery.noty.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url('assets/template/'); ?><!--plugins/noty/layouts/top.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url('assets/template/'); ?><!--plugins/noty/themes/default.js"></script>-->

<!-- DataTables -->
<!-- DataTables -->

<!--<script type="text/javascript" src="--><?php //echo base_url('assets/template/'); ?><!--plugins/datatables/jquery.dataTables.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/datatables/tes/jquery.dataTables.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url('assets/template/'); ?><!--plugins/datatables/tes/dataTables.bootstrap.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/datatables/tabletools/TableTools.min.js"></script> <!-- optional -->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/datatables/colvis/ColVis.min.js"></script> <!-- optional -->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/datatables/DT_bootstrap.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url('assets/template/'); ?><!--plugins/datatables/dataTables.rowReorder.js"></script>-->

<!-- Forms -->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/select2/select2.min.js"></script>

<!-- Pickers -->
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/pickadate/picker.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/pickadate/picker.date.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/pickadate/picker.time.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/'); ?>plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- App -->
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/app.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/plugins.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/plugins.form-components.js"></script>

<!-- Dual Box -->
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>plugins/duallistbox/jquery.duallistbox.min.js"></script>


<!-- Form Validation -->
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>plugins/validation/jquery.validate.min.js"></script>

<!-- IMG Fitter -->
<script type="text/javascript" src="<?php echo base_url('assets/');?>plugins/img-fitter/jquery.imgFitter.js"></script>



<!-- Demo JS -->
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/custom.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/demo/pages_calendar.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/demo/form_components.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/demo/charts/chart_filled_blue.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url('assets/template/');?>js/demo/charts/chart_simple.js"></script> -->

<!-- JWT Encode -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/');?>jwt/encode/hmac-sha256.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/');?>jwt/encode/enc-base64-min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/');?>jwt/encode/jwt.encode.js"></script>

<!-- JWT Decode -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/');?>jwt/decode/build/jwt-decode.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<!-- Custom -->
<script type="text/javascript">
    window.base_url_js = "<?php echo base_url(); ?>";
    window.sessionNIP = "<?php echo $this->session->userdata('NIP'); ?>";
    window.timePerCredits = "<?php echo $this->session->userdata('timePerCredits'); ?>";

    window.allowDepartementNavigation = [];

    window.daysEng = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    window.daysInd = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
    $(document).ready(function(){
        // "use strict";


        App.init(); // Init layout and core plugins
        Plugins.init(); // Init all plugins
        FormComponents.init(); // Init all form-specific plugins

        $('.img-fitter').imgFitter({

            // CSS background position
            backgroundPosition: 'center center',

            // for image loading effect
            fadeinDelay: 400,
            fadeinTime: 1200

        });

    });

    $.fn.extend({
        animateCss: function (animationName, callback) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
                if (callback) {
                    callback();
                }
            });
            return this;
        }
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    function loading_page(element) {
        $(''+element).html('<div class="row">' +
            '<div class="col-md-12" style="text-align: center;">' +
            '<h3 class="animated flipInX"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> <span>Loading page . . .</span></h3>' +
            '</div>' +
            '</div>');
    }

    function loading_text(element) {
        $(element).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading...');
    }

    function loading_button(element) {
        $(''+element).html('<i class="fa fa-refresh fa-spin fa-fw right-margin"></i> Loading...');
        $(''+element).prop('disabled',true);
    }

    function loading_buttonSm(element) {
        $(''+element).html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
        $(''+element).prop('disabled',true);
    }

    function convertDateMMtomm(mounth) {
        var arr_mounth = {
            'January': 0,
            'February': 1,
            'March': 2,
            'April': 3,
            'May': 4,
            'June': 5,
            'July': 6,
            'August': 7,
            'September': 8,
            'October': 9,
            'November': 10,
            'December': 11,
        }

        return arr_mounth[mounth];
    }

    function dateTimeNow() {
        return moment().format('YYYY-MM-DD HH:mm:ss');
    }

    function dateNow()
    {
        return moment().format('YYYY-MM-DD');
    }

    function log(data) {
        console.log(data);
    }

    function loadSelectOptionProgramCampus(element,selected) {
        var url = base_url_js+'api/__crudProgramCampus';
        var token = jwt_encode({action:'read'},'UAP)(*');
        $.post(url,{token:token},function (data_json) {
            if(data_json.length>0){
                var option = $(element);
                for(var i=0;i<data_json.length;i++){
                    selected = (selected==data_json[i].ID) ? 'selected' : '';
                    option.append('<option value="'+data_json[i].ID+'" '+selected+'>'+data_json[i].Name+'</option>');
                }
            }
        });
    }

    function loadSelectOptionBaseProdi(element,selected) {
        var url = base_url_js+"api/__getBaseProdiSelectOption";
        $.get(url,function (data) {
            for(var i=0;i<data.length;i++){
                var selc = (data[i].ID==selected) ? 'selected' : '';
                $(''+element).append('<option value="'+data[i].ID+'.'+data[i].Code+'" '+selc+'>'+data[i].NameEng+'</option>');
            }
        });
    }

    function loadSelectOptionBaseProdiAll(element,selected) {
        var url = base_url_js+"api/__getBaseProdiSelectOptionAll";
        $.get(url,function (data) {
            for(var i=0;i<data.length;i++){
                var selc = (data[i].ID==selected) ? 'selected' : '';
                $(''+element).append('<option value="'+data[i].ID+'.'+data[i].Code+'" '+selc+'>'+data[i].NameEng+'</option>');
            }
        });
    }



    function loadSelectOptionEducationLevel(element,selected) {
        var url = base_url_js+"api/__geteducationLevel";
        $.get(url,function (data) {
            for(var i=0;i<data.length;i++){
                var selc = (data[i].ID==selected) ? 'selected' : '';
                $(''+element).append('<option value="'+data[i].ID+'" '+selc+'>'+data[i].Name+'</option>');
            }
        });
    }

    $(document).on('click','button[data-toggle=collapse]',function () {
        var cl = $(this).attr("class").split(" ");

        if($.inArray('btn-danger',cl)==1){
            $(this).removeClass('btn-danger');
            $(this).addClass('btn-info');
            $(this).children().removeClass('fa-minus-circle');
            $(this).children().addClass('fa-plus-circle');
        } else {
            $(this).addClass('btn-danger');
            $(this).removeClass('btn-info');
            $(this).children().addClass('fa-minus-circle');
            $(this).children().removeClass('fa-plus-circle');
        }

    });

    function errorInput(element) {
        $(element).css('border','1px solid red');
        setTimeout(function () {
            $(element).css('border','1px solid #cccccc');
        },5000);

        return false;
    }


</script>
