<?php


namespace MS\Mod\B\Sales4O3\L;


use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Product extends Logic
{
    public static $userConstructData = [
        'UniqId' => 'string',

    ];

    public static $c_m = 'O3_Sales_Master';
    public static $c_d = 'O3_Sales_Data';
    public static $c_c = 'O3_Sales_Config';
    public static $modCode = 'Sales4O3';
    public $DB = [];

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->modPre = 'Sales';

        $this->SalesMasterProduct = 'Product';
        $this->SalesMasterProductCategory = 'ProductCategory';
        $this->SalesMasterProductLedger = 'ProductLedger';


    }

    public static function loadRoutes()
    {
        $r = new \MS\Core\Helper\MSRoute();

        $r->n('Category.Add.Form')->m('__product_AddCategoryForm_onlyuser_role')->r('Category/add/new')->g();
        $r->n('Category.Add.Form.Post')->m('__product_AddCategoryFormPost_role')->r('Category/add/new')->p();

        $r->n('Category.View.All')->m('__product_ViewAllProductCategory_role')->r('Category/view/all')->g();
        $r->n('Category.View.All.pagination')->m('__product_viewAllProductCategoryPagination_role')->r('Category/view/all/pagination')->g();
        $r->n('api.Get.All.Category')->m('__product_getAllCategoryByApi__role_onlyuser')->r('/Category/view/all/api')->g();

        $r->n('Add.Form')->m('__product_AddProductForm_role')->r('add/new')->g();
        $r->n('Add.Form.Post')->m('__product_AddProudctFormPost_role')->r('add/new')->p();

        $r->n('View.All')->m('__product_ViewAllProduct_role')->r('view/all')->g();
        $r->n('View.All.pagination')->m('__product_viewAllProductPagination_role')->r('view/all/pagination')->g();

        $r->n('Edit.byId')->m('__product_EditProduct_role')->r('edit/{id?}')->g();
        $r->n('Delete.byId')->m('__product_DeleteProduct_role')->r('delete/{id?}')->g();
        $r->n('Edit.byId.Post')->m('__product_EditProductPost_role')->r('edit/{id?}')->p();

        return $r->all();
    }



    public static function getTableRaw($data = [])
    {
        $allMethods = get_class_methods(__CLASS__);
        $autoMethodsGrabed = [];
        foreach ($allMethods as $k => $m) if (strpos($m, 'setup') === 0) $autoMethodsGrabed[$m] = [];
        //  dd($autoMethodsGrabed);
        $methodToCall = [];
        $methodToCall = array_merge($autoMethodsGrabed, $methodToCall);
        //   dd($methodToCall);
        $c = new self();
        $d = [];
        foreach ($methodToCall as $method => $data) if (method_exists($c, $method)) $d = array_merge($d, $c->$method($data));
        return $d;
    }

    public function DeleteProduct($data){
        $productId=reset($data['para']);
        $this->deletProductById($productId);
        return $this->throwNextData('Sales','View All Product & Services','O3.Sales.Product.View.All');
    }

    private function deletProductById($id):void {
        $companyId=ms()->companyId();
        $m=$this->getSalesMasterProductModel($companyId);
        $m2=$this->getSalesMasterProductLedgerModel(implode('_',[$companyId,$id]));
        $m->rowDelete(['UniqId'=>$id]);
        $m2->delete();

    }
    public function EditProduct($data){

        $productId=reset($data['para']);
        $companyId=ms()->companyId();
        $m=$this->getSalesMasterProductModel($companyId);
        $rowData=$m->rowGet(['UniqId'=>$productId]);
        $productData=reset($rowData);
        if($productData==false)return$this->throwError(['No Product Found.']);
        //dd($productData);

        return $m->editForm('editProduct', $productData,['ProductCategory' => ['perFix' => [$companyId]]]);
        dd($productId);
    }
    public function EditProductPost($data){
        $input=$data['r']->all();
        $productId=reset($data['para']);
      //  $input['UniqId']=$productId;
        $companyId=ms()->companyId();
        $m=$this->getSalesMasterProductModel($companyId);
        $m->attachR($data['r']);
        if(!$m->checkRulesForEditData(['perFix' => ['ProductCategory' => $companyId],'UniqId'=>$productId]))return $this->throwError($m->CurrentError);

        $m->rowEdit(['UniqId'=>$productId],$input);

        return $this->throwNextData('Sales','View All Product & Services','O3.Sales.Product.View.All');
    }



    public function ViewAllProduct($data){
        $companyId=ms()->companyId();
        $m = $this->getSalesMasterProductModel($companyId);
        //dd($m);
        return $m->viewData('allProduct',['perFix'=>['ProductCategory'=>$companyId]]);
    }
    public function viewAllProductPagination($data){
        $companyId=ms()->companyId();
        $m = $this->getSalesMasterProductModel($companyId);
        return $m->ForPagination($data['r'],['perFix'=>['ProductCategory'=>$companyId]],'allProduct');
    }

    public function AddCategoryForm($data)
    {

        $input = $data['r']->all();
        //   dd((bool)$input['modal']);
        $modalForm = false;
        if (array_key_exists('modal', $input) && (bool)$input['modal']) $modalForm = true;

        // dd($modalForm);

        $m = $this->getSalesMasterProductCategoryModel();

        return $m->displayForm('addCategory', [], $modalForm);

    }

    public function AddCategoryFormPost($data)
    {

        $input = $data['r']->all();
        $companyId = ms()->companyId();
        $uniqCode = ms()->random(5, 5, 1, [$companyId]);
        $input['UniqId'] = $uniqCode;
        $m = $this->getSalesMasterProductCategoryModel(ms()->companyId());
        $m->attachR($data['r']);
        $valid = $m->checkRulesForData();
        if (!$valid) return $this->throwError($m->CurrentError, 418);
        if (!$m->checkTableExist()) $m->migrate();
        $proccess[$m->rowAdd($input)] = 'Category Entery In table';

       return $this->throwNextData('Sales','View All Category','O3.Sales.Product.Category.View.All');


    }

    public function ViewAllProductCategory($data)
    {

        $m = $this->getSalesMasterProductCategoryModel(ms()->companyId());

        return $m->viewData('allCatedory');

    }

    public function viewAllProductCategoryPagination($data)
    {
        $m = $this->getSalesMasterProductCategoryModel(ms()->companyId());
        return $m->ForPagination($data['r'],[],'allCatedory');
    }

    public function getAllCategoryByApi()
    {
        $user = ms()->companyId();
        $m = $this->getSalesMasterProductCategoryModel($user);

        return $this->throwData($m->rowAll());
    }

    public function AddProductForm($data)
    {
        $companyId = ms()->companyId();
        $m = $this->getSalesMasterProductModel();
        return $m->displayForm('addProduct', ['ProductCategory' => ['perFix' => [$companyId]]]);
    }

    public function AddProudctFormPost($data)
    {
        $r = $data['r'];
        $input = $r->all();
        $companyId = ms()->companyId();
        $m = $this->getSalesMasterProductModel($companyId);
      //  dd($m->rowAll());
        if (!$m->checkTableExist()) $m->migrate();
        $m->attachR($r);
        $valid = $m->checkRulesForData(['perFix' => ['ProductCategory' => ms()->companyId()]]);
        //dd($valid);
        if (!$valid) return $this->throwError($m->CurrentError, 418);
        if (!$m->checkTableExist()) $m->migrate();
        $UniqId = $this->newProductUniqId();
        if (!array_key_exists('UniqId', $input)) $input['UniqId'] = $UniqId;

        $proccess[$m->rowAdd($input)][] = 'Category Entery In table';
        $proccess[$this->migrateForWhenProductCreated($UniqId)][] = 'Table Migrated for Product';

        return$this->throwNextData('Sales','View All Product & Services','O3.Sales.Product.View.All');


    }

    private function newProductUniqId()
    {
        $companyId = ms()->companyId();
        return ms()->random(16, 5, 1, [$companyId]);
    }

    public function migrateForWhenProductCreated($productId)
    {
        $tableId = implode('_', [ms()->companyId(), $productId]);
        $er = [];
        $migrate = [
            'Product Ledger Table' => $this->getSalesMasterProductLedgerModel($tableId)
        ];
        foreach ($migrate as $k => $m) {
            $er[$m->migrate()][] = $k;
        }

        return (array_key_exists('0', $er)) ? false : true;
    }

    private function setupMasterProduct()
    {
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProduct]),
            'tableName' => implode('_', [self::$modCode, 'MasterProduct']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $c = new \MS\Core\Helper\MSTableFieldSchema();

        $m->setFields($c->n('UniqId')->flush());
        $m->setFields($c->n('ProductCodeVesrion')->flush());
        $m->setFields($c->n('ProductBarcode')->vn('Barcode')->i('number')->flush());
        $m->setFields($c->n('ProductName')->vn('Name of Product')->required()->flush());
        $m->setFields($c->n('ProductUnit')->vn('Unit')->required()->flush());
        $m->setFields($c->n('ProductDescription')->vn('Description')->flush());
        $m->setFields($c->n('ProductSaleCount')->flush());
        $m->setFields($c->n('ProductCategory')->vn('Category')->i('option')->connectDB('MS\Mod\B\Sales4O3', 'Sales4O3_' . $this->SalesMasterProductCategory, 'UniqId', 'CategoryName')->addAction('addCategory')->required()->flush());
        $m->setFields($c->n('ProductMadeCompany')->vn('Company')->flush());
        $m->setFields($c->n('ProductModel')->vn('Version Or Model')->flush());
        $m->setFields($c->n('ProductHsnSac')->i('number')->vn('Tax Code')->required()->flush());
        $m->setFields($c->n('ProductBasePrice')->vn('Product Default Price')->flush());
        $m->setFields($c->n('ProductAvaragePrice')->flush());
        $m->setFields($c->n('ProductTrade')->vn('Show Product In Purchase')->t('boolean')->i('radio')->connectDBRaw(MSCORE_UI_BOOL_1)->required()->flush());
        $m->setFields($c->n('ProductKeepStock')->vn('Keep Invetory For this Product')->t('boolean')->i('radio')->connectDBRaw(MSCORE_UI_BOOL_1)->required()->flush());
        $m->setFields($c->n('ProductStatus')->t('boolean')->i('radio')->connectDBRaw(MSCORE_UI_BOOL_1)->flush());

        $m->UniqFields(['UniqId', 'ProductBarcode', 'ProductName']);

        $groupId = 'Basic Product Details';
        //$groupData=['ProductBarcode','ProductUnit','ProductName','ProductDescription','ProductCategory'];

        $groupId2 = 'Product Make Deatils';
        //$groupData2=['ProductMadeCompany','ProductModel'];

        $groupId3 = 'Price & Tax Details';
        //$groupData3=['ProductHsnSac','ProductBasePrice'];

        $groupId4 = 'Product Manage Functionality';
        // $groupData4=['ProductTrade','ProductKeepStock'];

        $allGroups = [
            [
                'name' => $groupId,
                'data' => ['ProductName', 'ProductDescription', 'ProductCategory']
            ],
            [
                'name' => $groupId2,
                'data' => ['ProductBarcode', 'ProductUnit', 'ProductMadeCompany', 'ProductModel']
            ],
            [
                'name' => $groupId3,
                'data' => ['ProductHsnSac', 'ProductBasePrice']
            ],
            [
                'name' => $groupId4,
                'data' => ['ProductTrade', 'ProductKeepStock']
            ]
        ];

        ms()->do()->registerGroups($m, $allGroups);


        $m->addAction('add', [
            "btnColor" => "blue",
            "route" => "O3.Sales.Product.Add.Form.Post",
            "btnIcon" => "fi2 flaticon-plus",
            'btnText' => "Add Product or Service",
            // "routePara"=>['id'=>'UniqId'],
            // 'msLinkKey'=>'UniqId',
            //'msLinkText'=>'RoleName',
            'ownTab' => true,
        ]);
        $m->addAction('addCategory', [
            "btnColor" => "blue",
            "route" => "O3.Sales.Product.Category.Add.Form",
            "btnIcon" => "fas fa-pencil-alt",
            'btnText' => "Add Category",
            'dataRoute' => 'O3.Sales.Product.api.Get.All.Category',
            // "routePara"=>['id'=>'UniqId'],
            // 'msLinkKey'=>'UniqId',
            //'msLinkText'=>'RoleName',
            'ownTab' => true,
        ]);
        $m->addAction('edit', [
            "btnColor" => "blue",
            "route" => "O3.Sales.Product.Edit.byId",
            "btnIcon" => "fas fa-pencil-alt",
            'btnText' => "Edit Product",
            "routePara"=>['id'=>'UniqId'],
            'msLinkKey'=>'UniqId',
            'msLinkText'=>'ProductName',
            'ownTab' => true,
        ]);
        $m->addAction('delete', [
            "btnColor" => "red",
            "route" => "O3.Sales.Product.Delete.byId",
            "btnIcon" => "far fa-trash-alt",
            'btnText' => "Delete Product",
            "routePara"=>['id'=>'UniqId'],
            'msLinkKey'=>'UniqId',
            'msLinkText'=>'ProductName',
            'ownTab' => true,
            'doubleConfirm'=>true,
            'doubleConfirm'=>'Are you sure you want Delete'
        ]);

        $m->addAction('editPost', [
            "btnColor" => "blue",
            "route" => "O3.Sales.Product.Edit.byId",
            "btnIcon" => "fas fa-pencil-alt",
            'btnText' => "Edit Product",
            "routePara"=>['id'=>'UniqId'],
            'msLinkKey'=>'UniqId',

            //'msLinkText'=>'RoleName',
            'ownTab' => true,
        ]);

        $formId = 'addProduct';
        $m->addForm($formId)->addTitle4Form($formId, 'Add New Product')->addGroup4Form($formId, [$groupId, $groupId2, $groupId3, $groupId4])->addAction4Form($formId, ['add']);

        $formId = 'editProduct';
        $m->addForm($formId)->addTitle4Form($formId, 'Edit Product')->addGroup4Form($formId, [$groupId, $groupId2, $groupId3, $groupId4])->addAction4Form($formId, ['editPost']);


        $viewId='allProduct';
        $m->addView($viewId)->addRowId($viewId,'UniqId')->addAction4View($viewId,['edit','delete'])->addTitle4View($viewId,'View All Product')->pagination4View($viewId,'O3.Sales.Product.View.All.pagination')->addGroup4View($viewId,[$groupId]);

        $m1 = $m->finalReturnForTableFile();
        //dd($m1);
        return array_merge($m1);
    }

    private function setupSalesMasterProductCategory()
    {
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductCategory]),
            'tableName' => implode('_', [self::$modCode, 'MasterProductCategory']),
            'connection' => self::$c_c,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'CategoryName', 'type' => 'string', 'vName' => 'Category Name', 'input' => 'text', 'validation' => ['required' => true]]);
        $m->setFields(['name' => 'CategoryExtraData', 'type' => 'string']);
        $m->setFields(['name' => 'CategoryDescription', 'type' => 'string', 'vName' => 'Category Description', 'input' => 'text', 'validation' => ['required' => true]]);
        $m->setFields(['name' => 'CategoryExtraName', 'type' => 'string', 'dbOff' => true, 'input' => 'text', 'vName' => 'Field Name']);
        $m->setFields(['name' => 'CategoryStatus', 'type' => 'boolean',]);

        $groupTitle = 'Category Details';
        $groupData1 = ['CategoryName', 'CategoryDescription'];

        $m->addGroup($groupTitle, $groupData1);

        $groupTitle2 = 'Category Extra Fields For Product';
        $groupData2 = ['CategoryExtraName'];

        $m->addGroup($groupTitle2, $groupData2);
        $m->makeGroupMultiple($groupTitle2);


        $m->addAction('add', [
            "btnColor" => "blue",
            "route" => "O3.Sales.Product.Category.Add.Form.Post",
            "btnIcon" => "fas fa-pencil-alt",
            'btnText' => "Add Category",
            // "routePara"=>['id'=>'UniqId'],
            // 'msLinkKey'=>'UniqId',
            //'msLinkText'=>'RoleName',
            'ownTab' => true,
        ]);


        $formId = 'addCategory';
        $m->addForm($formId)->addTitle4Form($formId, 'Add Product & Service Category')->addGroup4Form($formId, [$groupTitle])->addAction4Form($formId, ['add']);
        $m->addAction4Form($formId, ['add']);

        $viewId = 'allCatedory';
        $m->addView($viewId)->addTitle4View($viewId, 'View All List')->addGroup4View($viewId, [$groupTitle]);
        $m->pagination4View($viewId, 'O3.Sales.Product.Category.View.All.pagination');
        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function setupSalesMasterProductLedger()
    {
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterProductLedger]),
            'tableName' => implode('_', [self::$modCode, 'MasterProductLedger']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $c = new \MS\Core\Helper\MSTableFieldSchema();

        $m->setFields($c->n('UniqId')->flush());
        $m->setFields($c->n('InvoiceId')->flush());
        $m->setFields($c->n('QuotationId')->flush());
        $m->setFields($c->n('QuotationVersion')->flush());
        $m->setFields($c->n('LeadId')->flush());
        $m->setFields($c->n('ProductRate')->flush());
        $m->setFields($c->n('ProductUnit')->flush());
        $m->UniqFields(['UniqId', 'InvoiceId', 'QuotationId', 'QuotationVersion', 'LeadId']);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

}
