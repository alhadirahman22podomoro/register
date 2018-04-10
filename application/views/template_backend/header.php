
<style>
    .navbar .nav > li.current > a {
        background: #0f1f4b85;
    }
</style>

<!-- Header -->
<header class="header navbar navbar-fixed-top" role="banner">
    <!-- Top Navigation Bar -->
    <div class="container">

        <!-- Only visible on smartphones, menu toggle -->
        <ul class="nav navbar-nav">
            <li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="fa fa-reorder"></i></a></li>
        </ul>

        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo base_url(); ?>">
            <!-- <img src="<?php echo base_url('images/logo-hitam-putih.png'); ?>" alt="Podomoro University" style="width:130px;" /> -->
            <img src="<?php echo base_url('images/logo-header-color.png'); ?>" alt="Podomoro University" style="width:150px;" />
            <!-- <strong>Podomoro</strong> University -->
        </a>
        <!-- /logo -->

        <!-- Top Left Menu -->
        <ul class="nav navbar-nav navbar-left hidden-xs hidden-sm">
            <li class="<?php if($this->uri->segment(1)=='dashboard'){echo 'current';} ?>">
                <a href="<?php echo base_url('formulir-registration/'.$url); ?>">
                    <i class="icon-home"></i>
                    <span>Formulir</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('formulir-upload-document/'.$url); ?>">
                    <i class="fa fa-database" aria-hidden="true"></i>
                    <span>Upload Document</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('jadwal-ujian/'.$url); ?>">
                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                    <span>Exam Schedule</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('hasil-ujian/'.$url); ?>">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span>Exam Results</span>
                </a>
            </li>
        </ul>
        <!-- /Top Left Menu -->

        <!-- Top Right Menu -->
        <ul class="nav navbar-nav navbar-right">
            <!-- User Login Dropdown -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 8px;padding-bottom: 5px;">
                    <!--<img alt="" src="assets/img/avatar1_small.jpg" />-->
<!--                    <i class="fa fa-male"></i>-->
<!--                    <img src="--><?php //echo base_url('images/avatar.png'); ?><!--" class="img-circle" style="max-width: 35px;border: 3px solid #0f1f4b;"/>-->
                    <img data-src="http://siak.podomorouniversity.ac.id/includes/foto/<?php echo $this->session->userdata('Photo'); ?>"
                         class="img-circle img-fitter" width="35" height="35" style="max-width: 35px;border: 3px solid #0f1f4b;"/>
                    <span class="username"><?php echo $this->session->userdata('Name'); ?></span>
                    <i class="fa fa-caret-down small"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url('profile/Nandang-Mulyadi'); ?>">
                            <i class="fa fa-user"></i>
                            My Profile</a></li>
<!--                    <li><a href="pages_calendar.html"><i class="fa fa-calendar"></i> My Calendar</a></li>-->
<!--                    <li><a href="#"><i class="fa fa-tasks"></i> My Tasks</a></li>-->
                    <li class="divider"></li>
                    <li><a href="javascript:void(0)" id="useLogOut"><i class="fa fa-power-off"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- /user login dropdown -->
        </ul>
        <!-- /Top Right Menu -->
    </div>
    <!-- /top navigation bar -->

</header> <!-- /.header -->

<!-- Global Modal -->
<div class="modal fade" id="GlobalModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content animated jackInTheBox">
            <div class="modal-header"></div>
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Notification -->
<div class="modal fade" id="NotificationModal" role="dialog" style="top: 100px;">
    <div class="modal-dialog" style="width: 400px;" role="document">
        <div class="modal-content animated flipInX">
<!--            <div class="modal-header"></div>-->
            <div class="modal-body"></div>
<!--            <div class="modal-footer"></div>-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).on('click','#useLogOut',function () {
        $('#NotificationModal .modal-body').html('<div style="text-align: center;"><b>Log Me Out ?? </b> ' +
            '<button type="button" id="btnActionLogOut" class="btn btn-primary" style="margin-right: 5px;">Yes</button>' +
            '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>' +
            '</div>');
        $('#NotificationModal').modal('show');
    });

    $(document).on('click','#btnActionLogOut',function () {
        var url = base_url_js+"auth/logMeOut";
        loading_page('#NotificationModal .modal-body');
        $.post(url,function (result) {
            setTimeout(function () {
                window.location.href = base_url_js+'login';
            },2000);
        });
    });
</script>
