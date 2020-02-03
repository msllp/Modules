<?php
namespace MS\Mod\B\User4O3\L;

class Users
{


    public $UserId;

    public static $userConstructData=[
        'UserId'=>'string'
            ];

    public function __construct($data=[])
    {
        if(count($data))foreach ($data as $k=>$v)if(array_key_exists($k,self::$userConstructData) && gettype($v)==self::$userConstructData[$k] )$this->$k=$v;


    }

    public static $type=['website','app','google'];


    public function getLiveUser(){
        return      [
            "Username"=>"maxirooney",
            "email"=>"user@company.com",
            "fname"=>"Mitul",
            "lname"=>"Patel",
            "phone"=>"9662611234",
            "sex"=>"male"
        ];;
    }

    public function getUserPlan($userId){

        return[
            'name'=>'',
            'limits'=>[

            'products'=>[
                'vName' =>'Products',
                'limit' =>5,
                'usage' =>1,
            ],
            'invoice'=>[
                'vName' =>'Invoice',
                'limit' =>5,
                'usage' =>1,
            ],
            'purchase'=>[
                'vName' =>'Sales',
                'limit' =>5,
                'usage' =>1,
            ]
            ]
        ];
    }
    public function signUpUser($data=[],$type=''){}
    public function signInUser($data=[],$type=''){}
    public function upgradeUser($data=[],$type=''){}
    public function viewUserProfile($data=[],$type=''){

        $user=$this->getLiveUser();
        $user['plan']=(array_key_exists('Username',$user))?$this->getUserPlan($user['Username']):$this->getUserPlan($user['email']);
            return $user;

    }
    public function editUserProfile($data=[],$type=''){}


    private function makeArrayForDBEntryForUserTable($data):array {}
    private function makeArrayForDBEntryTableConnection($data):array {}
    private function MigrateDBForUser($data):array {}



}
