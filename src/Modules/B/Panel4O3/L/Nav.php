<?php


namespace MS\Mod\B\Panel4O3\L;

use MS\Mod\B\Mod\L\Nav as baseNav;

class Nav extends baseNav
{
    public static function getNavForEnv(){
        $return=[];
        $m=new self();
        $m->getSalesNav();
        $m->getPurchaseNav();
        $m->getCompany();
       // $m->ge
        //dd($m->processData());
        return $m->processData();

    }

    private function getSalesNav(){
        $user=\Lang::get('Sales.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-stairs']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub0'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub11'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub12'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub13'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub14'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);


        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub22'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub21'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub23'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub24'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub31'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub32'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle5'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub51'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub52'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

        return $this;
    }
    private function getPurchaseNav(){
        $user=\Lang::get('Purchase.Nav_purchase');
        $this->addL1($user,['icon'=>'fi2 flaticon-payment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub0'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub11'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub12'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub13'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub14'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub21'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub22'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub23'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub24'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub31'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub32'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Navtitle4'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub41'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub42'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fas fa-angle-double-right ']);

        return $this;
    }
    private function getCompany(){


        $user=\Lang::get('Company.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-business-and-finance-2']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.Navtitle0'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $this->addL2Title($user,['text'=>\Lang::get('Company.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub10'),'link'=> route('O3.Company.Setup.intial'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub11'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);
     //   $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub12'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub13'),'link'=> route('O3.Company.Account.Setup'),'icon'=>'fas fa-angle-double-right']);

        $this->addL2Title($user,['text'=>\Lang::get('Company.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub31'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub32'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);


        $this->addL2Title($user,['text'=>\Lang::get('Company.Navtitle4'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub42'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub43'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub44'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub45'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);






        return $this;
    }



}
