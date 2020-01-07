<?php

namespace MS\Mod\B\Users;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\Comman;
use mysql_xdevapi\Exception;
use Razorpay\Api;
use function GuzzleHttp\Promise\all;
use Socialite;
class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;


    protected $data=
        [
            'logo'=>"logo-a.png"

        ];
    protected $ln='en';

    public function MaintainaceDashboard(Request $r,$ln=null){

        if($ln==null)$ln=$this->ln;
        $r->session()->put('ln', $ln);
        session('ln',$ln);
        \App::setlocale(session('ln'));
        return view("MS::core.layouts.MS.mpanel");
    }


    public function SideNavForMaintainaceDashboard(Request $r){

        \App::setlocale(session('ln'));
        //dd($r->session()->all());
        $rdata=['accessToken'=>'UserMitul'];
        $data=\MS\Mod\B\Mod\L\Nav::getNav();
        //dd(route('MOD.Mod.Master.Event.View.All'));
        return \MS\Core\Helper\Comman::proccessReqNGetSideNavDataForDashboard($r,$data, $rdata);
    }

    ///Root User Start
    public function addAppUserFrom(){
    $m=F::getAppUserModel();
    return $m->displayForm('add_app_user');
}
    public function addUserFrom(){
        $m=F::getRootUserModel();
        return $m->displayForm('add_user');
    }
    public function saveUser(Request $r){
        $m=F::getRootUserModel();
        $d1=$r->all();
        $m->attachR($r);
        $valid=$m->checkRulesForData();
        $d=[];
        $t=[];
        $n=[];
        if($valid){



            $t=[
                'Create Root User'=>F::createRootUser($d1)
            ];

            $n=\MS\Core\Helper\Comman::makeNextData('Users','View All User',route('MOD.User.Master.View.All'));




        }else{
           $t['Create Root User']=false;
        }

        return $m->processForSave($r,$d,$t,$n);

    }
    public function editUserFrom(Request $r,$id){
        $m=F::getRootUserModel();


        $d1=$m->rowGet(['UniqId'=>$id]);
        //   dd();

        if(! (count($d1) >0)){
            return $m->jsonOutError(['Oppes, Root user not found in my system.']);
        }elseif (count($d1) ==1){
            $d=$d1[0];
        }
        return $m->editForm('edit_user',$d);
    }
    public function updateUser(Request $r,$id){
        $m=F::getRootUserModel();
        $d=$r->all();
        $i=['UniqId'=>$id];
        $t=[];
        $t['Root User updated']=F::editRootUser($i,$d);
        $valid=0;
        $e=[];
      //  dd(Comman::checkAllTrueArray($t));
        if(!Comman::checkAllTrueArray($t)) return $m->jsonOutError(['Oppes, Root user not updated in my system.']);
        $nextDat=\MS\Core\Helper\Comman::makeNextData('Core','View All Root Users',route('MOD.User.Master.View.All'));
        return $m->jsonOut($t,$nextDat,$e);

    }
    public function deleteUser(Request $r,$id){
        $m=F::getRootUserModel();
        $d=$r->all();
        $i=['UniqId'=>$id];
        $t=[];
        $t['Root User Deleted']=F::deleteRootUser($i);
        $valid=0;
        $e=[];
        //  dd(Comman::checkAllTrueArray($t));
        if(!Comman::checkAllTrueArray($t)) return $m->jsonOutError(['Oppes, Root user unable delete in my system.']);
        $nextDat=\MS\Core\Helper\Comman::makeNextData('Core','View All Root Users',route('MOD.User.Master.View.All'));
        return $m->jsonOutNext($t,$nextDat,$e);
    }
    public function  viewAllUser(){
        $m=F::getRootUserModel();
     //   $m->migrate();
        return $m->viewData('view_all');
    }
    public function viewAllUserPagination(Request $r){

        $m=F::getRootUserModel();
        return $m->ForPagination($r);
    }
    ///Root User End

    ///User Role Start
    public function addUserRolesFrom(){
        $m=F::getUserTypeModel();
        return $m->editForm('add_user_type');
    }
    public function saveUserRoles(Request $r){
        $m=F::getUserTypeModel();
        $d1=$r->all();
        $d=[];
        $t=[
            'Create User Role'=>F::makeRoles($d1
            )
        ];
        dd($m->processForSave($r,$d,$t));



        F::makeRoles($r->all());
    }

    public function editUserRolesFrom(Request $r,$id){
        $m=F::getUserTypeModel();


        $d1=$m->rowGet(['UniqId'=>$id]);
        //   dd();

        if(! (count($d1) >0)){
            return $m->jsonOutError(['Oppes, User Role not found in my system.']);
        }elseif (count($d1) ==1){
            $d=$d1[0];
        }
        return $m->editForm('edit_user_type',$d);
    }

    public function viewAllUserRoles(Request $r){
        $m=F::getUserTypeModel();
        //   $m->migrate();
        return $m->viewData('view_all');
    }

    public function viewAllUserPaginationRoles(Request $r){
        $m=F::getUserTypeModel();
        return $m->ForPagination($r);
    }
    ///User Role End
    public function  saveAppUser(Request $r){

        $m=F::getAppUserModel();
        $d1=$r->all();
        $d=[];
        $t=[
            'Create User Role'=>F::makeAppUser($d1
            )
        ];
        dd($m->processForSave($r,$d,$t));



        F::makeRoles($r->all());

    }

    public function loginForRootUser(Request $r){

        $m=F::getRootUserModel();
    //    dd($m);
        return $m->loginPage();

    }

    public function loginForRootUserFromOthers(){
     //   config()->set('services.test',[]);
        \MS\Mod\B\Users\L\OutLoginApi::checkOaAuthisOk();
   //     dd(config());
          return Socialite::driver('google')->redirect();
    }


    public function loginForRootUserFromOtherCallback(Request $r){

        $user = Socialite::driver('google')->user();

        dd($user);
    }

    public function cTest(Request $r){
       dd(\MS\Mod\B\Mod\L\Nav::getNav());
        dd(\MS\Mod\B\Purchase\L\Products::getProductTableRaw());
        dd(\MS\Mod\B\Sales\L\Products::getProductTableRaw());
        $m1=\MS\Core\Helper\MSTableSchema::getTableDataForTable('Mod');
        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Mod_MasterCoreTable');
     // dd($m->mod_Tables);
        dd($m->attachTableData($m1));
    }



}
