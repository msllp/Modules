<?php
namespace MS\Mod\B\Company\L;
class Company
{

    public static function setCurrentComapny($id){
        // TODO: Make function set company id in session
        session()->put('CurrentComapany',$id);

    }
    public static function getCurrentCompany(){
        $sA=session()->all();
        if(!array_key_exists('CurrentComapany',$sA) && true)$sA['CurrentComapany']='1729279176';//TODO:Remove in Production
        return $sA['CurrentComapany'];
    }
    public static function getCompanyClass(){
        $sA=session()->all();
        $user=\MS\Mod\B\Users\F::getCurrentUser();

        if(!array_key_exists('CurrentComapany',$sA) && true)$sA['CurrentComapany']='1729279176';//TODO:Remove in Production

        if(array_key_exists('CurrentComapany',$sA) ) return new Self($sA['CurrentComapany'],$user['UniqId']);
        return new Self();


    }

    public static function createCompany($d){
        $m=\MS\Mod\B\Company\F::getCompanyModel();
        \MS\Mod\B\Accounts\L\Ledger::msfly($d['UniqId']);
        return $m->rowAdd($d,['UniqId','CompanyName','CompanyShortName','CompanyGST','CompanyPANTAN']);
    }
    public static function editCompany($uniqId,$d){
        $m=\MS\Mod\B\Company\F::getCompanyModel();
        return $m->rowEdit(['UniqId'=>$uniqId],$d);
    }
    public static function deleteCompany($uniqId){
        $m=\MS\Mod\B\Company\F::getCompanyModel();
        \MS\Mod\B\Accounts\L\Ledger::msreversefly($uniqId);
        return $m->rowDelete(['UniqId'=>$uniqId]);
    }

    public $companyID,$userID,$companyData;

    public function __construct($companyID=null,$userID=null)
    {

        if($companyID != null)$this->companyID=$companyID;
        if($userID != null)$this->userID=$userID;

        $m=\MS\Mod\B\Company\F::getCompanyModel();
        $md=$m->rowGet(['UniqId'=>$this->companyID]);
        $this->setCompanyData(reset($md));

        $this->checkAllOk();
    }

    /**
     * @return null
     */
    public function getCompanyID()
    {
        return $this->companyID;
    }

    /**
     * @param null $companyID
     */
    public function setCompanyID($companyID)
    {
        $this->companyID = $companyID;
    }

    /**
     * @return null
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param null $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getCompanyData()
    {
        return $this->companyData;
    }

    /**
     * @param mixed $companyData
     */
    public function setCompanyData($companyData)
    {
        $this->companyData = $companyData;
    }

    public function checkAllOk(){

        \MS\Mod\B\Accounts\L\Ledger::msfly();

    }






}
