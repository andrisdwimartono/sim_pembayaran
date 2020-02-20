<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('paket_model');
		$this->load->model('tagihan_model');
                $this->load->model('pembayaran_model');
		$this->load->model('siswa_model');
	}
	
	

	public function index()
	{
		$data['coba'] = 'welcome';
		$this->view('tagihan/buat_tagihan', $data);
		//$this->view('layouts/content', $data);
		
	}
	
	public function create_tagihan(){
            $pesan['status'] = false;
            $cto_check = true;
            $siswa = null;
            if ($this->input->post('fk_siswa_id') != "" ) {
                    $data['fk_siswa_id'] = $this->input->post('fk_siswa_id');
                    $siswa = $this->siswa_model->getAData($data['fk_siswa_id']);
            }else{
                    $pesan['err_fk_siswa_id'] = 'Choose one!';
                    $cto_check = false;
            }

            $paket = null;
            if ($this->input->post('fk_paket_id') != "" ) {
                    $data['fk_paket_id'] = $this->input->post('fk_paket_id');
                    $paket = $this->paket_model->getAData($data['fk_paket_id']);
            }else{
                    $pesan['err_fk_paket_id'] = 'Choose one!';
                    $cto_check = false;
            }

            try{
                    if($cto_check){
                        if(!$this->tagihan_model->checkHasTagihan($data['fk_siswa_id'])){
                            $data['tagihan_ke'] = $this->tagihan_model->countTagihan($data['fk_siswa_id']);
                            $id  = $this->tagihan_model->insertGetID($data);
                            if(!empty($id)){
                                    if($this->tagihan_model->insertDetail($id)){
                                            $pesan['messages'] = 'Data is saved';
                                            $pesan['status'] = true;
                                    }else{
                                            $pesan['messages'] = 'Failed to create Tagihan Detail!';
                                    }
                            }else{
                                    $pesan['messages'] = 'Data isn\'t saved!';
                            }
                        }else{
                            $pesan['messages'] = 'Siswa masih memiliki tagihan belum lunas!';
                        }
                    }else{
                            $pesan['messages'] = 'Errors!';
                    }
            }catch(Exception $e){
                    $pesan['messages'] = $e->getMessage();
            }

            echo json_encode($pesan);
	}
        
        public function list_tagihan(){
            $data = array();
            $this->view('tagihan/list_tagihan', $data);
        }

        public function fetch()
	{
		$keyword = null;
		if(isset($_POST["search"]["value"])){
			$keyword = $_POST["search"]["value"];
		}
		
		$orders = null;
		if(isset($_POST["order"])){
			$orders = array($_POST['order']['0']['column'], $_POST['order']['0']['dir']);
		}
		
		$limit = null;
		if(isset($_POST["length"]) && $_POST["length"] != -1){
			$limit = array(intval($_POST["start"]), intval($_POST['length']));
		}
		
		$output = array(
			"draw"    => intval($_POST["draw"]),
			"recordsTotal"  =>  (int)$this->tagihan_model->nAllData(),
			"recordsFiltered" => intval($this->tagihan_model->nData($keyword, $orders)),
			"data"    => $this->tagihan_model->getData($keyword, $orders, $limit)
		);
		
		echo json_encode($output);
	}
	
	public function create_new()
	{
		$data['coba'] = 'welcome';
		$this->view('tagihan/form_tagihan', $data);
	}
        
        public function view_kartu_tagihan($id){
		foreach($this->tagihan_model->getAData($id) as $x => $y){
			$data[$x] = $y;
		}
		$data['cto_id'] = $id;
		$data['tagihan_detail'] = $this->tagihan_model->getDataDetail($id);
                $data['pembayaran_detail'] = $this->pembayaran_model->getDataDetail($id);
		$this->view('tagihan/view_kartu_tagihan_detail', $data);
	}
        
        public function kartu_tagihan($id){
            $this->load->library('Pdf');
            foreach($this->tagihan_model->getAData($id) as $x => $y){
                    $data[$x] = $y;
            }
            //var_dump($data);die();
            $data['cto_id'] = $id;
            $data['tagihan_detail'] = $this->tagihan_model->getDataDetail($id);
            $data['pembayaran_detail'] = $this->pembayaran_model->getDataDetail($id);
            $this->view('pembayaran/kartu_tagihan', $data);
	}
	
	public function insert()
	{
		$pesan['status'] = false;
		$cto_check = true;
		if ($this->input->post('nama') != "" ) {
			$data['nama'] = $this->input->post('nama');
		}else{
			$pesan['err_nama'] = 'Nama Paket cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('harga') != "" ) {
			if (is_numeric($this->input->post('harga'))) {
			   if($this->input->post('harga') > 0){
				  $data['harga'] = $this->input->post('harga');
			   }else{
				  $pesan['err_harga'] = 'Harga is must more than 0!';
				  $cto_check = false;
			   }
			}else{        $pesan['err_harga'] = 'Harga is must numeric!';
			   $cto_check = false;
			}
		}else{
			$pesan['err_harga'] = 'Harga cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('termin') != "" ) {
			$data['termin'] = $this->input->post('termin');
		}else{
			$pesan['err_termin'] = 'Jumlah Bayar cannot be empty!';
			$cto_check = false;
		}


		if (true) {
			$data['keterangan'] = $this->input->post('keterangan');
		}else{
			$pesan['err_keterangan'] = 'Keterangan cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('aktif') != "" ) {
			$data['aktif'] = $this->input->post('aktif');
		}else{
			$pesan['err_aktif'] = 'Aktif cannot be empty!';
			$cto_check = false;
		}


		try{
			if($cto_check){
				if($this->paket_model->insert($data)){
					$pesan['messages'] = 'Data is saved';
					$pesan['status'] = true;
				}else{
					$pesan['messages'] = 'Data isn\'t saved!';
				}
			}else{
				$pesan['messages'] = 'Errors!';
			}
		}catch(Exception $e){
			$pesan['messages'] = $e->getMessage();
		}
		
		echo json_encode($pesan);
	}
	
	public function edit($id)
	{
		foreach($this->paket_model->getAData($id) as $x => $y){
			$data[$x] = $y;
		}
		$data['cto_id'] = $id;
		$this->view('paket/form_paket', $data);
	}
	
	public function update()
	{
		$pesan['status'] = false;
		$cto_check = true;
		if ($this->input->post('nama') != "" ) {
			$data['nama'] = $this->input->post('nama');
		}else{
			$pesan['err_nama'] = 'Nama Paket cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('harga') != "" ) {
			if (is_numeric($this->input->post('harga'))) {
			   if($this->input->post('harga') > 0){
				  $data['harga'] = $this->input->post('harga');
			   }else{
				  $pesan['err_harga'] = 'Harga is must more than 0!';
				  $cto_check = false;
			   }
			}else{        $pesan['err_harga'] = 'Harga is must numeric!';
			   $cto_check = false;
			}
		}else{
			$pesan['err_harga'] = 'Harga cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('termin') != "" ) {
			$data['termin'] = $this->input->post('termin');
		}else{
			$pesan['err_termin'] = 'Jumlah Bayar cannot be empty!';
			$cto_check = false;
		}


		if (true) {
			$data['keterangan'] = $this->input->post('keterangan');
		}else{
			$pesan['err_keterangan'] = 'Keterangan cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('aktif') != "" ) {
			$data['aktif'] = $this->input->post('aktif');
		}else{
			$pesan['err_aktif'] = 'Aktif cannot be empty!';
			$cto_check = false;
		}

		try{
			if($cto_check){
				if($this->paket_model->update($this->input->post('id'), $data)){
					$pesan['messages'] = 'Data is saved';
					$pesan['status'] = true;
				}else{
					$pesan['messages'] = 'Data isn\'t saved!';
				}
			}else{
				$pesan['messages'] = 'Errors!';
			}
		}catch(Exception $e){
			$pesan['messages'] = $e->getMessage();
		}
		
		echo json_encode($pesan);
	}
	
	public function delete(){
		if(isset($_POST["id"])){
			if($this->paket_model->update($_POST["id"], array('is_active' => -1)))
			{
				$pesan['status'] = true;
				$pesan['messages'] = 'Deactivated';
				echo json_encode($pesan);
			}else{
				$pesan['status'] = false;
				$pesan['messages'] = 'Deactivated is failed!';
				echo json_encode($pesan);
			}
		}
	}
	
	public function undelete(){
		if(isset($_POST["id"])){
			if($this->paket_model->update($_POST["id"], array('is_active' => 1)))
			{
				$pesan['status'] = true;
				$pesan['messages'] = 'Reactivated';
				echo json_encode($pesan);
			}else{
				$pesan['status'] = false;
				$pesan['messages'] = 'Reactivated is failed!';
				echo json_encode($pesan);
			}
		}
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
