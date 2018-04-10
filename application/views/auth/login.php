
<link href="<?php echo base_url('assets/template/css/login.css'); ?>" rel="stylesheet" type="text/css" />
<!-- App -->
<script type="text/javascript" src="<?php echo base_url('assets/template/js/login.js'); ?>"></script>
<script>
    $(document).ready(function(){
        "use strict";
        Login.init(); // Init login JavaScript
    });
</script>
<style>
    body {
        /*background: url('*/<?php //echo base_url('images/bg.jpg'); ?>/*');*/
        background-color: #f9f9f9;
    }
</style>
<div class="login" style="background: none;">
    <!-- /Logo -->

    <!-- Login Box -->
    <div class="box">
        <div class="content">
            <!-- Login Formular -->
            <div class="logo">
                <img src="<?php echo base_url('images/logo.png'); ?>" style="width: 200px;" alt="logo" />

            </div>
            <!-- Title -->
            <h3 class="form-title">Sign In to your Portal</h3>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <!--                    <label class="checkbox pull-left"><input type="checkbox" class="uniform" name="remember"> Remember me</label>-->
                <a href="<?php echo $loginURL; ?>" class="btn btn-google-plus btn-block">
                            <i class="icon-google-plus"></i> Sign in with Google
                </a>
            </div>

            <!-- /Login Formular -->

        </div> <!-- /.content -->
    </div>
    <!-- /Login Box -->

    <script>

        $(document).ready(function () {
            window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
            var pc = new RTCPeerConnection({iceServers:[]}), noop = function () {};
            pc.createDataChannel("");
            pc.createOffer(pc.setLocalDescription.bind(pc),noop);
            pc.onicecandidate = function (ice) {
                if(!ice || !ice.candidate || !ice.candidate.candidate) return;
                var myIPc = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate);
                var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];

                console.log(myIPc);


                $.getJSON("//freegeoip.net/json/?callback=?", function (data) {
                    console.log(data);
                    // alert('Local IP : '+myIP +' | Public IP : '+data.ip);

                });

                pc.onicecandidate = noop;
            }
        });

        $('#login_btn').click(function(){
            sendAuth();
        });

        $('.form-login').keypress(function (e) {

            if (e.which == 13) {
                sendAuth();
                return false;    //<---- Add this line
            }
        });

        function sendAuth() {
            var nip = ($('#nip').val()!='') ? $('#nip').val() :
                $('#nip').css('border', '1px solid red').animateCss('shake');

            var password = ($('#password').val()!='')? $('#password').val() :
                $('#password').css('border','1px solid red').animateCss('shake');

            setTimeout(function () {
                $('.form-login').css('border','1px solid #ccc');
            },3000);

            if($('#nip').val()!='' && $('#password').val()!=''){

                loading_button('#login_btn');
                $('.form-login').prop('disabled',true);

                var url = base_url_js+"uath/authUserPassword";
                var data = {
                    nip : nip,
                    password : password
                };

                var token = jwt_encode(data,'L06M31N');
                $.post(url,{token:token},function (result) {
                    var res = result.trim();

                    setTimeout(function () {
                        if(res==1){
                            toastr.success('Logged In TRUE', 'Success!!');
                            window.location.href = base_url_js+'dashboard';
                        } else {
                            $('.box').animateCss('shake');
                            toastr.error('NIK and Password not match', 'Error!!');
                            // $('.form-login').val('');
                            $('.form-login').css('border','1px solid red');
                            setTimeout(function () {
                                $('.form-login').css('border','1px solid #ccc');
                            },5000);
                        }
                        $('#login_btn').html('Sign In <i class="icon-angle-right" style="margin-left: 5px;"></i>');
                        $('.form-login,#login_btn').prop('disabled',false);

                    },2000);

                });
            }
        }
    </script>



</div>