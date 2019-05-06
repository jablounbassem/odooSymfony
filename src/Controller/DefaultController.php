<?php

namespace Odoo\ConnectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Odoo\ConnectorBundle\Traits\ripcord;
class DefaultController extends Controller
{
    public function indexAction($name)
    {

        return $this->render('OdooConnectorBundle:Default:index.html.twig');
    }

    public function addAction($name)
    {
        $url  =  "http://http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //print_r($common->version());
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());
        $id = $models->execute_kw($db, $uid, $password,
            'res.partner', 'create',
            array(array('name'=>"$name")));
        //   echo $id;
        return $this->render('OdooConnectorBundle:Users:add.html.twig');
    }

    public function listUsersAction(){
        $url  =  "http://http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;


        $common = ripcord::client($url.'/xmlrpc/2/common');
        $uid = $common->authenticate($db, $username, $password, array());
        $models = ripcord::client("$url/xmlrpc/2/object");

        $partners= $models->execute_kw($db, $uid, $password,
            'res.partner', 'search_read',
            array(array(
            )),
            array('fields'=>array('name', 'country_id', 'comment')));

        return $this->render('OdooConnectorBundle:Users:list.html.twig',array(
            'partners'=>$partners));

    }

    public function updateAction($id,$name){
        $url  =  "http://http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //print_r($common->version());
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());
        $models->execute_kw($db, $uid, $password, 'res.partner', 'write',
            array(array((int)$id), array('name'=>"$name")));
        return $this->forward('OdooConnectorBundle:Default:listUsers');

    }
    public function deleteAction($id){
        $url  =  "http://http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());
        $models->execute_kw($db, $uid, $password,
            'res.partner', 'unlink',
            array(array((int)$id)));
        return $this->forward('OdooConnectorBundle:Default:listUsers');

    }

    public function connectionAction()
    {
        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        $models = ripcord::client("$url/xmlrpc/2/object");
         $uid = $common->authenticate($db, $username, $password, array());
         return $models;
    }

    public function zzzAction(){
       print_r($this->connectionAction()) ;
        die();
        return $this->forward('OdooConnectorBundle:Default:listUsers');

    }
}
