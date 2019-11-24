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
            'createRouteTypeTable'=>'Master Routes Types Configuration started',
            'fillDataInRouteTypes'=>'Master Routes Types Configuration finished',
            'createRouteTable'=>'Master Routes Configuration started',
            'fillDataInRoute'=>'Master Routes Configuration finished',
            'createMasterEventTable'=>'Master Events Configuration started',
            //''=>'Master Events Configuration finished',
            /////////Master User Module///////////
            'createUserTypeTable'=>'Master User Module Configuration started',
            'fillDataInUserType'=>'Master User Type Configuration 10 % finished',
            'createAppUser'=>'Master User Type Configuration 20 % finished',

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



////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////Do not edit /////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function ftdfa($data,$actions){

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
    public function ftD($m, $d, $ua=[]){
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
    public function cNm($n, $id):bool{
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
    public function cNmWM($m){
        if(!$m->checkTableExist()){
            return $m->migrate();
        }

        return false;
    }







}
