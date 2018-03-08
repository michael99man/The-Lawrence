<?php

	$emailTo = "info@enterprise.com"; // Enter your email for feedbacks here
	
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	
	$subject = "Contact form message"; // Enter your subject here
	$body = "";

	reset($_POST);
	while (list($key, $val) = each($_POST)) {
		$title = ucwords(strtolower($key));
		$body .= "<b>$title:</b> ";
		$body .= $val;
	  	$body .= "<br>";
	}
	  
	$result = mail($emailTo, $subject, $body, $headers);
	
  ?>