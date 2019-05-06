<?php
/**
 * Created by PhpStorm.
 * User: Bassem
 * Date: 14/03/2019
 * Time: 22:07
 */

namespace Odoo\ConnectorBundle\Service;

class PurchaseOrderService
{
    private $odoo;
    private $product;

    /**
     * PurchaseOrderService constructor.
     * @param $odoo
     */
    public function __construct($odoo,$product)
    {
        $this->odoo = $odoo;
        $this->product=$product;
    }


    public function addPurchase($tab){

        $idVendor = (int)$tab['vendor'];
        $vendor=$this->odoo->search('res.partner');
        $date_planned = date('Y-m-d H:i:s', strtotime($tab['planned_date']));
        $purchase = array(
            'company_id' => $vendor[0]['company_id'][0],
            'currency_id' => $vendor[0]['currency_id'][0],
            'partner_id' => $idVendor,
            'partner_ref'=>(String)$tab['partner_ref'],
            'date_order'=>$date_planned

        );
        $id=$this->odoo->create('purchase.order',$purchase);
        if (isset($tab['article'])){
            $this->addCommandeLine($tab,$id);
        }
    }

    public function addCommandeLine($req,$id){

        for ($i=0;$i<count($req['article']);$i++)
        {
            $date_planned = date('Y-m-d H:i:s', strtotime($req['date'][$i]));
            if (strlen($req["description"][$i])==0){
                $req["description"][$i]=$this->product->getProduct($req["article"][$i])['display_name'];
            }
            $commandeline = array(
                'name' => $req["description"][$i],
                'date_planned' => $date_planned,
                'product_qty' => $req["quantite"][$i],
                'product_id' => $req["article"][$i],
                'order_id' => $id,
                'price_unit' => $req["pu"][$i],
                'product_uom' => 2,
                'taxes_id'=>$req["taxe"][$i],
            );
            $this->odoo->create('purchase.order.line', $commandeline);

        }

    }

    public function getPurchase($id){
        $id=(int)$id;
        $option[0] = array('id', '=', $id);
        $result=$this->odoo->search('purchase.order',$option);
        return $result;
    }

    public function getCommandeLine($id){
        $id=(int)$id;
        $option[0] = array('id', '=', $id);
        $result=$this->odoo->search('purchase.order.line',$option);
        return $result[0];
    }

    public function getPurchaseOrderCommandeLine($id){
        $pruchase=$this->getPurchase($id);
        $tab=array();
        foreach ($pruchase[0]['order_line'] as $value){
            array_push($tab,$this->getCommandeLine($value));
        }
        return $tab;
    }

    public function geTaxes($id){
        $id=(int)$id;
        $option[0] = array('id', '=',$id);
        return $this->odoo->search('account.tax',$option)[0];

    }

    public function updateCommandeLine($id,$option){
        $id=(int)$id;
        $this->odoo->update('purchase.order.line',$id,$option);


    }

    public function updatePurchase($id,$data){
        $date_planned = date('Y-m-d H:i:s', strtotime($data['planned_date']));

        $option = array(
            'partner_id' => $data['vendor'],
            'date_order' => $date_planned,
            'partner_ref' => (String)$data['partner_ref']
        );

        $this->odoo->update('purchase.order', $id, $option);
    }






}