<?php

namespace MS\Mod\B\Company4O3;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\Comman;
use MS\Core\Helper\MSDB;
use mysql_xdevapi\Exception;
use Razorpay\Api;
use function GuzzleHttp\Promise\all;
use Socialite;
class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;


    protected $data=[];

    protected $ln='en';


    public function test(){
    //    $m=new MSDB(__NAMESPACE__,'test');
       // dd(MSDB::makeDB('O3_Company_Master'));
      //  MSDB::backUpDB('O3_Company_Data');
       // MSDB::makeDB('O3_Company_Config');
        $c=new L\Company();
        dd($c->getCompanyUserMasterModel('9668431692111893')->rowAll());
        $userId=\MS\Mod\B\User4O3\F::getUser()['id'];
        dd($c->migrateById($c->CompanyMaster,[$userId]));
    }

    public function getCompanyForWebsite($companyId){
       // dd($companyId);
        return \MS\Mod\B\Company4O3\L\Company::fromController([['method'=>'getCompanyForWebsite','data'=>['companyId'=>$companyId]]]);


    }
    public function getCompanyForWebsiteByCompanyId($companyId){
       // dd($companyId);
        return \MS\Mod\B\Company4O3\L\Company::fromController([['method'=>'getCompanyForWebsiteById','data'=>['companyId'=>$companyId]]]);


    }

    public function setupCompany(){
        return \MS\Mod\B\Company4O3\L\Company::fromController([['method'=>'setupFirstCompany','data'=>[]]]);

    }

    public function getStatesForCompany(){
        return \MS\Mod\B\Company4O3\L\Company::fromController([['method'=>'getAllStates','data'=>[]]]);

    }

    public function setupCompanyPost(Request $r){
        return \MS\Mod\B\Company4O3\L\Company::fromController([['method'=>'makeCompanyForUser','data'=>[ 'company'=>$r->all()]]]);
    }


}