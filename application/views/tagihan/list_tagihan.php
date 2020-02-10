<div class="content-wrapper">
    <!-- Main content -->
<section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-10 connectedSortable">
          <!-- Calendar -->
          <div class="box box-solid">
            <div class="box-header">
              <i class="fa fa-wpforms"></i>

              <h4 class="box-title">List of Tagihan Siswa</h4>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- CTOF Content here-->
		<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No Induk</th>
                    <th>Nama</th>
                    <th>Paket</th>
                    <th>Harga</th>
                    <th>Termin</th>
                    <th>Tagihan Ke</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
              </table>
              
               <!-- /.modal start -->
                <div class="modal modal-info fade" id="modal-info">
                  <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Bayar Tagihan</h4>
                                </div>
                          <div class="modal-body" id="cto_bayar_form">
				
                          </div>
                          <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                <div id="cto_distribusipenuhupdate" class="pull-right"></div>
                                <div id="cto_finishupdate" class="pull-right"></div>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                        <!-- Loading (remove the following to stop the loading)-->
                        <div id="cto_overlay" class="overlay">
                          <div id="cto_mengecek"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
                        </div>
                        <!-- end loading -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
			  <!-- CTOF Content here end! -->
            </div>
            <!-- /.box-body -->
			<div id="cto_overlay" class="overlay">
			  <div id="cto_mengecek"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
			</div>
          </div>
          <!-- /.box -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
	
</div>
<script type="text/javascript" language="javascript" >
    var ctojs_fields = ['fk_tagihan_id','nominal_pembayaran', 'keterangan_pembayaran'];
    $(document).ready(function(){
    fetch_data();

    function fetch_data(){
      cto_loading_show();
      $('#example1').DataTable().destroy();
      var dataTable = $('#example1').DataTable({
          "autoWidth": false,
          dom: 'Bfrtip',
          "scrollX" : true,
          "processing" : true,
          "serverSide" : true,
          "pagingType": "full_numbers",
          "order" : [],
          "ajax" : {
              url:"<?php echo base_url(); ?>tagihan/fetch",
              type:"POST"
          }
      });
      cto_loading_hide();
    }
  
  $(document).on('click', '.delete', function(){
	cto_loading_show();
   var id = $(this).attr("id");
   if(confirm("Are you sure?"))
   {
    $.ajax({
     url:"<?php echo base_url(); ?>tagihan/delete",
     method:"POST",
     data:{id:id},
     success:function(data){
		 data = $.parseJSON(data);
		 alert(data.messages);
      //$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      fetch_data();
     }
    });
    setInterval(function(){
     //$('#alert_message').html('');
    }, 5000);
   }
   $('#example1').DataTable().destroy();
   cto_loading_hide();
  });
  
  $(document).on('click', '.undelete', function(){
	cto_loading_show();
   var id = $(this).attr("id");
   if(confirm("Are you sure?"))
   {
    $.ajax({
     url:"<?php echo base_url(); ?>tagihan/undelete",
     method:"POST",
     data:{id:id},
     success:function(data){
		 data = $.parseJSON(data);
		 alert(data.messages);
      //$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      fetch_data();
     }
    });
    setInterval(function(){
     //$('#alert_message').html('');
    }, 5000);
   }
   $('#example1').DataTable().destroy();
   cto_loading_hide();
  });
  
  // var table = $('#example1').DataTable();
	// // table.column( 0 ).visible( false );
	// table.on( 'order.dt search.dt', function () {
        // t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            // cell.innerHTML = i+1;
        // } );
    // } ).draw();
  
 });
 
    function openBayarForm(id_tagihan){
        var bayars = ajaxGetValue("<?php echo base_url(); ?>pembayaran/getPembayaranInfo", id_tagihan);
        var prog = "";
        
        prog += "<div class=\"form-group row\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">No Induk</label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            +" : "+bayars['no_induk']
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Paket</label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            +" : "+bayars['nama_paket']
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                         //+"<button type=\"button\" class=\"fa fa-remove btn-danger\" onclick=\"cto_removeImg(<?php if(isset($fk_submission_id)){echo $fk_submission_id;}else{echo 0;} ?>, "+photoupload[i]['id']+");\"></button>"
                +"</div>"
                +"<div class=\"form-group row\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Nama</label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            +" : "+bayars['nama']
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Harga</label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            +" : "+bayars['harga']
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                         //+"<button type=\"button\" class=\"fa fa-remove btn-danger\" onclick=\"cto_removeImg(<?php if(isset($fk_submission_id)){echo $fk_submission_id;}else{echo 0;} ?>, "+photoupload[i]['id']+");\"></button>"
                +"</div>"
                +"<div class=\"form-group row\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\"></label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Terbayar</label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            +" : "+bayars['nominal_bayar']
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                         //+"<button type=\"button\" class=\"fa fa-remove btn-danger\" onclick=\"cto_removeImg(<?php if(isset($fk_submission_id)){echo $fk_submission_id;}else{echo 0;} ?>, "+photoupload[i]['id']+");\"></button>"
                +"</div>"
                
                +"<div class=\"form-group row\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\"></label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                        
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Tunggakan</label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            +" : "+bayars['sisa_tunggakan']
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                         //+"<button type=\"button\" class=\"fa fa-remove btn-danger\" onclick=\"cto_removeImg(<?php if(isset($fk_submission_id)){echo $fk_submission_id;}else{echo 0;} ?>, "+photoupload[i]['id']+");\"></button>"
                +"</div>"
                +"<div class=\"form-group row\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\"></label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                                
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                
                         +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Status</label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            +" : "+bayars['status']
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                         //+"<button type=\"button\" class=\"fa fa-remove btn-danger\" onclick=\"cto_removeImg(<?php if(isset($fk_submission_id)){echo $fk_submission_id;}else{echo 0;} ?>, "+photoupload[i]['id']+");\"></button>"
                +"</div>"
                
                +"<form class=\"form-horizontal\" id=\"cto_form\" method=\"post\"><div class=\"form-group row text-navy\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Nominal<font style=\"color:red;\">*</font></label>"//
                        +"<div class=\"col-sm-4\">"
                              +"<input id=\"nominal_membayar\" type=\"text\" name=\"nominal_membayar\" class=\"form-control\" placeholder=\"75000\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                
                         +"<label for=\"create_odp\" class=\"col-sm-2 control-label\"></label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                            
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                         //+"<button type=\"button\" class=\"fa fa-remove btn-danger\" onclick=\"cto_removeImg(<?php if(isset($fk_submission_id)){echo $fk_submission_id;}else{echo 0;} ?>, "+photoupload[i]['id']+");\"></button>"
                +"</div>"
                
                +"<div class=\"form-group row text-navy\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Keterangan</label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                              +"<textarea id=\"keterangan_membayar\">"+"</textarea>"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                
                         +"<label for=\"create_odp\" class=\"col-sm-2 control-label\"></label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                         //+"<button type=\"button\" class=\"fa fa-remove btn-danger\" onclick=\"cto_removeImg(<?php if(isset($fk_submission_id)){echo $fk_submission_id;}else{echo 0;} ?>, "+photoupload[i]['id']+");\"></button>"
                +"</div>"
                
                +"<div class=\"form-group row text-navy\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\">Tanggal<font style=\"color:red;\">*</font></label>"//
                        +"<div class=\"col-sm-4\">"
                             +"<input id=\"tanggal_membayar\" type=\"text\" name=\"tanggal_membayar\" class=\"form-control\" placeholder=\"Tahun-Bulan-Tanggal\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                
                         +"<label for=\"create_odp\" class=\"col-sm-2 control-label\"></label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                         //+"<button type=\"button\" class=\"fa fa-remove btn-danger\" onclick=\"cto_removeImg(<?php if(isset($fk_submission_id)){echo $fk_submission_id;}else{echo 0;} ?>, "+photoupload[i]['id']+");\"></button>"
                +"</div>"
                
                +"<div class=\"form-group row text-navy\">"
                        +"<label for=\"create_odp\" class=\"col-sm-2 control-label\"></label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                             +"<input type='hidden' id='id_tagihan' name='id_tagihan' value='"+bayars['id']+"'>"
                            +"<button type=\"button\" class=\"fa btn-danger\" onclick=\"lakukan_pembayaran();\"> Proses</button>"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"
                
                         +"<label for=\"create_odp\" class=\"col-sm-2 control-label\"></label>"//<font style=\"color:red;\">*</font>
                        +"<div class=\"col-sm-4\">"
                                //+"<input id=\"nama\" type=\"text\" name=\"nama\" class=\"form-control\" placeholder=\"Paket ABC\">"
                        +"<span class=\"help-block\" id=\"ctomesserror_\"></span>"
                        +"</div>"                         
                +"</div></form>";
            
        document.getElementById('cto_bayar_form').innerHTML = prog;
        $('#modal-info').modal('show');
        //Date picker
        $('#tanggal_membayar').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        
    }
    
    function ajaxGetValue(addr, param){ 
	var data = function () { 
            var tmp = null; 
            var jsonString = JSON.stringify(param); 
            $.ajax({ 
                'async': false, 
                'type': "POST", 
                'global': false, 
                'dataType': 'json', 
                'url': addr, 
                'data': { 'data': jsonString}, 
                'success': function (data) { 
                    tmp = data; 
                } 
            }); 
            return tmp; 
	}(); 
	return data; 
    }
    
    function lakukan_pembayaran(){
        cto_loading_show();
        //ctoerr_messages_clear(ctojs_fields);
        //cto_messages_hide();
        id_tagihan = $('#id_tagihan').val();
        nominal_membayar = $('#nominal_membayar').val();
        keterangan_membayar = $('#keterangan_membayar').val();
        tanggal_membayar = $('#tanggal_membayar').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>pembayaran/proses_membayar",
            data: { 'fk_tagihan_id' : id_tagihan, 'nominal_membayar' : nominal_membayar, 'keterangan_membayar' : keterangan_membayar, 'tanggal_membayar' : tanggal_membayar},
            dataType: 'json',
            success: function(data){
                cto_loading_hide();
                if(data['status']){
                    $('#modal-info').modal('hide');
                    var cetak = confirm("Cetak bukti bayar?");
                    var win = window.open("<?php echo base_url(); ?>tagihan/view_kartu_tagihan/"+data['id_tagihan'], '_blank');
                    win.focus();
                    //cto_messages_show(data);
                    //window.location = "<?php echo base_url(); ?>paket/create";
                }else{
                    alert(data['messages']);
                    //ctoerr_messages(ctojs_fields, data);
                    //cto_messages_show(data);
                }
            },
           error: function (response) {
                cto_loading_hide();
           }
        });
        cto_loading_hide();
        fetch_data2();
    }
		
    $("input[name='nominal_membayar']").TouchSpin({
        min: 0,
        max: 1000,
        step: 1,
        decimals: 0,
        boostat: 1,
        maxboostedstep: 10,
        buttondown_class:'btn hidden',
        buttonup_class:'btn hidden',
    });
    
    
    function fetch_data2(){
      cto_loading_show();
      $('#example1').DataTable().destroy();
      var dataTable = $('#example1').DataTable({
          "autoWidth": false,
          dom: 'Bfrtip',
          "scrollX" : true,
          "processing" : true,
          "serverSide" : true,
          "pagingType": "full_numbers",
          "order" : [],
          "ajax" : {
              url:"<?php echo base_url(); ?>tagihan/fetch",
              type:"POST"
          }
      });
      cto_loading_hide();
    }
    
</script>
<?php $this->load->view('layouts/footer');?>