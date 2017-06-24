<?php
function downloadAttachment($imap, $uid, $partNum, $encoding) {
    $partStruct = imap_bodystruct($imap, imap_msgno($imap, $uid), $partNum);

    $filename = $partStruct->dparameters[0]->value;
    $message = imap_fetchbody($imap, $uid, $partNum, FT_UID);

    switch ($encoding) {
        case 0:
        case 1:
            $message = imap_8bit($message);
            break;
        case 2:
            $message = imap_binary($message);
            break;
        case 3:
            $message = imap_base64($message);
            break;
        case 4:
            $message = quoted_printable_decode($message);
            break;
    }

    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $filename);
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    echo $message;
}

$host = 'mail.clippingimagesmails.com';
 
			$imap = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");

$uid = $_GET['uid']; 
$partNum = $_GET['part']; 
$encoding = $_GET['enc'];
downloadAttachment($imap,$uid,$partNum,$encoding);

?>