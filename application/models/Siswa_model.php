<?php
class Siswa_model extends MY_Model
{
	public function __construct() {
		parent::__construct();
	}
	
    protected $_table_name = 'p_siswa';
	protected $_cto_columns = array('no_induk', 'nama', 'jk', 'tgl_lahir', 'tempat_lahir', 'alamat', 'kelas', 'unit', 'asrama', 'kontak');
	
	
	public function nData($keyword = null, $orders = null){
		$querying = 'select count(*) as ndata from '.$this->_table_name;
		
        if ($keyword != null){
            $querying .= ' where no_induk like "%'.$keyword.'%" OR nama like "%'.$keyword.'%" OR alamat like "%'.$keyword.'%" OR kelas like "%'.$keyword.'%" OR asrama like "%'.$keyword.'%" OR kontak like "%'.$keyword.'%"';
        }
		
		$columns = $this->_cto_columns;
		if ($orders != null){
            $querying .= ' order by '.$columns[$orders[0]].' '.$orders[1];
        }else{
			$querying .= ' order by id desc';
		}
		
		$query = $this->db->query($querying);
		
        return $query->row()->ndata;
	}
	
	public function getData($keyword = null, $orders = null, $limit = null){
		$querying = '
		select `id`, `no_induk`, `nama`, case when `jk` = 1  then "Laki - laki" else "Perempuan" end jk,
		CONCAT(`tempat_lahir`, CONCAT(", ", date_format(`tgl_lahir`, "%d-%m-%Y"))) ttl, `alamat`, `kelas`, `unit`, `asrama`, `kontak`, case when is_active = 1 then \'Active\' else \'Deactive\' end AS is_active from '.$this->_table_name;
		
        if ($keyword != null){
            $querying .= ' where no_induk like "%'.$keyword.'%" OR nama like "%'.$keyword.'%" OR alamat like "%'.$keyword.'%" OR kelas like "%'.$keyword.'%" OR asrama like "%'.$keyword.'%" OR kontak like "%'.$keyword.'%"';
        }
		//echo ''.$querying;
		
		$columns = $this->_cto_columns;
		if ($orders != null){
            $querying .= ' order by '.$columns[$orders[0]].' '.$orders[1];
        }else{
			$querying .= ' order by id desc';
		}
		
		if ($limit != null){
			$querying .= ' limit '.$limit[0].', '.$limit[1];
        }
		
		$data = array();
		$query = $this->db->query($querying);
		foreach($query->result() as $row){
			$sub_array = array();
			$sub_array[] = $row->no_induk;
			$sub_array[] = $row->nama;
			$sub_array[] = $row->jk;
			$sub_array[] = $row->ttl;
			$sub_array[] = $row->kelas;
			$sub_array[] = $row->unit;
			$sub_array[] = $row->kontak;
			
			
			if($row->is_active == "Active"){
				$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="is_active"><i class="fa fa-circle green" style="color: green;">' . $row->is_active . '<i></div>';
				$sub_array[] = '<a href="'.base_url().'siswa/edit/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'"><li class="btn btn-xs fa fa-edit"></li></a>';
			}else{
				$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="is_active"><i class="fa fa-circle green" style="color: red;">' . $row->is_active . '<i></div>';
				$sub_array[] = '<a href="'.base_url().'siswa/edit/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'"><li class="btn btn-xs fa fa-edit"></li></a>';
			}
			
			$data[] = $sub_array;
		}
        return $data;
	}
	
	public function getAData($id){
        $query = $this->db->query('select * from '.$this->_table_name.' where id = '.$id.' limit 1');
		$result = array();
		foreach($query->result() as $row){
			$result['no_induk'] = $row->no_induk;
			$result['nama'] = $row->nama;
			$result['jk'] = $row->jk;
			$result['tgl_lahir'] = $row->tgl_lahir;
			$result['tempat_lahir'] = $row->tempat_lahir;
			$result['alamat'] = $row->alamat;
			$result['kelas'] = $row->kelas;
			$result['unit'] = $row->unit;
			$result['asrama'] = $row->asrama;
			$result['kontak'] = $row->kontak;
			$result['is_active'] = $row->is_active;
		}
		return $result;
    }
	
	public function check_no_induk_exist($no_induk){
		$query = $this->db->query("SELECT count(*) jml FROM ".$this->_table_name." WHERE no_induk = '".$no_induk."'");
		$result = $query->result_array();
		if($result[0]['jml'] > 0){
			return true;
		}else{
			return false;
		}
	}

	public function cto_getDatas(){
		$query = $this->db->query("SELECT id value, concat(no_induk, ' - ', nama) label FROM ".$this->_table_name." WHERE is_active != -1");
		$result = $query->result_array();
		return $result;
	}

}