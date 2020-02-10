<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('paket_model');
		$this->load->model('tagihan_model');
                $this->load->model('pembayaran_model');
		$this->load->model('siswa_model');
	}
	
	

	public function index()
	{
		//$data['coba'] = 'welcome';
		//$this->view('tagihan/buat_tagihan', $data);
		//$this->view('layouts/content', $data);
		
	}
        
        public function proses_membayar(){
            $pesan['status'] = false;
            $cto_check = true;
            if ($this->input->post('fk_tagihan_id') != "" ) {
                $data['fk_tagihan_id'] = $this->input->post('fk_tagihan_id');
            }else{
                $pesan['err_fk_tagihan_id'] = 'fk_tagihan_id cannot be null!';
                $cto_check = false;
            }

            if ($this->input->post('nominal_membayar') != "") {
                if (is_numeric($this->input->post('nominal_membayar'))) {
                   if($this->input->post('nominal_membayar') > 0){
                        $data['nominal_bayar'] = $this->input->post('nominal_membayar');
                   }else{
                        $pesan['err_nominal_membayar'] = 'Nomnal Harga is must more than 0!';
                        $cto_check = false;
                   }
                }else{   
                    $pesan['err_nominal_membayar'] = 'Nominal Membayar is must numeric!';
                    $cto_check = false;
                }
            }else{
                $pesan['err_nominal_membayar'] = 'Nominal  cannot be empty!';
                $cto_check = false;
            }
            
            if (true) {
                $data['keterangan'] = $this->input->post('keterangan_membayar');
            }else{
                $pesan['err_keterangan_membayar'] = 'Keterangan cannot be null!';
                $cto_check = false;
            }
            
            if ($this->input->post('tanggal_membayar') != "" ) {
                $data['tgl_bayar'] = $this->input->post('tanggal_membayar');
            }else{
                $pesan['err_tanggal_membayar'] = 'Tanggal Membayar cannot be null!';
                $cto_check = false;
            }
            
            try{
                if($cto_check){
                    $status_tagihan = $this->tagihan_model->getAData($data['fk_tagihan_id'])['status_code'];
                    if($status_tagihan == 1){
                        $pembayaran = $this->pembayaran_model->getPembayaranInfo($data['fk_tagihan_id']);
                        $nominal_membayar = $data['nominal_bayar'];
                        $sisa_membayar = $data['nominal_bayar'];
                        $c = 0;

                        $data2 = array();
                        $data2['fk_siswa_id']  = $pembayaran['fk_siswa_id'];
                        $data2['fk_tagihan_id']  = $data['fk_tagihan_id'];
                        $data2['tgl_bayar']  = $data['tgl_bayar'];
                        $data2['nominal_bayar']  = $data['nominal_bayar'];
                        $data2['keterangan']  = $data['keterangan'];

                        $id_pembayaran = $this->pembayaran_model->insertGetID($data2);
                        //echo $id_pembayaran."|";
    //                    var_dump($this->tagihan_model->getDataDetail($data['fk_tagihan_id'])[0]->sisa_tunggakan);
                        foreach($this->tagihan_model->getDataDetail($data['fk_tagihan_id']) as $tag_det ){
                            $c = $sisa_membayar;
                            $sisa_membayar = $sisa_membayar-$tag_det->sisa_tunggakan;
                            $data3 = array();
                            $data3['fk_bayar_id'] = $id_pembayaran;
                            $data3['fk_tagihan_detail_id'] = $tag_det->id;
                            if($sisa_membayar <= 0){
                                //insert $sisa_membayar to p_bayar_spreading
                                //if($sisa_membayar == 0){
                                    //$data3['nominal'] = $sisa_membayar;
                                    $data3['nominal'] = $c;
    //                            }else{
    //                                //$data3['nominal'] = $sisa_membayar+$tag_det->sisa_tunggakan;
    //                                $data3['nominal'] = $c;
    //                                echo "x";
    //                            }


                                $this->pembayaran_model->insertPembayaranDetail($data3);
                                break;
                            }elseif($tag_det->sisa_tunggakan > 0){
                                //insert $tag_det->sisa_tunggakan
                                $data3['nominal'] = $tag_det->sisa_tunggakan;
                                $this->pembayaran_model->insertPembayaranDetail($data3);
                            }
                        }

                        if($sisa_membayar > 0){
                            //ada lebihan bayar
                            $data6 = array();
                            $data6['fk_bayar_id'] = $id_pembayaran;
                            $data6['nominal'] = $sisa_membayar;
                            $data6['status'] = 1;
                            $id_pembayaran_det = $this->pembayaran_model->insertPembayaranDetail($data6);


                            $data5 = array();
                            $data5['kembalian'] = $sisa_membayar;
                            $this->pembayaran_model->update($id_pembayaran, $data5);
                            $pesan['stx'] = "ccc".$data6['status']."ccc";
                        }

                        if($sisa_membayar >= 0){
                            //ada lebihan bayar
                            $data4 = array();
                            $data4['status'] = 2;
                            $this->tagihan_model->update($data['fk_tagihan_id'], $data4);
                        }

                        $pesan['status'] = true;
                        $pesan['messages'] = 'Data is saved!';
                        $pesan['id_tagihan'] = $data['fk_tagihan_id'];
                        //    $id  = $this->tagihan_model->insertGetID($data);
    //                        if(!empty($id)){
    ////                            if($this->tagihan_model->insertDetail($id)){
    ////                                $pesan['messages'] = 'Data is saved';
    ////                                $pesan['status'] = true;
    ////                            }else{
    ////                                $pesan['messages'] = 'Failed to create Tagihan Detail!';
    ////                            }
    //                        }else{
    //                            $pesan['messages'] = 'Data isn\'t saved!';
    //                        }

                }elseif($status_tagihan == 2){
                    $pesan['messages'] = 'Tagihan sudah Lunas!';
                }else{
                    $pesan['messages'] = 'Tagihan tidak aktif!'.$status_tagihan;
                }
            }else{
                $pesan['messages'] = 'Errors!';
            }
            }catch(Exception $e){
                    $pesan['messages'] = $e->getMessage();
            }

            echo json_encode($pesan);
        }
	
	public function getPembayaranInfo(){
		//$data = json_decode(stripslashes($_POST['data']));
		// here i would like use foreach:
		// foreach($data as $d){
			// echo $d;
		// }
                $fk_tagihan_id = json_decode(stripslashes($_POST['data']));
		
		$value = $this->pembayaran_model->getPembayaranInfo($fk_tagihan_id);
		
		echo json_encode($value);
	}
        
        public function delete_pembayaran(){
            //get tagihan from id_pembayaran
            $pesan =  array();
            $pesan['status'] = false;
            $fk_tagihan_id  = $this->pembayaran_model->getAData($this->input->post('data'))['fk_tagihan_id'];
            $status_tagihan = $this->tagihan_model->getAData($fk_tagihan_id)['status_code'];
            if($status_tagihan == 1){
                $data = array();
                $data['status'] = -1;
                if($this->pembayaran_model->update($this->input->post('data'), $data) && $this->pembayaran_model->deleteDet($this->input->post('data'), $data)){
                    $pesan['status'] = true;
                    $pesan['messages'] = 'Berhasil dihapus!';
                }else{
                    $pesan['messages'] = 'Gagal menghapus!';
                }
            }elseif($status_tagihan == 2){
                $pesan['messages'] = 'Tagihan sudah lunas!';
            }else{
                $pesan['messages'] = 'Tagihan tidak aktif!';
            }
            
            echo json_encode($pesan);
        }
	
	public function cto_getDatas(){
		//$data = json_decode(stripslashes($_POST['data']));
		// here i would like use foreach:
		// foreach($data as $d){
			// echo $d;
		// }
		$param = array('is_active' => 1);
		$menupack = $this->cto_menupackage_model->cto_getDatas($param);
		$value = array();
		foreach($menupack->result() as $mp){
			array_push($value, array($mp->value, $mp->label));
		} 
		echo json_encode($value);
	}
}
