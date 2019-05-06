<?php
/**
 * Created by PhpStorm.
 * User: Bassem
 * Date: 11/03/2019
 * Time: 14:51
 */

namespace Odoo\ConnectorBundle\Service;
use Odoo\ConnectorBundle\Traits\ripcord;

class OdooService
{
    private $db;
    private $url;
    private $username;
    private $password;


    public function __construct($url,$db,$username,$password)
    {
        $this->url=$url;
        $this->db=$db;
        $this->username=$username;
        $this->password=$password;
    }
    public function checkAccess()
    {
        $common = ripcord::client($this->url.'/xmlrpc/2/common');
        return  $common->version();
    }
    //return odoo models
    public function getModel()
    {
       return  ripcord::client($this->url.'/xmlrpc/2/object');

    }
    public function getUid()
    {
        $common = ripcord::client($this->url.'/xmlrpc/2/common');
        return $uid = $common->authenticate($this->db, $this->username, $this->password, array());

    }
    public function search($model,$option=[])
    {
        $tab=null;
        if($option!=null){
            $tab=$option;
        }
        $models=$this->getModel();
        $uid=$this->getUid();
        $result= $models->execute_kw($this->db, $uid, $this->password,
            $model, 'search_read',
           array($tab));
        return $result;
    }

    public function delete($model,$id)
    {
        $models=$this->getModel();
        $uid=$this->getUid();
        $result= $models->execute_kw($this->db, $uid, $this->password, $model, 'unlink',
            array(array($id)));
        return $result;
    }

    public function create($model,$option)
    {
        $models=$this->getModel();
        $uid=$this->getUid();
        $result=$models->execute_kw($this->db, $uid, $this->password, $model, 'create', array($option));
        return $result;
    }

    public function update($model,$id,$option)
    {
        $models=$this->getModel();
        $uid=$this->getUid();
        $id=(int)$id;
        return $result=$models->execute_kw($this->db, $uid, $this->password, $model, 'write',
            array(array($id), $option));

    }

    public function fields($model){

        $models=$this->getModel();
        $uid=$this->getUid();
        return $models->execute_kw($this->db, $uid, $this->password, $model, 'fields_get',
            array());
    }


}
