<?php


namespace MS\Mod\B\Mod\L;


class Nav
{
private $fData,$fromData;


    public static function getNav(){
        $c=new self();
        return $c->getDefaultData();
    }


    public function addL1($id,$data){

        $this->setFromData($id,$data);
        return $this;
    }

    public function addL2Link($id,$data){
        $bdata=[
            'type'=>'link',
        ];
        $bdata=array_merge($bdata,$data);
        $this->addL2($id,$bdata);
        return $this;
    }
    public function addL2Title($id,$data){
        $bdata=[
            'type'=>'title',
        ];
        $bdata=array_merge($bdata,$data);

        $this->addL2($id,$bdata);
     //  dd($this);
        return $this;
    }

    public function addL2($id,$data){
        //dd($this->getFromData());
        $setData=$this->getFromData();
        if(is_array($setData) && array_key_exists($id,$setData))$setData[$id]['sub'][]=$data;

       // dd($setData);

        $this->setFromData($id,$setData[$id]);
        return $this;
    }

    public function processData(){
        $bdata=[
            'type'=>'mainNav',
        ];
            $setData=$this->getFromData();
        $fData=[];
        if(is_array($setData))foreach ($setData as $id=>$data){
         if(!array_key_exists('name',$data)) $bdata['text']=$id;
        $fData[$id]=array_merge($bdata,$data);

        }
     //   dd($fData);
        return $fData;


    }

    private function getDefaultData(){

        $id=\Lang::get('UI.company');
        $this->addL1($id,['icon'=>'fi2 flaticon-ui-3 msicon-r-270']);



        $this->getSalesNav();
        $this->getPurchaseNav();


        $id=\Lang::get('UI.accounts');
        $this->addL1($id,['icon'=>'fi2 flaticon-list']);

        $id=\Lang::get('Operation.mainTitle');
        $this->addL1($id,['icon'=>'fi2 flaticon-msicon-for-mainoperation']);

        $this->addL2Title($id,['text'=>\Lang::get('Operation.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-managemachine']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub15'),'link'=> route('Operation.Machine.Cat.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addmachine ']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub11'),'link'=> route('Operation.Vendor.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addmachine ']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub12'),'link'=> route('Operation.Machine.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addmake']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub16'),'link'=> route('Operation.Machine.Cat.View'),'icon'=>' fi2 flaticon-msicon-for-addmachine ']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub14'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewmachine']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub13'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewmake ']);


        $this->addL2Title($id,['text'=>\Lang::get('Operation.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-managemachinehealth']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub21'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-checkmachinehealth ']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub22'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-updateinsurence ']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub23'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-managemachinehealth']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub24'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewinsurance ']);


        $this->addL2Title($id,['text'=>\Lang::get('Operation.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-managelnd']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub31'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-adddepartment']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub32'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-adddepartmentmachine']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub33'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewlocation ']);
        $this->addL2Link($id,['text'=>\Lang::get('Operation.NavSub34'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewdepartment ']);


        return $this->processData();

    }

    private function getSalesNav(){


        $user=\Lang::get('UI.sales');
        $this->addL1($user,['icon'=>'fi2 flaticon-payment']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub0'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub11'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub12'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addquotation ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub13'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub14'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewquotation ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub21'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub22'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addinvoice ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub23'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewinvoice ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub24'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewpayments ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle5'),'icon'=> 'fi2 flaticon-msicon-for-manageproduct']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub51'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addproduct']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub52'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewproduct']);


        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-managecustomer']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub31'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addcustomer ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub32'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewcustomer ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle4'),'icon'=> 'fi2 flaticon-msicon-for-manageproduct']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub41'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub42'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addquotation ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub43'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub44'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewquotation ']);


    }

    private function getPurchaseNav(){
        $id=\Lang::get('UI.purchase');
        $this->addL1($id,['icon'=>'fi2 flaticon-payment msicon-fh-180']);
        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub0'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);

        $this->addL2Title($id,['text'=>\Lang::get('Purchase.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-managepurchase']);

        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub11'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-cashpurchase ']);
        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub12'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-invoicepurchase ']);
        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub13'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-wallet ']);
        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub14'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-viewinvoice']);


        $this->addL2Title($id,['text'=>\Lang::get('Purchase.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-dues']);

        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub22'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);
        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub24'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-viewpayments']);

        $this->addL2Title($id,['text'=>\Lang::get('Purchase.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-managecustomer']);

        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub31'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);
        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub32'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);

        $this->addL2Title($id,['text'=>\Lang::get('Purchase.Navtitle4'),'icon'=> 'fi2 flaticon-msicon-for-managecustomer']);

        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub41'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);
        $this->addL2Link($id,['text'=>\Lang::get('Purchase.NavSub42'),'link'=> route('MOD.Sales.Dashboard'),'icon'=>' fi2 flaticon-msicon-for-dashboard ']);


    }
    /**
     * @return mixed
     */
    private function getFData()
    {
        return $this->fData;
    }

    /**
     * @param mixed $fData
     */
    private function setFData($fData)
    {
        if(is_array($this->fData))$fData=array_merge($this->fData,$fData);
        $this->fData = $fData;
    }
    /**
     * @return mixed
     */
    private function getFromData()
    {
        return $this->fromData;
    }

    /**
     * @param mixed $fromData
     */
    private function setFromData($id,$fromData)
    {
        $this->fromData[$id] = $fromData;
    }


}
