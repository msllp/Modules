<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 09-10-2019
 * Time: 01:36 AM
 */

namespace MS\Mod\B\MSSetup;
use Faker\Generator as Faker;
use phpDocumentor\Reflection\Types\Boolean;

//use Faker\Provider\Miscellaneous as Faker;
class F
{


    private function info(){
        return true;
    }
    public static function setupApp():array {
        $setupStatus=[];
        $function=[
            'createRootUserTable'=>'Root User Configured',
            'addMasterRootUser'=>'Default Login Credatials Configured',
            'createBool1Table'=>'UI Bool 1 Configuration started',
            'fillDataInBool1'=>'UI Bool 1 Configuration finished',
            'createIconTable'=>'UI Icon 1 Configuration started',
            'fillDataInIcon'=>'UI Icon 1 Configuration finished',
            'createModTable'=>'Module Core File Configuration started',
            'fillDataForDefaultMod'=>'Module Core File Configuration finished',
            'createRouteTypeTable'=>'Master Routes Types Configuration started',
            'fillDataInRouteTypes'=>'Master Routes Types Configuration finished',
            'createRouteTable'=>'Master Routes Configuration started',
            'fillDataInRoute'=>'Master Routes Configuration finished',
            'createMasterEventTable'=>'Master Events Configuration started',
            'info'=>'Master Events Configuration finished',
            /////////Master Modules///////////
            'createUserTypeTable'=>'Master User Module Configuration started',
            'fillDataInUserType'=>'Progress 10% : Master User Type Configuration Started',
            'createUserMaster'=>'Progress 15% : Master User Module Configuration Started',

            'createAppUser'=>'Progress 20%  : Master User Type Configuration finished',
            'createAccountConfig'=>'Progress 30% :Master Account Configuration Started',
            'fillDataInAccountConfig'=>'Progress 40% :Master Account Configuration finished',
            'CreatCompanyMaster'=>'Progress 50% :Company Nodule Configuration finished',


        ];
        $c=new self();
        foreach ($function as $f=>$t){
            $setupStatus[$t]=$c->$f();

        }
        return $setupStatus;
    }


    public function createRootUserTable():bool {
        return $this->cNmWM(\MS\Mod\B\Users\F::getRootUserModel());
    }

    public  function addMasterRootUser():bool{

        $m=new \MS\Core\Helper\MSDB('MS\Mod\B\Users','Master_User');
        $data=[

            [
                'UniqId'=>'001',
                'MSUsername'=>'admin',
                'MSPassword'=>\MS\Core\Helper\Comman::encode('admin!123'),
            ],
        ];

        return $this->ftD($m,$data,['UniqId']);


    }

    public function createBool1Table():bool{
        return $this->cNm(__NAMESPACE__,'Master_Bool_1');
    }

    public function fillDataInBool1():bool{
        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_Bool_1');
        $data=[

            [
            'BoolName'=>'Active',
            'BoolValue'=>1,
            'Status'=>true,
        ],
            [
                'BoolName'=>'Inactive',
                'BoolValue'=>0,
                'Status'=>true,
            ]
        ];

        return $this->ftD($m,$data,['BoolValue']);


    }

    public function createIconTable():bool
    {
        return $this->cNm(__NAMESPACE__, 'Master_Icon_1');
    }

    public function fillDataInIcon():bool{
        $iconDataFilePath=base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','MSSetup','T','IconData.php']));

        $iconData=require($iconDataFilePath);
      //  dd();
        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_Icon_1');
        $data=$iconData;

        return $this->ftD($m,$data,['IconName']);

    }

    public function createModTable(){
        return $this->cNmWM(\MS\Mod\B\Mod\F::getRootModuleModel());
    }
    public function fillDataForDefaultMod(){

        $d=[
            [
                'm'=>\MS\Mod\B\Mod\F::getRootModuleModel(),
                'f'=>base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','Mod','D','MasterMod.php'])),
                'u'=>['ModuleName']
            ],

        ];
        $e=[];
        foreach ($d as $t){
            $data=require($t['f']);
           // dd($data);
            if(!$this->ftD($t['m'],$data,$t['u']))$e[]=$t;

        }



        if(count($e)>0)return false;
        return true;
    }

    public function createRouteTypeTable(){
        return $this->cNm(__NAMESPACE__, 'MS_Route_Type');
    }

    public function  fillDataInRouteTypes(){

        //dd(\MS\Mod\B\Mod\B::migrateRoutesToDb());



        $DataFilePath=base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','MSSetup','T','RouteData.php']));
     //   dd($DataFilePath);
        $Data=require($DataFilePath);
        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'MS_Route_Type');
        $data=$Data;
    //    dd($data);
        return $this->ftD($m,$data,['RouteTypeCode']);
    }


    public function createRouteTable(){

        return $this->cNmWM(\MS\Mod\B\Mod\F::getRouteModel());
    }

    public function fillDataInRoute(){

        $Mdata=[
            'Modules'=>\MS\Mod\B\Mod\B::migrateRoutesToDb(),
            'Users'=>\MS\Mod\B\Users\B::migrateRoutesToDb(),
            'Accounts'=>\MS\Mod\B\Accounts\B::migrateRoutesToDb(),

        ];
        $DataFilePath=base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','Mod','D','MasterRoutes.php']));
      //  dd($DataFilePath);
        $Data=require($DataFilePath);
        $m=\MS\Mod\B\Mod\F::getRouteModel();
        $Data=array_merge($Data,$Mdata['Modules'],$Mdata['Users']);
        $data=$Data;
    //  dd($data);
        return $this->ftD($m,$data,['RouteUrl','UniqId','RouteName']);
    }

    public function createMasterEventTable(){

    $m=\MS\Mod\B\Mod\F::getEventModel();
    return $m->migrate();
//        dd($m->migrate());
//
//        $d=[
//            'ebfsCz','hRAbQx'
//
//        ];
//        dd(\MS\Mod\B\Mod\F::createModuleEventSub('JwpWQp',$d));
//
//        return $this->cNmWM(\MS\Mod\B\Mod\F::getEventModel());
    }


    public function createUserTypeTable():bool
    {
        //dd(\MS\Mod\B\Users\F::getUserTypeModel());
        $msm=\MS\Mod\B\Users\F::getUserTypeModel();
        return $this->cNmWM($msm);



    }

    public function fillDataInUserType(){
        $msm=\MS\Mod\B\Users\F::getUserTypeModel();
        $DataFilePath=base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','Users','D','UserType.php']));
        $Data=require($DataFilePath);
        $m=$msm;
        $data=$Data;
        $action=['\MS\Mod\B\Users\F::makeRole'];
        return $this->ftdfa($data,$action);
        return $this->ftD($m,$data,['UserTypeName','UniqId']);
    }

    public function createAppUser(){
        $msm=\MS\Mod\B\Users\F::getAppUserModel();
        return $this->cNmWM($msm);

    }

public function createAccountConfig(){
        $f=[
            \MS\Mod\B\Accounts\F::getPaidStatusModel(),
            \MS\Mod\B\Accounts\F::getIncomeTypeModel(),
            \MS\Mod\B\Accounts\F::getExpenseTypeModel(),
            \MS\Mod\B\Accounts\F::getIncomeModel(),
            \MS\Mod\B\Accounts\F::getExpenseModel(),
        ];
        $e=[];
        foreach ($f as $m){

            if(!($this->cNmWM($m)))$e[]=$m;
        }
      //  dd( $f);
    if(count($e)>0)return false;
    return true;
}

public function fillDataInAccountConfig(){

        $d=[
            [
                'm'=>\MS\Mod\B\Accounts\F::getPaidStatusModel(),
                'f'=>base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','Accounts','D','PaidStatus.php'])),
                'u'=>['PaidStatusName']
            ],
            [
                'm'=>\MS\Mod\B\Accounts\F::getIncomeTypeModel(),
                'f'=>base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','Accounts','D','IncomeType.php'])),
                'u'=>['IncomeTypeName']
            ],
            [
                'm'=>\MS\Mod\B\Accounts\F::getExpenseTypeModel(),
                'f'=>base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','Accounts','D','ExpenseType.php'])),
                'u'=>['ExpenseTypeName']
            ]
        ];
    $e=[];
        foreach ($d as $t){
            $data=require($t['f']);
            if(!$this->ftD($t['m'],$data,$t['u']))$e[]=$t;

        }



    if(count($e)>0)return false;
    return true;
}



public function CreatCompanyMaster(){



    $this->cDB(['COMPANY']);
    $f=[
        \MS\Mod\B\Company\F::getCompanyModel(),

    ];
    $e=[];
    foreach ($f as $m){

        if(!($this->cNmWM($m)))$e[]=$m;
    }
    //  dd( $f);
    if(count($e)>0)return false;
    return true;

}
public function createUserMaster(){
    $this->cDB(['USERS']);
    $f=[
       'CreateTable'=>[ \MS\Mod\B\Users\F::getUserSourceModel(), ],
       'DataFillInTable'=>[ ],
       'BatchProccess'=>['fillDefaultDatainMasterUserMod'],
    ];
    $e=[];
    return $this->setupMod($f);
}


private function fillDefaultDatainMasterUserMod(){


        $d=[
            [
                'm'=>\MS\Mod\B\Users\F::getUserSourceModel(),
                'f'=>base_path(implode(DS,['vendor','msllp','modules','src','Modules','B','Users','D','DefaultUserSources.php'])),
                'u'=>['VerifyName','UniqId']
            ],

        ];
        $e=[];
        foreach ($d as $t){
            $data=require($t['f']);
            if(!$this->ftD($t['m'],$data,$t['u']))$e[]=$t;

        }



        if(count($e)>0)return false;
        return true;

}




////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////Do not edit /////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function setupMod($f){
        $e=[];
        foreach ($f as $type=>$fType){
            switch ($type){
                case 'CreateTable':
                    foreach ($f[$type] as $m){
                        if(!($this->cNmWM($m)))$e[]=$m;
                    }
                    break;
                case 'DataFillInTable':
                    break;
                case 'BatchProccess':
                    foreach ($fType as $m){
                       // dd($m);
                        if(!($this->$m()))$e[]=$m;
                    }
                    break;
            }
        }
        if(count($e)>0)return false;
        return true;
    }

    private function cDB($dl){
        $e=[];
        $types=['Master','Config','Data'];
        if(is_array($dl))foreach ($dl as $db){
            foreach ($types as $per){
                $fDB=implode('_',['MS',$db,$per]);
                if(!\MS\Core\Helper\MSDB::checkDB($db))
                {
                    if(!\MS\Core\Helper\MSDB::makeDB($fDB))$e[$fDB]=\MS\Core\Helper\MSDB::makeDB($fDB);
                }

            }
//            if(!\MS\Core\Helper\MSDB::checkDB($db))
//            {
//                $n1=implode('_',['MS',$db,'Master']);
//                $n2=implode('_',['MS',$db,'Config']);
//                $n3=implode('_',['MS',$db,'Data']);
//
//
//
//                if(!\MS\Core\Helper\MSDB::makeDB($n1))$e[$n1]=\MS\Core\Helper\MSDB::makeDB($n1);
//                if(!\MS\Core\Helper\MSDB::makeDB($n2))$e[$n2]=\MS\Core\Helper\MSDB::makeDB($n2);
//                if(!\MS\Core\Helper\MSDB::makeDB($n3))$e[$n3]=\MS\Core\Helper\MSDB::makeDB($n3);
//            }

        }
        if(count($e)==0)return true;
        return false;
    }
    private function ftdfa($data,$actions){

        $err=[];
        foreach ($data as $row){

            foreach ($actions as $ac){
                $err[$ac($row)][]=$ac;
            }


        }

        if(count($actions) == count($err[1])){
            return true;
        }
        return false;



    }


    /**
     * @param $m
     * @param $d
     * @param array $ua
     * @return bool
     */
    private function ftD($m, $d, $ua=[]){
        $err=[];
        foreach ($d as $v){
            if(!$m->rowAdd($v,$ua)){
             if(array_key_exists('BoolName',$v))$err[$v['BoolName']]=$v;
                $err[]=$m->rowAdd($v,$ua);
               // dd($err);
            }

        }
        return (count($err) < 1);

    }


    /**
     * To create tables with model & id of th table
     * @param $n
     * @param $id
     * @return bool
     */
    private function cNm($n, $id):bool{
        $m=new \MS\Core\Helper\MSDB($n,$id);

        if(!$m->checkTableExist()){
            return $m->migrate();
        }

        return false;

    }

    /**
     * create table from given MSDB class
     * @param $m
     * @return bool
     */
    private function cNmWM($m){
        if(!$m->checkTableExist()){
            return $m->migrate();
        }

        return false;
    }







}
