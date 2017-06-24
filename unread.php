<?
		$host = 'mail.clippingimagesmails.com';
 
			$mbox = imap_open("{" . $host . ":993/imap/ssl/novalidate-cert}", 'info@clippingimagesmails.com', '4$\F+pZPua>69~k') or header("Could not connect. Something is wrong !");
			 
			 
			
			$check = imap_mailboxmsginfo($mbox);
			echo $check->Unread;
			
?>