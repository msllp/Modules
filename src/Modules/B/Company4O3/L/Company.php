<?php


namespace MS\Mod\B\Company4O3\L;


use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class Company extends Logic
{
    public function __construct($data = [])
    {

        $this->modPre='Company';

        $this->CompanyUserMaster='CompanyUserMaster';
        $this->CompanyMaster='CompanyMaster';
        $this->CompanyAccounts='CompanyAccounts';
        $this->CompanyCashLedger='CompanyCash';
        $this->CompanyAccountLedger="CompanyAccountLedger";



        parent::__construct($data);
        }



    public static $userConstructData = [
        'UniqId' => 'string',
        'MeetingHeadUserId'=>'string',
        'MeetingUsers'=>'array'
    ];

    public static $c_m = 'O3_Company_Master';
    public static $c_d = 'O3_Company_Data';
    public static $c_c = 'O3_Company_Config';
    public static $modCode = 'Company4O3';
    public $DB=[];

    public function getCompanyForWebsiteById($data){
        $er=[
            '101'=>['Company Not Found']
        ];
        $unSet=['UniqId','CompanyShortName','id','CompanyHasBranch','updated_at','CompanyStatus'];

        $foundCompany=$this->getCompanyByCompanyId($data['companyId'],false);
        if(count($foundCompany)<1)return $this->throwError($er['101']);
        $foundCompany=\MS\Core\Helper\Comman::filterArray($foundCompany,$unSet);

        $d=\Carbon::parse($foundCompany['created_at']);
        $d->tz = 'Asia/Kolkata';
        $foundCompany['created_at']=$d->format('jS, F Y');
        $foundCompany['CompanyType']=Config::getTypeOfBusiness($foundCompany['CompanyType']);
        $foundCompany['CompanyCategory']=Config::getCategory($foundCompany['CompanyCategory']);
        $foundCompany['CompanyState']=Config::getStateByCode($foundCompany['CompanyState']);

        $outData=[
            'companyDetails'=>$foundCompany,
            'companyStatistics'=>[
                'totalTurnove'=>\MS\Core\Helper\Comman::moneyFormatIndia(2312123),
                'totalInvoices'=>10,
                'totalProducts'=>1213,
                'totalPurchase'=>324,
                'totalEmployes'=>34
            ],
            'companyServices'=>[
                [
                    'name'=>'Custom ERP',
                ],
                [
                    'name'=>'Cloud Application',
                ],
                [
                    'name'=>'Dynamic Website',
                ]
            ],
            'companyProduct'=>[
                [
                    'name'=>'MS-ERP',
                    'subText'=>'Most Customized ERP Solution'
                ],
                [
                    'name'=>'MS-CRM',
                    'subText'=>'Most Customized CRM Solution'
                ],
                [
                    'name'=>'MS-CCA',
                    'subText'=>'Most Customized Cloud Application Solution'
                ],
                [
                    'name'=>'MS-Flex',
                    'subText'=>'A Complate Website Solution'
                ]
            ],
        ];
        return $this->throwData($outData);
      //  dd($foundCompany);

    }
    public function getCompanyForWebsite($data){
        $er=[
            '101'=>['Company Not Found']
        ];
        $unSet=['UniqId','CompanyShortName','id','CompanyHasBranch','updated_at','CompanyStatus'];

        $foundCompany=$this->getCompanyById($data['companyId'],false);
        if(count($foundCompany)<1)return $this->throwError($er['101']);
        $foundCompany=\MS\Core\Helper\Comman::filterArray($foundCompany,$unSet);

        $d=\Carbon::parse($foundCompany['created_at']);
        $d->tz = 'Asia/Kolkata';
        $foundCompany['created_at']=$d->format('jS, F Y');
        $foundCompany['CompanyType']=Config::getTypeOfBusiness($foundCompany['CompanyType']);
        $foundCompany['CompanyCategory']=Config::getCategory($foundCompany['CompanyCategory']);
        $foundCompany['CompanyState']=Config::getStateByCode($foundCompany['CompanyState']);

        $outData=[
            'companyDetails'=>$foundCompany,
            'companyStatistics'=>[
                'totalTurnove'=>\MS\Core\Helper\Comman::moneyFormatIndia(2312123),
                'totalInvoices'=>10,
                'totalProducts'=>1213,
                'totalPurchase'=>324,
                'totalEmployes'=>34
            ],
            'companyServices'=>[
                [
                    'name'=>'Custom ERP',
                ],
                [
                    'name'=>'Cloud Application',
                ],
                [
                    'name'=>'Dynamic Website',
                ]
            ],
            'companyProduct'=>[
                [
                    'name'=>'MS-ERP',
                    'subText'=>'Most Customized ERP Solution'
                ],
                [
                    'name'=>'MS-CRM',
                    'subText'=>'Most Customized CRM Solution'
                ],
                [
                    'name'=>'MS-CCA',
                    'subText'=>'Most Customized Cloud Application Solution'
                ],
                [
                    'name'=>'MS-Flex',
                    'subText'=>'A Complate Website Solution'
                ]
            ],
        ];
        return $this->throwData($outData);
      //  dd($foundCompany);

    }

    private function getCompanyById($id,$outJson=true){
        $er=[
            '101'=>['Company Not Found']
        ];
        $exId=explode('_',$id);
        $userId=reset($exId);
        $m=$this->getUserCompanyModel($userId);
        $foundCompany=$m->rowGet(['UniqId'=>$id,'CompanyStatus'=>1]);
        if(count($foundCompany)<1)return ($outJson)?$this->throwError($er['101']):[];
        $foundCompany=reset($foundCompany);
        return ($outJson)?$this->throwData($foundCompany):$foundCompany;


    }
    private function getCompanyByCompanyId($id,$outJson=true){
        $er=[
            '101'=>['Company Not Found']
        ];
        $m0=$this->getMasterCompanyModel();
        $foundCompanyId=$m0->rowGet(['CompanyId'=>$id,'CompanyStatus'=>1]);
        if(count($foundCompanyId)<1)return ($outJson)?$this->throwError($er['101']):[];
        $foundCompanyId=reset($foundCompanyId);
       // dd($foundCompanyId);
        $exId=explode('_',$foundCompanyId['UniqId']);
        $userId=reset($exId);
        $m=$this->getUserCompanyModel($userId);
        $foundCompany=$m->rowGet(['UniqId'=>$foundCompanyId['UniqId'],'CompanyStatus'=>1]);
        if(count($foundCompany)<1)return ($outJson)?$this->throwError($er['101']):[];
        $foundCompany=reset($foundCompany);
        return ($outJson)?$this->throwData($foundCompany):$foundCompany;


    }
    public function ForUsersetupFirstCompany(){
        $data=[];

      //  dd(Session::all());
        return  view('MOD::B.Company4O3.V.Static.SetupCompany')->with('data',$data);
    }

    public function getAllStates(){
        $data=Config::allStates();
        $mapFunction=function ($ar){
            $ar['name']=strtoupper(implode(' ',[ '('.$ar['stateCode'].')',$ar['name'] ]));
            unset($ar['stateCode']);
            return $ar;
        };
        $data=array_map($mapFunction,$data);

       return $this->throwData($data);

    }



    public function makeCompanyForUser($data){

     //   dd($data['company']->session()->all());


        $er=[
            '101'=>['compamy not valid']
        ];
        $com=(array_key_exists('company',$data))?$data['company']:[];
        if(count($com)< 1)return $this->throwError($er['101']);

        $user=\MS\Mod\B\User4O3\F::getUser();

        $companyid=\MS\Core\Helper\Comman::random('9',4,1,[$user['id']]);
        $companyData=[

            'UniqId'=>$companyid,
            'CompanyLogo'=>(array_key_exists('gst',$com))?$com['logo']:'',
            'CompanyName'=>$com['businessName'],
            'CompanyShortName'=>$com['shortBusinessName'],
            'CompanyType'=>$com['typeOfBusiness'],
            'CompanyCategory'=>$com['categoryOfBusiness'],
            'CompanyAddress1'=>$com['addressLine1'],
            'CompanyAddress2'=>$com['addressLine2'],
            'CompanyAddress3'=>$com['addressLine3'],
            'CompanyCity'=>$com['city'],
            'CompanyState'=>$com['state'],
            'CompanyPincode'=>$com['pincode'],
            'CompanyContactNo'=>(array_key_exists('contactNo',$com))?$com['contactNo']:'',
            'CompanyEmail'=>(array_key_exists('email',$com))?$com['email']:'',
            'CompanyGST'=>(array_key_exists('gst',$com))? $com['gst']:'',
            'CompanyPANTAN'=>(array_key_exists('pan',$com))?$com['pan']:'',
            'CompanyLLPNo'=>(array_key_exists('llpNo',$com))?$com['llpNo']:'',
            'CompanyCIN'=>(array_key_exists('cin',$com))?$com['cin']:'',
            'CompanyVerified'=>false,
            'CompanyHasBranch'=>false,
            'CompanyStatus'=>true,

        ];
        $companyData2=[
            'UniqId'=>$companyid,
            'CompanyName'=>$com['businessName'],
            'CompanyGST'=>(array_key_exists('gst',$com))? $com['gst']:'',
            'CompanyPANTAN'=>(array_key_exists('pan',$com))?$com['pan']:'',
            'CompanyLLPNo'=>(array_key_exists('llpNo',$com))?$com['llpNo']:'',
            'CompanyCIN'=>(array_key_exists('cin',$com))?$com['cin']:'',
            'CompanyVerified'=>false,
            'CompanyStatus'=>true

        ];

        $m=$this->getUserCompanyModel($user['id']);
        $m2=$this->getMasterCompanyModel();

        if(!$m->checkTableExist())$m->migrate();
        if(!$m2->checkTableExist())$m2->migrate();
        //dd($m);
        $data=[];
        $data['companMaster']= $m2->rowAdd($companyData2,$this->getMasterCompanyModelUniq());
        $data['companUserMaster']= $m->rowAdd($companyData,$this->getUserCompanyModelUniq());
        $data['migrateDependents']=$this->ForUsersetupForCompany($companyid);

        foreach ($data as $v)if(!$v)return['status'=>$v,'debug'=>$data];

        return ['staus'=>true];

    }


    private function ForUsersetupForCompany($companyId){
        $models=[
            'account'=>$this->getUserCompanyAccountModel($companyId),
            'cash'=>$this->getUserCompanyCashModel($companyId)
        ];
        $process=[];
        foreach ($models as $t=>$m){
            $process[$m->migrate()][]=$t;
        }
        return (array_key_exists(0,$process)  && $process[0]>0)?false:true;
    }



    private function getMasterCompanyModel(){
        return self::getModel(implode('\\',['MS','Mod','B','Company4O3']),$this->CompanyMaster);
    }
    private function getUserCompanyModel($id){
        return self::getModel(implode('\\',['MS','Mod','B','Company4O3']),$this->CompanyUserMaster,[$id]);
    }
    private function getUserCompanyAccountModel($id){
        return self::getModel(implode('\\',['MS','Mod','B','Company4O3']),$this->CompanyAccounts,[$id]);
    }
    private function getUserCompanyCashModel($id){
        return self::getModel(implode('\\',['MS','Mod','B','Company4O3']),$this->CompanyCashLedger,[$id]);
    }


    private function getUserCompanyModelUniq(){
        $data=[
            'UniqId','CompanyGST','CompanyPANTAN'
        ];
        return $data;

    }
    private function getMasterCompanyModelUniq(){
        $data=[
            'UniqId','CompanyGST','CompanyPANTAN','CompanyCIN','CompanyId'
        ];
        return $data;

    }
    private function getUserCompanyAccountModelUniq(){
        $data=[
            'UniqId','BankAcNo','CompanyPANTAN'
        ];
        return $data;

    }
    private function getUserCompanyCashModelUniq(){
        $data=[
            'UniqId','TransactionAgaintsId'
        ];
        return $data;

    }

    private function setupMasterUserCompany()
    {


        $data = [
            'tableId' => implode('_', [self::$modCode, $this->CompanyUserMaster]),
            'tableName' => implode('_', [self::$modCode, 'Company4Users']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyId', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyLogo', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyName', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyShortName', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyType', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyCategory', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyAddress1', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyAddress2', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyAddress3', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyCity', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyState', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyPincode', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyContactNo', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyEmail', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyGST', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyPANTAN', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyLLPNo', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyHasBranch', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyVerified', 'type' => 'string',]);

        $m->setFields(['name' => 'CompanyStatus', 'type' => 'boolean',]);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupMasterCompany()
    {


        $data = [
            'tableId' => implode('_', [self::$modCode, $this->CompanyMaster]),
            'tableName' => implode('_', [self::$modCode, 'CompanyMaster']),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyId', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyName', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyGST', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyPANTAN', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyCIN', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyLLPNo', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyVerified', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyStatus', 'type' => 'boolean',]);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function setupMasterAccounts(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->CompanyAccounts]),
            'tableName' => implode('_', [self::$modCode, 'CompanyAccounts']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'BankName', 'type' => 'string']);
        $m->setFields(['name' => 'AccountType', 'type' => 'string']);
        $m->setFields(['name' => 'BankAcNo', 'type' => 'string',]);
        $m->setFields(['name' => 'CurrentBalance', 'type' => 'string',]);
        $m->setFields(['name' => 'TotalInBalance', 'type' => 'string',]);
        $m->setFields(['name' => 'TotalOutBalance', 'type' => 'string',]);
        $m->setFields(['name' => 'AccountStatus', 'type' => 'string',]);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupMasterAccountLedger(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->CompanyAccountLedger]),
            'tableName' => implode('_', [self::$modCode, 'CompanyAccounts']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'TransactionAmount', 'type' => 'string']);
        $m->setFields(['name' => 'TransactionINOUT', 'type' => 'string']);
        $m->setFields(['name' => 'TransactionType', 'type' => 'string']);
        $m->setFields(['name' => 'TransactionBeforBalance', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionCurrentBalance', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionAgaintsType', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionAgaintsId', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionDoneBy', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionVerifiedBy', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionApprovedBy', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionPartial', 'type' => 'boolean',]);
        $m->setFields(['name' => 'TransactionStatus', 'type' => 'boolean',]);

        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
    private function setupMasterCashLedger(){

        $data = [
                'tableId' => implode('_', [self::$modCode, $this->CompanyCashLedger]),
                'tableName' => implode('_', [self::$modCode, 'CompanyCashLedger']),
                'connection' => self::$c_d,
            ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'TransactionAmount', 'type' => 'string']);
        $m->setFields(['name' => 'TransactionINOUT', 'type' => 'string']);
        $m->setFields(['name' => 'TransactionType', 'type' => 'string']);
        $m->setFields(['name' => 'TransactionBeforBalance', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionCurrentBalance', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionAgaintsType', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionAgaintsId', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionDoneBy', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionVerifiedBy', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionApprovedBy', 'type' => 'string',]);
        $m->setFields(['name' => 'TransactionPartial', 'type' => 'boolean',]);
        $m->setFields(['name' => 'TransactionStatus', 'type' => 'boolean',]);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);

    }
    public static function getTableRaw($data=[]){
        $allMethods=get_class_methods (__CLASS__);
        $autoMethodsGrabed=[];
        foreach ($allMethods as $k=>$m)if(strpos($m,'setup')===0)$autoMethodsGrabed[$m]=[];
        $methodToCall = [];
        $methodToCall=array_merge($autoMethodsGrabed,$methodToCall);
        $c = new self();
        $d = [];
        foreach ($methodToCall as $method => $data) if (method_exists($c, $method))  $d = array_merge($d, $c->$method($data));

        return $d;
    }


}
