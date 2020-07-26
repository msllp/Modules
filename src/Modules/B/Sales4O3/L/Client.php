<?php


namespace MS\Mod\B\Sales4O3\L;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Client extends Logic
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

        $this->SalesMasterClient='MasterClient';//For Only One
        $this->SalesMasterClientLedger='MasterClientLedger';//For Every Client
        $this->SalesMasterClientPaymentLedger='MasterClientPaymentLedger';//For Every Client

    }

    public function addClient($data){}
    private function migrateForClient($clientId){}
    public function editClient($data){}

    public function AddCustomerForm($data){
        $input = $data['r']->all();

        $modalForm = false;
        $data=[
            'default'=>[
                'state'=>['name'=>'state','value'=>24],
                'paymentCreditPeriod'=>['name'=>'paymentCreditPeriod','value'=>30],
                'CreditLimit'=>['name'=>'CreditLimit','value'=>0],
                'creditInvoiceLimit'=>['name'=>'creditInvoiceLimit','value'=>0],

            ],
            'path'=>[
                'img'=>[
                    'ac'=>asset('ms/company/bankaccount.svg')
                ],
                'data'=>[
                    'allAccounts'=>route('O3.Account.All')
                ],
                'form'=>[
                    'post'=>route('O3.Sales.Customer.Add.Form.Post')
                ]
            ]
        ];

        return view('MOD::B.Sales4O3.V.Static.addClientForm')->with('data',$data);
        if (array_key_exists('modal', $input) && (bool)$input['modal']) $modalForm = true;

        // dd($modalForm);

        $m = $this->getSalesMasterClientModel();

        return $m->displayForm('addCustomer', [], $modalForm);
    }

    private function userFrontEndArrayConect($find){
        $customerData=[
            'UniqId'=>null,
            'CustomerType'=>'typeOfCustomer',
            'FirstName'=>'FirstName',
            'LastName'=>'LastName',
            'Sex'=>'sex',
            'Email'=>'email',


            'ContactNo'=>'contactNo',
            'TotalPaid'=>null,
            'TotalPending'=>null,
            'O3ConnectId'=>null,
            'O3User'=>null,
            'CompanyType'=>'typeOfCompany',
            'CompanyName'=>'name',
            'CompanyAddress1'=>'adressLine1',
            'CompanyAddress2'=>'adressLine2',
            'CompanyAddress3'=>'adressLine3',
            'CompanyPincode'=>'pincode',
            'CompanyCity'=>'city',
            'CompanyState'=>'state',
            'CompanyGST'=>'gstin',
            'CompanyPANTAN'=>'pan',
            'CompanyCIN'=>'llporcin',
            'CompanyLLPNo'=>'llporcin',
            'ClientStatus'=>null,
            'CrediLimitAmount'=>'CreditLimit',
            'CrediLimitPeriod'=>'paymentCreditPeriod',
            'CrediLimitInvoice'=>'creditInvoiceLimit',
            'CrediLimit'=>'allowTo',




        ];
        return(array_key_exists($find,$customerData))?$customerData[$find]:null;
    }
    private function makeForFrontend($data){
        $array=[];
        foreach ($data->toArray() as $n=>$e){
        $v=$this->userFrontEndArrayConect($n);
        if($v!=null)$array[$v]=$e;
        }

        return $array;
    }

    public function AddCustomerFormPost($data){
     //   dd($data['r']->all());
        $input=$data['r']->all();
        $typeOfCustomer=$input['typeOfCustomer'];
        $id=ms()->companyId();
        $uniqId=ms()->random(16,1,1,[$id]);
       // dd($input['contactNo']);
        $customerData=[
            'UniqId'=>$uniqId,
            'CustomerType'=>$typeOfCustomer,
            'FirstName'=>(array_key_exists('FirstName',$input))? $input['FirstName'] :'',
            'LastName'=>(array_key_exists('LastName',$input))? $input['LastName'] :'',
            'Sex'=>(array_key_exists('sex',$input))? $input['sex'] :'',
            'Email'=>(array_key_exists('email',$input))? $input['email'] :'',
            'ContactNo'=>(array_key_exists('contactNo',$input))? $input['contactNo'] :'',
            'TotalPaid'=>0,
            'TotalPending'=>0,
            'O3ConnectId'=>'',
            'O3User'=>'',
            'CompanyType'=>($typeOfCustomer=='company')? $input['typeOfCompany'] :'',
            'CompanyName'=>($typeOfCustomer=='company')? $input['name'] :implode(' ',[$input['FirstName'],$input['LastName']]),
            'CompanyAddress1'=>(array_key_exists('adressLine1',$input))? $input['adressLine1'] :'',
            'CompanyAddress2'=>(array_key_exists('adressLine2',$input))? $input['adressLine2'] :'',
            'CompanyAddress3'=>(array_key_exists('adressLine3',$input))? $input['adressLine3'] :'',
            'CompanyPincode'=>(array_key_exists('pincode',$input))? $input['pincode'] :'',
            'CompanyCity'=>(array_key_exists('city',$input))? $input['city'] :'',
            'CompanyState'=>$input['state'],
            'CompanyGST'=>(array_key_exists('gstin',$input))? $input['gstin'] :'',
            'CompanyPANTAN'=>(array_key_exists('pan',$input))? $input['pan'] :'',
            'CompanyCIN'=>($typeOfCustomer=='company' && (array_key_exists('typeOfCompany',$input)&& ($input['typeOfCompany']=='private'||$input['typeOfCompany']=='public'||$input['typeOfCompany']=='coop')))? $input['llporcin'] :'',
            'CompanyLLPNo'=>($typeOfCustomer=='company' && (array_key_exists('typeOfCompany',$input)&&$input['typeOfCompany']=='llp'))? $input['llporcin'] :'',
            'ClientStatus'=>true,
            'CrediLimitAmount'=>($input['CreditLimit']==0)?'0':'1',
            'CrediLimitPeriod'=>($input['paymentCreditPeriod']==0)?'0':'1',
            'CrediLimitInvoice'=>($input['creditInvoiceLimit']==0)?'0':'1',
            'CrediLimit'=>($input['allowTo']==0)?'0':'1',




        ];

        $companyId=ms()->companyId();


        $m=$this->getSalesMasterClientModel($companyId);
        $this->checkTableOrMigrate($m);
       // dd($customerData);
        $error=$m->checkRulesForData([],$data['r'],$customerData) ;
       if(!$error)$error=$this->checkRulesForFilteredData($m->CurrentError);

        if(!$error)return $this->throwError([['There is some input error.']],419,['inputError'=>$this->makeForFrontend($m->CurrentError)]);

        if(!$m->rowAdd($customerData,['UniqId','CompanyName']))return$this->throwError($m->CurrentError);

    }
    private function checkRulesForFilteredData($data){
       return (count($this->makeForFrontend($data))>0)?false:true;
    }

    private function checkTableOrMigrate(\MS\Core\Helper\MSDB $m):void {
        if(!$m->allOk()) $m->migrate();
    }

    public function TestModel(){


        $fun=implode('',['get','SalesMasterClient','Model']);
        $companyid=ms()->companyId();
        $m= call_user_func([$this,$fun],'1321196489262681_hLwTNvgch');
        $model=$m->getModel();
        $companyid=ms()->companyid();
        $m2=$this->getSalesMasterClientLedgerModel('1321196489262681_hLwTNvgch_7945374683173483');

        $dataToAttach=[
            'type'=>'this',
            'class'=>$this,
            'method'=>'getSalesMasterClientLedgerModel',
            'connectId'=>"UniqId"
        ];
        $m->attach('payment',$dataToAttach);

        dd($m->rowGet());
    }

    public static function loadRoutes(){
        $r = new \MS\Core\Helper\MSRoute();

        $r->n('Add.Form')->m('__client_AddCustomerForm_onlyuser_role')->r('add/new')->g();
        $r->n('Add.Form.Post')->m('__client_AddCustomerFormPost_onlyuser_role')->r('add/new')->p();
        $r->n('Test')->m('__client_TestModel')->r('test')->g();

        return $r->all();
    }

    public static function defaultDataForCustomerData(){
        $data=[
            [
                'BoolName'=>'Company',
                'BoolValue'=>'com',
            ],
            [
                'BoolName'=>'Indiviual',
                'BoolValue'=>'inv',
            ]
        ];
       // dd($data);
        return $data;
    }
    private function setupSalesMasterClient(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterClient]),
            'tableName' => implode('_', [self::$modCode, 'MasterClient']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $c = new \MS\Core\Helper\MSTableFieldSchema();

        $m->setFields($c->n('UniqId')->t('UID')->flush());
        $m->setFields($c->n('CustomerType')->i('radio')->vn('Select Type of Customer')->giveData('MS\Mod\B\Sales4O3\L\Client','defaultDataForCustomerData')->flush());
        $m->setFields($c->n('FirstName')->vn('First Name')->flush());
        $m->setFields($c->n('LastName')->vn('Last Name')->flush());
        $m->setFields($c->n('Sex')->t('boolean')->i('radio')->connectDBRaw(MSCORE_User_SEX)->flush());
        $m->setFields($c->n('Email')->i('email')->flush());
        $m->setFields($c->n('ContactNo')->vn('Contact Number')->required()->i('number')->flush());
        $m->setFields($c->n('TotalPaid')->flush());
        $m->setFields($c->n('TotalPending')->flush());
        $m->setFields($c->n('O3ConnectId')->flush());
        $m->setFields($c->n('O3User')->flush());
        $m->setFields($c->n('CompanyType')->connectTo('CustomerType','com')->i('option')->nodb()->vn('Select Type of Company')->giveData('MS\Mod\B\Company4O3\L\Config','allTypeOfBusiness','name','value')->flush());
        $m->setFields($c->n('CrediLimitAmount')->required()->flush());
        $m->setFields($c->n('CrediLimitPeriod')->required()->flush());
        $m->setFields($c->n('CrediLimitInvoice')->required()->flush());
        $m->setFields($c->n('CrediLimit')->t('boolean')->required()->flush());

        $m->setFields($c->n('CompanyName')->debugOn()->vn('Company Name')->connectTo('CompanyType',['com'])->required()->flush());
        $m->setFields($c->n('CompanyAddress1')->pattern('^$|^\S[a-zA-Z0-9 ,-]*$')->vn('Block/Plot no.')->flush());
        $m->setFields($c->n('CompanyAddress2')->pattern('^$|^\S[a-zA-Z0-9 ,-]*$')->vn('Landmark')->flush());
        $m->setFields($c->n('CompanyAddress3')->pattern('^$|^\S[a-zA-Z0-9 ,-]*$')->vn('Road/Area')->flush());
        $m->setFields($c->n('CompanyPincode')->vn('Pinocde')->flush());
        $m->setFields($c->n('CompanyCity')->vn('City')->flush());
        $m->setFields($c->n('CompanyState')->vn('State')->flush());
        $m->setFields($c->n('CompanyGST')->vn('GST No.')
            //->connectTo('CustomerType',['com'])
        ->connectTo('CompanyType',['solo','partnership','llp','private','public','coop'])->flush());
        $m->setFields($c->n('CompanyPANTAN')->vn('PAN / TAN')
        //connectTo('CustomerType',['com'])
            ->connectTo('CompanyType',['solo','partnership','llp','private','public','coop'])->flush());
        $m->setFields($c->n('CompanyCIN')
            //->connectTo('CustomerType',['com'])
        ->connectTo('CompanyType',['private','public','coop'])->flush());
        $m->setFields($c->n('CompanyLLPNo')
            //->connectTo('CustomerType',['com'])
            ->connectTo('CompanyType',['llp'])->flush());
        $m->setFields($c->n('ClientStatus')->flush());

        $groupId0="Type of Customer";
        $groupId1='Customer/Contact Person Basic Details';
        $groupId2='Company Basic Details';
        $groupId3='Company/Customer Location Details';

        $m->addGroup($groupId0,['CustomerType','ClientStatus']);
        $m->addGroup($groupId1,['FirstName','LastName','Sex','Email','ContactNo']);
        $m->addGroup($groupId2,['CompanyType','CompanyName','CompanyGST','CompanyPANTAN','CompanyCIN','CompanyLLPNo']);
        $m->addGroup($groupId3,['CompanyAddress1','CompanyAddress2','CompanyAddress3','CompanyCity','CompanyState','CompanyPincode']);

        $m->addAction('add', [
            "btnColor" => "blue",
            "route" => "O3.Sales.Customer.Add.Form.Post",
            "btnIcon" => "fi2 flaticon-plus",
            'btnText' => "Add Customer",
            // "routePara"=>['id'=>'UniqId'],
            // 'msLinkKey'=>'UniqId',
            //'msLinkText'=>'RoleName',
            'ownTab' => true,
        ]);


        $formId='addCustomer';

        $m->addForm($formId)->addTitle4Form($formId,'Add Customer')->addGroup4Form($formId,[$groupId0,$groupId1,$groupId2,$groupId3 ])->addAction4Form($formId,['add']);

        $m1 = $m->finalReturnForTableFile();
     //  dd($m1);
        return array_merge($m1);
    }
    private function setupSalesMasterClientLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterClientLedger]),
            'tableName' => implode('_', [self::$modCode, 'MasterClientLedger']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'LeadId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationVersion', 'type' => 'string']);
        $m->setFields(['name' => 'InvoiceId', 'type' => 'string']);
        $m->setFields(['name' => 'TotalAmount', 'type' => 'string']);
        $m->setFields(['name' => 'TotalTax', 'type' => 'string']);
        $m->setFields(['name' => 'TaxDetails', 'type' => 'string']);
        $m->setFields(['name' => 'TotalPaid', 'type' => 'string']);
        $m->setFields(['name' => 'PartialPaid', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentDetails', 'type' => 'string']);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupSalesMasterClientPaymentLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->SalesMasterClientPaymentLedger]),
            'tableName' => implode('_', [self::$modCode, $this->SalesMasterClientPaymentLedger]),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'LeadId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationId', 'type' => 'string']);
        $m->setFields(['name' => 'QuotationVersion', 'type' => 'string']);
        $m->setFields(['name' => 'InvoiceId', 'type' => 'string']);
        $m->setFields(['name' => 'AmountPaid', 'type' => 'string']);
        $m->setFields(['name' => 'AmountTax', 'type' => 'string']);
        $m->setFields(['name' => 'AmountPending', 'type' => 'string']);
        $m->setFields(['name' => 'PaymentType', 'type' => 'string']);
        $m->setFields(['name' => 'ActionInwardBy', 'type' => 'string']);
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
