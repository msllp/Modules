<?php
namespace MS\Mod\B\Company;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\Comman;
use mysql_xdevapi\Exception;
use Razorpay\Api;

class C extends BaseController
{


    use  DispatchesJobs, ValidatesRequests;
public function addForm(){
    \App::setlocale(session('ln'));
    $m = F::getCompanyModel();
    return $m -> displayForm('add_company');
}
    public function addFormPost(Request $r){
        \App::setlocale(session('ln'));
        $m=F::getCompanyModel();
        $d1=$r->all();
        $m->attachR($r);
        $valid=$m->checkRulesForData();
        $d=[];
        $t=[];
        $n=[];
        if($valid){



            $t=[
                'Create Root User'=>L\Company::createCompany($d1),
            ];

            $n=\MS\Core\Helper\Comman::makeNextData('Company','View All Comapany',route('Company.viewForm'));




        }else{
            $t['Create Root User']=false;
        }

        return $m->processForSave($r,$d,$t,$n);

    }

    public function viewForm(){
        \App::setlocale(session('ln'));

        $m = F::getCompanyModel();
        //   $m->migrate();
        return $m->viewData('view_all');
    }

    public function viewFormAjax(Request $r){
        \App::setlocale(session('ln'));
        $m = F::getCompanyModel();
        return $m->ForPagination($r);
}

}
