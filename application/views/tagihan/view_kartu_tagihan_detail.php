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

              <h4 class="box-title">Lihat Kartu Tagihan dan Pembayaran</h4>
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
			
			<form class="form-horizontal" id="cto_form" method="post">
                            <div class="form-group" id="ctof_no_induk">
                                <div class="col-sm-2">
                                    <b>No Induk</b>
                                </div>
                                <div class="col-sm-4">
                                    : <?php echo $no_induk; ?>
                                </div>
                                <div class="col-sm-2">
                                    <b>Jumlah Termin</b>
                                </div>
                                <div class="col-sm-4">
                                    : <?php echo $termin; ?>
                                </div>
                            </div>
                            <div class="form-group" id="ctof_nama">
                                <div class="col-sm-2">
                                    <b>Nama</b>
                                </div>
                                <div class="col-sm-4">
                                    : <?php echo $nama; ?>
                                </div>
                                <div class="col-sm-2">
                                    <b>Tagihan Ke</b>
                                </div>
                                <div class="col-sm-4">
                                    : <?php echo $tagihan_ke; ?>
                                </div>
                            </div>
                            <div class="form-group" id="ctof_nama_paket">
                                <div class="col-sm-2">
                                    <b>Nama Paket</b>
                                </div>
                                <div class="col-sm-4">
                                    : <?php echo $nama_paket; ?>
                                </div>
                                <div class="col-sm-2">
                                    <b>Status</b>
                                </div>
                                <div class="col-sm-4">
                                    : <?php echo $status; ?>
                                </div>
                            </div>
                            <div class="form-group" id="ctof_harga_paket">
                                <div class="col-sm-2">
                                    <b>Harga</b>
                                </div>
                                <div class="col-sm-4">
                                    : Rp <?php echo number_format($harga, 2); ?>
                                </div>
                            </div>
			</form>

              <table class="table table-striped">
                  <caption style="text-align: center;"><h4><b>Kartu Tagihan</b></h4></caption>
                    <tr>
                        <th>Tagihan Ke</th>
                        <th>Jatuh Tempo</th>
                        <th>Nominal</th>
                        <th>Nominal Terbayar</th>
                        <th>Tunggakan</th>
                    </tr>
                        <?php 
                        $i = 1;
                        $tot = 0;
                        $tot_bayar = 0;
                        foreach($tagihan_detail as $tag_det){
                            echo "<tr><td>".$i++."</td>";
                            echo "<td>".$tag_det->jatuh_tempo."</td>";
                            echo "<td>".number_format($tag_det->nominal, 2)."</td>";
                            echo "<td>".number_format($tag_det->nominal_terbayar, 2)."</td>";
                            echo "<td>".number_format($tag_det->nominal-$tag_det->nominal_terbayar, 2)."</td></tr>";
                            $tot += $tag_det->nominal;
                            $tot_bayar += $tag_det->nominal_terbayar;
                        }
                        ?>
                <tf>
                    <th colspan="2"><div class="pull-right">Total</div></th>
                    <th><?php echo number_format($tot, 2); ?></th>
                    <th><?php echo number_format($tot_bayar, 2); ?></th>
                    <th><?php echo number_format($tot-$tot_bayar, 2); ?></th>
                </tf>
              </table>
          

              <table class="table table-striped">
                  <caption style="text-align: center;"><h4><b>Pembayaran</b></h4></caption>
                    <tr>
                        <th>Pembayaran Ke</th>
                        <th>Tanggal Bayar</th>
                        <th>Nominal Bayar</th>
                        <th>Kembalian</th>
                        <th>Action</th>
                    </tr>
                        <?php 
                        $i = 1;
                        $tot = 0;
                        $tot_kembali = 0;
                        foreach($pembayaran_detail as $pem_det){
                            $coloring = "";
                            if($pem_det->status == -1){
                                $coloring = " style='color:red' ";
                            }
                            echo "<tr".$coloring."><td>".$i."</td>";
                            echo "<td>".$pem_det->tgl_bayar."</td>";
                            echo "<td>".number_format($pem_det->nominal_bayar, 2)."</td>";
                            echo "<td>".number_format($pem_det->kembalian, 2)."</td>";
                            if($pem_det->status == -1){
                                echo "<td>Batal</td></tr>";
                            }else{
                                echo "<td>".'<li class="btn btn-xs fa fa-trash" onclick="delete_pembayaran('.$pem_det->id.', \''.$i.',  Tgl '.$pem_det->tgl_bayar.'\');"></li>'
                                        . '<a href="'.base_url().'pembayaran/bukti_pembayaran/'.$pem_det->id.'" target="_blank"><li class="btn btn-xs fa fa-print"></li></a>'."</td></tr>";
                                $tot += $pem_det->nominal_bayar;
                                $tot_kembali += $pem_det->kembalian;
                            }
                            $i++;
                        }
                        ?>
                <tf>
                    <th colspan="2"><div class="pull-right">Total</div></th>
                    <th><?php echo number_format($tot, 2); ?></th>
                    <th><?php echo number_format($tot_kembali, 2); ?></th>
                    <th></th>
                </tf>
              </table>
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
          	url: "<?php echo base_url(); ?>tagihan/preview_tagihan", 
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
		
            function delete_pembayaran(id_pembayaran, pem_ke_tgl){
                var deleting = confirm("Hapus pembayaran ke-"+pem_ke_tgl+"?");
                if(deleting){
                    var del = ajaxGetValue("<?php echo base_url(); ?>pembayaran/delete_pembayaran/", id_pembayaran);
                    alert(del['messages']);
                }else{

                }

            }
</script>
<?php $this->load->view('layouts/footer');?>