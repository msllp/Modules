<?php
namespace MS\Mod\B\Sales\L;


class Products
{

    public static $c_m='MS_Sales_Master';
    public static $c_d='MS_Sales_Data';
    public static $c_c='MS_Sales_Config';
    public static $modCode='Sales';
    public function __construct()
    {
    }

    public static function getProductTableRaw(){

        $methodToCall=[
            'setUpProductCategory'=>[],
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
        $m->setFields(['name'=>'ProductPurchaseConnect','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'boolean','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ProductPurchaseConnectId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
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

}
