<?php


namespace MS\Mod\B\Panel4O3\L;

use MS\Mod\B\Mod\L\Nav as baseNav;

class Nav extends baseNav
{
    public static function getNavForEnv(){
        $return=[];
        $m=new self();
        //$m->getUsersNav();
        $m->getPurchaseNav();
       // $m->ge
        //dd($m->processData());
        return $m->processData();

    }


    private function getPurchaseNav(){
        $user=\Lang::get('Purchase.Nav_purchase');
        $this->addL1($user,['icon'=>'fi2 flaticon-payment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub0'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Nav_purchase_1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_1_1'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_1_2'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addquotation ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Nav_purchase_2'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_2_1'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_2_2'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_2_3'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addinvoice ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Nav_purchase_3'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_3_1'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_3_2'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_3_3'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addinvoice ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Nav_purchase_4'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_4_1'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_4_2'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_4_3'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addinvoice ']);


        return $this;
    }
    private function getUsersNav(){


        $user=\Lang::get('Company.Nav_User_1');
        $this->addL1($user,['icon'=>'fi2 flaticon-payment']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.Nav_User_h1'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);

        $this->addL2Title($user,['text'=>\Lang::get('Company.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub21'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub22'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addquotation ']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub23'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addquotation ']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub24'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addquotation ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Nav_purchase_2'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_2_1'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_2_2'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_2_3'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addinvoice ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Nav_purchase_3'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_3_1'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_3_2'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_3_3'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addinvoice ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Nav_purchase_4'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_4_1'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_4_2'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.Nav_purchase_4_3'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addinvoice ']);


        return $this;
    }
    private function getCompany(){

    }


}
