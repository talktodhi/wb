<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function indexAction(Request $request)
    {
        
        $data['username'] = $request->get('username');
        $data['password'] = $request->get('password');
        //prx($data);
        
        $sql2 = 'SELECT * FROM user where email="'.$data['username'].'" and password="'.$data['password'].'"';
        $em = $this->getDoctrine()->getManager();
       
        $dataSet = $em->getConnection()
                    ->fetchAll($sql2);
        if(count($dataSet) > 0){
            $session = $request->getSession();
            $session->remove('user');
            $session->set('user',$dataSet[0]);
            $return['success'] = '1';
            $return['redirect_url']     =   $this->generateUrl('doctors_listing');
        }else{
            $return['success'] = '0';
        }
        return new JsonResponse($return);  
    }
}
