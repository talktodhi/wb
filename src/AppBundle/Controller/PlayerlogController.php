<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;

class PlayerlogController extends Controller
{
    /**
     * @Route("/playerlog", name="playerlog_listing")
     */
    public function indexAction(Request $request)
    {
        $session                        =   $request->getSession();
        $user                           =   $session->get('user');
        if($user['id'] < 1){
            //$this->redirectToRoute('login');
            return $this->redirect($this->generateUrl("logout"));
        }
        
        $data = array();
        $router = $this->get('router');
        
        $data['main_menu']  =   'playerlog';
        $data['sub_menu']   =   'playerlog_listing';
        
        $limit = 20;  
        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
        $start_from = ($page-1) * $limit;  

        $sql_data = "SELECT * FROM playerlogs";
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
        //prx($sql_data);
        $em = $this->getDoctrine()->getManager();
        $dataSet = $em->getConnection()
                    ->fetchAll($sql_data);
        //prx($dataSet);
        $sql_data_count = 'SELECT * FROM playerlogs ';
        $data_connection2 = $this->getDoctrine()->getManager();
        $allDoctorData = $data_connection2->getConnection()
                    ->fetchAll($sql_data_count);
        $options['location_id'] = array();
        //prx($allDoctorData);
        foreach($allDoctorData as $allDoctorDataVal){
            $options['location_id'][$allDoctorDataVal['location_id']] = $allDoctorDataVal['location_id'];
          //  $options['doctor_name'][$allDoctorDataVal['name']] = $allDoctorDataVal['name'];
          //  $options['city'][$allDoctorDataVal['city']] = $allDoctorDataVal['city'];
        }
        
        $data['options']    =   $options;
        $dataCount['count'] =   count($allDoctorData);
        $data['total_records']          =   $dataCount['count'];
        $data['playerlog_list']   =   $dataSet;
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
                $rt = $router->generate('playerlog_listing', array('page' => $i));
             $pagLink .= "<li><a href='".$rt."'>".$i."</a></li>";  
        }; 
        $pagLink .= "</ul></nav>";
        $data['paginations'] = $pagLink;
        return $this->render('default/playerlog_listing.html.twig',array('data'=>$data));
    }
    
    /**
     * @Route("/playerlog_upload", name="playerlog_upload")
     */
    public function uploadAction(Request $request)
    {
        $data = array();
        $data['main_menu']  =   'playerlog';
        $data['sub_menu']   =   'playerlog_upload';
        
        return $this->render('default/playerlog_upload.html.twig',array('data'=>$data));
    }
    
    /**
     * @Route("/playerlog_upload_process", name="playerlog_upload_process")
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
            $uploaded_file = '../web/uploaded_docs/playerlog/'.$fileName;
            
            $sql_data_count = 'SELECT * FROM datapincode ';
            $data_connection2 = $this->getDoctrine()->getManager();
            $allPincode = $data_connection2->getConnection()
                    ->fetchAll($sql_data_count);
            $pincode    =   array();
            foreach($allPincode as $allPincodeVal){
                $pincode[] = $allPincodeVal['pincode'];
            }
            if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
                
                $lines = $this->fromCSVFile($uploaded_file);
                
                $insert_qry_here = 'INSERT INTO playerlogs (location_id, datetime, title, artist_name, playlist_name, category_name) VALUES ';
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
               //     prx($insert_qry_data);
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
       // echo "DOne success";
        exit;
    }
    
    private function fromCSVFile( $file) {
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
        return $result;
    }
    
}
