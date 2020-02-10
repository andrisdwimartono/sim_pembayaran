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

              <h4 class="box-title">Buat Kartu Tagihan Pembayaran</h4>
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
		
		
		<div class="form-group" id="ctof_fk_siswa_id">
				<label for="fk_siswa_id" class="col-sm-2 control-label">Siswa<font style="color:red;">*</font></label>
				<div class="col-sm-5">
				<select class="form-control select2" style="width: 100%;" id="fk_siswa_id" name="fk_siswa_id" data-error=".errorTxt6">
					
				</select>
				<span class="help-block" id="ctomesserror_fk_siswa_id"></span>
				</div>
		</div>
		
		<div class="form-group" id="ctof_fk_paket_id">
				<label for="fk_paket_id" class="col-sm-2 control-label">Paket<font style="color:red;">*</font></label>
				<div class="col-sm-5">
				<select class="form-control select2" style="width: 100%;" id="fk_paket_id" name="fk_paket_id" data-error=".errorTxt6">
					
				</select>
				<span class="help-block" id="ctomesserror_fk_paket_id"></span>
				</div>
		</div>
				
				
				<div class="row align-right">
					<div class="col-sm-5">
					  
					</div>
					<div class="col-sm-2">
					  <button type="submit" class="btn btn-primary btn-block btn-flat">Masukkan Siswa</button>
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
	
//	------javascript ctojs_fields-------
var ctojs_fields = ['fk_siswa_id', 'fk_paket_id'];

//---------javascript inside ajax for post-------

    $("#cto_form").on('submit', function(e) { 
       	e.preventDefault(); 
       	cto_loading_show(); 
       	ctoerr_messages_clear(ctojs_fields); cto_messages_hide(); 
       	<?php if(isset($cto_id)){echo "id = ".$cto_id.";\n";}?> 
       fk_siswa_id = $('#fk_siswa_id').val();
       fk_paket_id = $('#fk_paket_id').val();
       	$.ajax({ 
          	type: "POST", 
          	url: "<?php echo base_url(); ?>tagihan/create_tagihan", 
          data: { <?php if(isset($cto_id)){echo "'id' : id, ";}?>'fk_siswa_id' : fk_siswa_id, 'fk_paket_id' : fk_paket_id},
          	dataType: 'json', 
          	success: function(data){ 
             	cto_loading_hide(); 
             	if(data['status']){ 
                	cto_messages_show(data); 
                	//window.location = "<?php echo base_url(); ?>cto_menu/create"; 
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
	  
	  ctoGetSelect("fk_siswa_id", "<?php echo base_url(); ?>siswa/cto_getDatas");
	  ctoGetSelect("fk_paket_id", "<?php echo base_url(); ?>paket/cto_getDatas");
	  function ctoGetSelect(cto_elementid, addr, param){
			param = [];
			param[0] = 1;
			var menupack = ajaxGetValue(addr, param);
			var opt = '';
			for (i = 0; i < menupack.length; i++) {
				<?php if(isset($fk_menupackage_id)){ ?>
				if(menupack[i]['value'] == <?php echo $fk_menupackage_id; ?>){
					opt+='<option value="'+menupack[i]['value']+'" selected>'+menupack[i]['label']+'</option>';
				}else{
				<?php } ?>
				opt+='<option value="'+menupack[i]['value']+'">'+menupack[i]['label']+'</option>';
				<?php if(isset($fk_menupackage_id)){ ?>
				}
				<?php } ?>
			}
			document.getElementById(cto_elementid).innerHTML = opt;
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
				'data': { 'data':  jsonString},
				'success': function (data) {
					tmp = data;
				}
			});
			return tmp;
		}();
		return data;
		}
		
</script>
<?php $this->load->view('layouts/footer');?>