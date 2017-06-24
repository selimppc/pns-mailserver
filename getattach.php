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