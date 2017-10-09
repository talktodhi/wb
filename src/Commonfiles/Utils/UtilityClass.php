<?php

namespace Commonfiles\Utils;

/**
 * This class has all the methods related to utility like date format conversion
 *
 * @author Dhiraj Bastwade
 */
class UtilityClass
{
 
    /*
     * This method  provides value of child tags of an xml tag. It works for 
     * single parent child level..
     *
     * @author Dhiraj Bastwade
     * @author Dhiraj Bastwade <dhiraj@wholdings.travel>
     * 
     * @filesource xmlUtilityClass.php
     * 
     * @param string $xml  xml string to be formated
     * @param string $tag  xml tag for which value need  to be fetched
     * @return tag value in form of array
     * 
     */
    public function changeDateFormat($date, $oldFormat, $newFormat)
    {
        $oldDate    =   $date;
        $DateTime =  new \DateTime();
        $date = $DateTime->createFromFormat($oldFormat, $date);
        if(trim($oldDate) == ""){
            return "";
        }else{
            return $date->format($newFormat);
        }
    }
    
    /*
     * This method  provides value of child tags of an xml tag. It works for 
     * single parent child level..
     *
     * @author Dhiraj Bastwade
     * @author Dhiraj Bastwade <dhiraj@wholdings.travel>
     * 
     * @filesource xmlUtilityClass.php
     * 
     * @param string $xml  xml string to be formated
     * @param string $tag  xml tag for which value need  to be fetched
     * @return tag value in form of array
     * 
     */
    public function generateBookingFile($bookingNumber, $pnrData)
    {
        $jsonFile = __DIR__.'/../../../web/bookingFiles/'.$bookingNumber.'.json';
        
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($pnrData));
        fclose($fp);
        
    }
    
    
    /*
     * This method  provides value of child tags of an xml tag. It works for 
     * single parent child level..
     *
     * @author Dhiraj Bastwade
     * @author Dhiraj Bastwade <dhiraj@wholdings.travel>
     * 
     * @filesource xmlUtilityClass.php
     * 
     * @param string $xml  xml string to be formated
     * @param string $tag  xml tag for which value need  to be fetched
     * @return tag value in form of array
     * 
     */
    public function getBookingFile($bookingNumber)
    {
        
        $jsonFile = __DIR__.'/../../../web/bookingFiles/'.$bookingNumber.'.json';
        if(file_exists($jsonFile)){
            $data = file_get_contents ($jsonFile);
            $json = json_decode($data, true);
            return $json;
        }else{
            return false;
        }
        
    }
    
    
    
    public function loginCURLCall($data){
		
        $url	=	'http://sworks.wholdings.travel/hiren/qcms_dev/rest/login';
        
        $fields = array(
            'email' => $data['email'],
            'pwd' => $data['password']
        );
        $fields_string = http_build_query($fields);
        $ch = curl_init();
        //url_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $dataArr    = json_decode($response,true);
	return $dataArr;
        
    }
    

    
}
