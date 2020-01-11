<?php


namespace MS\Mod\B\Sales\L;


class Invoice
{
    //TODO Make Invoice table Structure
    public static $c_m='MS_Sales_Master';
    public static $c_d='MS_Sales_Data';
    public static $c_c='MS_Sales_Config';
    public static $modCode='Sales';
    public function __construct()
    {
    }

    public static function getTableRaw(){

        $methodToCall=[
            'setUpInvoice'=>[],];
       //     'setUpCustome'=>['modCode'=>self::$modCode]];
        $c=new self();
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
        return $d;
        dd($d);

    }

    private function setUpInvoice(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'MasterInvoice']),
            'tableName'=>implode('_',[self::$modCode,'MasterInvoice']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InAmount','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InTaxAmount','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InPaymentStatus','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InParty1','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InParty2','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InItemCount','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InLeadConnect','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InLeadConnectId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InQuotationConnect','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'InQuotationConnectId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);


        $m1=$m->finalReturnForTableFile();

        $data=[
            'tableId'=>implode('_',[self::$modCode,'InvoiceSub']),
            'tableName'=>implode('_',[self::$modCode,'InvoiceSub']),//_{MasterInvoice.UniqId}
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductBatchUnit','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductUnit','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductUnitPrice','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductTotalPrice','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductTax','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $m2=$m->finalReturnForTableFile();
    }


    //TODO Make below Methods

    public function getInvoiceModel(){}
    public function getInvoiceSubModel(){}
    public function addInvoice($data){}

    private function IncoiceEntryToDB($data){}
    private function IncoiceSubEntryToDB($data){}
    public function editInvoice($data){}
    public function deleteInvoice($data){}
}
