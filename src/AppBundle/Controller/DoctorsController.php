<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DoctorsController extends Controller
{
    /**
     * @Route("/doctors", name="doctors_listing")
     */
    public function indexAction(Request $request)
    {
        $data = array();
        $router = $this->get('router');
        
        $data['main_menu']  =   'doctors';
        $data['sub_menu']   =   'doctors_listing';
        
        $limit = 20;  
        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
        $start_from = ($page-1) * $limit;  

        $sql_data = "SELECT * FROM doctors";
        $where = array();
        if(isset($_GET['location_id'])){
            $_GET['location_id'] = array_filter($_GET['location_id']);
        }
        if(isset($_GET['location_id']) && (count($_GET['location_id']) > 0)){
            $where[] .= "location_id IN (".implode(',',$_GET['location_id']).")";
        }
        if(isset($_GET['doctor_name']) > 0){
            $doctorNameTemp = array();
            foreach($_GET['doctor_name'] as $doctor_name_val){
                if($doctor_name_val != ""){
                    $doctorNameTemp[] = "'".$doctor_name_val."'";
                }
            }
            
            if(count($doctorNameTemp) > 0){
                $where[] .= "name IN (".implode(',',$doctorNameTemp).")";
            }
        }
        if(isset($_GET['city']) > 0){
            $cityTemp = array();
            foreach($_GET['city'] as $city_val){
                if($city_val != ''){
                $cityTemp[] = "'".$city_val."'";
                }
            }
            if(count($cityTemp) > 0){
                $where[] .= "city IN (".implode(',',$cityTemp).")";
            }
        }
        
        $whereQry = '';
        if(count($where) >0){
            $whereQry .= " where ".implode(" OR ", $where);
        }
        $sql_data .= $whereQry;
        $sql_data .= " LIMIT ".$start_from.",".$limit;
        
        $em = $this->getDoctrine()->getManager();
        $dataSet = $em->getConnection()
                    ->fetchAll($sql_data);
        
        $sql_data_count = 'SELECT * FROM doctors ';
        $data_connection2 = $this->getDoctrine()->getManager();
        $allDoctorData = $data_connection2->getConnection()
                    ->fetchAll($sql_data_count);
        $options['location_id'] = array();
        
        foreach($allDoctorData as $allDoctorDataVal){
            $options['location_id'][$allDoctorDataVal['location_id']] = $allDoctorDataVal['location_id'];
            $options['doctor_name'][$allDoctorDataVal['name']] = $allDoctorDataVal['name'];
            $options['city'][$allDoctorDataVal['city']] = $allDoctorDataVal['city'];
        }
        $data['options']    =   $options;
        $dataCount['count'] =   count($allDoctorData);
        $data['total_records']          =   $dataCount['count'];
        $data['doctors_list']   =   $dataSet;
        if(isset($_GET)){
            $data['get']    = $_GET;
        }
        if(isset($_GET["page"])){
            $data['current_page']   =    $_GET["page"];
            $data['countSrNo']      =   (($_GET["page"] - 1)*$limit) + 1;
        }else{
            $data['current_page']  =    '1';
            $data['countSrNo']      =   1;
        }
        $total_records = $dataCount['count'];
        //$limit         =   1;
        $data['limit']   = $limit;
        $total_pages = ceil($total_records / $limit);  
        $pagLink = "<nav><ul class='pagination'>";  
        for ($i=1; $i<=$total_pages; $i++) {
                $rt = $router->generate('doctors_listing', array('page' => $i));
             $pagLink .= "<li><a href='".$rt."'>".$i."</a></li>";  
        }; 
        $pagLink .= "</ul></nav>";
        $data['paginations'] = $pagLink;
        return $this->render('default/doctors_listing.html.twig',array('data'=>$data));
    }
    
    /**
     * @Route("/doctors_upload", name="doctors_upload")
     */
    public function uploadAction(Request $request)
    {
        $data = array();
        $data['main_menu']  =   'doctors';
        $data['sub_menu']   =   'doctors_upload';
        
        return $this->render('default/doctors_upload.html.twig',array('data'=>$data));
    }
    
    /**
     * @Route("/doctors_upload_process", name="doctors_upload_process")
     */
    public function uploadprocessAction(Request $request)
    {
        $data = array();
        $data['main_menu']  =   'doctors';
        $data['sub_menu']   =   'doctors_upload';
        
        if(!empty($_FILES)){
            $filename = basename($_FILES['file']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            
            $upload_dir = "";
            $fileName = $_FILES['file']['name'];
            $uploaded_file = '../web/uploaded_docs/doctors/'.$fileName;
            
            $sql_data_count = 'SELECT * FROM datapincode ';
            $data_connection2 = $this->getDoctrine()->getManager();
            $allPincode = $data_connection2->getConnection()
                    ->fetchAll($sql_data_count);
            $pincode    =   array();
            foreach($allPincode as $allPincodeVal){
                $pincode[] = $allPincodeVal['pincode'];
            }
            if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
                
                $lines = assoc_getcsv($uploaded_file);
                /*
                $insert_qry_here = 'INSERT INTO playerlogs (location_id, datetime, title, artist_name, playlist_name, category_name) VALUES ';
	
                foreach($lines as $insert_qry_arr1_tempVal){
                    $formated_date = '';
                    $date = new \DateTime($insert_qry_arr1_tempVal['DateTime']);
                    $formated_date = $date->format('Y-m-d H:i:s');
                    $insert_qry_data[] = "('".$insert_qry_arr1_tempVal['TokenId']."','".$formated_date."','".$insert_qry_arr1_tempVal['Title']."','".$insert_qry_arr1_tempVal['ArtistName']."','".$insert_qry_arr1_tempVal['PlaylistName']."','".$insert_qry_arr1_tempVal['CategoryName']."')";
                }
                    
                $insert_qry_here    .=  implode(", ",$insert_qry_data);
                $insert_qry_here    .=  ';';
                */
                   // prx($lines);
                
                    $insert_qry_here = 'INSERT INTO doctors (location_id, network_id, name, mobile, ll_num1, ll_num2, receptionist_name, receptioist_mobile, city, state, country, pincode, address, morning_time_from, morning_time_to, evening_time_from, evening_time_to) VALUES ';
                    foreach($lines as $insert_qry_arr1_tempVal){
                        prx($insert_qry_arr1_tempVal);
			$formated_date = '';
                        $insert_qry_data[] = "('".$insert_qry_arr1_tempVal['Location-ID']."','".$insert_qry_arr1_tempVal['Network-ID']."','".$insert_qry_arr1_tempVal['Doctor Name']."','".$insert_qry_arr1_tempVal['Doctors Mobile Number']."','".$insert_qry_arr1_tempVal['Landline Number of clinic 1']."','".$insert_qry_arr1_tempVal['Landline Number of clinic 2']."','".$insert_qry_arr1_tempVal['Receptionst Name']."','".$insert_qry_arr1_tempVal['Receptionst Mobile Number']."','".$insert_qry_arr1_tempVal['City']."','".$insert_qry_arr1_tempVal['State']."','INDIA','".$insert_qry_arr1_tempVal['Pincode']."','".mysql_real_escape_string($insert_qry_arr1_tempVal['Address'])."','09:30:00','13:30:00','15:00:00','21:00:00')";
                        if((!in_array($insert_qry_arr1_tempVal['Pincode'], $pincode)) && ($insert_qry_arr1_tempVal['Pincode'] > 0)){
                            //$insert_qry_arr1_tempVal['Pincode']
                            $retVal = $this->getcoordinates($insert_qry_arr1_tempVal['Pincode'], $insert_qry_arr1_tempVal['City']);
                            if($retVal > 0){
                                $pincode[] = $retVal;
                            }
                        }
                    }
                    
                    $insert_qry_here    .=  implode(", ",$insert_qry_data);
                    
                    $insert_qry_here    .= '  ON DUPLICATE KEY UPDATE network_id=VALUES(network_id), name=VALUES(name), mobile=VALUES(mobile), ll_num1=VALUES(ll_num1), ll_num2=VALUES(ll_num2), receptionist_name=VALUES(receptionist_name), receptioist_mobile=VALUES(receptioist_mobile), city=VALUES(city), state=VALUES(state), country=VALUES(country), pincode=VALUES(pincode), address=VALUES(address), morning_time_from=VALUES(morning_time_from), morning_time_to=VALUES(morning_time_to), evening_time_from=VALUES(evening_time_from), evening_time_to=VALUES(evening_time_to)';
                    $insert_qry_here    .=  ';';
                
                 $em = $this->getDoctrine()->getManager();
                 $conn = $em->getConnection();
                 $conn->prepare($insert_qry_here)
                 ->execute();
            }
        }
        exit;
    }
    
    private function getcoordinates($pincode,$city){
        
        /*
        $sql_data_count = 'SELECT * FROM pincode where pincode='.$pincode;
        $data_connection2 = $this->getDoctrine()->getManager();
        $allDoctorData = $data_connection2->getConnection()
                    ->fetchAll($sql_data_count);
        */
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$pincode."+INDIA&key=AIzaSyCTZJR8ga_v2tUYzFHBHuS5VCpPXWbreJ4";
        $details=file_get_contents($url);
        $result = json_decode($details,true);
        //prx($result);
        if(isset($result['results'][0]['geometry'])){
            $lat = $result['results'][0]['geometry']['location']['lat'];
            $lng = $result['results'][0]['geometry']['location']['lng'];
            $insert_qry = "INSERT INTO pincode (pincode,latitude,longitude,city) VALUES ('".$pincode."','".$lat."','".$lng."','".$city."')";
            $em = $this->getDoctrine()->getManager();
                 $conn = $em->getConnection();
                 $conn->prepare($insert_qry)
                 ->execute();
           return $pincode;
        }else{
           return 0; 
        }
        
        //$insert_qry = "INSERT INTO pincode (pincode,latitude,longitude,city) VALUES ('".$pincode."','".$lat."','".$lng."','".$city."')";
    }
    

}
