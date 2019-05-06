<?php

namespace Odoo\ConnectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Odoo\ConnectorBundle\Traits\ripcord;


class TestController extends Controller
{
    public function indexAction()
    {
        return $this->render('');
    }

//strecture
    public function fieldsAction()
    {

        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        // pour l'authentification
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //pour la requéte
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());

        $fileds=$models->execute_kw($db, $uid, $password,
            'purchase.order.line', 'fields_get',

            array()
          //  , array('attributes' => array('string'))
        );

        echo '<pre>' . var_export($fileds, true) . '</pre>';

        die();

        return $this->render('');
    }


    public function dateFAction(){

        echo date("y-m-d h:m:s");
        die();
        return $this->render('');
    }
    public function tesorderAction(){

        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        // pour l'authentification
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //pour la requéte
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());

        $fileds=$models->execute_kw($db, $uid, $password,
            'purchase.order', 'search_read',
            array(array(
            ))
            , array(
                'limit'=>1
            ))
        ;


        echo '<pre>' . var_export($fileds[0]['id'], true) . '</pre>';
        die();
        return $this->render('');
    }
        public function testServiceAction( ){


            $service=$this->get('OdooService');
            print_r($service->search('res.partner'));
            die();
            return $this->render('');

        }

}
