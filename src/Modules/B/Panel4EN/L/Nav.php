<?php


namespace MS\Mod\B\Panel4EN\L;

use MS\Mod\B\Mod\L\Nav as baseNav;

class Nav extends baseNav
{

    public static function getNavForEnv(){
    $return=[];
    $m=new self();

  //  $m->getUsersNav();
    $m->getSalesNav();
    $m->getPurchaseNav();
    $m->getInventoryNav();
    $m->getAccountsNav();
    $m->getHRNav();
    $m->getCompany();
    return $m->processData();

}


    private function getPurchaseNav(){
      $user=\Lang::get('Purchase.Nav_purchase');
      $this->addL1($user,['icon'=>'fi2 flaticon-stairs-1']);
      $this->addL2Link($user,['text'=>\Lang::get('UI.purDashboard'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

      $this->addL2Title($user,['text'=>\Lang::get('UI.purPurchase'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
      $this->addL2Link($user,['text'=>\Lang::get('UI.purAddPurchase'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
      $this->addL2Link($user,['text'=>\Lang::get('UI.purAllPurchase'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);


      $this->addL2Title($user,['text'=>\Lang::get('UI.purVendor'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

      $this->addL2Link($user,['text'=>\Lang::get('UI.purAddVendor'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
      $this->addL2Link($user,['text'=>\Lang::get('UI.purAllVendor'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

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
        $user=\Lang::get('UI.company');
        $this->addL1($user,['icon'=>'fi2 flaticon-msicon-for-addmake']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.companyDashboard'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        $this->addL2Title($user,['text'=>\Lang::get('UI.companyManage'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.companyDetails'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.companyBank'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('UI.companyProductNServices'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.companyMasterItem'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.companyMasterUnit'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

       $this->addL2Title($user,['text'=>\Lang::get('UI.companyTax'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.companyMasterTaxSlab'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.companyHSNSAC'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.companyPaymentTerms'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.companyPurchaseType'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

        return $this;
    }
    private function getSalesNav(){
        $user=\Lang::get('UI.sales');
        $this->addL1($user,['icon'=>'fi2 flaticon-stairs']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.salesDashboard'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        $this->addL2Title($user,['text'=>\Lang::get('UI.salesManageSales'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.salesAddSales'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.salesAllSales'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);


        $this->addL2Title($user,['text'=>\Lang::get('UI.salesManageCust'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.salesAddCust'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.salesAllCust'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

        return $this;
    }
    private function getAccountsNav(){
        $user=\Lang::get('UI.accounts');
        $this->addL1($user,['icon'=>'fi2 flaticon-rupee']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.acDashboard'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        $this->addL2Title($user,['text'=>\Lang::get('UI.acManageLedger'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.acCashLedger'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.acVendorLedger'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.acCustomerLedger'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.acProfitLedger'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);


        $this->addL2Title($user,['text'=>\Lang::get('UI.acReports'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.acSaleReports'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.acPurchaseReports'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.acGSTReports'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.acBalanceSheet'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.acProfitLoss'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);



        return $this;
    }
    private function getInventoryNav(){
        $user=\Lang::get('UI.inventory');
        $this->addL1($user,['icon'=>'fi2 flaticon-msicon-for-managemachine']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.invDashboard'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

        $this->addL2Title($user,['text'=>\Lang::get('UI.invLive'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.invLiveItemWiese'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.invLiveLocation'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);


        $this->addL2Title($user,['text'=>\Lang::get('UI.invStock'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.invInward'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.invOutward'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

        $this->addL2Title($user,['text'=>\Lang::get('UI.invLocation'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('UI.invAddLocation'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
        $this->addL2Link($user,['text'=>\Lang::get('UI.invAllLocation'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);




        return $this;
    }
    private function getHRNav(){
        $user=\Lang::get('UI.hr');
        $this->addL1($user,['icon'=>'fi2 flaticon-msicon-for-addcustomer']);

     $this->addL2Link($user,['text'=>\Lang::get('UI.hrDashboard'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-mainoperation ']);

     $this->addL2Title($user,['text'=>\Lang::get('UI.hrManageRoles'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

     $this->addL2Link($user,['text'=>\Lang::get('UI.hraddRoles'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
     $this->addL2Link($user,['text'=>\Lang::get('UI.hrmanageRoles'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

     $this->addL2Link($user,['text'=>\Lang::get('UI.hraddUsers'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
     $this->addL2Link($user,['text'=>\Lang::get('UI.hrmanageUsers'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

     $this->addL2Title($user,['text'=>\Lang::get('UI.hrleaveNAtta'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

     $this->addL2Link($user,['text'=>\Lang::get('UI.hrmanegeAtta'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
     $this->addL2Link($user,['text'=>\Lang::get('UI.hrmanageLeave'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

     $this->addL2Title($user,['text'=>\Lang::get('UI.hrUserFunction'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

     $this->addL2Link($user,['text'=>\Lang::get('UI.hrUserAppointment'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
     $this->addL2Link($user,['text'=>\Lang::get('UI.hrUserExperience'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);
     $this->addL2Link($user,['text'=>\Lang::get('UI.hrUserSalary'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fas fa-angle-double-right ']);

     return $this;
    }



}
