<div class="container">
    <header>
        <h1>Registration Form</h1>
    </header>
    <section>       
        <div id="container_demo" >
            <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>
            <div id="wrapper">
                <div id="login" class="animate form">
                    <div align = "center">
                      <img src="<?php echo base_url('images/logo_tr.png'); ?>" alt="Podomoro University" /> 
                    </div>
                    <br>
                    <p> 
                        <label for="firstname" class="uname" >Firstname</label>
                        <input id="firstname" name="username" required="required" type="text" placeholder="Your Firstname"/>
                    </p>
                    <p> 
                        <label for="lastname" class="uname" > Lastname</label>
                        <input id="lastname" name="username" required="required" type="text" placeholder="Your Lastname"/>
                    </p>
                    <p> 
                        <label class="youpasswd"> Email </label>
                        <input id="regEmail" name="password" required="required" type="email" placeholder="myusername or mymail@mail.com" /> 
                    </p>
                    <p> 
                        <label for="password" class="youpasswd"> Region :  </label>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-8">
                              <select class="select2-select-00 col-md-12 full-width-fix" id="selectWilayah">
                                <option></option>
                              </select>
                            </div>
                          </div> <!--.row -->
                        </div>        
                    </p>
                    <p> 
                        <label for="password" class="youpasswd"> School Name : </label>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-12">
                                <select class="select2-select-00 col-md-12 full-width-fix" id="schoolName">
                                  <option></option>
                                </select>
                              </div>
                            </div> <!--.row -->
                          </div>
                    </p>
                    <p class="signin button"> 
                      <button class="btn btn-inverse btn-notification" id="sbmt-reg">Register</button>
                    </p>
                </div>
            </div>
        </div>  
    </section>
</div>
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

    $(document).on('click','#sbmt-reg',function () {
      loading_button('#sbmt-reg');
        var momentUnix = moment().unix();
        var url = base_url_js + 'register/proses-register';
        var firstname =$("#firstname").val().trim();
        var lastname =$("#lastname").val().trim();
        var regEmail = $("#regEmail").val().trim();
        var region = $('#selectWilayah').val();
        var schoolName = $('#schoolName').val();
        var data = {
          Firstname : firstname,
          Lastname : lastname,
          Email : regEmail,
          SchoolName : schoolName,
          momentUnix : momentUnix
        };
        var token = jwt_encode(data,"UAP)(*");
        var validationInput =validation(data);
        if (validationInput) {
            $.post(url,{token:token},function (data_json) {
              var response = jQuery.parseJSON(data_json);
              if (response.errorMSG == "") {
                if (response.statusEmail == 0) {
                  toastr.error(response.msgEmail, 'Failed!!');
                }
                else
                {
                  toastr.options.fadeOut = 10000;
                  toastr.success("Please check your email <br>" + response.statusDB, 'Success!');
                }
                console.log(data_json);
                moveTab();
              }
              else
              {
                toastr.error(response.errorMSG, 'Failed!!');
              }
              $('#sbmt-reg').prop('disabled',false).html('Register');
            })
        }
        else
        {
          $('#sbmt-reg').prop('disabled',false).html('Register');
        }
    });
});

function moveTab()
{
  var element = $("#tablogin a");
  element.parent().addClass('active');
  $("#tabsignup a").parent().removeClass('active');
  target = element.attr('href');
  $('.tab-content > div').not(target).hide();
  $(target).fadeIn(600);
}

function validation(arr)
{
  var toatString = "";
  var result = "";
  for(var key in arr) {
     switch(key)
     {
      case  "SchoolName" :
      case  "Lastname" :
            break;
      case  "Email" :
            result = Validation_email(arr[key],key);
            if (result['status'] == 0) {
              toatString += result['messages'] + "<br>";
            }
            break;
      default :
            result = Validation_leastCharacter(3,arr[key],key);
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
    },1000);

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
  $('#schoolName').empty()
  $.post(url,{token:token},function (data_json) {
        for(var i=0;i<data_json.length;i++){
            var selected = (i==0) ? 'selected' : '';
            //var selected = (data_json[i].RegionName=='Kota Jakarta Pusat') ? 'selected' : '';
            $('#schoolName').append('<option value="'+data_json[i].ID+'" '+selected+'>'+data_json[i].SchoolName+'</option>');
        }
        $('#schoolName').select2({
           //allowClear: true
        });
  })

}
</script>

