
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
        <a class="navbar-brand" href="http://podomorouniversity.ac.id">
            <!-- <img src="<?php echo base_url('images/logo-hitam-putih.png'); ?>" alt="Podomoro University" style="width:130px;" /> -->
            <img src="<?php echo base_url('images/logo-header-color.png'); ?>" alt="Podomoro University" style="width:150px;" />
            <!-- <strong>Podomoro</strong> University -->
        </a>
        <!-- /logo -->
        <!--<ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="project-switcher-btn dropdown-toggle">
                    <i class="icon-folder-open"></i>
                    <span>Register</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="project-switcher-btn dropdown-toggle">
                    <i class="fa fa-circle"></i>
                    <span>Sign in</span>
                </a>
            </li>
        </ul>-->    
    </div>
    <!-- /top navigation bar -->

    <?php //echo $page_departement; ?>

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
