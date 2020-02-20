<?php
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Author');
    $pdf->SetTitle('Kartu Tagihan dan Pembayaran');
    $pdf->SetSubject('Print Kartu Tagihan dan Pembayaran');
    $pdf->SetKeywords('Kartu, Tagihan, Bukti, Pembayaran');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Kartu Tagihan dan Pembayaran | ID-'.$id, $nama_institusi);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('dejavusans', '', 10);

    // add a page
    $pdf->AddPage();
    $html = '';
    $html = '<table><tr><td width="100pt">No Induk</td><td width="10pt">:</td><td width="100pt">'.$no_induk.'</td><td>  </td><td width="100pt">Jumlah Termin</td><td width="10pt">:</td><td width="100pt">'.$termin.'</td></tr>'
             . '<tr><td>Nama</td><td>:</td><td>'.$nama.'</td><td>  </td><td>Tagihan Ke</td><td>:</td><td>'.$tagihan_ke.'</td></tr>'
             . '<tr><td>Paket</td><td>:</td><td>'.$nama_paket.'</td><td>  </td><td>Status</td><td>:</td><td>'.$status.'</td></tr>'
             . '<tr><td>Harga</td><td>:</td><td>Rp '.number_format($harga, 2).'</td><td>  </td><td colspan="4"> </td></tr></table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    
    // reset pointer to the last page
    $pdf->lastPage();
    
    $html = '<div align="center"><b>Kartu Tagihan</b></div>
    <div align="center">
    <table border="1" cellspacing="3" cellpadding="4">
        <tr>
            <th width="28pt"><b>No</b></th>
            <th width="85pt"><b>Jatuh Tempo</b></th>
            <th width="125pt"><b>Nominal</b></th>
            <th width="125pt"><b>Nominal Terbayar</b></th>
            <th width="125pt"><b>Tunggakan</b></th>
        </tr>
        ';
    $i = 1;
    $tot = 0;
    $tot_bayar = 0;
    foreach($tagihan_detail as $tag_det){
        $html .= "<tr><td>".$i++."</td>";
        $html .= "<td>".$tag_det->jatuh_tempo."</td>";
        $html .= "<td>".number_format($tag_det->nominal, 2)."</td>";
        $html .= "<td>".number_format($tag_det->nominal_terbayar, 2)."</td>";
        $html .= "<td>".number_format($tag_det->nominal-$tag_det->nominal_terbayar, 2)."</td></tr>";
        $tot += $tag_det->nominal;
        $tot_bayar += $tag_det->nominal_terbayar;
    }
        $html .= '
        <tr>
            <td colspan="2" align="right"><b>Total</b></td>
            <td align="center"><b>'.number_format($tot, 2).'</b></td>
            <td align="center"><b>'.number_format($tot_bayar, 2).'</b></td>
            <td align="center"><b>'.number_format($tot-$tot_bayar, 2).'</b></td>
        </tr>
    </table></div>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    // Print some HTML Cells
    
$html = '<div align="center"><b>Tagihan</b></div>
    <div align="center">
    <table border="1" cellspacing="3" cellpadding="4">
        <tr>
            <th width="28pt"><b>No</b></th>
            <th width="85pt"><b>Tanggal Bayar</b></th>
            <th width="125pt"><b>Nominal Bayar</b></th>
            <th width="125pt"><b>Kembalian</b></th>
            <th width="125pt"><b>Status</b></th>
        </tr>
        ';
        $i = 1;
        $tot = 0;
        $tot_kembali = 0;
        foreach($pembayaran_detail as $pem_det){
            $coloring = "";
            if($pem_det->status == -1){
                $coloring = " style='color:red' ";
            }
            $html .= "<tr".$coloring."><td>".$i."</td>";
            $html .= "<td>".$pem_det->tgl_bayar."</td>";
            $html .= "<td>".number_format($pem_det->nominal_bayar, 2)."</td>";
            $html .= "<td>".number_format($pem_det->kembalian, 2)."</td>";
            if($pem_det->status == -1){
                $html .= "<td>Batal</td></tr>";
            }else{
                $html .= "<td>Diterima</td></tr>";
                $tot += $pem_det->nominal_bayar;
                $tot_kembali += $pem_det->kembalian;
            }
            $i++;
        }
        $html .= '
        <tr>
            <td colspan="2" align="right"><b>Total</b></td>
            <td align="center"><b>'.number_format($tot, 2).'</b></td>
            <td align="center"><b>'.number_format($tot_kembali, 2).'</b></td>
            <td align="center"></td>
        </tr>
    </table></div>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    //Close and output PDF document
    $pdf->Output('bukti_bayar_14.pdf', 'I');
?>