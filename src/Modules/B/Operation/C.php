<?php

namespace MS\Mod\B\Operation;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\Comman;
use MS\Mod\B\Users\F;

class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;

    public function addMachineCatFrom(){
        $m=new L\Machine();
        $m=$m->getItemCatModel();
        return $m->displayForm('add_machine_cat');
    }

    public function addMachineForm(){
        $m=new L\Machine();
        $m=$m->getItemModel();
        return $m->displayForm('add_machine');

    }

    public function addVendorForm(){
        $m=new L\Machine();
        $m=$m->getVendorModel();
       // dd($m->mod_Tables);
        return $m->displayForm('add_vendor');
    }

    public function addMachineCatPost (Request $r){
        $bM=new L\Machine();
        $m=$bM->getItemCatModel();
        $d=$r->all();
        if($m->attachR($r)->checkRulesForData()){
            $t=[
                'Add Machine Category'=>$m->rowAdd($d,['UniqId','CatName']),
            ];
        }else{
            $t=[
                'Add Machine Category'=>false,
            ];

        }

        $nextDat=\MS\Core\Helper\Comman::makeNextData('Core',\Lang::get('Operation.ViewMachineCatShort'),route('Operation.Machine.Cat.View'));

        return $m->processForSave($r,$d,$t,$nextDat);

    }

    public function viewCat(){
        $m=new L\Machine();
        $m=$m->getItemCatModel();
        //   $m->migrate();
        return $m->viewData('view_machine_cat');
    }
    public function viewCatData(Request $r){
        $m=new L\Machine();
        $m=$m->getItemCatModel();
        return $m->ForPagination($r);
    }

}
