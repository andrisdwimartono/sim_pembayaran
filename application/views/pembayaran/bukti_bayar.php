<?php
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Author here');
    $pdf->SetTitle('Bukti Pembayaran');
    $pdf->SetSubject('Bukti Pembayaran atas Tagihan');
    $pdf->SetKeywords('Bukti, Pembayaran');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Lembar Bukti Pembayaran no. '.$pembayaran['id'], $pembayaran['nama_institusi']);

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
    
    $html = '<table><tr><td width="100pt">No Induk</td><td width="10pt">:</td><td width="375pt">'.$pembayaran['no_induk'].'</td></tr>'
             . '<tr><td>Nama Siswa </td><td>:</td><td>'.$pembayaran['nama_siswa'].'</td></tr>'
             . '<tr><td>Tanggal Bayar </td><td>:</td><td>'.$pembayaran['tgl_bayar'].'</td></tr>'
             . '<tr><td>Total Bayar </td><td>:</td><td>Rp '.number_format($pembayaran['nominal_bayar'], 2).'</td></tr>'
             . '<tr><td>Terbilang </td><td>:</td><td><i>'.$pembayaran['terbilang_bayar'].' Rupiah</i></td></tr></table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    
    // reset pointer to the last page
    $pdf->lastPage();
    
    $html = '<div align="center">
    <table border="1" cellspacing="3" cellpadding="4">
        <tr>
            <th width="28pt"><b>No</b></th>
            <th width="325pt"><b>Peruntukan</b></th>
            <th width="125pt"><b>Nominal (Rp)</b></th>
        </tr>
        ';
    $tot_bayar = 0;
    for($pd = 0; $pd<count($pembayaran_detail);$pd++){
        $html .= '<tr>
            <td>'.($pd+1).'</td>
            <td align="left">'.$pembayaran_detail[$pd]['keterangan'].'</td>
            <td align="left">'.number_format($pembayaran_detail[$pd]['nominal'], 2).'</td>
        </tr>';
        $tot_bayar += $pembayaran_detail[$pd]['nominal'];
    }
        $html .= '
        <tr>
            <td colspan="2" align="right"><b>Total</b></td>
            <td align="left"><b>'.number_format($tot_bayar, 2).'</b></td>
        </tr>
    </table></div>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    // Print some HTML Cells
    
    $html = '<table border="1"><tr><td><b>Keterangan :</b><br>'.$pembayaran['keterangan'].'</td></tr></table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    
    // reset pointer to the last page
    $pdf->lastPage();
    
    $html = '<table align="left" border="0"><tr><td width="175pt"> </td><td width="160pt"> </td><td width="175pt">Surabaya, '.$pembayaran['tgl_bayar2'].'</td></tr>'
            . '<tr><td>Pembayar</td><td> </td><td>Petugas</td></tr>'
             . '<tr><td height="70pt"> </td><td> </td><td> </td></tr>'
             . '<tr><td>'.$pembayaran['nama_siswa'].'</td><td> </td><td>'.$pembayaran['petugas'].'</td></tr></table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    
    // reset pointer to the last page
    $pdf->lastPage();
    
    //Close and output PDF document
    $pdf->Output('bukti_bayar_'.$pembayaran['id'].'.pdf', 'I');
?>