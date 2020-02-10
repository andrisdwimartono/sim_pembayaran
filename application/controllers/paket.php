<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('paket_model');
	}
	
	public function index()
	{
		$data['coba'] = 'welcome';
		$this->view('paket/list_paket', $data);
		//$this->view('layouts/content', $data);
		
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
			"recordsTotal"  =>  (int)$this->paket_model->nAllData(),
			"recordsFiltered" => intval($this->paket_model->nData($keyword, $orders)),
			"data"    => $this->paket_model->getData($keyword, $orders, $limit)
		);
		
		echo json_encode($output);
	}
	
	public function create()
	{
		$data['coba'] = 'welcome';
		$this->view('paket/form_paket', $data);
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
				$id = $this->paket_model->insertGetID($data);
				if(!empty($id)){
					$this->paket_model->create_paket_detail($id);
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
					$this->paket_model->delete_paket_detail($this->input->post('id'));
					$this->paket_model->create_paket_detail($this->input->post('id'));
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
		$data = $this->paket_model->cto_getDatas();
		echo json_encode($data);
	}

	public function view_kartu_paket($fk_paket_id){
		foreach($this->paket_model->getAData($fk_paket_id) as $x => $y){
			$data[$x] = $y;
		}
		$data['cto_id'] = $fk_paket_id;
		$data['paket_detail'] = $this->paket_model->getDataDetail($fk_paket_id);
		$this->view('paket/view_kartu_paket_detail', $data);
	}
}
