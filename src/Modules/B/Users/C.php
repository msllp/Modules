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

class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;


    protected $data=
        [
            'logo'=>"logo-a.png"

        ];

    public function MaintainaceDashboard(){


        return view("MS::core.layouts.MS.mpanel");
    }


    public function SideNavForMaintainaceDashboard(Request $r){

        $rdata=['accessToken'=>'UserMitul'];
        $data=[
            [
                'text'=>'Users',
                'type'=>'mainNav',
                'icon'=>'fi flaticon-user',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Root User',
                        'icon'=> 'fi flaticon-problem'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Add Root User',
                        'link'=> route('MOD.User.Master.AddForm'),
                        'icon'=>'fi flaticon-partner'
                    ]

                    ,

                    [
                        'type'=> 'link',
                        'text'=> 'View All Root Users',
                        'link'=> route('MOD.User.Master.View.All'),
                        'icon'=>'fi flaticon-users-group'
                    ],
                    [
                        'type'=> 'title',
                        'text'=> 'Manage App User Roles',
                        'icon'=> 'fas fa-cogs'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Add User Role',
                        'link'=> route('MOD.User.Master.Roles.AddForm'),
                        'icon'=>'fi flaticon-partner'
                    ]

                    ,

                    [
                        'type'=> 'link',
                        'text'=> 'View All User Roles',
                        'link'=> route('MOD.User.Master.Roles.View.All'),
                        'icon'=>'fi flaticon-users-group'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Add App User',
                        'link'=> route('MOD.User.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ],

                ],
            ],


            [
                'text'=>'Modules',
                'type'=>'mainNav',
                'icon'=>'fi flaticon-distributed',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Modules',
                        'icon'=> 'fi flaticon-execution'
                    ], [
                        'type'=> 'link',
                        'text'=> 'Add Module',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ]
                    ,[
                        'type'=> 'link',
                        'text'=> 'View All Modules',
                        'link'=> route('MOD.Mod.Master.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],
                    [
                        'type'=> 'title',
                        'text'=> 'Manage Routes',
                        'icon'=> 'fi flaticon-execution'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Add Route',
                        'link'=> route('MOD.Mod.Master.Route.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'View All Routes',
                        'link'=> route('MOD.Mod.Master.Route.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Events',
                        'icon'=> 'fi flaticon-commerce-and-shopping-1'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Add Event',
                        'link'=> route('MOD.Mod.Master.Event.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'View All Events',
                        'link'=> route('MOD.Mod.Master.Event.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],



                ],
            ],


        ];
        //dd(route('MOD.Mod.Master.Event.View.All'));
        return \MS\Core\Helper\Comman::proccessReqNGetSideNavDataForDashboard($r,$data, $rdata);
    }

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

    public function viewAllUserRoles(Request $r){
        $m=F::getUserTypeModel();
        //   $m->migrate();
        return $m->viewData('view_all');
    }

    public function viewAllUserPaginationRoles(Request $r){
        $m=F::getUserTypeModel();
        return $m->ForPagination($r);
    }

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





}
