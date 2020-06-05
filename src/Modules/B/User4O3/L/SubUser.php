<?php


namespace MS\Mod\B\User4O3\L;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class SubUser extends Logic
{

    public static $userConstructData = [
        'UniqId' => 'string',
    ];

    public static $c_m = 'O3_Users_Master';
    public static $c_d = 'O3_Users_Data';
    public static $c_c = 'O3_Users_Config';
    public static $modCode = 'User4O3';
    public $DB=[];

    public function __construct($data = [])
    {


        $this->modPre='User';
        parent::__construct($data);

        $this->UserSubRole='UsersRoles';
        $this->UserRolePermissions='RolesPermission';
        $this->UserSubUser='SubUser';
    }

    public function getUserByApiToken($apiToken){
        $m=$this->getUserSubUserModel();
        $foundUser=$m->rowGet(['apiToken'=>$apiToken]);
        return reset($foundUser);

    }



    public function attacheDataFromRootId($data){
      //  dd($data);
        $rootId=$data['RootId'];
        $c=Users::getUserModel();
        $foundRootId=$c->rowGet(['UniqId'=>$rootId]);
        if(count($foundRootId)>0){
            $foundRootId=reset($foundRootId);
            $data['UserPlan']=$foundRootId['UserPlan'];
            $data['UserValidUpto']=$foundRootId['UserValidUpto'];
            $data['UserProductCount']=$foundRootId['UserProductCount'];
            $data['UserInvoiceCount']=$foundRootId['UserInvoiceCount'];
            $data['UserPurchaseCount']=$foundRootId['UserPurchaseCount'];
            $data['UserCompanyCount']=$foundRootId['UserCompanyCount'];
            $data['UserCompanyUserCount']=$foundRootId['UserCompanyUserCount'];
            $data['UserStatus']=$foundRootId['UserStatus'];
            return $data;

        }else{
            return $data;
        }
    }
    public function viewRoles($data){
        //ms()->cache()->flush();
        $userId=ms()->user()['id'];
        $m1=$this->getUserSubRoleModel($userId);

        return $m1->viewData('ViewAllRoles');
        dd($m1->viewData('ViewAllRoles'));
    }

    public function viewRolesPagination($data){
        $userId=ms()->user()['id'];
        $m=$this->getUserSubRoleModel($userId);
        return $m->ForPagination($data['r']);
    }

    public function createSubUserForm($data){

        if(!\MS\Mod\B\User4O3\F::checkUserLimits('user')){
            $data=['which'=>'Employee'];
            return  view('MS::core.layouts.Error.LimitOver')->with('data',$data);

        }
    $c=$this->getUserSubUserModel();
    $c->migrate();

   // dd($c);
       // dd(ms()->cache()->all());

    return$c->displayForm('addSubUserForm',['Role'=>['perFix'=>[ms()->user()['id']]]]);
    dd($c->displayForm('addSubUserForm'));
    }
    public function createSubUserFormPost($data){
        $m=$this->getUserSubUserModel();
        $m->attachR($data['r']);
        $valid=$m->checkRulesForData();
       // dd($valid);

        $user=ms()->user();

        if(!$valid)return $this->throwError($m->CurrentError,418)   ;

        $newUserData=$data['r']->all();
       // dd($newUserData);
        $userClass=new Users();

        $allowedCompanies=$this-> getAllowedCompanyByRoleId($newUserData['Role']);

        $defaultCompany=reset($allowedCompanies);



        $dataToDB = [
            'UniqId' => implode('_',[$user['id'],$userClass->getNewUserNo()]) ,
            'apiToken' => $userClass->getNewApiTokenForUser(),
            'HookType' =>0,
            'HookId' =>null,
            'HookData' => null,
            'Email' =>  $newUserData['Email'],
            'ContactNo' => $newUserData['ContactNo'],
            'Username' => $newUserData['Username'],
            'Password' => ms()->encode($newUserData['Password']),
            'FirstName' =>$newUserData['FirstName'],
            'LastName' => $newUserData['LastName'],
            'Sex' => ($newUserData['Sex'])?'male':'female',
            'CompanyId' => $defaultCompany,
            'CompanyPost'=>$newUserData['Role'],
            'RootId'=>$user['id'],
            'UserStatus' => 1,

        ];

        $preccesToAdd[$m->rowAdd($dataToDB,['UniqId','Username','Email','ContactNo'])]='SubUser Added To Table';
        $this->migrationForSubUser($dataToDB['UniqId']);

        $nextData=\MS\Core\Helper\Comman::makeNextData('User','View All Employees',route('O3.SubUser.User.View.All'));

        return \MS\Core\Helper\Comman::msJson([],$nextData,[]);

    }

    public function viewAllUsers(){
        $user=ms()->user()['id'];
        $m1=$this->getUserSubUserModel();
        $data=[
            'where'=>['RootId'=>$user]
        ];
        return $m1->viewData('ViewAllUsers',$data);
    }

    public function viewAllUsersPagination($data){
        $user=ms()->user()['id'];
        $cdata=[
            'where'=>['RootId'=>$user]
        ];
        $m=$this->getUserSubUserModel();
        return $m->ForPagination($data['r'],$cdata);
    }

    public function migrationForSubUser($id){
        $user=new Users();
        //$user->migrateById('Payment_Ledger', [$id]);
        $user->migrateById('Users_Notification', [$id]);
        $this->migrateById($this->UserSubRole,[$id]);
    }




    public function getAllPermissionById($id){
        $user=ms()->user();
        $allPermission=$this->getUserRolePermissionsModel(implode('_',[$user['id'],$id]))->rowAll();
        return $allPermission;

    }

    public function getAllowedCompanyByRoleId($id){

        $permissions=$this->getAllPermissionById($id);
      //  dd($permissions);
        $cP=collect($permissions)->groupBy('CompanyId')->toArray();
        return array_keys($cP);

    }
    public function addRoleForm($data){


        $allInput=$data['r']->all();
        if(array_key_exists('modal',$allInput))$allInput['modal']=(bool)$allInput['modal'];

        $input=[
            'companies'=>\MS\Mod\B\Company4O3\F::getAllCompany(),
            'permissions'=>\MS\Mod\B\Mod4O3\F::getPermissions(),
            'path'=>[
                'post'=>route('O3.SubUser.Role.Add.FormPost')
            ],
         //   'modalForm'=>$allInput['modal']
        ];
        if(array_key_exists('modal',$allInput))$input['modalForm']=$allInput['modal'];
      //  dd(\Route::getCurrentRoute()->getActionName());

        return view('MOD::B.User4O3.V.SubUser.AddRole')->with('data',$input);

    }
    public function saveRole($data){
        $inputData=$data['r']->all();
        //  dd(\Route::getCurrentRoute()->getActionName());
        $userId=ms()->user()['id'];

        $roletableData=[
            'UniqId'=>ms()->random(4,5),
            'RoleName'=>$inputData['userrolename'],
            'RoleDescription'=>$inputData['userdescription'],
            'RoleStatus'=>1
        ];

        $m1=$this->getUserSubRoleModel($userId);
        if(!$m1->checkTableExist())$m1->migrate();
        $process[$m1->rowAdd($roletableData)][]='Role Added to Table';
        $m2=$this->getUserRolePermissionsModel(implode('_',[$userId,$roletableData['UniqId']]) );
        if(!$m2->checkTableExist())$m2->migrate();
        $data3=[
            'subModules'=>$inputData['subModules'],
            'modules'=>$inputData['modules'],
            'companies'=>$inputData['companies']
        ];



        $rolePermissionData=\MS\Mod\B\Mod4O3\F::makeDataForPermission($data3);
        $process[$m2->rowAddMass($rolePermissionData,['UniqId'])][]='Role  Permission Added to Table';

        $nextData=\MS\Core\Helper\Comman::makeNextData('User','View All Roles',route('O3.SubUser.Role.View.All'));

        return \MS\Core\Helper\Comman::msJson([],$nextData,[]);

    }

    public  function editRole($data){
        $input=[
            'companies'=>\MS\Mod\B\Company4O3\F::getAllCompany(),
            'permissions'=>\MS\Mod\B\Mod4O3\F::getPermissions(),
            'path'=>[
                'post'=>route('O3.SubUser.Role.View.Edit.Post',['id'=>$data['id']])
            ],
            'fillData'=>$this->getRoleById($data['id'])

        ];
        $userId=ms()->user()['id'];
        $m=$this->getUserSubRoleModel($userId);
        $foundRole=$m->rowGet(['UniqId'=>$data['id']]);
        $foundRole=reset($foundRole);

        $input['fillData']['userrolename']=$foundRole['RoleName'];
        $input['fillData']['userdescription']=$foundRole['RoleDescription'];
        //dd($input);


        //  dd(\Route::getCurrentRoute()->getActionName());

        return view('MOD::B.User4O3.V.SubUser.AddRole')->with('data',$input);
    }
    public function editRolePost($data){
        $inputData=$data['r']->all();
        $userId=ms()->user()['id'];
        $m=$this->getUserRolePermissionsModel(implode('_',[$userId,$data['id']]));
        $m->delete();
        $m->migrate();

        $m1=$this->getUserSubRoleModel($userId);
        $roletableData=[
           // 'UniqId'=>ms()->random(4,5),
            'RoleName'=>$inputData['userrolename'],
            'RoleDescription'=>$inputData['userdescription'],
           // 'RoleStatus'=>1
        ];
        $m1->rowEdit(['UniqId'=>$data['id']],$roletableData);

        $data3=[
            'subModules'=>$inputData['subModules'],
            'modules'=>$inputData['modules'],
            'companies'=>$inputData['companies']
        ];

     //   dd($data3);
        $rolePermissionData=\MS\Mod\B\Mod4O3\F::makeDataForPermission($data3);
       // dd($rolePermissionData);
        $m->rowAddMass($rolePermissionData,['UniqId']);
        $nextData=\MS\Core\Helper\Comman::makeNextData('User','View All Roles',route('O3.SubUser.Role.View.All'));

        return \MS\Core\Helper\Comman::msJson([],$nextData,[]);
    }

    private function getRoleById($id){
        $userId=ms()->user()['id'];
        $m2=$this->getUserRolePermissionsModel(implode('_',[$userId,$id]));
        $foundPermission=$m2->rowAll();
        $outData=collect($foundPermission)->groupBy('CompanyId')->toArray();
        $outData2=reset($outData);
        $outData3=collect($outData2)->groupBy('ModuleId')->toArray();
        $outData4=[];
        $modules=[];
        $companies=[];
        foreach ($outData as $k0=>$v0){
            $companies[$k0]=true;
            $outData3=collect($outData2)->groupBy('ModuleId')->toArray();
            foreach ($outData3 as $k=>$v){

                $modules[$k0][$k]=true;
                //$outData4[$k0][$k]=collect($v)->groupBy('ModuleSubId')->toArray();
                $od=collect($v)->groupBy('ModuleSubId')->toArray();

                foreach ($od as $k2=>$v2){

                    foreach ($v2 as $k3=>$v3){
                        $outData4[$k0][$k][$k2][$v3[
                            'ModuleActionId']]=true;
                    }

                }
            }

        }

      // dd($outData4);

        $data=[
            'companies'=> $companies,
            'modules'=>$modules,
            'subModules'=>$outData4
        ];
       //dd($data);
        return $data;
    }

    public function getUserRole(){
        $user=ms()->user()['id'];
        $m=$this->getUserSubRoleModel($user);

        return $this->throwData($m->rowAll());

    }

    public static function loadRoutes(){

        $r=new \MS\Core\Helper\MSRoute();

        $r->n('Role.Add.Form')->m('CreateUserRole')->r('Role/add/new')->g();
        $r->n('api.Get.All.Role')->m('getUserRolegetUserRole')->r('Role/get/All')->g();
        $r->n('Role.Add.FormPost')->m('SaveUserRole')->r('Role/save')->p();
        $r->n('Role.View.All')->m('viewAllRoles')->r('Role/view/all')->g();
        $r->n('Role.View.All.Pagination')->m('viewAllRolesPagination')->r('Role/view/all/pagination')->g();
        $r->n('Role.View.Edit')->m('roleEdit')->r('Role/edit/{id?}')->g();
        $r->n('Role.View.Edit.Post')->m('roleEditPost')->r('Role/edit/{id?}')->p();

        $r->n('User.Add.Form')->m('createSubUserForm')->r('User/add/new')->g();
        $r->n('User.Add.FormPost')->m('createSubUserFormPost')->r('User/add/new')->p();

        $r->n('User.View.All')->m('viewAllUsers')->r('Users/view/all')->g();
        $r->n('User.View.All.Pagination')->m('viewAllUsersPagination')->r('Users/view/all/pagination')->g();


        return $r->all();
        dd($r->all());

    }

    private function setupRoles(){
        //ms()->cache()->flush();
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->UserSubRole]),
            'tableName' => implode('_', [self::$modCode, 'UsersRoles']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string',]);
        $m->setFields(['name' => 'RoleName', 'type' => 'string','input'=>'text','vName'=>'Role Name']);
        $m->setFields(['name' => 'RoleDescription', 'type' => 'string','input'=>'text','vName'=>'Role Description']);
        $m->setFields(['name' => 'RoleStatus', 'type' => 'boolean']);

        $safeToDisplay='safeForPublic';
        $m->addGroup($safeToDisplay)->addField($safeToDisplay,['RoleName','RoleDescription']);

        $m->addAction('edit',[
            "btnColor"=>"bg-blue-500",
            "route"=>"O3.SubUser.Role.View.Edit",
            "btnIcon"=>"fas fa-pencil-alt",
            'btnText'=>"Edit Role",
            "routePara"=>['id'=>'UniqId'],
            'msLinkKey'=>'UniqId',
            'msLinkText'=>'RoleName',
            'ownTab'=>true,
        ]);


        $viewId='ViewAllRoles';
        $m->addView($viewId)->addGroup4View($viewId,[$safeToDisplay])->addTitle4View($viewId,'View All Roles');
        $m->pagination4View($viewId,'O3.SubUser.Role.View.All.Pagination');
        $m->addAction4View($viewId,['edit']);
        $m1 = $m->finalReturnForTableFile();
       // dd($m1);;
        return array_merge($m1);

    }
    private function setupRolesPermissions(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->UserRolePermissions]),
            'tableName' => implode('_', [self::$modCode, 'UsersRolesPermissions']),
            'connection' => self::$c_d,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'CompanyId', 'type' => 'string']);
        $m->setFields(['name' => 'ModuleId', 'type' => 'string']);
        $m->setFields(['name' => 'ModuleSubId', 'type' => 'boolean',]);
        $m->setFields(['name' => 'ModuleActionId', 'type' => 'boolean',]);
        $m->setFields(['name' => 'ModuleActionMethod', 'type' => 'boolean',]);

        $m1 = $m->finalReturnForTableFile();

     //   dd($m1);
        return array_merge($m1);

    }
    private function setupSubUser(){
        $data = [
            'tableId' => implode('_', [self::$modCode, $this->UserSubUser]),
            'tableName' => implode('_', [self::$modCode, $this->UserSubUser]),
            'connection' => self::$c_m,
        ];
        $m = new  MSTableSchema($data);

        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'Username', 'type' => 'string','input'=>'text','vName'=>'Username', "validation"=>[
            'required'=>true,
            'length'=>['minimum'=>5,'maximum'=>40],
            'format'=>[ 'pattern'=> "[a-zA-Z0-9]+([_]?[a-zA-Z0-9]){5,40}$", 'flags'> "i", 'message'=> "only number,alphabates & '_' allowed" ]
        ] ]);
        $m->setFields(['name' => 'Password', 'type' => 'string','input'=>'password','vName'=>'Passwrod',"validation"=>[
            'required'=>true,
            'length'=>['minimum'=>8],
           'format'=>[ 'pattern'=> "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$", 'flags'> "i", 'message'=> "Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character" ]
        ]
        ]);
        $m->setFields(['name' => 'apiToken', 'type' => 'string']);
        $m->setFields(['name' => 'HookType', 'type' => 'string']);
        $m->setFields(['name' => 'HookId', 'type' => 'string',]);
        $m->setFields(['name' => 'HookData', 'type' => 'string',]);
        $m->setFields(['name' => 'FirstName', 'type' => 'string','input'=>'text','vName'=>'First Name',"validation"=>['required'=>true
        ,'format'=>[ 'pattern'=> "[a-zA-Z]{1,40}$", 'flags'> "i", 'message'=> "only alphabates allowed" ]
        ]]);
        $m->setFields(['name' => 'Sex', 'type' => 'string','input'=>'radio','vName'=>'Sex',"validation"=>['required'=>true,'existIn'=>MSCORE_User_SEX]]);
        $m->setFields(['name' => 'LastName', 'type' => 'string','input'=>'text','vName'=>'Last Name',"validation"=>['required'=>true
            ,'format'=>[ 'pattern'=> "[a-zA-Z]{1,40}$", 'flags'> "i", 'message'=> "only alphabates allowed" ]
        ]]);
        $m->setFields(['name' => 'Email', 'type' => 'string','input'=>'email','vName'=>'Email',"validation"=>['required'=>true,'email'=>true]]);
        $m->setFields(['name' => 'ContactNo', 'type' => 'string','input'=>'number','vName'=>'Contact No',"validation"=>['length'=>['is'=>10], 'required'=>true,'numericality'=> ['strict'=> true]]]);
        $m->setFields(['name' => 'CompanyId', 'type' => 'string',]);
        $m->setFields(['name' => 'CompanyPost', 'type' => 'string',]);
        $m->setFields(['name' => 'RootId', 'type' => 'string',]);
        $m->setFields(['name' => 'UserStatus', 'type' => 'boolean',]);
        $m->setFields(['name'=>'Role','vName'=>'Employee Role','dbOff'=>true,'input'=>'option',"validation"=>['required'=>true,'existIn'=>'MS\Mod\B\User4O3:User4O3_UsersRoles:UniqId->RoleName'],'addAction'=>'addRole']);


        $loginCredantials='Employee Login Credentials';
        $m->addGroup($loginCredantials)->addField($loginCredantials,['Username','Password']);
        $basicDetails='Employee Basic Details';
        $m->addGroup($basicDetails)->addField($basicDetails,['FirstName','LastName','Sex','Email','ContactNo','Role']);

        $m->addAction('addSubUser',[
            "btnColor"=>"green",
            "route"=>'O3.SubUser.User.Add.FormPost',
            "btnIcon"=>"fi2 flaticon-unlocked",
            'btnText'=>"Add Employee",

        ]);

        $m->addAction('addRole',[
            "btnColor"=>"blue",
            "route"=>'O3.SubUser.Role.Add.Form',
            "btnIcon"=>"fi2 flaticon-unlocked",
            'btnText'=>"Add Role",
            'dataRoute'=>'O3.SubUser.api.Get.All.Role'
        ]);

        $formForSubUser='addSubUserForm';
        $m->addForm($formForSubUser)
            ->addGroup4Form($formForSubUser,[$loginCredantials,$basicDetails])
            ->addTitle4Form($formForSubUser,'Add Emlpoyee')
            ->addAction4Form($formForSubUser,['addSubUser']);


        $safeToDisplay='safeForPublic';
        $m->addGroup($safeToDisplay)->addField($safeToDisplay,['Username','FirstName','LastName','Email',]);


        $viewId='ViewAllUsers';
        $m->addView($viewId)->addGroup4View($viewId,[$safeToDisplay])->addTitle4View($viewId,'View All Employees');
        $m->pagination4View($viewId,'O3.SubUser.User.View.All.Pagination');
       // $m->addAction4View($viewId,['edit']);


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
