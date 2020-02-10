<?php
class Paket_model extends MY_Model
{
	public function __construct() {
		parent::__construct();
	}
	
    protected $_table_name = 'p_paket';
	protected $_cto_columns = array('nama', 'harga', 'termin', 'keterangan', 'aktif');
	
	
	public function nData($keyword = null, $orders = null){
		$querying = 'select count(*) as ndata from '.$this->_table_name;
		
        if ($keyword != null){
            $querying .= ' where nama like "%'.$keyword.'%" OR harga like "%'.$keyword.'%" OR termin like "%'.$keyword.'%" OR keterangan like "%'.$keyword.'%" OR aktif like "%'.$keyword.'%"';
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
		select id, nama, harga, termin, keterangan, case when aktif = 1 then \'Active\' else \'Deactive\' end AS aktif from '.$this->_table_name;
		
        if ($keyword != null){
            $querying .= ' where nama like "%'.$keyword.'%" OR harga like "%'.$keyword.'%" OR termin like "%'.$keyword.'%" OR keterangan like "%'.$keyword.'%" OR aktif like "%'.$keyword.'%"';
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
			$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="nama">'.$row->nama . '</div>';
			$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="harga">'.$row->harga . '</div>';
			$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="termin">'.$row->termin . '</div>';
			$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="keterangan">'.$row->keterangan . '</div>';
			
			
			if($row->aktif == "Active"){
				$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="aktif"><i class="fa fa-circle green" style="color: green;">' . $row->aktif . '<i></div>';
				$sub_array[] = '<a href="'.base_url().'paket/edit/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Edit"><li class="btn btn-xs fa fa-edit"></li></a>'.
				'<a href="'.base_url().'paket/view_kartu_paket/'.$row->id.'" target="_blank" name="View_kartu_tagihan" class="btn lime" id="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="View Detail"><li class="btn btn-xs fa fa-file-text-o"></li></a>';
			}else{
				$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="aktif"><i class="fa fa-circle green" style="color: red;">' . $row->aktif . '<i></div>';
				$sub_array[] = '<a href="'.base_url().'paket/edit/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Edit"><li class="btn btn-xs fa fa-edit"></li></a>'.
				'<a href="'.base_url().'paket/view_kartu_paket/'.$row->id.'" target="_blank" name="View_kartu_tagihan" class="btn lime" id="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="View Detail"><li class="btn btn-xs fa fa-file-text-o"></li></a>';
			}
			
			$sub_array[] ='';
			$data[] = $sub_array;
		}
        return $data;
	}
	
	public function getAData($id){
        $query = $this->db->query('select * from '.$this->_table_name.' where id = '.$id.' limit 1');
		$result = array();
		foreach($query->result() as $row){
			$result['nama'] = $row->nama;
			$result['harga'] = $row->harga;
			$result['termin'] = $row->termin;
			$result['keterangan'] = $row->keterangan;
			$result['aktif'] = $row->aktif;
		}
		return $result;
    }
	
	public function cto_getDatas(){
		$query = $this->db->query("SELECT id value, nama label FROM ".$this->_table_name."");
		$result = $query->result_array();
		return $result;
	}

	public function getDataDetail($fk_paket_id){
            $query = $this->db->query('select * from p_paket_detail where fk_paket_id = '.$fk_paket_id.' order by id ASC');
            return $query->result();
        }

	public function create_paket_detail($id){
		$query = $this->db->query('select * from p_paket where id = '.$id.' limit 1');
		foreach($query->result() as $paket){
			$nominal_umum_awal = round($paket->harga/$paket->termin/1000);
			$nominal_umum = $nominal_umum_awal*1000;

			for($i = 1; $i <= $paket->termin; $i++){
				if($i != $paket->termin){
					$data['fk_paket_id'] = $id;
					$data['nominal'] = $nominal_umum;
					$data['created_by'] = $_SESSION['id'];
					$this->db->insert('p_paket_detail',$data);
					$this->db->affected_rows() ? true : false;
				}else{
					$data['fk_paket_id'] = $id;
					$data['nominal'] = $paket->harga-($nominal_umum*($i-1));
					$data['created_by'] = $_SESSION['id'];
					$this->db->insert('p_paket_detail',$data);
					$this->db->affected_rows() ? true : false;
				}
			}
		}
	}

	public function delete_paket_detail($fk_paket_id){
		$this->db->where('fk_paket_id', $fk_paket_id);
		$this->db->delete('p_paket_detail');
		return $this->db->affected_rows() ? true : false;
	}
	
}