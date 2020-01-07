<?php


namespace MS\Mod\B\Purchase\L;


class Products
{
    public static $c_m= 'MS_Purchase_Master';
    public static $c_d='MS_Purchase_Data';
    public static $c_c='MS_Purchase_Config';
    public static $modCode='Purchase';
    public function __construct()
    {
    }

    public static function getProductTableRaw(){

        $methodToCall=[
            'setUpProductCategory'=>[],
            'setUpVendor'=>[],
            'setUpProduct'=>['modCode'=>self::$modCode]];
        $c=new self();
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
        dd($d);



    }
    private function setUpProductCategory(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'ProductsCat']),
            'tableName'=>implode('_',[self::$modCode,'ProductsCat']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CatName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CatDescription','vName'=>\Lang::get('Core.fieldType'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $groupId1=\Lang::get('Core.productCategory');
        $groupFields1=['CatName','CatDescription'];
        $m->addGroup($groupId1)->addField($groupId1,$groupFields1);
        //TODO Change in Production
        $action1=[
            "btnColor"=>"bg-green",
            "route"=>"MOD.User.Master.Add.toDB",
            "btnIcon"=>"far fa-save",
            'btnText'=>\Lang::get('Core.productCategoryAddBtn')
        ];
        $actionId1='add';
        $m->addAction($actionId1,$action1);


        $formId1='add_product_category';


        $m->addForm($formId1)->addGroup4Form($formId1,[$groupId1])->addAction4Form($formId1,[$actionId1])->addTitle4Form($formId1,\Lang::get('Core.productCategoryAddFormTitle'));
        $m1=$m->finalReturnForTableFile();
        //  dd($m1);
        $data=[
            'tableId'=>implode('_',[self::$modCode,'ProductsCatExtra']),
            'tableName'=>implode('_',[self::$modCode,'ProductsCatExtra']),
            'connection'=>self::$c_m,
        ];
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']);
        //dd( \MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']));
        return array_merge($m1,$m2);
    }

    private function setUpProduct($data=[]){
        $modCode=(array_key_exists('modCode',$data))? $data['modCode']:self::$modCode;
        $data=[
            'tableId'=>implode('_',[$modCode,'Products']),
            'tableName'=>implode('_',[$modCode,'Products']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductCatCode','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductDescription','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductMade','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductMake','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductVendorUniqId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductUnit','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductBatchUnit','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductSalesConnect','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'boolean','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductSalesConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductInventoryConnect','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'boolean','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductInventoryConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductSalePrice','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductSaleVary','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'boolean','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductPurchasePrice','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductTaxCode','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductTaxAmount','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductMargin','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductJobConnect','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'boolean','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductJobConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductStatus','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);



        $m1=$m->finalReturnForTableFile();
        $data=[
            'tableId'=>implode('_',[self::$modCode,'ProductsExtra']),
            'tableName'=>implode('_',[self::$modCode,'ProductsExtra']),
            'connection'=>self::$c_m,
        ];
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']);
        //dd( \MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']));
        return array_merge($m1,$m2);

    }

    private function setUpVendor(){
        $data=[
            'tableId'=>implode('_',[self::$modCode,'VendorMaster']),
            'tableName'=>implode('_',[self::$modCode,'vendor_master']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorShortName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorDescription','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorType','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorAddress1','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorAddress2','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorAddress3','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorCity','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorState','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorPincode','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorContactNo','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorEmail','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorGST','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorPANTAN','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorCIN','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorCredit','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorCreditLimit','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorCreditDay','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorSales','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorSalesConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorInventory','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorInventoryConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorAmountPaid','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorAmountUnpaid','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorAmountPaidAmount','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorAmountUnpaidAmount','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);


        $groupId1=\Lang::get('Core.vendorGroup1');
        $groupId2=\Lang::get('Core.vendorGroup2');
        $groupId3=\Lang::get('Core.vendorGroup3');
        $groupId4=\Lang::get('Core.vendorGroup4');
        $groupId5=\Lang::get('Core.vendorGroup5');


        $groupFields1=['VendorName','VendorShortName','VendorDescription','VendorType'];
        $groupFields2=['VendorGST','VendorPANTAN','VendorCIN','VendorCredit','VendorCreditLimit','VendorCreditDay'];
        $groupFields3=['VendorAddress1','VendorAddress2','VendorAddress3','VendorCity','VendorState','VendorPincode'];
        $groupFields4=['VendorContactNo','VendorEmail'];
        $groupFields5=['VendorSales','VendorInventory'];
        $m->addGroup($groupId1)->addField($groupId1,$groupFields1);
        $m->addGroup($groupId2)->addField($groupId2,$groupFields2);
        $m->addGroup($groupId3)->addField($groupId3,$groupFields3);
        $m->addGroup($groupId4)->addField($groupId4,$groupFields4);
        $m->addGroup($groupId5)->addField($groupId5,$groupFields5);

        $formId='add_vendor';
        $formTitle='Add Vendor';
        $action1=[
            "btnColor"=>"bg-green",
            "route"=>"MOD.User.Master.Add.toDB",
            "btnIcon"=>"far fa-save",
            'btnText'=>\Lang::get('Core.productCategoryAddBtn')
        ];
        $actionId1='add';
        $m->addAction($actionId1,$action1);
        $m->addForm($formId)->addTitle4Form($formId,$formTitle)->addGroup4Form($formId,[$groupId1,$groupId2,$groupId3,$groupId4,$groupId5])->addAction4Form($formId,[$actionId1]);
        dd($m);
        return$m->finalReturnForTableFile();


        $m->addGroup($groupId1)->addField($groupId1,$groupFields1);





    }
}
