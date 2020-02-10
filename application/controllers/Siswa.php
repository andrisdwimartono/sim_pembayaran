<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('siswa_model');
	}
	
	public function index()
	{
		$data['coba'] = 'welcome';
		$this->view('siswa/list_siswa', $data);
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
			"recordsTotal"  =>  (int)$this->siswa_model->nAllData(),
			"recordsFiltered" => intval($this->siswa_model->nData($keyword, $orders)),
			"data"    => $this->siswa_model->getData($keyword, $orders, $limit)
		);
		
		echo json_encode($output);
	}
	
	public function create()
	{
		$data['coba'] = 'welcome';
		$this->view('siswa/form_siswa', $data);
	}
	
	public function insert()
	{
		$pesan['status'] = false;
		$cto_check = true;

		if ($this->input->post('no_induk') != "" ) {
			if(!$this->siswa_model->check_no_induk_exist($this->input->post('no_induk'))){
				$data['no_induk'] = $this->input->post('no_induk');
			}else{
				$pesan['err_no_induk'] = 'NPSN sudah ada!';
				$cto_check = false;
			}
		}else{
			$pesan['err_no_induk'] = 'No Induk cannot be empty!';
			$cto_check = false;
		}

		if ($this->input->post('nama') != "" ) {
			$data['nama'] = $this->input->post('nama');
		}else{
			$pesan['err_nama'] = 'Nama cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('jk') != "" ) {
			$data['jk'] = $this->input->post('jk');
		}else{
			$pesan['err_jk'] = 'Jenis Kelamin cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('tgl_lahir') != "" ) {
		$tgl = date('Y-m-d', strtotime($this->input->post('tgl_lahir')));
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$tgl)) {
		$data['tgl_lahir'] = $tgl;
		}else{
		$pesan['errors'] = 'Format Tanggal Lahir harus yyyy-mm-dd!';
		}
		}else{
		$pesan['errors'] = 'Tanggal Lahir tidak boleh kosong!';
		}


		if ($this->input->post('tempat_lahir') != "" ) {
			$data['tempat_lahir'] = $this->input->post('tempat_lahir');
		}else{
			$pesan['err_tempat_lahir'] = 'Tempat Lahir cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('alamat') != "" ) {
			$data['alamat'] = $this->input->post('alamat');
		}else{
			$pesan['err_alamat'] = 'Alamat cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('kelas') != "" ) {
			$data['kelas'] = $this->input->post('kelas');
		}else{
			$pesan['err_kelas'] = 'Kelas cannot be empty!';
			$cto_check = false;
		}


		if (true) {
			$data['unit'] = $this->input->post('unit');
		}else{
			$pesan['err_unit'] = 'Unit cannot be empty!';
			$cto_check = false;
		}


		if (true) {
			$data['asrama'] = $this->input->post('asrama');
		}else{
			$pesan['err_asrama'] = 'Asrama cannot be empty!';
			$cto_check = false;
		}


		if (true) {
			$data['kontak'] = $this->input->post('kontak');
		}else{
			$pesan['err_kontak'] = 'Kontak Telp/HP cannot be empty!';
			$cto_check = false;
		}

		
		if ($this->input->post('is_active') != "" ) {
			$data['is_active'] = $this->input->post('is_active');
		}else{
			$pesan['err_is_active'] = 'Aktif cannot be empty!';
			$cto_check = false;
		}


		try{
			if($cto_check){
				if($this->siswa_model->insert($data)){
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
		foreach($this->siswa_model->getAData($id) as $x => $y){
			$data[$x] = $y;
		}
		$data['cto_id'] = $id;
		$this->view('siswa/form_siswa', $data);
	}
	
	public function update()
	{
		$pesan['status'] = false;
		$cto_check = true;
		if ($this->input->post('no_induk') != "" ) {
			if(!$this->siswa_model->check_no_induk_exist($this->input->post('no_induk'))){
				$data['no_induk'] = $this->input->post('no_induk');
			}else{
				$pesan['err_no_induk'] = 'NPSN sudah ada!';
				$cto_check = false;
			}
		}else{
			$pesan['err_no_induk'] = 'No Induk cannot be empty!';
			$cto_check = false;
		}

		if ($this->input->post('nama') != "" ) {
			$data['nama'] = $this->input->post('nama');
		}else{
			$pesan['err_nama'] = 'Nama cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('jk') != "" ) {
			$data['jk'] = $this->input->post('jk');
		}else{
			$pesan['err_jk'] = 'Jenis Kelamin cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('tgl_lahir') != "" ) {
		$tgl = date('Y-m-d', strtotime($this->input->post('tgl_lahir')));
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$tgl)) {
		$data['tgl_lahir'] = $tgl;
		}else{
		$pesan['errors'] = 'Format Tanggal Lahir harus yyyy-mm-dd!';
		}
		}else{
		$pesan['errors'] = 'Tanggal Lahir tidak boleh kosong!';
		}


		if ($this->input->post('tempat_lahir') != "" ) {
			$data['tempat_lahir'] = $this->input->post('tempat_lahir');
		}else{
			$pesan['err_tempat_lahir'] = 'Tempat Lahir cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('alamat') != "" ) {
			$data['alamat'] = $this->input->post('alamat');
		}else{
			$pesan['err_alamat'] = 'Alamat cannot be empty!';
			$cto_check = false;
		}


		if ($this->input->post('kelas') != "" ) {
			$data['kelas'] = $this->input->post('kelas');
		}else{
			$pesan['err_kelas'] = 'Kelas cannot be empty!';
			$cto_check = false;
		}


		if (true) {
			$data['unit'] = $this->input->post('unit');
		}else{
			$pesan['err_unit'] = 'Unit cannot be empty!';
			$cto_check = false;
		}


		if (true) {
			$data['asrama'] = $this->input->post('asrama');
		}else{
			$pesan['err_asrama'] = 'Asrama cannot be empty!';
			$cto_check = false;
		}


		if (true) {
			$data['kontak'] = $this->input->post('kontak');
		}else{
			$pesan['err_kontak'] = 'Kontak Telp/HP cannot be empty!';
			$cto_check = false;
		}
		
		if ($this->input->post('is_active') != "" ) {
			$data['is_active'] = $this->input->post('is_active');
		}else{
			$pesan['err_is_active'] = 'Aktif cannot be empty!';
			$cto_check = false;
		}

		try{
			if($cto_check){
				if($this->siswa_model->update($this->input->post('id'), $data)){
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
			if($this->siswa_model->update($_POST["id"], array('is_active' => -1)))
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
			if($this->siswa_model->update($_POST["id"], array('is_active' => 1)))
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
		$data = $this->siswa_model->cto_getDatas();
		echo json_encode($data);
	}
}
