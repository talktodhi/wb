<?php
require_once 'vendor/autoload.php';
date_default_timezone_set("Europe/London");
putenv('GOOGLE_APPLICATION_CREDENTIALS=edae9107104d.json');

// I'm using a service account, use whatever Google auth flow for your type of account.
//putenv('GOOGLE_APPLICATION_CREDENTIALS=/path/to/service/account/key.json');
$client = new Google_Client();
$all_scope = array(Google_Service_Drive::DRIVE,Google_Service_Drive::DRIVE_APPDATA,Google_Service_Drive::DRIVE_FILE,Google_Service_Drive::DRIVE_METADATA,Google_Service_Drive::DRIVE_METADATA_READONLY,Google_Service_Drive::DRIVE_PHOTOS_READONLY,Google_Service_Drive::DRIVE_READONLY,Google_Service_Drive::DRIVE_SCRIPTS);
$client->addScope($all_scope);
$client->useApplicationDefaultCredentials();

$service = new Google_Service_Drive($client);
//https://drive.google.com/open?id=1nr6_fOV0wDKbTeNZq7PZHOx6CHNNNmQC

$fileId = "1nr6_fOV0wDKbTeNZq7PZHOx6CHNNNmQC"; // Google File ID
$content = $service->files->get($fileId);

//name = 'my_private_directory'
//https://drive.google.com/drive/folders/1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg?usp=sharing
//  https://drive.google.com/drive/folders/1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg?usp=sharing
//https://drive.google.com/drive/folders/1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg?usp=sharing
/*
$parameters = array(
      'id' => "1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg",
  );
  $files = $service->files->list($parameters);
  */
  /*
    $parameters = array(
       'folderId' => "1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg",
	);
  $files = $service->files->listFiles($parameters);
*/
  //$result = array_merge($result, $files->getFiles());
  /*
  
      $parameters = array(
       'folderId' => "1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg",
  );
 //  $children = $service->children->listChildren("1AvfHcllqZlHyqScKctXLoqNAbOdaQkIg", null);
//var_dump($children);
   //   foreach ($children->getItems() as $child) {
    //    print 'File Id: ' . $child->getId();
     // }
	  */
  echo "<pre>";
var_dump($content);
exit;


/*

$parameters = array(
      'q' => "mimeType contains 'image/'",
  );
  $files = $service->files->listFiles($parameters);

*/


/*
// Open file handle for output.

$outHandle = fopen("/new", "w+");

// Until we have reached the EOF, read 1024 bytes at a time and write to the output file handle.

while (!$content->getBody()->eof()) {
        fwrite($outHandle, $content->getBody()->read(1024));
}

// Close output file handle.

fclose($outHandle);
echo "Done.\n"
*/
?>