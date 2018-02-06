<?php
//error_reporting(E_ALL);
/*
 $json2echo=array("speech"=> "Got it !","messages"=> [array("title"=> 'Oblivion',"subtitle"=> 'Oblivion is a SciFi film.',"buttons"=> [ array("text"=> "view film","postback"=>"https://www.moovrika.com/m/3520"),array("text"=> "Ask something else","postback"=>"I want to ask something else")],"type"=> 1)]);
 */
 /*
$json2echo=array("speech"=> "Got it !","messages"=> [array("title"=> 'Oblivion')]);
      header('Content-Type: application/json');
      echo json_encode($json2echo, JSON_UNESCAPED_SLASHES);
	  
	  */
	  
	  header('Content-Type: application/json');
ob_start();

$data = json_decode(file_get_contents('php://input'), true);

$intent 	=	$data['result']['metadata']['intentName'];

if(strtoupper($intent) == 'TRAVEL'){
	$from_city	=	$data['result']['parameters']['geo-city'];
	$to_city	=	$data['result']['parameters']['geo-city1'];
	$onwards_date	=	$data['result']['parameters']['date'];
	$return_date	=	$data['result']['parameters']['date1'];
	$user_email	=	$data['result']['parameters']['email'];
	
	$html_body	=	'
	Hi, <br/>
	New request from Chat Bot.<br.>
	
	<table border="1">
		<tr><td>Client E-Mail:</td><td>'.$user_email.'</td></tr>
		<tr><td>FROM</td><td>'.$from_city.'</td></tr>
		<tr><td>TO</td><td>'.$to_city.'</td></tr>
		<tr><td>On-Wards Date</td><td>'.$onwards_date.'</td></tr>
		<tr><td>Return Date</td><td>'.$return_date.'</td></tr>
	</table>
	';
	
	
	if(($from_city != '') && ($to_city != '') && ($user_email != '')){
		
		include "../classes/class.phpmailer.php"; // include the class name

		$mail = new PHPMailer;
		
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.apptixemail.net';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'qcms@wholdings.travel';                 // SMTP username
		$mail->Password = '0C35.2015';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		
		$mail->setFrom('qcms@wholdings.travel', 'Mailer');
		$mail->addAddress('dhiraj@wholdings.travel', 'Joe User');     // Add a recipient
		$mail->addReplyTo('dhiraj@wholdings.travel', 'Information');
		
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = 'Inquiry from BOT !';
		$mail->Body    = $html_body;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		$mail->send();
		
		$params	=	array();
		
		foreach($data['result']['parameters'] as $key => $value){
			$params[$key]	=	$value;
		}
	
			$outPutText	=	"We got it. We will send you the best deals for ".strtoupper($to_city)." on your email id. ";
	
			$output["contextOut"] = array(array("name" => "Got It"));
			$output["speech"] = $outPutText;
			$output["displayText"] = $outPutText;
			
			
			ob_end_clean();
			echo json_encode($output);
			
	}


}else{
		$country	=	$data['result']['parameters']['geo-country'];
		$age	=	$data['result']['parameters']['age'];
		$year	=	$data['result']['parameters']['year'];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'http://api.population.io:80/1.0/population/'.$year.'/'.$country.'/'.$age.'/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		$response = curl_exec($ch);
		$result = json_decode($response, true);
		
		if(($country != '') && ($age != '') && ($year != '')){
			$outPutText	=	'In '.$year.', the Population shows a total of '.$result[0]['males'].' males and '.$result[0]['females'].' females in '.$result[0]['country'].' in the age group of '.$result[0]['age'].' years.';
			/*
			$json2echo=array("speech"=> 'HI',"messages"=> [array("title"=> $outPutText)]);
				header('Content-Type: application/json');
				$json2echo=array("speech"=> "Got it !","messages"=> [array("title"=> 'Oblivion',"subtitle"=> 'Oblivion is a SciFi film.',"buttons"=> [ array("text"=> "view film","postback"=>"https://www.moovrika.com/m/3520"),array("text"=> "Ask something else","postback"=>"I want to ask something else")],"type"=> 1)]);
				
				echo json_encode($json2echo, JSON_UNESCAPED_SLASHES);*/
				$output["contextOut"] = array(array("name" => "Got It", "parameters" =>
			array("geo-country" => $country, "year" => $year, "age" => $age)));
			$output["speech"] = $outPutText;
			$output["displayText"] = $outPutText;
			
			ob_end_clean();
			echo json_encode($output);
		}
		
		
}



