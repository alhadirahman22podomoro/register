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

</style>
<link rel="stylesheet" href="<?php  echo base_url('assets/custom/style/fixed_header_tables.css'); ?>">
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
                    <h3 class="panel-title">Download Your Formulir<span class="required">*</span></h3>
                  </div>
                  <div class="panel-body">
                    <!-- content -->
                      <label class="col-md-3 control-label">Formulir </label>
                      <div class="col-md-6">
                       <button class="ng-button" id="btn-formulir" data-sbmt = "">Download Formulir</button>
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
                    <div class = "col-md-3"><i class="fa fa-minus-circle" style="color: red;"></i> Not Yet Uploaded</div>
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
      loadDataDokument();
  });

  function loadDataDokument()
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
    var url = base_url_js+'api/__getDataDokument';
    $.get(url,function (data_json) {
        $('#pageUploadDokument').append('<table class="points_table" id ="tablechkDokument">'+
                                         '<thead>'+
                                           '<tr>'+
                                              '<th class="col-xs-1">No</th>'+
                                              '<th class="col-xs-5">Document</th>'+
                                              '<th class="col-xs-1">Required</th>'+
                                              '<th class="col-xs-2">&nbsp&nbsp Action</th>'+
                                              '<th class="col-xs-1">Status</th>'+
                                           '</tr>'+
                                          '</thead>'+
                                          '<tbody id = "isiData" class="points_table_scrollbar">' 

                                       );
          var Nomor = 1;

          for (var k = 0; k < data_json.length; k++) {
            var setODDEven = Nomor % 2;
            var setRow = 'odd';
            var setIcon = '<i class="fa fa-minus-circle" style="color: red;"></i>';
            if (setODDEven == 0) {
              setRow = 'even';
              setIcon = '<i class="fa fa-check-circle" style="color: green;"></i>';
            }

            if (Nomor == 5) {
              setIcon = '<i class="fa fa-circle-o-notch fa-spin" style="color: green;"></i>';
            }

            $('#isiData').append('<tr class = "'+setRow+'">'+
                                    '<td class="col-xs-1">'+Nomor+'</td>'+
                                    '<td class="col-xs-5">'+data_json[k].DocumentChecklist+'</td>'+
                                    '<td class="col-xs-1">'+data_json[k].Required+'</td>'+
                                    '<td class="col-xs-2">'+'<label for="file-upload" class="custom-file-upload"><span class="glyphicon glyphicon-upload"></span> Upload </label><input class = "file-upload'+data_json[k].ID+'" id="file-upload" type="file" data-sbmt = "'+data_json[k].ID+'"/>'+'</td>'+
                                    '<td class="col-xs-1">'+setIcon+'</td>'+
                                 '</tr>'
                                );
            Nomor++;
          }
          $('#isiData').append('</tbody>');
          $('#isiData').append('</table>');
    }).always(function() {
          setTimeout(function () {
              $('#NotificationModal').modal('hide');
          },500);
    });
  }
</script>
