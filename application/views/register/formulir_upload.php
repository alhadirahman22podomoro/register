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

  /* Button Upload */
  input[type="file"] {
      display: none;
  }
  .custom-file-upload {
      border: 1px solid #ccc;
      display: inline-block;
      padding: 3px 3px;
      cursor: pointer;
  } 

  .table thead {
      background: #d91f2d;
      color: #fff;
  }

 </style>
<!-- <link rel="stylesheet" href="<?php  echo base_url('assets/custom/style/fixed_header_tables.css'); ?>"> -->
<div class="container">
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
               <div class= "judul">New Student Registration Form / Formulir Pendaftaran Mahasiswa Baru</div>
              </div>
              <br>
              <div class = row>
                <div class="panel panel-primary">
                  <div class="panel-heading" style="border-radius: 0px;">
                    <h3 class="panel-title">Download Your Data<span class="required">*</span></h3>
                  </div>
                  <div class="panel-body">
                    <!-- content -->
                    <div class="form-horizontal">
                      <div class="form-group">
                        <div class = "col-md-3">
                          <!-- <label class="control-label">Formulir </label> -->
                            <!-- <div class="col-md-3"> -->
                              <button class="ng-button" id="btn-dwnformulir" data-sbmt = "<?php echo $this->session->userdata('ID_register_formulir') ?>">Formulir</button> 
                            <!-- </div> -->
                        </div>
                        <div class = "col-md-3">
                          <!-- <label class="control-label">Admission Statement </label> -->
                            <!-- <div class="col-md-3"> -->
                              <button class="ng-button" id="btn-dwnadmss" data-sbmt = "<?php echo $this->session->userdata('ID_register_formulir') ?>">Admission Statement</button> 
                            <!-- </div> -->
                        </div>
                        <div class = "col-md-4">
                          <!-- <label class="control-label">Admission Statement </label> -->
                            <!-- <div class="col-md-3"> -->
                              <button class="ng-button" id="btn-dwnBebasNarkoab" data-sbmt = "<?php echo $this->session->userdata('ID_register_formulir') ?>">Surat Pernyataan Bebas Narkoba</button> 
                            <!-- </div> -->
                        </div>
                      </div>
                      <div class="form-group">   
                        <div class = "col-md-5">
                          <!-- <label class="control-label">Admission Statement </label> -->
                            <!-- <div class="col-md-3"> -->
                              <button class="ng-button" id="btn-dwnformulir" data-sbmt = "<?php echo $this->session->userdata('ID_register_formulir') ?>">Surat Pernyataan Kesanggupan Kelengkapan STTB</button> 
                            <!-- </div> -->
                        </div>
                        <div class = "col-md-5">
                          <!-- <label class="control-label">Admission Statement </label> -->
                            <!-- <div class="col-md-3"> -->
                              <button class="ng-button" id="btn-dwnformulir" data-sbmt = "<?php echo $this->session->userdata('ID_register_formulir') ?>">Surat Pernyataan Kesanggupan Kelengkapan Dokument</button> 
                            <!-- </div> -->
                        </div>
                      </div>  
                    </div>    
                  </div>
                </div>
              </div>
              <div class = row>
                <div class="panel panel-primary">
                  <div class="panel-heading" style="border-radius: 0px;">
                    <h3 class="panel-title">Upload Your Dokument <span class="required">*</span></h3>
                  </div>
                  <div class="panel-body">
                    <div class = "col-md-3">Description Status : </div>
                    <div class = "col-md-3"><i class="fa fa-check-circle" style="color: green;"></i> Done</div>
                    <div class = "col-md-3"><i class="fa fa-circle-o-notch fa-spin" style="color: green;"></i> Progress</div>
                    <div class = "col-md-3"><i class="fa fa-minus-circle" style="color: red;"></i> Not Yet Uploaded / Reject</div>
                    <!-- content -->
                    <br><br>
                    <div id = "pageUploadDokument"></div>
                  </div>
                </div>
              </div>
          </div>
        </div>  
      </div>  
    </div>  
  </section>
</div>  

<script type="text/javascript">
  $(document).ready(function() {
      CheckDataInjected();
      //loadDataDokument();
  });

  function CheckDataInjected()
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

    var url = base_url_js+'checkDocument';
    $.get(url,function (data_json) {

    }).done(function() {
            /*setTimeout(function () {
                $('#NotificationModal').modal('hide');
            },500);*/
            loadDataDokument();
    });
  }

  function loadDataDokument()
  {
    var url = base_url_js+'getDataDokument';
    $("#pageUploadDokument").empty();
    $.post(url,function (data_json) {
        var response = jQuery.parseJSON(data_json);
        //console.log(response.length);
        //table class="points_table
        $('#pageUploadDokument').append('<div class="table-responsive"><table class="table" id ="tablechkDokument">'+
                                         '<thead>'+
                                           '<tr>'+
                                              '<th class="col-xs-1">No</th>'+
                                              '<th class="col-xs-3">Document</th>'+
                                              '<th class="col-xs-1">Required</th>'+
                                              '<th class="col-xs-2">&nbsp&nbsp Action</th>'+
                                              '<th class="col-xs-1">Status</th>'+
                                              '<th class="col-xs-1">Attachment</th>'+
                                              '<th class="col-xs-1">Description</th>'+
                                           '</tr>'+
                                          '</thead>'+
                                          '<tbody id = "isiData" class="points_table_scrollbar">' 

                                       );
          var Nomor = 1;

          for (var k = 0; k < response.length; k++) {
            var setODDEven = Nomor % 2;
            var setRow = 'odd';
            var setIcon = '<i class="fa fa-minus-circle" style="color: red;"></i>';
            if (setODDEven == 0) {
              setRow = 'even';
            }
            var buttonUpload = '<label class="btn btn-primary" style="color: #ffff;">Browse&hellip; <input class = "file-upload" type="file" style="display: none;" data-sbmt = "'+response[k].ID+'" id = "file-upload'+response[k].ID+'" attachName = "'+response[k].DocumentChecklist+'"></label>';
            var Description = "";
            switch(response[k].Status)
            {
             case  "Belum Upload" :
                    setIcon = '<i class="fa fa-minus-circle" style="color: red;"></i>';
                    break;
             case  "Reject" :
                    setIcon = '<i class="fa fa-minus-circle" style="color: red;"></i>';
                    Description = 'Reject';
                    break;
             case  "Progress Checking" :
                    setIcon = '<i class="fa fa-circle-o-notch fa-spin" style="color: green;"></i>';
                   buttonUpload =' ';
                   break;
             case  "Done" :
                   setIcon = '<i class="fa fa-check-circle" style="color: green;"></i>';
                   buttonUpload =' ';
                   break;
             default :
                   setIcon = '<i class="fa fa-minus-circle" style="color: red;"></i>';      
            }
            var Attachment = "";
            if (response[k].Attachment == null) {
              Attachment = "";
            }
            else
            {
              Attachment = '<a href="'+base_url_js+'fileShow/'+response[k].Attachment+'" target="_blank">'+response[k].Attachment+'</a>';
              // Attachment = response[k].Attachment;
            }

            /*if (response[k].Description == null) {
              Description = "";
            }
            else
            {
              Description = response[k].Description;
            }*/

            $('#isiData').append('<tr class = "'+setRow+'">'+
                                    '<td class="col-xs-1">'+Nomor+'</td>'+
                                    '<td class="col-xs-3">'+response[k].DocumentChecklist+'</td>'+
                                    '<td class="col-xs-1">'+response[k].Required+'</td>'+
                                    '<td class="col-xs-2" id = "buttonUpload'+response[k].ID+'">'+buttonUpload+'</td>'+
                                    '<td class="col-xs-1" id ="setIcon'+response[k].ID+'">'+setIcon+'</td>'+
                                    '<td class="col-xs-1" id = "Attachment'+response[k].ID+'">'+Attachment+'</td>'+
                                     '<td class="col-xs-3">'+Description+'</td>'+
                                 '</tr>'
                                );
            Nomor++;
          }
          $('#isiData').append('</tbody>');
          $('#isiData').append('</table></div>');
    }).done(function() {
          setTimeout(function () {
              $('#NotificationModal').modal('hide');
          },500);
    });
  }

  $(document).on('click','#btn-dwnformulir', function () {
    loading_button('#btn-dwnformulir');
    var ID_register_formulir = $(this).attr('data-sbmt');
    var url = base_url_js+'downloadPDFFormulir';
    var data = {
      ID_register_formulir : ID_register_formulir,
    };
    var token = jwt_encode(data,"UAP)(*");
    $.post(url,{token:token},function (data_json) {
      var response = jQuery.parseJSON(data_json);
      //console.log(response);
      //window.location.href = base_url_js+'fileGet/'+response;
      window.open(base_url_js+'fileGet/'+response,'_blank');
    }).done(function() {
      toastr.success('The Download processing success', 'Success!');
    }).fail(function() {
      toastr.error('The Download Processing error, please try again', 'Failed!!');;
    }).always(function() {
      $('#btn-dwnformulir').prop('disabled',false).html('Formulir');
    });
    //$('#btn-dwnformulir').prop('disabled',false).html('Download Formulir');

  });

  $(document).on('click','#btn-dwnadmss', function () {
    loading_button('#btn-dwnadmss');
    var ID_register_formulir = $(this).attr('data-sbmt');
    var url = base_url_js+'downloadPDFAdmissionStatement';
    var data = {
      ID_register_formulir : ID_register_formulir,
    };
    var token = jwt_encode(data,"UAP)(*");
    $.post(url,{token:token},function (data_json) {
      var response = jQuery.parseJSON(data_json);
      //console.log(response);
      //window.location.href = base_url_js+'fileGet/'+response;
      window.open(base_url_js+'fileGet/'+response,'_blank');
    }).done(function() {
      toastr.success('The Download processing success', 'Success!');
    }).fail(function() {
      toastr.error('The Download Processing error, please try again', 'Failed!!');;
    }).always(function() {
      $('#btn-dwnadmss').prop('disabled',false).html('Admission Statement');
    });
    //$('#btn-dwnformulir').prop('disabled',false).html('Download Formulir');

  });

  $(document).on('click','#btn-dwnBebasNarkoab', function () {
    loading_button('#btn-dwnBebasNarkoab');
    var ID_register_formulir = $(this).attr('data-sbmt');
    var url = base_url_js+'downloadPDFBebasNarkoba';
    var data = {
      ID_register_formulir : ID_register_formulir,
    };
    var token = jwt_encode(data,"UAP)(*");
    $.post(url,{token:token},function (data_json) {
      var response = jQuery.parseJSON(data_json);
      //console.log(response);
      //window.location.href = base_url_js+'fileGet/'+response;
      window.open(base_url_js+'fileGet/'+response,'_blank');
    }).done(function() {
      toastr.success('The Download processing success', 'Success!');
    }).fail(function() {
      toastr.error('The Download Processing error, please try again', 'Failed!!');;
    }).always(function() {
      $('#btn-dwnBebasNarkoab').prop('disabled',false).html('Surat Pernyataan Bebas Narkoba');
    });
    //$('#btn-dwnformulir').prop('disabled',false).html('Download Formulir');

  });

  function file_validation(ID_element)
  {
    try{
      var name = document.getElementById(ID_element).files[0].name;
      var ext = name.split('.').pop().toLowerCase();
      if(jQuery.inArray(ext, ['png','jpg','jpeg','pdf']) == -1) 
      {
        toastr.error("Invalid Image File", 'Failed!!');
        return false;
      }
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById(ID_element).files[0]);
      var f = document.getElementById(ID_element).files[0];
      var fsize = f.size||f.fileSize;
      if(fsize > 500000) // 500kb
      {
       toastr.error("Image File Size is very big", 'Failed!!');
       return false;
      }

    }
    catch(err)
    {
      return false;
    }
      return true;
  }


  $(document).on('change','.file-upload',function () {
      var ID_document = $(this).attr('data-sbmt');
      var ID_element = $(this).attr('id');
      var attachName = $(this).attr('attachName');
      // console.log(ID_element);
      if (file_validation(ID_element)) {
        SaveFile(ID_element,ID_document,attachName);
      }
      
        
  });

  function SaveFile(ID_element,ID_document,attachName)
  {
      var form_data = new FormData();
      var fileData = document.getElementById(ID_element).files[0];
      var url = base_url_js + "upload_dokument";
      var DataArr = {
                      ID_document : ID_document,
                      attachName : attachName,
                    };
      var token = jwt_encode(DataArr,"UAP)(*");
      form_data.append('token',token);
      form_data.append('fileData',fileData);
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
            $("#setIcon"+ID_document).html('<i class="fa fa-circle-o-notch fa-spin" style="color: green;"></i>');
            $("#buttonUpload"+ID_document).html('');
            $("#Attachment"+ID_document).html('<a href="'+base_url_js+'fileShow/'+data.filename+'" target="_blank">'+data.filename+'</a>');
            toastr.options.fadeOut = 100000;
            toastr.success(data.msg, 'Success!');
          }
          else
          {
            toastr.options.fadeOut = 100000;
            toastr.error(data.msg, 'Failed!!');
          }
        setTimeout(function () {
            toastr.clear();
          },1000);

        },
        error: function (data) {
          toastr.error(data.msg, 'Connection error, please try again!!');
        }
      })
  }

  
</script>
