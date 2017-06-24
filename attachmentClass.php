<?php
//--------------------- download attachment
function get_attached_file($mbox,$structure,$k,$mid)
{
        $encoding = $structure->parts[$k]->encoding;
        //extract file name from headers
        $fileName = strtolower($structure->parts[$k]->dparameters[0]->value);
        //extract attachment from email body
        $fileSource = base64_decode(imap_fetchbody($mbox, $mid, $k+1));
        
        //get extension
        $ext = substr($fileName, strrpos($fileName, '.') + 1);
        //die($ext);
        
        //get mime file type
        switch ($ext) {
        case "asf":
                $type = "video/x-ms-asf";
                break;
        case "avi":
                $type = "video/avi";
                break;
        case "flv":
                $type = "video/x-flv";
                break;
        case "fla":
                $type = "application/octet-stream";
                break;
        case "swf":
                $type = "application/x-shockwave-flash";
                break;          
        case "doc":
                $type = "application/msword";
                break;
        case "docx":
                $type = "application/msword";
                break;
        case "zip":
                $type = "application/zip";
                break;
        case "xls":
                $type = "application/vnd.ms-excel";
                break;
        case "gif":
                $type = "image/gif";
                break;
        case "jpg" || "jpeg":
                $type = "image/jpg";
                break;
        case "png":
                $type = "image/png";
                break;          
        case "wav":
                $type = "audio/wav";
                break;
        case "mp3":
                $type = "audio/mpeg3";
                break;
        case "mpg" || "mpeg":
                $type = "video/mpeg";
                break;
        case "rtf":
                $type = "application/rtf";
                break;
        case "htm" || "html":
                $type = "text/html";
                break;
        case "xml":
                $type = "text/xml";
                break;  
        case "xsl":
                $type = "text/xsl";
                break;
        case "css":
                $type = "text/css";
                break;
        case "php":
                $type = "text/php";
                break;
        case "txt":
                $type = "text/txt";
                break;
        case "asp":
                $type = "text/asp";
                break;
        case "pdf":
                $type = "application/pdf";
                break;
        case "psd":
                $type = "application/octet-stream";
                break;
        default:
                $type = "application/octet-stream";
        }
        
        //download file
        header('Content-Description: File Transfer');
        header('Content-Type: ' .$type);
        header('Content-Disposition: attachment; filename='.$fileName);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileSource));
        ob_clean();
        flush();
        echo $fileSource;
}

        //$mbox = imap stream
        //$mid = message id
        //$parno = message part number
        $partno = $_GET['download'];
        $i = $_GET['i'];
       $host = 'mail.clippingimagesmails.com';
 
	$mbox = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
        $structure = imap_fetchstructure($mbox, $i);
        get_attached_file($mbox,$structure,$partno,$i);
?>