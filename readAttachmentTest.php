<?php
	function getAttachments($imap, $mailNum, $part, $partNum) {
	    $attachments = array();
	 
	    if (isset($part->parts)) {
	        foreach ($part->parts as $key => $subpart) {
	            if($partNum != "") {
	                $newPartNum = $partNum . "." . ($key + 1);
	            }
	            else {
	                $newPartNum = ($key+1);
	            }
	            $result = getAttachments($imap, $mailNum, $subpart,
	                $newPartNum);
	            if (count($result) != 0) {
	                 array_push($attachments, $result);
	             }
	        }
	    }
	    else if (isset($part->disposition)) {
	        if ($part->disposition == "ATTACHMENT") {
	            $partStruct = imap_bodystruct($imap, $mailNum,
	                $partNum);
	            $attachmentDetails = array(
	                "name"    => $part->dparameters[0]->value,
	                "partNum" => $partNum,
	                "enc"     => $partStruct->encoding
	            );
	            return $attachmentDetails;
	        }
	    }
	 
	    return $attachments;
	}
	
?>

<?php

$host = 'mail.clippingimagesmails.com';
 
			$imap = imap_open("{" . $host . ":110/pop3/notls}", 'info@clippingimagesmails.com', 'CI@Mailsrv') or header("Could not connect. Something is wrong !");
$count = imap_num_msg($imap);

for ($i = 14970; $i >= 14960; $i--) {			
	$mailStruct = imap_fetchstructure($imap, $i);
	$attachments = getAttachments($imap, $i, $mailStruct, "");

	echo  $i." Attachments: ";
	foreach ($attachments as $attachment) {

	echo '<a href="attachmentClass.php??download=' . $attachment["partNum"] . '&i=' . $i . '">' .
	    $attachment["name"]. "</a> ".$attachment["partNum"] . $attachment["enc"];
	
	}
		echo "<br>";
	}
?>