<?php


namespace MS\Mod\B\Users\L;


use MS\Core\Helper\MSDB;

class OutLoginApi
{

    public $m,$sData,$sDataKey;
    public static  $google=[
        'client_id' => '319261013343-na7nnss33ank4sg98jld64iuf2ou342p.apps.googleusercontent.com',
        'client_secret' => 'vnRnQ-0hmh3rG7Mli_5XNWtJ',
        'redirect' => 'MOD.User.Master.Roles.Login.Owner.Callback',
    ];

    public static function checkOaAuthisOk(){
        if(!config()->has('services.google'))config()->set('services.google',self::setGoogleServices());
        return  true;
    }

    public static function setGoogleServices(){
       $d=self::$google;
       $d['redirect']=route($d['redirect']);
       return $d;

    }

    public function __construct()
    {
       // $this->m=$m;
        $this->m=\MS\Mod\B\Users\F::getUserSourceModel();
    }

    /**
     * @return \MS\Core\Helper\MSDB
     */
    public function getM()
    {
        return $this->m;
    }

    /**
     * @param \MS\Core\Helper\MSDB $m
     */
    public function setM($m)
    {
        $this->m = $m;
    }

    /**
     * @return mixed
     */
    public function getSData()
    {
        return $this->sData;
    }

    /**
     * @param mixed $sData
     */
    public function setSData($sData)
    {
        $this->sData = $sData;
    }

    /**
     * @return mixed
     */
    public function getSDataKey()
    {
        return $this->sDataKey;
    }

    /**
     * @param mixed $sDataKey
     */
    public function setSDataKey($sDataKey)
    {
        $this->sDataKey = $sDataKey;
    }

    public function getSourceByName($name,$debug=false){
       if($debug) dd($name);
        $d=$this->m->rowGet(['VerifyName'=>$name]);
        return reset($d);
    }


}
