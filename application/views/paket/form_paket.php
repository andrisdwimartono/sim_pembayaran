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

              <h4 class="box-title">Create Paket</h4>
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
            <div class="box-body no-padding">
				<!-- messages box-->
				<div class="" id="cto_messages">
					
				</div>
				<!-- /.messages box-->
              <!-- CTOF Content here-->
			  <form class="form-horizontal" id="cto_form" method="post">
				<div class="form-group" id="ctof_nama">
					 <label for="nama" class="col-sm-2 control-label">Nama Paket<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<input id="nama" type="text" name="nama" <?php if(isset($nama)){echo "value=\"".$nama."\"";} ?> class="form-control" placeholder="Paket ABC">
						<span class="help-block" id="ctomesserror_nama"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_harga">
					 <label for="harga" class="col-sm-2 control-label">Harga<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<input id="harga" type="text" name="harga" <?php if(isset($harga)){echo "value=\"".$harga."\"";} ?> class="form-control" placeholder="100,000">
						<span class="help-block" id="ctomesserror_harga"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_termin">
					 <label for="termin" class="col-sm-2 control-label">Jumlah Bayar<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<select class="form-control select2" style="width: 100%;" id="termin" name="termin" data-error=".errorTxt6">
						   <option value="3" <?php if(isset($termin) && $termin == "3"){echo "selected=\"selected\"";} ?> > 3 </option>
						   <option value="6" <?php if(isset($termin) && $termin == "6"){echo "selected=\"selected\"";} ?> > 6 </option>
						   <option value="12" <?php if(isset($termin) && $termin == "12"){echo "selected=\"selected\"";} ?> > 12 </option>
						</select>
						<span class="help-block" id="ctomesserror_termin"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_keterangan">
					 <label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
					 <div class="col-sm-5">
						<input id="keterangan" type="text" name="keterangan" <?php if(isset($keterangan)){echo "value=\"".$keterangan."\"";} ?> class="form-control" placeholder="...">
						<span class="help-block" id="ctomesserror_keterangan"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_aktif">
					 <label for="aktif" class="col-sm-2 control-label">Aktif<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<select class="form-control select2" style="width: 100%;" id="aktif" name="aktif" data-error=".errorTxt6">
						   <option value="1" <?php if(isset($aktif) && $aktif == "1"){echo "selected=\"selected\"";} ?> > Aktif </option>
						   <option value="0" <?php if(isset($aktif) && $aktif == "0"){echo "selected=\"selected\"";} ?> > Non Aktif </option>
						</select>
						<span class="help-block" id="ctomesserror_aktif"></span>
					 </div>
				</div>
				
				<div class="row align-right">
					<div class="col-sm-5">
					  
					</div>
					<div class="col-sm-2">
					  <button type="submit" class="btn btn-primary btn-block btn-flat"><?php if(isset($cto_id)){echo "Update";}else{echo "Save"; }?></button>
					</div>
					<!-- /.col -->
				  </div>
			  </form>
			  <!-- CTOF Content here end! -->
            </div>
            <!-- /.box-body -->
			<!-- Loading (remove the following to stop the loading)-->
            <div id="cto_overlay" class="overlay">
			  <div id="cto_mengecek"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
			</div>
            <!-- end loading -->
          </div>
          <!-- /.box -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>
<!-- input number bootstrap-touchspin-master -->
<script src="<?php echo base_url().'assets/'; ?>bower_components/bootstrap-touchspin-master/dist/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo base_url().'assets/'; ?>bower_components/bootstrap-touchspin-master/src/jquery.bootstrap-touchspin.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url().'assets/'; ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
	// var ctojs_fields = ['controller', 'method', 'path', 'name', 'fk_menupackage_id', 'sequence', 'is_shown', 'is_active'];
	
	// $("#cto_form").on('submit', function(e) {
		// e.preventDefault();
		// cto_loading_show();
		// ctoerr_messages_clear(ctojs_fields);
		// cto_messages_hide();
		// <?php if(isset($cto_id)){echo "id = ".$cto_id.";\n";}?>
		// controller = $('#controller').val();
        // method = $('#method').val();
        // path = $('#path').val();
        // name = $('#name').val();
        // fk_menupackage_id = $('#fk_menupackage_id').val();
        // menupackage_name = $('#menupackage_name').val();
        // sequence = $('#sequence').val();
        // is_shown = $('#is_shown').val();
        // is_active = $('#is_active').val();
		// $.ajax({
			// type: "POST",
			// url: "<?php echo base_url(); ?>cto_menu/<?php if(isset($cto_id)){echo "update";}else{echo "insert"; }?>",
			// data: { <?php if(isset($cto_id)){echo "'id' : id, ";}?> 'controller' : controller, 'method' : method, 'path' : path, 'name' : name, 'fk_menupackage_id' : fk_menupackage_id, 'menupackage_name' : menupackage_name, 'sequence' : sequence, 'is_shown' : is_shown, 'is_active' : is_active},
			// dataType: 'json',                         
			// success: function(data){
				// cto_loading_hide();
				// if(data['status']){
					// //alert(data['messages']);
					// cto_messages_show(data);
					// //window.location = "<?php echo base_url(); ?>cto_user/create";
				// }else{
					// //alert(data['messages']);
					// //show error for each fields
					// ctoerr_messages(ctojs_fields, data);
					// cto_messages_show(data);
				// }
			// },
			// error: function (response) {
			   // //Handle error
			   // cto_loading_hide();
			   // //alert(response['messages']);
			// }           
		// });
		// cto_loading_hide();
	// });
//------javascript ctojs_fields-------
var ctojs_fields = ['nama', 'harga', 'termin', 'keterangan', 'aktif'];

//---------javascript inside ajax for post-------

     $("#cto_form").on('submit', function(e) {
        e.preventDefault();
        cto_loading_show();
        ctoerr_messages_clear(ctojs_fields);
        cto_messages_hide();
        <?php if(isset($cto_id)){echo "id = ".$cto_id.";\n";}?>
       nama = $('#nama').val();
       harga = $('#harga').val();
       termin = $('#termin').val();
       keterangan = $('#keterangan').val();
       aktif = $('#aktif').val();
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>paket/<?php if(isset($cto_id)){echo "update";}else{echo "insert"; }?>",
          data: { <?php if(isset($cto_id)){echo "'id' : id, ";}?>'nama' : nama, 'harga' : harga, 'termin' : termin, 'keterangan' : keterangan, 'aktif' : aktif},
           dataType: 'json',
           success: function(data){
              cto_loading_hide();
              if(data['status']){
                 cto_messages_show(data);
                 //window.location = "<?php echo base_url(); ?>paket/create";
              }else{
                 ctoerr_messages(ctojs_fields, data);
                 cto_messages_show(data);
              }
           },
           error: function (response) {
              cto_loading_hide();
           }
        });
        cto_loading_hide();
     }); 
		
	$("input[name='sequence']").TouchSpin({
		min: 0,
		max: 1000,
		step: 1,
		decimals: 0,
		boostat: 1,
		maxboostedstep: 10,
		buttondown_class:'btn hidden',
		buttonup_class:'btn hidden',
	});
	
	$(function () {
		//Initialize Select2 Elements
		$('.select2').select2()
	  })
	  
	  // ctoGetSelect("fk_menupackage_id", "<?php echo base_url(); ?>cto_menu/cto_getDatas");
	  // function ctoGetSelect(cto_elementid, addr, param){
			// param = [];
			// param[0] = 1;
			// var menupack = ajaxGetValue(addr, param);
			// var opt = '';
			// for (i = 0; i < menupack.length; i++) {
				// opt+='<option value="'+menupack[i][0]+'">'+menupack[i][1]+'</option>';
			// }
			// document.getElementById(cto_elementid).innerHTML = opt;
		// }
		
		// function ajaxGetValue(addr, param){
			// var data = function () {
			// var tmp = null;
			// var jsonString = JSON.stringify(param);
			// $.ajax({
				// 'async': false,
				// 'type': "POST",
				// 'global': false,
				// 'dataType': 'json',
				// 'url': addr,
				// 'data': { 'data':  jsonString},
				// 'success': function (data) {
					// tmp = data;
				// }
			// });
			// return tmp;
		// }();
		// return data;
		// }
		
		// //assign nama package sesuai dropdown ke hidden field pertama kali
		// document.getElementById("menupackage_name").value = $('#fk_menupackage_id option:selected').text();
		// //assign nama package sesuai dropdown ke hidden field
		// $("#fk_menupackage_id").on('change', function(e) {
			// document.getElementById("menupackage_name").value = $('#fk_menupackage_id option:selected').text();
		// });
</script>
<?php $this->load->view('layouts/footer');?>