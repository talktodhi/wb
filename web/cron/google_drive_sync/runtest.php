<?php
error_reporting(E_ALL);
//require_once 'vendor/autoload.php';
require_once __DIR__.'/vendor/autoload.php';
//date_default_timezone_set("Europe/London");
putenv('GOOGLE_APPLICATION_CREDENTIALS=edae9107104d.json');

## DB COnnection - Start ##
$config = new \Doctrine\DBAL\Configuration();
$connectionParams = array(
    'dbname' => 'wbcms',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
## DB COnnection - END ##


	function fromCSVFile( $file) {
        // open the CVS file
        $handle = @fopen( $file, "r");
        if ( !$handle ) {
            throw new \Exception( "Couldn't open $file!" );
        }

        $result = [];
        // read the first line
        $first = fgets( $handle, 4096 );
        // get the keys
        $keys = str_getcsv( $first );
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
        return $result;
    }
	
	
	function getDataFromFile($fileData){
			if($fileData['mimeType'] == 'text/csv'){
		$name = $fileData['name'];
		$fileLink = $fileData['webContentLink'];
		$uploaded_file = $fileLink;
		##########################################################
        /*
        if(!empty($_FILES)){
            $filename = basename($_FILES['file']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            
            $upload_dir = "";
            $fileName = $_FILES['file']['name'];
            $uploaded_file = '../web/uploaded_docs/playerlog/'.$fileName;
            
            if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
                */
                $lines = fromCSVFile($uploaded_file);
                $insert_qry_here = 'INSERT INTO playerlogs2 (location_id, datetime, title, artist_name, playlist_name, category_name) VALUES ';
                $previousData = array();
                $insert_qry_data = array();
                foreach($lines as $insert_qry_arr1_tempVal){
                    $date = new \DateTime($insert_qry_arr1_tempVal['DateTime']);
                    $just_date = $date->format('Y-m-d');
                    if(!isset($previousData[$insert_qry_arr1_tempVal['TokenId']][$just_date])){
                        $previousData[$insert_qry_arr1_tempVal['TokenId']][$just_date]  =   array();
                        $getData = 'SELECT * FROM playerlogs2 where location_id="'.$insert_qry_arr1_tempVal['TokenId'].'" AND  datetime LIKE "%'.$just_date.'%"';
                        //$data_connection2 = $this->getDoctrine()->getManager();
                        $allGetData = $conn->fetchAll($getData);

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

                    //$em = $this->getDoctrine()->getManager();
                    //$conn = $em->getConnection();
                    $conn->prepare($insert_qry_here)
                     ->execute();
                }
            /*
			}
        }
		*/
		##########################################################		
	}
	}
// I'm using a service account, use whatever Google auth flow for your type of account.
//putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/service/account/key.json');

	function getAllFilesFromSubFolder($folderID){
		//$tempfiles
		$client = new Google_Client();
		$all_scope = array(Google_Service_Drive::DRIVE,Google_Service_Drive::DRIVE_APPDATA,Google_Service_Drive::DRIVE_FILE,Google_Service_Drive::DRIVE_METADATA,Google_Service_Drive::DRIVE_METADATA_READONLY,Google_Service_Drive::DRIVE_PHOTOS_READONLY,Google_Service_Drive::DRIVE_READONLY,Google_Service_Drive::DRIVE_SCRIPTS, Google_Service_Sheets::SPREADSHEETS_READONLY);
		
		$client->addScope($all_scope);
		$client->useApplicationDefaultCredentials();
		
		$service = new Google_Service_Drive($client);
		$optParams = array(
				//'pageSize' => 10,
				'fields' => "nextPageToken, files(id,name,size,webContentLink,webViewLink,mimeType,parents)",
				'q' => "'".$folderID."' in parents"
				);
		
		
		$files = $service->files->listFiles($optParams);
		$filesArr = json_decode(json_encode($files), true);
		$allFiles = array();
		foreach($filesArr["files"] as $fileData){
			echo "<pre>";
			print_r($fileData);
			exit;
			if($fileData['mimeType'] == 'text/csv'){
				$allFiles[$fileData['id']] = $fileData;
			}
			
			if($fileData['mimeType'] == 'application/vnd.google-apps.folder'){
				$otherFiles = getAllFilesFromSubFolder($fileData['id']);
			}
			$allTempFiles = array_merge($allFiles,$otherFiles);
		}
		return $allTempFiles;
	}
	/*
$client = new Google_Client();
$all_scope = array(Google_Service_Drive::DRIVE,Google_Service_Drive::DRIVE_APPDATA,Google_Service_Drive::DRIVE_FILE,Google_Service_Drive::DRIVE_METADATA,Google_Service_Drive::DRIVE_METADATA_READONLY,Google_Service_Drive::DRIVE_PHOTOS_READONLY,Google_Service_Drive::DRIVE_READONLY,Google_Service_Drive::DRIVE_SCRIPTS, Google_Service_Sheets::SPREADSHEETS_READONLY);

$client->addScope($all_scope);
$client->useApplicationDefaultCredentials();

$service = new Google_Service_Drive($client);
 $optParams = array(
        //'pageSize' => 10,
        'fields' => "nextPageToken, files(id,name,size,webContentLink,webViewLink,mimeType,parents)",
        'q' => "'1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg' in parents"
        );
 

$files = $service->files->listFiles($optParams);

$filesArr = json_decode(json_encode($files), true);
$allFiles = array();
$FInalFIles = array();
foreach($filesArr["files"] as $fileData){
	echo "<pre>";
	
	if($fileData['mimeType'] == 'text/csv'){
		$allFiles[$fileData['id']] = $fileData;
	}
	
	if($fileData['mimeType'] == 'application/vnd.google-apps.folder'){
		$otherFiles = getAllFilesFromSubFolder($fileData['id']);
	}
	$FInalFIles = array_merge($allFiles,$otherFiles);
	
}
*/



function getDirContents($folderId, &$results = array()){
	/*
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
	*/
		$client = new Google_Client();
		$all_scope = array(Google_Service_Drive::DRIVE,Google_Service_Drive::DRIVE_APPDATA,Google_Service_Drive::DRIVE_FILE,Google_Service_Drive::DRIVE_METADATA,Google_Service_Drive::DRIVE_METADATA_READONLY,Google_Service_Drive::DRIVE_PHOTOS_READONLY,Google_Service_Drive::DRIVE_READONLY,Google_Service_Drive::DRIVE_SCRIPTS, Google_Service_Sheets::SPREADSHEETS_READONLY);
		
		$client->addScope($all_scope);
		$client->useApplicationDefaultCredentials();
		
		$service = new Google_Service_Drive($client);
		$optParams = array(
				//'pageSize' => 10,
				'fields' => "nextPageToken, files(id,name,size,webContentLink,webViewLink,mimeType,parents)",
				'q' => "'".$folderId."' in parents"
				);
		
		
		$files = $service->files->listFiles($optParams);
		$filesArr = json_decode(json_encode($files), true);
		$allFiles = array();
		foreach($filesArr["files"] as $fileData){
			//echo "<pre>";
			//print_r($fileData);
			//exit;
			if($fileData['mimeType'] == 'text/csv'){
				$results[] = $fileData;
			}
			
			if($fileData['mimeType'] == 'application/vnd.google-apps.folder'){
				getDirContents($path, $results);
				$results[] = $path;
			}
			//$allTempFiles = array_merge($allFiles,$otherFiles);
		}
		return $results;
		
}

?>