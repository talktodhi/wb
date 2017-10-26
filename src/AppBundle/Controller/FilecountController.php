<?php

namespace AppBundle\Controller;

use Commonfiles\Utils\UtilityClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;



class FilecountController extends Controller
{
    /**
     * @Route("/filecount", name="filecount_listing")
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
        
        $data['main_menu']  =   'filecount';
        $data['sub_menu']   =   'filecount_listing';
        
        $limit = 20;  
        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
        $start_from = ($page-1) * $limit;  

        $sql_data = "SELECT * FROM device_file_count";
        $where = array();
        if(isset($_GET['location_id'])){
            $_GET['location_id'] = array_filter($_GET['location_id']);
        }
        if(isset($_GET['location_id']) && (count($_GET['location_id']) > 0)){
            $where[] .= "location_id IN (".implode(',',$_GET['location_id']).")";
        }
        /*
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
        */
        $whereQry = '';
        if(count($where) >0){
            $whereQry .= " where ".implode(" OR ", $where);
        }
        $sql_data .= $whereQry;
        $sql_data .= " LIMIT ".$start_from.",".$limit;
        
        $em = $this->getDoctrine()->getManager();
        $dataSet = $em->getConnection()
                    ->fetchAll($sql_data);
        
        $sql_data_count = 'SELECT * FROM device_file_count ';
        $sql_data_count .= $whereQry;
        $data_connection2 = $this->getDoctrine()->getManager();
        $allDoctorData = $data_connection2->getConnection()
                    ->fetchAll($sql_data_count);
        $dataCount['count'] =   count($allDoctorData);
        $data['total_records']          =   $dataCount['count'];
        
        $sql_alldata_count = 'SELECT * FROM device_file_count ';
        $data_connection2 = $this->getDoctrine()->getManager();
        $allDoctorData = $data_connection2->getConnection()
                    ->fetchAll($sql_alldata_count);
        $options['location_id'] = array();
        foreach($allDoctorData as $allDoctorDataVal){
            $options['location_id'][$allDoctorDataVal['location_id']] = $allDoctorDataVal['location_id'];
          //  $options['doctor_name'][$allDoctorDataVal['name']] = $allDoctorDataVal['name'];
          //  $options['city'][$allDoctorDataVal['city']] = $allDoctorDataVal['city'];
        }
        
        $data['options']    =   $options;

        $data['filecount_list']   =   $dataSet;
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
                
                if(isset($_GET)){
                    $params = $_GET;
                }
                $params['page'] = $i;
                $rt = $router->generate('filecount_listing', $params);
             $pagLink .= "<li><a href='".$rt."'>".$i."</a></li>";  
        }; 
        $pagLink .= "</ul></nav>";
        $data['paginations'] = $pagLink;
        unset($params['page']);
        $params['page'] =   '';
        $data['url'] =  $router->generate('filecount_listing', $params);;
        return $this->render('default/filecount_listing.html.twig',array('data'=>$data));
    }
    
    /**
     * @Route("/filecount_upload", name="filecount_upload")
     */
    public function uploadAction(Request $request)
    {
        $data = array();
        $data['main_menu']  =   'filecount';
        $data['sub_menu']   =   'filecount_upload';
        
        return $this->render('default/filecount_upload.html.twig',array('data'=>$data));
    }
    
    /**
     * @Route("/filecount_upload_process", name="filecount_upload_process")
     */
    public function uploadprocessAction(Request $request)
    {
        $data = array();
        $data['main_menu']  =   'filecount';
        $data['sub_menu']   =   'filecount_upload';
        
        //$utilityClass = new UtilityClass();
        
        if(!empty($_FILES)){
            $filename = basename($_FILES['file']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            
            $upload_dir = "";
            $fileName = $_FILES['file']['name'];
            $uploaded_file = '../web/uploaded_docs/filecount/'.$fileName;
            
            $sql_data_count = 'SELECT * FROM datapincode ';
            $data_connection2 = $this->getDoctrine()->getManager();
            $allPincode = $data_connection2->getConnection()
                    ->fetchAll($sql_data_count);
            $pincode    =   array();
            foreach($allPincode as $allPincodeVal){
                $pincode[] = $allPincodeVal['pincode'];
            }
            if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
                error_reporting(0);
                $lines = $this->fromCSVFile($uploaded_file);
                $insert_qry_here = 'INSERT INTO device_file_count (location_id, network_id, status, download_count, total_count, player_version) VALUES ';
	
                foreach($lines as $insert_qry_arr1_tempVal){
                    
                    if(isset($insert_qry_arr1_tempVal['FileCount'])){
                        $countsTemp     =   explode('/',$insert_qry_arr1_tempVal['FileCount']);
                        $downloadCnt    =   (int)$countsTemp[0];
                        $totalCnt       =   (int)$countsTemp[1];
                    }else{
                        $downloadCnt    =   0;
                        $totalCnt       =   0;
                    }
                    
                    if($insert_qry_arr1_tempVal['TokenId'] > 0){
                        $insert_qry_data[] = "('".$insert_qry_arr1_tempVal['TokenId']."','".$insert_qry_arr1_tempVal['PlayerNo']."','".$insert_qry_arr1_tempVal['PlayerStatus']."','".$downloadCnt."','".$totalCnt."','".$insert_qry_arr1_tempVal['PlayerVersion']."')";
                    }
                }
                    
                $insert_qry_here    .=  implode(", ",$insert_qry_data);
                $insert_qry_here    .=  ';';
                
                $em = $this->getDoctrine()->getManager();
                $conn = $em->getConnection();
                $conn->prepare($insert_qry_here)
                 ->execute();
            }
        }
        echo "Done success";
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
