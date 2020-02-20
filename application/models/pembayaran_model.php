<?php
class Pembayaran_model extends MY_Model
{
	public function __construct() {
		parent::__construct();
	}
	
        protected $_table_name = 'p_bayar';
	protected $_cto_columns = array('fk_siswa_id', 'fk_tagihan_id', 'nominal_bayar', 'keterangan', 'status');
	
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
				$sub_array[] = '<a href="'.base_url().'tagihan/view_kartu_tagihan/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'" target="_blank"><li class="btn btn-xs fa fa-file"></li></a>';
			}else{
				$sub_array[] = '<div class="update" data-id="'.$row->id.'" data-column="aktif"><i class="fa fa-circle green" style="color: red;">' . $row->status . '<i></div>';
				$sub_array[] = '<a href="'.base_url().'tagihan/view_kartu_tagihan/'.$row->id.'" name="Edit" class="btn lime" id="'.$row->id.'" target="_blank"><li class="btn btn-xs fa fa-file"></li></a>';
			}
			
			$sub_array[] ='';
			$data[] = $sub_array;
		}
        return $data;
	}
	
	public function getAData($id){
        $query = $this->db->query("SELECT * FROM p_bayar pb
            INNER JOIN p_siswa ps ON ps.id = pb.fk_siswa_id
            WHERE pb.id = ".$id);
		$result = array();
		foreach($query->result() as $row){
                    $result['id'] = $row->id;
                    $result['fk_tagihan_id'] = $row->fk_tagihan_id;
                    $result['fk_siswa_id'] = $row->fk_siswa_id;
                    $result['nama'] = $row->nama;
                    $result['nominal_bayar'] = $row->nominal_bayar;
                    $result['tgl_bayar'] = $row->tgl_bayar;
                    $result['keterangan'] = $row->keterangan;
                    $result['status'] = $row->status;
		}
		return $result;
        }
        
        public function getDataDetail($fk_tagihan_id){
            $query = $this->db->query('SELECT pb.`id`, pb.`fk_siswa_id`, pb.`fk_tagihan_id`, date_format(pb.`tgl_bayar`, "%d/%m/%Y") tgl_bayar, pb.`nominal_bayar`, pbspreading.kembalian, pb.`keterangan`, pb.`status`, pb.`created_by`, pb.`created_time`, pb.`updated_by`, pb.`updated_time` FROM `p_bayar` pb '
                    . 'LEFT JOIN (SELECT sum(pbs.nominal) kembalian,  pbs.fk_bayar_id FROM p_bayar_spreading pbs WHERE pbs.fk_tagihan_detail_id is null and pbs.status != -1 GROUP BY pbs.fk_bayar_id) pbspreading ON pbspreading.fk_bayar_id = pb.id '
                    . 'WHERE pb.fk_tagihan_id = '.$fk_tagihan_id.' order by pb.id ASC');
            return $query->result();
        }
        
        public function getPembayaranInfo($fk_tagihan_id){
            $query = $this->db->query("SELECT 
                    pt.id,
                    ps.id fk_siswa_id,
                    ps.no_induk,
                    ps.nama,
                    pp.nama nama_paket,
                    pp.harga,
                    COALESCE(SUM(pb.nominal_bayar-pb.kembalian), 0) nominal_bayar,
                    pp.harga - COALESCE(SUM(pb.nominal_bayar-pb.kembalian), 0) sisa_tunggakan,
                    COALESCE(csd.name, CASE WHEN pp.harga - COALESCE(SUM(pb.nominal_bayar), 0) >  0 THEN 'Aktif' ELSE '-' END) status
                FROM
                    p_tagihan pt
                        INNER JOIN
                    p_paket pp ON pp.id = pt.fk_paket_id
                        INNER JOIN
                    p_siswa ps ON ps.id = pt.fk_siswa_id
                        INNER JOIN
                    p_bayar pb ON pt.id = pb.fk_tagihan_id AND pb.status != -1
                        INNER JOIN
                    cto_status_dict csd ON csd.code = pt.status
                        AND csd.table_name = 'p_tagihan'
                WHERE
                    pb.fk_tagihan_id = ".$fk_tagihan_id." ORDER BY pt.id DESC");
		$result = array();
		foreach($query->result() as $row){
                    $result['id'] = $row->id;
                    $result['fk_siswa_id'] = $row->fk_siswa_id;
                    $result['no_induk'] = $row->no_induk;
                    $result['nama'] = $row->nama;
                    $result['nama_paket'] = $row->nama_paket;
                    $result['harga'] = $row->harga;
                    $result['nominal_bayar'] = $row->nominal_bayar;
                    $result['sisa_tunggakan'] = $row->sisa_tunggakan;
                    $result['status'] = $row->status;
		}
		return $result;
        }
        
        public function insertPembayaranDetail($data){
		if(empty($data['created_by'])){
			$data['created_by'] = $_SESSION['id'];
		}
		$this->db->insert('p_bayar_spreading',$data);
		return $this->db->affected_rows() ? true : false;
	}
        
        public function deleteDet($fk_bayar_id, $data){
            if(empty($data['updated_by'])){
			$data['updated_by'] = $_SESSION['id'];
		}
            $this->db->where('fk_bayar_id', $fk_bayar_id);
            $this->db->update('p_bayar_spreading',$data);

            return $this->db->affected_rows() ? true : false;
        }
        
        public function getBuktiBayar($id){
        $query = $this->db->query("SELECT pb.id,
                    ps.no_induk,
                    pb.fk_siswa_id,
                    pb.fk_tagihan_id,
                    date_format(pb.tgl_bayar, '%d-%m-%Y') tgl_bayar,
                    CONCAT(date_format(pb.tgl_bayar, '%d'), ' ', cd.name, ' ', date_format(pb.tgl_bayar, '%Y')) tgl_bayar2,
                    pb.nominal_bayar,
                    pb.kembalian,
                    pb.keterangan,
                    COALESCE(csd.name, pb.status) status_name,
                    pb.status,
                    ps.nama nama_siswa,
                    pp.nama nama_paket,
                    pp.termin termin_paket,
                    pp.harga harga_paket,
                    cc.petugas,
                    cc.nama_institusi
                FROM sim_pembayaran.p_bayar pb
                LEFT JOIN cto_status_dict csd ON csd.code = pb.status
                INNER JOIN p_tagihan pt ON pt.id = pb.fk_tagihan_id
                INNER JOIN p_paket pp ON pt.fk_paket_id = pp.id
                INNER JOIN p_siswa ps ON ps.id = pb.fk_siswa_id
                LEFT JOIN cto_dict cd ON cd.code = date_format(pb.tgl_bayar, '%m') AND cd.type  = 'namabulan'
                LEFT JOIN (SELECT MAX(cc.id) id, cc.petugas, cc.name nama_institusi FROM cto_company cc) cc ON true
            WHERE pb.id = ".$id);
		$result = array();
		foreach($query->result() as $row){
                    $result['id'] = $row->id;
                    $result['fk_tagihan_id'] = $row->fk_tagihan_id;
                    $result['fk_siswa_id'] = $row->fk_siswa_id;
                    $result['no_induk'] = $row->no_induk;
                    $result['nama_siswa'] = $row->nama_siswa;
                    $result['nominal_bayar'] = $row->nominal_bayar;
                    $result['terbilang_bayar'] = $this->getTerbilang($row->nominal_bayar);
                    $result['tgl_bayar'] = $row->tgl_bayar;
                    $result['tgl_bayar2'] = $row->tgl_bayar2;
                    $result['keterangan'] = $row->keterangan;
                    $result['status'] = $row->status;
                    $result['status_name'] = $row->status_name;
                    $result['nama_paket'] = $row->nama_paket;
                    $result['petugas'] = $row->petugas;
                    $result['nama_institusi'] = $row->nama_institusi;
		}
		return $result;
        }
        
        public function getBuktiBayarDetail($fk_bayar_id){
        $query = $this->db->query("SELECT pbs.id, 
            pbs.fk_bayar_id, 
            SUM(pbs.nominal) nominal,
            pbs.status,
            ca.account_name keterangan
            FROM sim_pembayaran.p_bayar_spreading pbs
            LEFT JOIN cto_account ca ON ca.code = CASE WHEN pbs.fk_tagihan_detail_id is null then 4 else pbs.status END
            WHERE pbs.fk_bayar_id = ".$fk_bayar_id."
            GROUP BY ca.account_name");
            $result = array();
            foreach($query->result() as $row){
                $res = array();
                $res['id'] = $row->id;
                $res['fk_bayar_id'] = $row->fk_bayar_id;
                $res['nominal'] = $row->nominal;
                $res['status'] = $row->status;
                $res['keterangan'] = $row->keterangan;
                array_push($result, $res);
            }
            return $result;
        }
        
        function getTerbilang($nilai){
            $nilai = abs($nilai);
            $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
            $temp = "";
            if ($nilai < 12) {
                    $temp = " ". $huruf[$nilai];
            } else if ($nilai <20) {
                    $temp = $this->getTerbilang($nilai - 10). " Belas";
            } else if ($nilai < 100) {
                    $temp = $this->getTerbilang($nilai/10)." Puluh". $this->getTerbilang($nilai % 10);
            } else if ($nilai < 200) {
                    $temp = " Seratus" . $this->getTerbilang($nilai - 100);
            } else if ($nilai < 1000) {
                    $temp = $this->getTerbilang($nilai/100) . " Ratus" . $this->getTerbilang($nilai % 100);
            } else if ($nilai < 2000) {
                    $temp = " Seribu" . $this->getTerbilang($nilai - 1000);
            } else if ($nilai < 1000000) {
                    $temp = $this->getTerbilang($nilai/1000) . " Ribu" . $this->getTerbilang($nilai % 1000);
            } else if ($nilai < 1000000000) {
                    $temp = $this->getTerbilang($nilai/1000000) . " Juta" . $this->getTerbilang($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                    $temp = $this->getTerbilang($nilai/1000000000) . " Milyar" . $this->getTerbilang(fmod($nilai,1000000000));
            } else if ($nilai < 1000000000000000) {
                    $temp = $this->getTerbilang($nilai/1000000000000) . " Trilyun" . $this->getTerbilang(fmod($nilai,1000000000000));
            }     
            return $temp;
        }
}