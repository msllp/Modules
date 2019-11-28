<?php

namespace MS\Mod\B\Users;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Razorpay\Api;

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

    public function  saveUser(Request $r){

        $m=F::getRootUserModel();
        $m->attachR($r);
        // $m->migrate();
        $d=$r->all();
        $valid=$m->checkRulesForData();

        $nextData=[

            "modCode"=>"Core",
            "modDView"=>"New Tab",
            "modUrl"=>route('MOD.User.Master.View.All'),
        ];
       // dd($m->CurrentError);

        if($valid){

            //F::makeUser($r,$m);

            return response()->json(['ms'=>[

                'status'=>200,
               // 'Rdata'=> $r->input(),
                'ProcessStatus'=>[
                    'User added to DB'=>$m->add()],
                'nextData'=>$nextData

            ]],200);
        }
        else{
            return response()->json([
                'errors' => $m->CurrentError
            ],418);
            return $m->CurrentError;
        }

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


    public function editUserFrom(Request $r,$id){
        $m=F::getRootUserModel();
        $d1=$m->rowGet(['UniqId'=>$id]);
     //   dd();

        if(!count($d1) >0){
        return $m->jsonOutError(['Oppes, Root user not found in my system.']);
        }elseif (count($d1) ==1){
            $d=$d1[0];
        }
        return $m->editForm('edit_user',$d);
    }



}
