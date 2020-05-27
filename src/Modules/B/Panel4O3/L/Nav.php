<?php


namespace MS\Mod\B\Panel4O3\L;

use MS\Mod\B\Mod\L\Nav as baseNav;

class Nav extends baseNav
{
    public static function getNavForEnv($allowedNav=[]){
        $return=[];
        $m=new self();
        $c=new \MS\Mod\B\Mod4O3\L\App();
        $m->permission=$c;
        $rootUser=ms()->checkRootUser();
        $m->rootUser=$rootUser;
      //  dd($rootUser);
        $allowedMod=$c->getAllowedModules();
        if(in_array('sales',$allowedMod) || $rootUser)$m->getSalesNav();
        if(in_array('purchase',$allowedMod) || $rootUser)$m->getPurchaseNav();
        if(in_array('inventory',$allowedMod) || $rootUser) $m->getInventorNav();
        if(in_array('hr',$allowedMod) || $rootUser) $m->getHRNav();
        if(in_array('company',$allowedMod) || $rootUser)$m->getCompanynav();
        if(in_array('accounts',$allowedMod) || $rootUser)$m->getAccountNav();
       // $m->ge
        //dd($m->processData());
        return $m->processData();

    }

    private function getSalesNav(){

        $mod='sales';
        $allowedSubSection=$this->permission->getAllowedModulesWithSub($mod);
        //dd($this);
        $user=\Lang::get('Sales.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-business-and-finance']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        if(in_array('lead',$allowedSubSection) || in_array('quotation',$allowedSubSection)  || $this->rootUser){
            $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub11'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub12'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub13'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub14'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        }


        if(in_array('invoice',$allowedSubSection) ||in_array('payments',$allowedSubSection)  || $this->rootUser){

            $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-addinvoice']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub22'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub21'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub23'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub24'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        }

        if(in_array('customer',$allowedSubSection) || $this->rootUser){
            $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle3'),'icon'=> 'fi2 flaticon-network']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub31'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub32'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        }

        if(in_array('product',$allowedSubSection) || $this->rootUser) {

            $this->addL2Title($user, ['text' => \Lang::get('Sales.Navtitle5'), 'icon' => 'fi2 flaticon-shipping-and-delivery-2']);
            $this->addL2Link($user, ['text' => \Lang::get('Sales.NavSub51'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            $this->addL2Link($user, ['text' => \Lang::get('Sales.NavSub52'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
        }
        return $this;
    }
    private function getPurchaseNav(){
        $user=\Lang::get('Purchase.Nav_purchase');
        $this->addL1($user,['icon'=>'fi2 flaticon-shipping-and-delivery']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-viewproduct']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub11'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub12'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub13'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub14'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-viewpayments']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub21'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub22'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub23'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub24'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-adddepartment']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub31'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub32'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('Purchase.Navtitle4'),'icon'=> 'fi2 flaticon-shipping-and-delivery-2']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub41'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub42'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        return $this;
    }
    private function getCompanyNav(){


        $user=\Lang::get('Company.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-business-and-finance-2']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.Navtitle0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $this->addL2Title($user,['text'=>\Lang::get('Company.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub10'),'link'=> route('O3.Company.Setup.intial'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub11'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
     //   $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub12'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub13'),'link'=> route('O3.Company.Account.Setup'),'icon'=>'fas fa-angle-double-right']);

        $this->addL2Title($user,['text'=>\Lang::get('Company.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub31'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub32'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);


        $this->addL2Title($user,['text'=>\Lang::get('Company.Navtitle4'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub42'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub43'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub44'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Company.NavSub45'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);






        return $this;
    }
    private function getHRNav(){


        $user=\Lang::get('HR.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-user-2']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.Navtitle0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $this->addL2Title($user,['text'=>\Lang::get('HR.Navtitle1'),'icon'=> 'fi2 flaticon-user-1']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub10'),'link'=> route('O3.SubUser.User.Add.Form'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub11'),'link'=> route('O3.SubUser.Role.Add.Form'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub12'),'link'=> route('O3.SubUser.User.View.All'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub13'),'link'=> route('O3.SubUser.Role.View.All'),'icon'=>'fas fa-angle-double-right']);

        $this->addL2Title($user,['text'=>\Lang::get('HR.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-viewcustomer']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub31'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub32'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub33'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);


        $this->addL2Title($user,['text'=>\Lang::get('HR.Navtitle4'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub42'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub43'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.NavSub44'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        return $this;
    }
    private function getInventorNav(){
        $user=\Lang::get('Inventory.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-msicon-for-addmachine']);
        $this->addL2Link($user,['text'=>\Lang::get('Inventory.Navtitle0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $this->addL2Title($user,['text'=>\Lang::get('Inventory.Navtitle1'),'icon'=> 'fi2 flaticon-touch-screen']);
        $this->addL2Link($user,['text'=>\Lang::get('Inventory.NavSub10'),'link'=> route('O3.Company.Setup.intial'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Inventory.NavSub11'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Inventory.NavSub12'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Inventory.NavSub13'),'link'=> route('O3.Company.Account.Setup'),'icon'=>'fas fa-angle-double-right']);

        $this->addL2Title($user,['text'=>\Lang::get('Inventory.Navtitle3'),'icon'=> 'fi2 flaticon-target']);
        $this->addL2Link($user,['text'=>\Lang::get('Inventory.NavSub31'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Inventory.NavSub32'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);



        return $this;

    }
    private function getAccountNav(){
        $user=\Lang::get('Account.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-agenda']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.Navtitle0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $this->addL2Title($user,['text'=>\Lang::get('Account.Navtitle1'),'icon'=> 'fi2 flaticon-files-and-folders-5']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub10'),'link'=> route('O3.Company.Setup.intial'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub11'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub12'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub13'),'link'=> route('O3.Company.Account.Setup'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub14'),'link'=> route('O3.Company.Account.Setup'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub15'),'link'=> route('O3.Company.Account.Setup'),'icon'=>'fas fa-angle-double-right']);

        $this->addL2Title($user,['text'=>\Lang::get('Account.Navtitle3'),'icon'=> 'fi2 flaticon-line-chart']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub31'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub32'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub33'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);


//        $this->addL2Title($user,['text'=>\Lang::get('Account.Navtitle4'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
//        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub42'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
//        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub43'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);
//        $this->addL2Link($user,['text'=>\Lang::get('Account.NavSub44'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fas fa-angle-double-right']);

        return $this;

    }



}
