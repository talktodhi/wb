<?php

require_once 'vendor/autoload.php';
date_default_timezone_set("Europe/London");
putenv('GOOGLE_APPLICATION_CREDENTIALS=edae9107104d.json');




// I'm using a service account, use whatever Google auth flow for your type of account.
//putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/service/account/key.json');
$client = new Google_Client();

$all_scope = array(Google_Service_Drive::DRIVE,Google_Service_Drive::DRIVE_APPDATA,Google_Service_Drive::DRIVE_FILE,Google_Service_Drive::DRIVE_METADATA,Google_Service_Drive::DRIVE_METADATA_READONLY,Google_Service_Drive::DRIVE_PHOTOS_READONLY,Google_Service_Drive::DRIVE_READONLY,Google_Service_Drive::DRIVE_SCRIPTS, Google_Service_Sheets::SPREADSHEETS_READONLY);

$client->addScope($all_scope);
$client->useApplicationDefaultCredentials();

$service = new Google_Service_Drive($client);
//https://drive.google.com/open?id=1nr6_fOV0wDKbTeNZq7PZHOx6CHNNNmQC

//$fileId = "1nr6_fOV0wDKbTeNZq7PZHOx6CHNNNmQC"; // Google File ID
//$content = $service->files->get($fileId);
echo "<pre>";
//$query = "title='a'";
 //$parameters = array();
 //$parameters['q'] = '1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg';

 $optParams = array(
        //'pageSize' => 10,
        'fields' => "nextPageToken, files(id,name,size,webContentLink,webViewLink,mimeType,parents)",
        'q' => "'1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg' in parents"
        );
 

$files = $service->files->listFiles($optParams);
$filesArr = json_decode(json_encode($files), true);
foreach($filesArr["files"] as $fileData){
	print_r($filesArr["files"]);
	exit;
	if($fileData['mimeType'] == 'text/csv'){
		$name = $fileData['name'];
		$fileLink = $fileData['webContentLink'];
				$handle = @fopen( $file, "r");
        if ( !$handle ) {
            throw new \Exception( "Couldn't open $file!" );
        }

        $result = array();

        // read the first line
        $first = fgets( $handle, 4096 );
        // get the keys
        $keys = str_getcsv( $first );
        //prx($keys);
        // read until the end of file
        while ( ($buffer = fgets( $handle, 4096 )) !== false ) {

            // read the next entry
            $array = str_getcsv ( $buffer );
            if ( empty( $array ) ) continue;

            $row = [];
            $i=0;

            // replace numeric indexes with keys for each entry
            if(count($keys) == count($array)){
                foreach ( $keys as $key ) {
                    $row[ $key ] = $array[ $i ];
                    $i++;
                }
            }
            // add relational array to final result
            $result[] = $row;
        }

       fclose( $handle );
       //print_r($result);
		
		        //$lines = $this->fromCSVFile($uploaded_file);
                $lines = $result;
                $insert_qry_here = 'INSERT INTO playerlogs2 (location_id, datetime, title, artist_name, playlist_name, category_name) VALUES ';
                $previousData = array();
                $insert_qry_data = array();
                foreach($lines as $insert_qry_arr1_tempVal){
                    $date = new \DateTime($insert_qry_arr1_tempVal['DateTime']);
                    $just_date = $date->format('Y-m-d');
                    if(!isset($previousData[$insert_qry_arr1_tempVal['TokenId']][$just_date])){
                        $previousData[$insert_qry_arr1_tempVal['TokenId']][$just_date]  =   array();
                        $getData = 'SELECT * FROM playerlogs where location_id="'.$insert_qry_arr1_tempVal['TokenId'].'" AND  datetime LIKE "%'.$just_date.'%"';
                        $data_connection2 = $this->getDoctrine()->getManager();
                        $allGetData = $data_connection2->getConnection()
                                ->fetchAll($getData);

                        if(count($allGetData) > 0){
                            foreach($allGetData as $allGetDataVal){
                                $previousData[$insert_qry_arr1_tempVal['TokenId']][$just_date][$allGetDataVal['datetime']] = $allGetDataVal;
                            }
                        }
                    }
                    
                    $formated_date = '';
                    $date = new \DateTime($insert_qry_arr1_tempVal['DateTime']);
                    $formated_date = $date->format('Y-m-d H:i:s');
                    if(!isset($previousData[$insert_qry_arr1_tempVal['TokenId']][$just_date][$formated_date])){
                        $insert_qry_data[] = "('".$insert_qry_arr1_tempVal['TokenId']."','".$formated_date."','".$insert_qry_arr1_tempVal['Title']."','".$insert_qry_arr1_tempVal['ArtistName']."','".$insert_qry_arr1_tempVal['PlaylistName']."','".$insert_qry_arr1_tempVal['CategoryName']."')";
                    }
                }
				
                if(count($insert_qry_data) > 0){
                    $insert_qry_here    .=  implode(", ",$insert_qry_data);
                    $insert_qry_here    .=  ';';

                    $em = $this->getDoctrine()->getManager();
                    $conn = $em->getConnection();
                    $conn->prepare($insert_qry_here)
                     ->execute();
                }
				
	}
}
exit;
?>