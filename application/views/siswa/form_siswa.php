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

              <h4 class="box-title">Create Siswa</h4>
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
				<div class="form-group" id="ctof_no_induk">
					 <label for="no_induk" class="col-sm-2 control-label">NPSN<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<input id="no_induk" type="text" name="no_induk" <?php if(isset($no_induk)){echo "value=\"".$no_induk."\"";} ?> class="form-control" placeholder="202010001">
						<span class="help-block" id="ctomesserror_no_induk"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_nama">
					 <label for="nama" class="col-sm-2 control-label">Nama<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<input id="nama" type="text" name="nama" <?php if(isset($nama)){echo "value=\"".$nama."\"";} ?> class="form-control" placeholder="Muh. Yasin">
						<span class="help-block" id="ctomesserror_nama"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_jk">
					 <label for="jk" class="col-sm-2 control-label">Jenis Kelamin<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<select class="form-control select2" style="width: 100%;" id="jk" name="jk" data-error=".errorTxt6">
						   <option value="1" <?php if(isset($jk) && $jk == "1"){echo "selected=\"selected\"";} ?> > Laki - laki </option>
						   <option value="2" <?php if(isset($jk) && $jk == "2"){echo "selected=\"selected\"";} ?> > Perempuan </option>
						</select>
						<span class="help-block" id="ctomesserror_jk"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_tgl_lahir">
					 <label for="tgl_lahir" class="col-sm-2 control-label">Tanggal Lahir<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<input type="date" class="datepicker" id="tgl_lahir" name="tgl_lahir" <?php if(isset($tgl_lahir)){echo "value=\"".$tgl_lahir."\"";} ?>>
						<span class="help-block" id="ctomesserror_tgl_lahir"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_tempat_lahir">
					 <label for="tempat_lahir" class="col-sm-2 control-label">Tempat Lahir<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<input id="tempat_lahir" type="text" name="tempat_lahir" <?php if(isset($tempat_lahir)){echo "value=\"".$tempat_lahir."\"";} ?> class="form-control" placeholder="Jombang">
						<span class="help-block" id="ctomesserror_tempat_lahir"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_alamat">
					 <label for="alamat" class="col-sm-2 control-label">Alamat<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<input id="alamat" type="text" name="alamat" <?php if(isset($alamat)){echo "value=\"".$alamat."\"";} ?> class="form-control" placeholder="Desa Merubetiri Kec. Ambegan Kab. Jombang">
						<span class="help-block" id="ctomesserror_alamat"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_kelas">
					 <label for="kelas" class="col-sm-2 control-label">Kelas<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<input id="kelas" type="text" name="kelas" <?php if(isset($kelas)){echo "value=\"".$kelas."\"";} ?> class="form-control" placeholder="XII IPA 2">
						<span class="help-block" id="ctomesserror_kelas"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_unit">
					 <label for="unit" class="col-sm-2 control-label">Unit</label>
					 <div class="col-sm-5">
						<input id="unit" type="text" name="unit" <?php if(isset($unit)){echo "value=\"".$unit."\"";} ?> class="form-control" placeholder="">
						<span class="help-block" id="ctomesserror_unit"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_asrama">
					 <label for="asrama" class="col-sm-2 control-label">Asrama</label>
					 <div class="col-sm-5">
						<input id="asrama" type="text" name="asrama" <?php if(isset($asrama)){echo "value=\"".$asrama."\"";} ?> class="form-control" placeholder="">
						<span class="help-block" id="ctomesserror_asrama"></span>
					 </div>
				</div>


				<div class="form-group" id="ctof_kontak">
					 <label for="kontak" class="col-sm-2 control-label">Kontak Telp/HP</label>
					 <div class="col-sm-5">
						<input id="kontak" type="text" name="kontak" <?php if(isset($kontak)){echo "value=\"".$kontak."\"";} ?> class="form-control" placeholder="0876192832">
						<span class="help-block" id="ctomesserror_kontak"></span>
					 </div>
				</div>
				
				
				<div class="form-group" id="ctof_is_active">
					 <label for="is_active" class="col-sm-2 control-label">Aktif<font style="color:red;">*</font></label>
					 <div class="col-sm-5">
						<select class="form-control select2" style="width: 100%;" id="is_active" name="is_active" data-error=".errorTxt6">
						   <option value="1" <?php if(isset($is_active) && $is_active == "1"){echo "selected=\"selected\"";} ?> > Active </option>
						   <option value="-1" <?php if(isset($is_active) && $is_active == "-1"){echo "selected=\"selected\"";} ?> > Non Active </option>
						</select>
						<span class="help-block" id="ctomesserror_is_active"></span>
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
<!-- datepicker -->
<script src="<?php echo base_url().'assets/'; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
	
//------javascript ctojs_fields-------
var ctojs_fields = ['no_induk', 'nama', 'jk', 'tgl_lahir', 'tempat_lahir', 'alamat', 'kelas', 'unit', 'asrama', 'kontak', 'is_active'];

//---------javascript inside ajax for post-------

     $("#cto_form").on('submit', function(e) {
        e.preventDefault();
        cto_loading_show();
        ctoerr_messages_clear(ctojs_fields);
        cto_messages_hide();
        <?php if(isset($cto_id)){echo "id = ".$cto_id.";\n";}?>
		no_induk = $('#no_induk').val();
		nama = $('#nama').val();
		jk = $('#jk').val();
		tgl_lahir = $('#tgl_lahir').val();
		tempat_lahir = $('#tempat_lahir').val();
		alamat = $('#alamat').val();
		kelas = $('#kelas').val();
		unit = $('#unit').val();
		asrama = $('#asrama').val();
		kontak = $('#kontak').val();
		is_active = $('#is_active').val();
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>siswa/<?php if(isset($cto_id)){echo "update";}else{echo "insert"; }?>",
          data: { <?php if(isset($cto_id)){echo "'id' : id, ";}?>'no_induk' : no_induk, 'nama' : nama, 'jk' : jk, 'tgl_lahir' : tgl_lahir, 'tempat_lahir' : tempat_lahir, 'alamat' : alamat, 'kelas' : kelas, 'unit' : unit, 'asrama' : asrama, 'kontak' : kontak, 'is_active' : is_active},
           dataType: 'json',
           success: function(data){
              cto_loading_hide();
              if(data['status']){
                 cto_messages_show(data);
                 //window.location = "<?php echo base_url(); ?>siswa/create";
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

	
	$(function () {
		//Initialize Select2 Elements
		$('.select2').select2()
	  })
	//Date picker
	$('.datepicker').datepicker({
	  autoclose: true
	})

	  
</script>
<?php $this->load->view('layouts/footer');?>