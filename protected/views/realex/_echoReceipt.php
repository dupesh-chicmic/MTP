<?php
$pdf = Yii::createComponent('application.extensions.tcpdf.tcpdf', 'P', 'cm', 'A4', true, 'UTF-8');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("MTP");
$pdf->SetTitle('Realex transaction receipt');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont("dejavusans", '', 10, '', false);
$pdf->writeHTML($this->renderPartial('_viewReceipt', array('qpayRequest'=>$qpayRequest), true));
$pdf->lastPage();
$pdf->Output('mtp_realex_transaction_receipt.pdf', 'I');