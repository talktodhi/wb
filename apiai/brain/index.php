<?php

//error_reporting(E_ALL);
/*
 $json2echo=array("speech"=> "Got it !","messages"=> [array("title"=> 'Oblivion',"subtitle"=> 'Oblivion is a SciFi film.',"buttons"=> [ array("text"=> "view film","postback"=>"https://www.moovrika.com/m/3520"),array("text"=> "Ask something else","postback"=>"I want to ask something else")],"type"=> 1)]);
 
 */
header('Content-Type: application/json');
ob_start();

		/*
		ob_end_clean();
		echo json_encode($json2echo);
//echo $json2echo;
exit;
*/
$data = json_decode(file_get_contents('php://input'), true);

$intent 	=	$data['result']['metadata']['intentName'];



if(strtoupper($intent) == 'TRAVEL'){

		
	$from_city		=	$data['result']['parameters']['geo-city'];
	$to_city		=	$data['result']['parameters']['geo-city1'];
	$onwards_date	=	$data['result']['parameters']['date'];
	$return_date	=	$data['result']['parameters']['date1'];
	$trip_type		=	$data['result']['parameters']['route-type'];
	$cabin			=	$data['result']['parameters']['cabin'];
	$airline		=	$data['result']['parameters']['airline'];
	$user_email		=	$data['result']['parameters']['email'];
	
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
	$html_body2 = "<html xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:w=\"urn:schemas-microsoft-com:office:word\"
  xmlns:m=\"http://schemas.microsoft.com/office/2004/12/omml\" xmlns=\"http://www.w3.org/TR/REC-html40\">

<head>
  <meta charset=\"utf-8\">
  <link rel=File-List href=\"Spotify%20-%20Prepayment%20Confirmation_files/filelist.xml\">
  <link rel=Edit-Time-Data href=\"Spotify%20-%20Prepayment%20Confirmation_files/editdata.mso\">
  <!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
  <!--[if gte mso 9]><xml>
 <o:OfficeDocumentSettings>
  <o:AllowPNG/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
  <link rel=themeData href=\"Spotify%20-%20Prepayment%20Confirmation_files/themedata.thmx\">
  <link rel=colorSchemeMapping href=\"Spotify%20-%20Prepayment%20Confirmation_files/colorschememapping.xml\">
</head>

<body>
  <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">
    <tr>
      <td align=\"center\">
        <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
            <td width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td width=\"600\" valign=\"top\">
              <p align=\"center\" style=\"text-align:center\">
                <!--[if gte vml 1]><v:shapetype
     id=\"_x0000_t75\" coordsize=\"21600,21600\" o:spt=\"75\" o:preferrelative=\"t\"
     path=\"m@4@5l@4@11@9@11@9@5xe\" filled=\"f\" stroked=\"f\">
     <v:stroke joinstyle=\"miter\"/>
     <v:formulas>
      <v:f eqn=\"if lineDrawn pixelLineWidth 0\"/>
      <v:f eqn=\"sum @0 1 0\"/>
      <v:f eqn=\"sum 0 0 @1\"/>
      <v:f eqn=\"prod @2 1 2\"/>
      <v:f eqn=\"prod @3 21600 pixelWidth\"/>
      <v:f eqn=\"prod @3 21600 pixelHeight\"/>
      <v:f eqn=\"sum @0 0 1\"/>
      <v:f eqn=\"prod @6 1 2\"/>
      <v:f eqn=\"prod @7 21600 pixelWidth\"/>
      <v:f eqn=\"sum @8 21600 0\"/>
      <v:f eqn=\"prod @7 21600 pixelHeight\"/>
      <v:f eqn=\"sum @10 21600 0\"/>
     </v:formulas>
     <v:path o:extrusionok=\"f\" gradientshapeok=\"t\" o:connecttype=\"rect\"/>
     <o:lock v:ext=\"edit\" aspectratio=\"t\"/>
    </v:shapetype><v:shape id=\"_x0000_i1030\" type=\"#_x0000_t75\" style='width:302px;
     height:45px'>
     <v:imagedata src=\"Spotify%20-%20Prepayment%20Confirmation_files/image001.png\" o:title=\"Spotify + WTMC\"/>
    </v:shape><![endif]-->
                <![if !vml]>
                <img height=45 src=\"http://www.wholdings.travel/images/logo_wtmc_big.png\" v:shapes=\"_x0000_i1030\">
                <![endif]>
              </p>
            </td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr style=\"margin:0;padding:0;\">
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#0081C2; margin:0;padding:0;\">
              <strong>Hello!</strong>
            </td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">It is a long established fact that a reader will be distracted by the readable content of a page when looking
              at its layout.</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">
              <!--<table role=\"presentation\" bgcolor=\"#fff\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\" align=\"center\" width=\"600\" style=\"max-width:100%; margin: auto; border-top: 2px solid #0388c3; background-color: #fff\"
                class=\"email-container\">
                <tbody>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
                      <table class=\"email-container\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"max-width: 600px; margin: auto;\">
                        <tbody>
                          <tr>
                            <td class=\"airLogo\" style=\"width:13%; vertical-align: top;\">
                              <div style=\"width: 50px; height:50px; margin: auto; text-align: center; \">
                                <img style=\"max-width: 100%;\" src='http://www.wholdings.travel/images/wtmc_air_icon.png' width=\"50\" border=\"0\" alt=\"Air\"
                                  title=\"Air\">
                              </div>
                            </td>
                            <td style=\"width: 87%; text-align:left;\">
                              <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">
                                <tbody>
                                  <tr>
                                    <td class=\"airjourney\" style=\"font-size: 1.6em; width: 100%; text-align:left; vertical-align: middle; font-weight: normal;color: #666;\"
                                      colspan=\"2\">Frankfurt to Bangalore</td>
                                  </tr>
                                  <tr>
                                    <td style=\"padding:10px;\" colspan=\"2\"></td>
                                  </tr>
                                  <tr>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Departure Date</span> Thus, Jan 19</div>
                                    </td>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Departure Time</span> Early Morning</div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style=\"padding:10px;\" colspan=\"2\"></td>
                                  </tr>
                                  <tr>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Return Date</span> Early Morning</div>
                                    </td>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Return Time</span> Early Morning</div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style=\"padding:10px;\" colspan=\"2\"></td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style=\"width:13%; vertical-align: top;\"></td>
                            <td style=\"width: 87%; text-align:left;\">
                              
                              <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border-top: 2px solid #eee;\">
                                <tbody>
                                  <tr>
                                    <td colspan=\"2\">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align=\"left\" style=\"width:49%;\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Cabin</span> Business</div>
                                      <div style=\"height:10px;\">&nbsp;</div>
                                    </td>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Flight Type</span> One Way</div>
                                      <div style=\"height:10px;\">&nbsp;</div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Additional request</span> No</div>
                                      <div style=\"height:10px;\">&nbsp;</div>
                                    </td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan=\"2\">&nbsp;</td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>-->
              <table role=\"presentation\" bgcolor=\"#fff\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\" align=\"center\" width=\"600\" style=\"max-width:100%; margin: auto; border-top: 2px solid #0388c3; background-color: #fff\"
                class=\"email-container\">
                <tbody>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
                      <table class=\"email-container\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"max-width: 600px; margin: auto;\">
                        <tbody>
                          <tr>
                            <td class=\"airLogo\" style=\"width:13%; vertical-align: top;\">
                              <div style=\"width: 50px; height:50px; margin: auto; text-align: center; \">
                                <img style=\"max-width: 100%;\" src=\"http://www.wholdings.travel/images/wtmc_air_icon.png\" width=\"50\" border=\"0\" alt=\"Air\"
                                  title=\"Air\">
                              </div>
                            </td>
                            <td style=\"width: 87%; text-align:left;\">
                              <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">
                                <tbody>
                                  <tr>
                                    <td class=\"airjourney\" style=\"font-size: 1.6em; width: 100%; text-align:left; vertical-align: middle; font-weight: normal;color: #666;\"
                                      colspan=\"2\">".ucfirst($from_city)." to ".ucfirst($to_city)."</td>
                                  </tr>
                                  <tr>
                                    <td style=\"padding:10px;\" colspan=\"2\"></td>
                                  </tr>
                                  <tr>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Departure Date</span> ".date("D, M d",strtotime($onwards_date))."</div>
                                    </td>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Departure Time</span> Early Morning</div>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td style=\"width:13%; vertical-align: top;\"></td>
                            <td style=\"width: 87%; text-align:left;\">
                              <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border-top: 2px solid #eee; margin-top: 15px !important;\">
                                <tbody>
                                  <tr>
                                    <td colspan=\"2\">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align=\"left\" style=\"width:49%;\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Cabin</span> ".ucfirst($cabin)."</div>
                                      <div style=\"height:10px;\">&nbsp;</div>
                                    </td>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Flight Type</span> ".ucfirst($trip_type)."</div>
                                      <div style=\"height:10px;\">&nbsp;</div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Additional request</span> No</div>
                                      <div style=\"height:10px;\">&nbsp;</div>
                                    </td>
                                    <td>&nbsp;</td>
                                  </tr>
								  <tr>
                                    <td align=\"left\">
                                      <div style=\"width:70%; display: inline-block; color:#000; text-align:left; font-size:0.85em; vertical-align: top; color: #999; text-align: left; line-height: normal;\">
                                        <span style=\"color: #999; display: block; margin-bottom: 3px; font-weight: bold;\">Preferred Airline</span> ".ucfirst($airline)."</div>
                                      <div style=\"height:10px;\">&nbsp;</div>
                                    </td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan=\"2\">&nbsp;</td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">
              There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form
              <a href=\"mailto:travel@wtmc.com\" style=\"color:#0083C3; font-weight:bold; text-decoration: none;\"> travel@wtmc.com</a>
            </td>
          </tr>

          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">Looking forward to working with you! </td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#0081C2;\">
              <strong>Thank you,</strong>
            </td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#0081C2;\">
              <strong>WTMC</strong>
            </td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
          <tr>
            <td height=\"1.2em\" width=\"600\" valign=\"top\" style=\"line-height:1.2em; font-size:11pt; font-family:'Arial', Helvetica, 'sans-serif'; color:#595959;\">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align=\"center\">
        <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
            <td width=\"600\">
              <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr>
                  <td width=\"600\" valign=\"top\">
                    <table border=\"0\" cellspacing=\"0\">
                      <tr>
                        <td style=\"padding: 8px 0px; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 12px; color:#0083C3; text-transform: uppercase; font-weight: bold;\">WTMC</td>
                        <td style=\"padding: 8px 8px; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 12px; color:#0083C3; text-transform: uppercase;\">
                          <span style=\"color:#0083C3; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 12px;\">●</span>
                        </td>
                        <td style=\"padding: 8px 0; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 12px; color:#0083C3; text-transform: uppercase;\">TRAVELER SUPPORT</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-top: #0083C3 3px solid;\">
    <tr>
      <td align=\"center\">
        <table>
          <tr>
            <td width=\"600\">
              <table cellspacing=\"0\" cellpadding=\"0\">
                <tr>
                  <td style=\"padding: 0; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999;\">&nbsp;</td>
                  <td style=\"padding: 0; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999;\">&nbsp;</td>
                  <td style=\"padding: 0; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-align: right;\">&nbsp;</td>
                  <td style=\"padding: 0; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999;\">&nbsp;</td>
                  <td style=\"padding: 0; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-align: right;\">&nbsp;</td>
                </tr>
                <tr>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">
                    <strong>AMER</strong>
                  </td>
                  <td style=\"padding: 8px 15px 8px 30px; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">US</td>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase; text-align: right;\">+1
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>866
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>967
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>7768</td>
                  <td style=\"padding: 8px 15px 8px 30px; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">BR</td>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase; text-align: right;\">+55
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>11
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>4349
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>1942</td>
                </tr>
                <tr>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">
                    <strong>EMEA</strong>
                  </td>
                  <td style=\"padding: 8px 15px 8px 30px; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">UK</td>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase; text-align: right;\">+44
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>207
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>570
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>0333</td>
                  <td style=\"padding: 8px 15px 8px 30px; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">SE</td>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase; text-align: right;\">+46
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>8
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>4468
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>2689</td>
                </tr>
                <tr>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">
                    <strong>APAC</strong>
                  </td>
                  <td style=\"padding: 8px 15px 8px 30px; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">HK</td>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase; text-align: right;\">+852
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>3018
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>4068</td>
                  <td style=\"padding: 8px 15px 8px 30px; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase;\">AU</td>
                  <td style=\"padding: 8px 0 8px 0; border-bottom: solid 1px #D6D6D6; font-family:'Arial', Helvetica, 'sans-serif'; font-size: 9px; color:#999999; text-transform: uppercase; text-align: right\">+61
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>2
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>9052
                    <span style=\"color: #D9D9D9;\">&nbsp;&#8226;&nbsp;</span>0832</td>
                </tr>

              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

  </table>
</body>

</html>";
	
	if(($from_city != '') && ($to_city != '') && ($user_email != '')){
		//$txt = json_encode($html_body2);
		//$myfile = file_put_contents('logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
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
		$mail->addAddress('dhiraj@wholdings.travel', 'Client');     // Add a recipient
		$mail->addReplyTo('dhiraj@wholdings.travel', 'Information');
		
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = 'Bot Enquiry - Flight from '.$from_city.' to '.$to_city.' on '.date("j F, Y",strtotime($onwards_date));
		$mail->Body    = $html_body2;
		//$mail->send();
		/*
		$link = new PDO("mysql:host=192.168.101.18;dbname=dhiraj", "dhiraj", "dhiraj123");
		$statement = $link->prepare("INSERT INTO chatbot_enquiries(form_data , client_email , from_city , to_city, joureny_type)
			VALUES(:form_data, :client_email, :from_city, :to_city,:joureny_type)");
		$statement->execute(array(
			"form_data" => base64_encode(json_encode($data['result']['parameters'])),
			"client_email" => $user_email,
			"from_city" => $from_city,
			"to_city" => $to_city,
			"joureny_type"=> "oneway"
		));
		*/
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



