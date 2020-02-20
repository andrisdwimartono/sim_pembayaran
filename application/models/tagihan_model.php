<?php
class Tagihan_model extends MY_Model
{
	public function __construct() {
		parent::__construct();
	}
	
        protected $_table_name = 'p_tagihan';
	protected $_cto_columns = array('fk_siswa_id', 'fk_paket_id', 'status');
	
	
	public function nData($keyword = null, $orders = null){
		$querying = "select count(*) as ndata from (SELECT pt.id, ps.no_induk, ps.nama, pp.nama nama_paket, pp.harga, pp.termin, ctd.name status FROM p_tagihan pt
                INNER JOIN p_siswa ps ON ps.id = pt.fk_siswa_id
                INNER JOIN p_paket pp ON pp.id = pt.fk_paket_id
                INNER JOIN cto_status_dict ctd ON ctd.code = pt.status AND ctd.table_name = 'p_tagihan') tagihan ";
		
        if ($keyword != null){
            $querying .= " where no_induk like '%".$keyword."%' OR nama like '%".$keyword."%' OR harga like '%".$keyword."%' OR termin like '%".$keyword."%' OR status like '%".$keyword."%'";
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
		$querying = "select * from (SELECT pt.id, ps.no_induk, ps.nama, pp.nama nama_paket, pp.harga, pp.termin, pt.tagihan_ke, ctd.name status FROM p_tagihan pt
                INNER JOIN p_siswa ps ON ps.id = pt.fk_siswa_id
                INNER JOIN p_paket pp ON pp.id = pt.fk_paket_id
                INNER JOIN cto_status_dict ctd ON ctd.code = pt.status AND ctd.table_name = 'p_tagihan') tagihan ";
		
        if ($keyword != null){
            $querying .= " where no_induk like '%".$keyword."%' OR nama like '%".$keyword."%' OR harga like '%".$keyword."%' OR termin like '%".$keyword."%' OR status like '%".$keyword."%'";
        }
		//echo ''.$querying;
		
		$columns = $this->_cto_columns; 
	if ($orders != null){
            $querying .= ' order by '.$columns[$orders[0]].' '.$orders[1];
        }else{
			$querying .= ' order by status, id desc';
		}
		
		if ($limit != null){
			$querying .= ' limit '.$limit[0].', '.$limit[1];
        }
		
		$data = array();
		$query = $this->db->query($querying);
		foreach($query->result() as $row){
			$sub_array = array();
                        $sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="no_induk">'.$row->no_induk . '</div>';
			$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="nama">'.$row->nama . '</div>';
                        $sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="nama_paket">'.$row->nama_paket . '</div>';
			$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="harga">'.$row->harga . '</div>';
			$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="termin">'.$row->termin . '</div>';
                        $sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="tagihan_ke">'.$row->tagihan_ke . '</div>';
			
			
			if($row->status == "Aktif"){
				$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="aktif"><i class="fa fa-circle green" style="color: green;">' . $row->status . '<i></div>';
				$sub_array[] = '<a href="'.base_url().'tagihan/view_kartu_tagihan/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'" target="_blank"><li class="btn btn-xs fa fa-file"></li></a>'
                                        . '<a href="'.base_url().'tagihan/kartu_tagihan/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'" target="_blank"><li class="btn btn-xs fa fa-print"></li></a>'
                                        . '<a href="#" name="Edit" class="btn lime" id="bayar'.$row->id.'" onclick="openBayarForm('.$row->id.')"><li class="btn btn-xs fa fa-money"></li></a>';
			}else{
				$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="aktif"><i class="fa fa-circle green" style="color: red;">' . $row->status . '<i></div>';
				$sub_array[] = '<a href="'.base_url().'tagihan/view_kartu_tagihan/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'" target="_blank"><li class="btn btn-xs fa fa-file"></li></a>'
                                        . '<a href="'.base_url().'tagihan/kartu_tagihan/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'" target="_blank"><li class="btn btn-xs fa fa-print"></li></a>';
			}
			
			$sub_array[] ='';
			$data[] = $sub_array;
		}
        return $data;
	}
	
	public function getAData($id){
        $query = $this->db->query("select * from (SELECT pt.id, ps.no_induk, ps.nama, pp.nama nama_paket, pp.harga, pp.termin, pt.tagihan_ke, ctd.name status, pt.status status_code, pp.keterangan, cc.nama_institusi, cc.petugas FROM p_tagihan pt
                INNER JOIN p_siswa ps ON ps.id = pt.fk_siswa_id
                INNER JOIN p_paket pp ON pp.id = pt.fk_paket_id
                INNER JOIN cto_status_dict ctd ON ctd.code = pt.status AND ctd.table_name = 'p_tagihan'
                LEFT JOIN (SELECT MAX(cc.id) id, cc.petugas, cc.name nama_institusi FROM cto_company cc) cc ON true) tagihan 
                WHERE  tagihan.id = ".$id);
		$result = array();
		foreach($query->result() as $row){
                    $result['id'] = $row->id;
                    $result['no_induk'] = $row->no_induk;
                    $result['nama'] = $row->nama;
                    $result['nama_paket'] = $row->nama_paket;
                    $result['harga'] = $row->harga;
                    $result['termin'] = $row->termin;
                    $result['tagihan_ke'] = $row->tagihan_ke;
                    $result['keterangan'] = $row->keterangan;
                    $result['status'] = $row->status;
                    $result['status_code'] = $row->status_code;
                    $result['nama_institusi'] = $row->nama_institusi;
                    $result['status_code'] = $row->status_code;
                    $result['petugas'] = $row->petugas;
		}
		return $result;
        }
        
        public function getDataDetail($fk_tagihan_id){
            $query = $this->db->query('select `ptd`.`id`,
            `ptd`.`fk_tagihan_id`,
            date_format(`ptd`.`jatuh_tempo`, "%d/%m/%Y") jatuh_tempo,
            `ptd`.`nominal`,
            `ptd`.`terbayar_uptodate`,
            pbspreading.nominal_terbayar,
            ptd.nominal-COALESCE(pbspreading.nominal_terbayar, 0) sisa_tunggakan,
            `ptd`.`sisa_uptodate`,
            `ptd`.`aktif`,
            `ptd`.`created_time`,
            `ptd`.`created_by`,
            `ptd`.`updated_time`,
            `ptd`.`updated_by` from p_tagihan_detail ptd 
            LEFT JOIN (SELECT SUM(pbs.nominal) nominal_terbayar, pbs.fk_tagihan_detail_id FROM p_bayar_spreading pbs WHERE pbs.status != -1 GROUP BY pbs.fk_tagihan_detail_id) pbspreading ON pbspreading.fk_tagihan_detail_id = ptd.id
            where fk_tagihan_id = '.$fk_tagihan_id.' order by id ASC');
            return $query->result();
        }

	public function insertDetail($fk_tagihan_id){
		$this->db->query("INSERT INTO p_tagihan_detail(fk_tagihan_id, jatuh_tempo, nominal, sisa_uptodate, created_by)  
			SELECT pt.id, CONCAT( date_format(now(), '%Y'), '-',  (date_format(now(), '%m')+(@row:=@row+1)), '-', '01'), ppd.nominal, ppd.nominal, ".$_SESSION['id']." FROM p_tagihan AS pt
			INNER JOIN p_paket pp ON pp.id = pt.fk_paket_id
			INNER JOIN p_paket_detail ppd ON pp.id = ppd.fk_paket_id
			INNER JOIN (SELECT @row:=-1) AS row_count
			WHERE pt.id = ".$fk_tagihan_id);
                
		return $this->db->affected_rows() ? true : false;
	}
        
        public function countTagihan($fk_siswa_id){
            $query = $this->db->query('select count(*)+1 jml from '.$this->_table_name.' where fk_siswa_id = '.$fk_siswa_id.' limit 1');
		$jml = 0;
		foreach($query->result() as $row){
			$jml = $row->jml;
			
		}
            return $jml;
        }
        
        public function checkHasTagihan($fk_siswa_id){
            $query = $this->db->query('select count(*) jml from '.$this->_table_name.' where fk_siswa_id = '.$fk_siswa_id.' and status = 1 limit 1');
            $jml = 0;
            foreach($query->result() as $row){
                    $jml = $row->jml;

            }
            if($jml > 0){
                return true;
            }else{
                return false;
            }
        }
	
	
}