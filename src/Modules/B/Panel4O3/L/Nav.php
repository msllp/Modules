<?php


namespace MS\Mod\B\Panel4O3\L;

use MS\Mod\B\Mod\L\Nav as baseNav;

class Nav extends baseNav
{
    public static function getNavForEnv($allowedNav=[]){
        $return=[];
      //  phpinfo();
        $m=new self();
        $m->permission=ms()->app();
        $rootUser=ms()->checkRootUser();
        $m->rootUser=$rootUser;
        $allowedMod=$m->permission->getAllowedModules();
        if($rootUser || in_array('sales',$allowedMod))$m->getSalesNav($rootUser);
        if($rootUser || in_array('purchase',$allowedMod))$m->getPurchaseNav($rootUser);
        if($rootUser || in_array('inventory',$allowedMod)) $m->getInventorNav($rootUser);
        if($rootUser || in_array('hr',$allowedMod)) $m->getHRNav($rootUser);
        if($rootUser || in_array('company',$allowedMod))$m->getCompanynav($rootUser);
        if($rootUser || in_array('accounts',$allowedMod))$m->getAccountNav($rootUser);

        return $m->processData();

    }
    private function getSalesNav($root){

        $mod='sales';
        if(!$root)$allowedSubSection=$this->permission->getAllowedModulesWithSub($mod);
       // $allowedSubSection
        //dd($this);
        $user=\Lang::get('Sales.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-business-and-finance']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);
        $section1='lead';
        $section2='quotation';
        if($root || in_array($section1,$allowedSubSection) || in_array($section2,$allowedSubSection)){

            if(!$root)$allowedAction=array_merge($this->permission->getAllowedModulesWithSubAction($mod,$section1),$this->permission->getAllowedModulesWithSubAction($mod,$section2));

            $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
            if($root || in_array('addLead',$allowedAction))$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub11'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            if($root || in_array('addQuotation',$allowedAction))$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub12'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            if($root ||in_array('viewLead',$allowedAction)||in_array('viewOwnLead',$allowedAction))$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub13'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            if($root ||in_array('viewQuotation',$allowedAction)||in_array('viewOwnQuotation',$allowedAction))$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub14'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        }

        $section3='invoice';
        $section4='payments';
        if($root || in_array($section3,$allowedSubSection) ||in_array($section4,$allowedSubSection) ){
             if(!$root)$allowedAction=array_merge($this->permission->getAllowedModulesWithSubAction($mod,$section3),$this->permission->getAllowedModulesWithSubAction($mod,$section4));

            $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-addinvoice']);
            if($root || in_array('addInvoice',$allowedAction)  )$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub22'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            if($root || in_array('addPayment',$allowedAction)  )$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub21'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            if($root || in_array('viewInvoice',$allowedAction) || in_array('viewOwnInvoice',$allowedAction)  )$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub23'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            if($root || in_array('viewPayment',$allowedAction) || in_array('viewOwnPayment',$allowedAction)  )$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub24'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);

        }

        $section5='customer';
        if($root || in_array($section5,$allowedSubSection)  ){
             if(!$root)$allowedAction=$this->permission->getAllowedModulesWithSubAction($mod,$section5);

           $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle3'),'icon'=> 'fi2 flaticon-network']);
            if($root || in_array('addCustomer',$allowedAction)  )$this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub31'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fas fa-angle-double-right ']);
            if($root || in_array('viewCustomer',$allowedAction)  ) $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub32'),'link'=> route('O3.Sales.Product.Category.View.All'),'icon'=>' fas fa-angle-double-right ']);

        }
        $section6='product';
        if($root || in_array($section6,$allowedSubSection)  ) {
             if(!$root)$allowedAction=$this->permission->getAllowedModulesWithSubAction($mod,$section6);

            $this->addL2Title($user, ['text' => \Lang::get('Sales.Navtitle5'), 'icon' => 'fi2 flaticon-shipping-and-delivery-2']);
            if($root || in_array('addProduct',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Sales.NavSub51'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('addProductCategory',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Sales.NavSub52'), 'link' => route('O3.Sales.Product.Category.Add.Form'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('viewProduct',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Sales.NavSub53'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('viewProductCategory',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Sales.NavSub54'), 'link' => route('O3.Sales.Product.Category.View.All'), 'icon' => ' fas fa-angle-double-right ']);
        }
        return $this;
    }
    private function getPurchaseNav($root){
        $mod='purchase';
         if(!$root)$allowedSubSection=$this->permission->getAllowedModulesWithSub($mod);
        $user=\Lang::get('Purchase.Nav_purchase');
        $this->addL1($user,['icon'=>'fi2 flaticon-shipping-and-delivery']);
        $this->addL2Link($user,['text'=>\Lang::get('Purchase.NavSub0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        $section1='cashpurchase';
        $section2='invoicepurchase';
        if($root || in_array($section1,$allowedSubSection) || in_array($section2,$allowedSubSection)   ) {
             if(!$root)$allowedAction=array_merge($this->permission->getAllowedModulesWithSubAction($mod,$section1),$this->permission->getAllowedModulesWithSubAction($mod,$section2));


            $this->addL2Title($user, ['text' => \Lang::get('Purchase.Navtitle1'), 'icon' => 'fi2 flaticon-msicon-for-viewproduct']);
            if($root || in_array('addCashPurchsae',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub11'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('addInvoicePurchase',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub12'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('viewCashPurchase',$allowedAction)|| in_array('viewOwnCashPurchase',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub13'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('viewInvoicePurchase',$allowedAction) || in_array('viewOwnInvoicePurchase',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub14'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
        }

        $section3='payments';
        if($root ||in_array($section3,$allowedSubSection)   ) {
            $allowedAction =$this->permission->getAllowedModulesWithSubAction($mod, $section3);


            $this->addL2Title($user, ['text' => \Lang::get('Purchase.Navtitle2'), 'icon' => 'fi2 flaticon-msicon-for-viewpayments']);
            if($root || in_array('addPayment',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub21'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('addPayment',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub22'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('viewPayment',$allowedAction)|| in_array('viewOwnPayment',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub23'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('viewPayment',$allowedAction)|| in_array('viewOwnPayment',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub24'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
        }

        $section4='vendor';
        if($root || in_array($section4,$allowedSubSection)   ) {
            $allowedAction =$this->permission->getAllowedModulesWithSubAction($mod, $section4);

            $this->addL2Title($user, ['text' => \Lang::get('Purchase.Navtitle3'), 'icon' => 'fi2 flaticon-msicon-for-adddepartment']);
            if($root || in_array('addVendor',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub31'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('viewVendor',$allowedAction)  )  $this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub32'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
        }

        $section5="product";
        if($root || in_array($section5,$allowedSubSection)   ) {
            $allowedAction =$this->permission->getAllowedModulesWithSubAction($mod, $section5);

            $this->addL2Title($user, ['text' => \Lang::get('Purchase.Navtitle4'), 'icon' => 'fi2 flaticon-shipping-and-delivery-2']);
            if($root || in_array('addProduct',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub41'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
            if($root || in_array('viewProduct',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Purchase.NavSub42'), 'link' => route('O3.Panel.AllInOne'), 'icon' => ' fas fa-angle-double-right ']);
        }
        return $this;
    }
    private function getInventorNav($root){
        $mod='inventory';
         if(!$root)$allowedSubSection=$this->permission->getAllowedModulesWithSub($mod);
        $user=\Lang::get('Inventory.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-msicon-for-addmachine']);
        $this->addL2Link($user,['text'=>\Lang::get('Inventory.Navtitle0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $section1='stocks';

        if($root || in_array($section1,$allowedSubSection)   ) {
             if(!$root)$allowedAction=$this->permission->getAllowedModulesWithSubAction($mod,$section1);

            $this->addL2Title($user, ['text' => \Lang::get('Inventory.Navtitle1'), 'icon' => 'fi2 flaticon-touch-screen']);
            if($root || in_array('inStocks',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Inventory.NavSub10'), 'link' => route('O3.Company.Setup.intial'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('outStocks',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Inventory.NavSub11'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('shiftStock',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Inventory.NavSub12'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('viewStocks',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Inventory.NavSub13'), 'link' => route('O3.Company.Account.Setup'), 'icon' => 'fas fa-angle-double-right']);
        }

        $section2='location';
        if($root || in_array($section2,$allowedSubSection)   ) {
            $allowedAction = $this->permission->getAllowedModulesWithSubAction($mod, $section2);

            $this->addL2Title($user, ['text' => \Lang::get('Inventory.Navtitle3'), 'icon' => 'fi2 flaticon-target']);
            if($root || in_array('addLocation',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Inventory.NavSub31'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('viewLocation',$allowedAction)||in_array('viewOwnLocation',$allowedAction)  )$this->addL2Link($user, ['text' => \Lang::get('Inventory.NavSub32'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
        }


        return $this;

    }
    private function getHRNav($root){
        $mod='hr';
         if(!$root)$allowedSubSection=$this->permission->getAllowedModulesWithSub($mod);

        $user=\Lang::get('HR.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-user-2']);
        $this->addL2Link($user,['text'=>\Lang::get('HR.Navtitle0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $section1='employee';
        if($root || in_array($section1,$allowedSubSection)   ) {
            $allowedAction = $this->permission->getAllowedModulesWithSubAction($mod, $section1);

            $this->addL2Title($user, ['text' => \Lang::get('HR.Navtitle1'), 'icon' => 'fi2 flaticon-user-1']);
            if($root || in_array('addEmployee',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub10'), 'link' => route('O3.SubUser.User.Add.Form'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('addRole',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub11'), 'link' => route('O3.SubUser.Role.Add.Form'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('viewEmployee',$allowedAction) ||in_array('viewOwnEmployee',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub12'), 'link' => route('O3.SubUser.User.View.All'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('viewRole',$allowedAction)||in_array('viewOwnRole',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub13'), 'link' => route('O3.SubUser.Role.View.All'), 'icon' => 'fas fa-angle-double-right']);
        }

        $section2='attendancenLeave';
        if($root || in_array($section2,$allowedSubSection)   ) {
            $allowedAction = $this->permission->getAllowedModulesWithSubAction($mod, $section2);

            $this->addL2Title($user, ['text' => \Lang::get('HR.Navtitle3'), 'icon' => 'fi2 flaticon-msicon-for-viewcustomer']);
            if($root || in_array('feedAttedance',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub31'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('askapproveLeave',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub32'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('attendanceReport',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub33'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
        }

        $section3='salary';
        if($root || in_array($section3,$allowedSubSection)   ) {
            $allowedAction = $this->permission->getAllowedModulesWithSubAction($mod, $section3);

            $this->addL2Title($user, ['text' => \Lang::get('HR.Navtitle4'), 'icon' => 'fi2 flaticon-msicon-for-manageleadsnquataions']);
            if($root || in_array('generateSalrarySlip',$allowedAction)  )  $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub42'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('editSalrarySlip',$allowedAction)  )  $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub43'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('salaryReport',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('HR.NavSub44'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
        }
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
    private function getAccountNav($root){
        $mod='accounts';
         if(!$root)$allowedSubSection=$this->permission->getAllowedModulesWithSub($mod);


        $user=\Lang::get('Account.NavMainHead');
        $this->addL1($user,['icon'=>'fi2 flaticon-agenda']);
        $this->addL2Link($user,['text'=>\Lang::get('Account.Navtitle0'),'link'=> route('O3.Panel.AllInOne'),'icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $section1='ledgers';
        if($root || in_array($section1,$allowedSubSection)   ) {
            $allowedAction = $this->permission->getAllowedModulesWithSubAction($mod, $section1);

            $this->addL2Title($user, ['text' => \Lang::get('Account.Navtitle1'), 'icon' => 'fi2 flaticon-files-and-folders-5']);
            if($root || in_array('incomeledger',$allowedAction)  )    $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub10'), 'link' => route('O3.Company.Setup.intial'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('expenseledger',$allowedAction)  )   $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub11'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('clientledger',$allowedAction)  )   $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub12'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('vendorledger',$allowedAction)  )   $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub13'), 'link' => route('O3.Company.Account.Setup'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('cashledger',$allowedAction)  )  $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub14'), 'link' => route('O3.Company.Account.Setup'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('bankledger',$allowedAction)  )  $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub15'), 'link' => route('O3.Company.Account.Setup'), 'icon' => 'fas fa-angle-double-right']);
        }
        $section2='reports';
        if($root || in_array($section2,$allowedSubSection)   ) {
            $allowedAction = $this->permission->getAllowedModulesWithSubAction($mod, $section2);

            $this->addL2Title($user, ['text' => \Lang::get('Account.Navtitle3'), 'icon' => 'fi2 flaticon-line-chart']);
            if($root || in_array('salesreport',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub31'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('purchasereport',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub32'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
            if($root || in_array('gstreport',$allowedAction)  ) $this->addL2Link($user, ['text' => \Lang::get('Account.NavSub33'), 'link' => route('O3.Panel.AllInOne'), 'icon' => 'fas fa-angle-double-right']);
        }


        return $this;

    }



}
