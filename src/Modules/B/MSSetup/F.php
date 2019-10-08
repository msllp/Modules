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


        $m=new \MS\Core\Helper\MSDB(__NAMESPACE__,'Master_Icon_1');
        $data=[

            [
                'IconName'=>'Admin User',
                'IconType'=>'class',
                'IconValue'=>'msicon-admin-user',
                'Status'=>1,

            ],
            [
                'IconName'=>'Modules',
                'IconType'=>'class',
                'IconValue'=>'msicon-modules',
                'Status'=>1,

            ],

        ];

        return $this->ftD($m,$data,['IconName']);

    }








    public function ftD($m,$d,$ua=[]){
        $err=[];
        foreach ($d as $v){
            if(!$m->rowAdd($v,$ua))$err[$v['BoolName']]=$v;
        }
        return (count($err) < 1);

    }


    public function cNm($n,$id):bool{
        $m=new \MS\Core\Helper\MSDB($n,$id);

        if(!$m->checkTableExist()){
            return $m->migrate();
        }

        return true;

    }

    public function cNmWM($m){
        if(!$m->checkTableExist()){
            return $m->migrate();
        }

        return true;
    }







}
