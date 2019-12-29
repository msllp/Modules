<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 26-05-2019
 * Time: 06:18 PM
 */

namespace MS\Mod\B\Users;
use Faker\Generator as Faker;
//use Faker\Provider\Miscellaneous as Faker;
class F
{



public function __invoke()
{

    self::runCron();


}

    public static function runCron(){

}

    public static function genUniqId(){
    return \MS\Core\Helper\Comman::random(10);
}

public static function genAPIToken(){
    $faker = \Faker\Factory::create();

    return $faker->md5();

}

public static function genAPISecrete(){
    $faker = \Faker\Factory::create();

    return $faker->sha256();
}


public static function getRootUserModel(){
    return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_User');
}
public static function getUserTypeModel(){
    return new \MS\Core\Helper\MSDB(__NAMESPACE__,'User_User_Type');
}
public static function getAppUserModel(){
        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'User_App_User');
    }
public static function getUserRolePermission($RoleId='JwpWQp'){
    return new \MS\Core\Helper\MSDB(__NAMESPACE__,'User_User_Type_sub',[$RoleId]);
}
public static function getUserSourceModel(){
        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_User_VerifyBy');
    }




public static function makeRole($d){
    $db=$d;
    if (!array_key_exists('UniqId',$d))$d['UniqId']=\MS\Core\Helper\Comman::random(4);
    $m1=self::getUserTypeModel();
    $err=[];
    $err[$m1->rowAdd($d,['UniqId','UserTypeName'])][]='Entery in Role Table' ;
    $m2=self::getUserRolePermission($d['UniqId']);
   if(array_key_exists(1,$err) && (count($err[1]) ==1)) $err[$m2->migrate()][]='Migrate User Role Permission Table' ;
    return true;
}


public static function deleteRole($roleCode){
    $m1=self::getUserTypeModel();
    $err=[];
    $err[$m1->rowDelete(['UniqId'=>$roleCode])][]='Delete in Role Table' ;
    $m2=self::getUserRolePermission($roleCode);
    $err[$m2->delete()][]='Delete User Role Permission Table' ;
    return true;
}

public static function updateRole($id,$d){

}
public static function getRole($id){



    }
public static function makeUser($data){



    }
public static function deleteUser($id){


}
public static function updateUser($data){



    }
public static function getUser($data){



    }
public static function getCurrentUser(){
    $sA=session()->all();
    if(!array_key_exists('CurrentMSUser',$sA) && true)$sA['CurrentMSUser']='001';//TODO:Remove in Production
    if(array_key_exists('CurrentMSUser',$sA))$user=new L\User($sA['CurrentMSUser']);
    if(!isset($user))return [] ;
    return $user->getUserData();
    }


public static function checkCurrentOkForUser($data){}
public static function upgradeUser($id){}


public static function createRootUser($d){

    $db=$d;
    if (!array_key_exists('UniqId',$d))$d['UniqId']=\MS\Core\Helper\Comman::random(4);
    $m1=self::getRootUserModel();
    $err=[];
    $err[$m1->rowAdd($d,['UniqId','UserTypeName'])][]='Root User Created' ;

    if(array_key_exists(0,$err) && is_array($err[0]) && count($err[0])>0)return false;
    return true;
}
public static function editRootUser($i,$d){
    $db=$d;
    //$i['UniqId']=$i['UniqId']."asdasd";
   // if (!array_key_exists('UniqId',$d))$d['UniqId']=\MS\Core\Helper\Comman::random(4);
    $m1=self::getRootUserModel();
    $row=$m1->rowGet($i);
    $err=[];

    if(!(array_key_exists(0,$err) && is_array($err[0]) && count($err[0])>0) && (count($row) > 0) ){
        $err[1][]='Root User Found';

        $d1=$row;

        $fData=\MS\Core\Helper\Comman::checkNGetOnlyDiffrent($d1,$d);
       //dd($fData);
        $err[$m1->rowEdit($i,$fData)][]='Root User Edited' ;
    }else{$err[0][]='Root User Not Found';}

    if(array_key_exists(0,$err) && is_array($err[0]) && count($err[0])>0)return false;
    return true;
}
public static function deleteRootUser($i){
   // $db=$d;
  //  if (!array_key_exists('UniqId',$d))$d['UniqId']=\MS\Core\Helper\Comman::random(4);
    $m1=self::getRootUserModel();
    $err=[];

    if(count($m1->rowGet($i)) > 0){
        $err[1][]='Root User Found';
        $err[$m1->rowDelete($i)][]='Root User Deleted';
    }else{$err[0][]='Root User Not Found';}

    if(array_key_exists(0,$err) && is_array($err[0]) && count($err[0])>0)return false;
    return true;
}

}
