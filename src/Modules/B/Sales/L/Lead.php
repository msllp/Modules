<?php


namespace MS\Mod\B\Sales\L;


class Lead
{
//TODO Make Lead table Structure

    public static $c_m='MS_Sales_Master';
    public static $c_d='MS_Sales_Data';
    public static $c_c='MS_Sales_Config';
    public static $modCode='Sales';
    public function __construct()
    {
    }

    public static function getTableRaw(){

        $methodToCall=[
            'setUpLeadCategory'=>[],
            'setUpLead'=>['modCode'=>self::$modCode]];
        $c=new self();
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
        dd($d);



    }

    private function setUpLeadCategory(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'LeadCat']),
            'tableName'=>implode('_',[self::$modCode,'LeadCat']),
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
            'tableId'=>implode('_',[self::$modCode,'LeadCatExtra']),
            'tableName'=>implode('_',[self::$modCode,'LeadCatExtra']),
            'connection'=>self::$c_m,
        ];
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']);
        //dd( \MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']));
        return array_merge($m1,$m2);
    }

    private function setUpLeadStatus(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'LeadStatus']),
            'tableName'=>implode('_',[self::$modCode,'LeadStatus']),
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
            'tableId'=>implode('_',[self::$modCode,'LeadStatusExtra']),
            'tableName'=>implode('_',[self::$modCode,'LeadStatusExtra']),
            'connection'=>self::$c_m,
        ];
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']);
        //dd( \MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']));
        return array_merge($m1,$m2);
    }
    private function setUpLead($data=[]){
        $modCode=(array_key_exists('modCode',$data))? $data['modCode']:self::$modCode;
        $data=[
            'tableId'=>implode('_',[$modCode,'Lead']),
            'tableName'=>implode('_',[$modCode,'Lead']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerDescription','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerNote','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAddress1','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAddress2','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerAddress3','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerCity','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerState','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerPincode','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerContactNo','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CustomerEmail','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadChannelId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadHandler','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadChain','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadResponse','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadAnswer','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadStatus','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadQuotationConnect','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadQuotationConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadInvoice','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'LeadInvoiceConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);



        $m1=$m->finalReturnForTableFile();
        $data=[
            'tableId'=>implode('_',[self::$modCode,'LeadExtra']),
            'tableName'=>implode('_',[self::$modCode,'LeadExtra']),
            'connection'=>self::$c_m,
        ];
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']);
        //dd( \MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']));
        return array_merge($m1,$m2);

    }
}
