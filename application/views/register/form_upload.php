<div class="container">
    <header>
        <h1>Upload Proof of Payment</h1>
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
                    <div id ="msgSuccess">
                      <p> 
                          <label for="firstname" class="uname" >Name</label>
                          <input id="firstname" name="Name" required="required" type="text" placeholder="Name" value="<?php echo $this->session->userdata('Name') ?>" disabled />
                      </p>
                      <p> 
                          <label class="youpasswd"> Email </label>
                          <input id="regEmail" name="email" required="required" type="email" placeholder="myusername or mymail@mail.com" value = "<?php echo $this->session->userdata('Email') ?>" disabled /> 
                      </p>
                      <p> 
                          <label class="youpasswd"> Upload File </label>
                          <input type="file" id="uploadFile" name="uploadfile">
                      </p>
                      <p class="signin button"> 
                        <button class="btn btn-inverse btn-notification" id="sbmt-reg">Submit</button>
                      </p>
                    </div>
                </div>
            </div>
        </div>  
    </section>
</div>

<script type="text/javascript">
  $(document).ready(function() {
      $(document).on('click','#sbmt-reg',function () {
        var Validation = file_validation();
        if (Validation) {
          processData();
        }
        
      });
  });

  function file_validation()
  {
      var name = document.getElementById("uploadFile").files[0].name;
      var ext = name.split('.').pop().toLowerCase();
      if(jQuery.inArray(ext, ['png','jpg','jpeg']) == -1) 
      {
        toastr.error("Invalid Image File", 'Failed!!');
        return false;
      }
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("uploadFile").files[0]);
      var f = document.getElementById("uploadFile").files[0];
      var fsize = f.size||f.fileSize;
      if(fsize > 500000) // 500kb
      {
       toastr.error("Image File Size is very big", 'Failed!!');
       return false;
      }

      return true;
  }

  function processData()
  {
    var form_data = new FormData();
    var fileData = document.getElementById("uploadFile").files[0];
    var url = base_url_js + "register/formupload_submit";
    form_data.append("fileData", fileData);
    loading_button('#sbmt-reg');
    $.ajax({
      type:"POST",
      url:url,
      data: form_data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false,       // The content type used when sending data to the server.
      cache: false,             // To unable request pages to be cached
      processData:false,
      dataType: "json",
      success:function(data)
      {
        if(data.status == 1) {
           toastr.options.fadeOut = 100000;
           toastr.success(data.msg, 'Success!');
           $("#msgSuccess").empty();
           $("#msgSuccess").html('<p><strong style="color: green;">This process has done</strong></p><p><strong style="color: green;">We check first your payment receipt </strong></p>' + 
            '<p><strong style="color: green;">We will inform to you as soon by email</strong></p>');
        }
        else  {
            toastr.options.fadeOut = 100000;
            toastr.error(data.msg, 'Failed!!');
        }  
        $('#sbmt-reg').prop('disabled',false).html('Submit');

      },
      error: function (data) {
        toastr.error("Connection Error, Please try again", 'Error!!');
        $('#sbmt-reg').prop('disabled',false).html('Submit');  
      }
    })
  } 

</script>

