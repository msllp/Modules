<?php


namespace MS\Mod\B\Sales4O3\L;


use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Product  extends Logic
{
    public static $userConstructData = [
        'UniqId' => 'string',

    ];

    public static $c_m = 'O3_Sales_Master';
    public static $c_d = 'O3_Sales_Data';
    public static $c_c = 'O3_Sales_Config';
    public static $modCode = 'Sales4O3';
    public $DB=[];

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->modPre='Sales';

        $this->SalesMasterProduct='Product';
        $this->SalesMasterProductCategory='ProductCategory';
        $this->SalesMasterProductLedger='ProductLedger';


    }

    public function AddCategoryForm($data){


        $m=$this->getSalesMasterProductCategoryModel();

        return $m->displayForm('addCategory');

    }

    public function AddCategoryFormPost($data){
        $input=$data['r']->all();
        $companyId=ms()->companyId();
        $uniqCode=ms()->random(5,5,1,[$companyId]);
        $input['UniqId']=$uniqCode;
        $m=$this->getSalesMasterProductCategoryModel(ms()->companyId());
        $m->attachR($data['r']);
        $valid=$m->checkRulesForData();
        if(!$valid)return $this->throwError($m->CurrentError,418)   ;
        if(!$m->checkTableExist())$m->migrate();
        $proccess[$m->rowAdd($input)]='Category Entery In table';

        dd($proccess);





    }

    public function ViewAllProductCategory($data){

       $m=$this->getSalesMasterProductCategoryModel(ms()->companyId());

        return $m->viewData('allCatedory');

    }

    public function viewAllProductCategoryPagination($data){
        $m=$this->getSalesMasterProductCategoryModel(ms()->companyId());
        return $m->ForPagination($data['r']);
    }

    public function getAllCategoryByApi(){
        $user=ms()->companyId();
        $m=$this->getSalesMasterProductCategoryModel($user);

        return $this->throwData($m->rowAll());
    }

    public function AddProductForm($data){

        $companyId=ms()->companyId();
        $m=$this->getSalesMasterProductModel();

        return $m->displayForm('addProduct',['ProductCategory'=>['perFix'=>[$companyId]]]);

    }
    public function AddProudctFormPost($data){
    }

    public static function loadRoutes(){
        $r=new \MS\Core\Helper\MSRoute();

        $r->n('Category.Add.Form')->m('AddCategoryForm')->r('Category/add/new')->g();
        $r->n('Category.Add.Form.Post')->m('__product_AddCategoryFormPost')->r('Category/add/new')->p();

        $r->n('Category.View.All')->m('__product_ViewAllProductCategory')->r('Category/view/all')->g();
        $r->n('Category.View.All.pagination')->m('__product_viewAllProductCategoryPagination')->r('Category/view/all/pagination')->g();
        $r->n('api.Get.All.Category')->m('__product_getAllCategoryBy_api_onlyuser')->r('/Category/view/all/api')->g();

        $r->n('Add.Form')->m('__product_AddProductForm')->r('add/new')->g();
        $r->n('Add.Form.Post')->m('__product_AddProudctFormPost')->r('add/new')->p();


        return $r->all();
    }
    private function setupMasterProduct(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProduct]),
            'tableName' => implode('_', [self::$modCode, 'MasterProduct']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $c=new \MS\Core\Helper\MSTableFieldSchema();



        $m->setFields($c->n('UniqId')->flush());
        $m->setFields($c->n('ProductCodeVesrion')->flush());
        $m->setFields($c->n('ProductBarcode')->vn('Barcode')->flush());
        $m->setFields($c->n('ProductName')->vn('Name of Product')->flush());
        $m->setFields($c->n('ProductUnit')->vn('Unit')->flush());
        $m->setFields($c->n('ProductDescription')->vn('Description')->flush());
        $m->setFields($c->n('ProductSaleCount')->flush());
        $m->setFields($c->n('ProductCategory')->vn('Category')->i('option')->connectDB('MS\Mod\B\Sales4O3','Sales4O3_'.$this->SalesMasterProductCategory,'UniqId','CategoryName')->addAction('addCategory')->flush());
        $m->setFields($c->n('ProductMadeCompany')->flush());
        $m->setFields($c->n('ProductModel')->flush());
        $m->setFields($c->n('ProductHsnSac')->flush());
        $m->setFields($c->n('ProductBasePrice')->flush());
        $m->setFields($c->n('ProductAvaragePrice')->flush());
        $m->setFields($c->n('ProductTrade')->t('boolean')->flush());
        $m->setFields($c->n('ProductKeepStock')->t('boolean')->flush());
        $m->setFields($c->n('ProductStatus')->t('boolean')->flush());

        $groupId='Basic Product Details';
        $groupData=['ProductBarcode','ProductUnit','ProductName','ProductDescription','ProductCategory'];

        $m->addGroup($groupId,$groupData);

        $m->addAction('add',[
            "btnColor"=>"blue",
            "route"=>"O3.Sales.Product.Category.Add.Form.Post",
            "btnIcon"=>"fas fa-pencil-alt",
            'btnText'=>"Add Category",
            // "routePara"=>['id'=>'UniqId'],
            // 'msLinkKey'=>'UniqId',
            //'msLinkText'=>'RoleName',
            'ownTab'=>true,
        ]);
        $m->addAction('addCategory',[
                    "btnColor"=>"blue",
                    "route"=>"O3.Sales.Product.Category.Add.Form",
                    "btnIcon"=>"fas fa-pencil-alt",
                    'btnText'=>"Add Category",
                   'dataRoute'=>'O3.Sales.Product.api.Get.All.Category',
                    // "routePara"=>['id'=>'UniqId'],
                    // 'msLinkKey'=>'UniqId',
                    //'msLinkText'=>'RoleName',
                    'ownTab'=>true,
                ]);

        $formId='addProduct';
        $m->addForm($formId)->addTitle4Form($formId,'Add New Product')->addGroup4Form($formId,[$groupId])->addAction4Form($formId,['add']);



        $m1 = $m->finalReturnForTableFile();
     //   dd($m1);
        return array_merge($m1);
    }
    private function setupSalesMasterProductCategory(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductCategory]),
            'tableName' => implode('_', [self::$modCode, 'MasterProductCategory']),
            'connection' => self::$c_c,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'CategoryName', 'type' => 'string','vName'=>'Category Name','input'=>'text','validation'=>['required'=>true]]);
        $m->setFields(['name' => 'CategoryExtraData', 'type' => 'string']);
        $m->setFields(['name' => 'CategoryDescription', 'type' => 'string','vName'=>'Category Description','input'=>'text','validation'=>['required'=>true]]);
        $m->setFields(['name' => 'CategoryExtraName', 'type' => 'string','dbOff'=>true,'input'=>'text','vName'=>'Field Name']);
        $m->setFields(['name' => 'CategoryStatus', 'type' => 'boolean',]);

        $groupTitle='Category Details';
        $groupData1=['CategoryName','CategoryDescription'];

        $m->addGroup($groupTitle,$groupData1);

        $groupTitle2='Category Extra Fields For Product';
        $groupData2=['CategoryExtraName'];

        $m->addGroup($groupTitle2,$groupData2);
        $m->makeGroupMultiple($groupTitle2);


        $m->addAction('add',[
            "btnColor"=>"blue",
            "route"=>"O3.Sales.Product.Category.Add.Form.Post",
            "btnIcon"=>"fas fa-pencil-alt",
            'btnText'=>"Add Category",
           // "routePara"=>['id'=>'UniqId'],
           // 'msLinkKey'=>'UniqId',
            //'msLinkText'=>'RoleName',
            'ownTab'=>true,
        ]);

        $formId='addCategory';
        $m->addForm($formId)->addTitle4Form($formId,'Add Product & Service Category')->addGroup4Form($formId,[$groupTitle])->addAction4Form($formId,['add']);
        $m->addAction4Form($formId,['add']);

        $viewId='allCatedory';
        $m->addView($viewId)->addTitle4View($viewId,'View All List')->addGroup4View($viewId,[$groupTitle]);
        $m->pagination4View($viewId,'O3.Sales.Product.Category.View.All.pagination');
        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function setupSalesMasterProductLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductLedger]),
            'tableName' => implode('_', [self::$modCode, 'MasterProductLedger']),
            'connection' => self::$c_c,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'InvoiceId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationVersion', 'type' => 'string']);
        $m->setFields(['name' => 'LeadId', 'type' => 'string']);
        $m->setFields(['name' => 'ProductRate', 'type' => 'string']);
        $m->setFields(['name' => 'ProductUnit', 'type' => 'string']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }


    public static function getTableRaw($data=[])
    {
        $allMethods=get_class_methods (__CLASS__);
        $autoMethodsGrabed=[];
        foreach ($allMethods as $k=>$m)if(strpos($m,'setup')===0)$autoMethodsGrabed[$m]=[];
        //  dd($autoMethodsGrabed);
        $methodToCall = [];
        $methodToCall=array_merge($autoMethodsGrabed,$methodToCall);
        //   dd($methodToCall);
        $c = new self();
        $d = [];
        foreach ($methodToCall as $method => $data) if (method_exists($c, $method))  $d = array_merge($d, $c->$method($data));
        return $d;
    }

}
