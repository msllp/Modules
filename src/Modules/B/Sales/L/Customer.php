<?php


namespace MS\Mod\B\Sales\L;


class Customer
{
    public static $c_m='MS_Sales_Master';
    public static $c_d='MS_Sales_Data';
    public static $c_c='MS_Sales_Config';
    public static $modCode='Sales';
    public function __construct()
    {
    }

    public static function getCustomerTableRaw(){

        $methodToCall=[
            'setUpCustomerCategory'=>[],
            'setUpCustome'=>['modCode'=>self::$modCode]];
        $c=new self();
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
        dd($d);



    }

    private function setUpCustomerCategory(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'CustomerCat']),
            'tableName'=>implode('_',[self::$modCode,'CustomerCat']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CatName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CatDescription','vName'=>\Lang::get('Core.fieldType'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $groupId1=\Lang::get('Core.productCategory');
        $groupFields1=['CatName','CatDescription'];
        $m->addGroup($groupId1)->addField($groupId1,$groupFields1);
        $action1=[
            "btnColor"=>"bg-green",
            "route"=>"MOD.User.Master.Add.toDB",
            "btnIcon"=>"far fa-save",
            'btnText'=>\Lang::get('Core.productCategoryAddBtn')
        ];
        $actionId1='add';
        $m->addAction($actionId1,$action1);


        $formId1='add_customer_category';


        $m->addForm($formId1)->addGroup4Form($formId1,[$groupId1])->addAction4Form($formId1,[$actionId1])->addTitle4Form($formId1,\Lang::get('Core.productCategoryAddFormTitle'));
        $m1=$m->finalReturnForTableFile();
        //  dd($m1);
        $data=[
            'tableId'=>implode('_',[self::$modCode,'CustomerCatExtra']),
            'tableName'=>implode('_',[self::$modCode,'CustomerCatExtra']),
            'connection'=>self::$c_m,
        ];
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']);
        //dd( \MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']));
        return array_merge($m1,$m2);
    }

    private function setUpCustomer($data=[]){
        $modCode=(array_key_exists('modCode',$data))? $data['modCode']:self::$modCode;
        $data=[
            'tableId'=>implode('_',[$modCode,'Customer']),
            'tableName'=>implode('_',[$modCode,'Customer']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerDescription','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerType','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAddress1','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAddress2','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAddress3','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerCity','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerState','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerPincode','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerContactNo','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerEmail','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerGST','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerPAN','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAge','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerSex','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerCredit','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerCreditLimit','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerCreditDay','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerSales','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerSalesConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerInventory','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerInventoryConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAmountPaid','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAmountUnpaid','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAmountPaidAmount','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAmountUnpaidAmount','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);



        $m1=$m->finalReturnForTableFile();
        $data=[
            'tableId'=>implode('_',[self::$modCode,'CustomerExtra']),
            'tableName'=>implode('_',[self::$modCode,'CustomerExtra']),
            'connection'=>self::$c_m,
        ];
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']);
        //dd( \MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']));
        return array_merge($m1,$m2);

    }
}
