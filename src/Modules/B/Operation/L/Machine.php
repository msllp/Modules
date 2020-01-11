<?php


namespace MS\Mod\B\Operation\L;


class Machine
{

    public static $c_m='MS_GE_Master';
    public static $c_d='MS_GE_Data';
    public static $c_c='MS_GE_Config';
    public static $modCode='Operation';
    public function __construct()
    {


    }


    public function migrate(){
        $tableIds=['getItemCatModel','getVendorModel','getItemModel',];
        $namespace=implode('\\',['MS','Mod','B','Operation']);
        foreach ($tableIds as $tableId){
            $m=$this->$tableId()->migrate();

        }
    }

    public static function getTableRaw(){

        $methodToCall=[
            'setUpMachineCategory'=>[],
            'setUpMachine'=>['modCode'=>self::$modCode],
            'setUpVendor'=>[]
        ];

        $c=new self();
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
        return $d;
        //dd($d);



    }

    private function setUpMachineCategory(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'MachineCat']),
            'tableName'=>implode('_',[self::$modCode,'MachineCat']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'CatName','vName'=>\Lang::get('Operation.AddMachineCatField1'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CatDescription','vName'=>\Lang::get('Operation.AddMachineCatField2'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);

        $groupId1=\Lang::get('Operation.AddMachineCatGroup1');
        $groupFields1=['CatName','CatDescription'];
        $m->addGroup($groupId1)->addField($groupId1,$groupFields1);
        $action1=[
      //      "btnColor"=>"bg-yellow-400",
            "route"=>"Operation.Machine.Cat.AddForm.Post",
            "btnIcon"=>"far fa-save",
            'btnText'=>\Lang::get('Operation.AddMachineCatBtn1')
        ];
        $actionId1='add';
        $m->addAction($actionId1,$action1);


        $formId1='add_machine_cat';


        $m->addForm($formId1)->addGroup4Form($formId1,[$groupId1])->addAction4Form($formId1,[$actionId1])->addTitle4Form($formId1,\Lang::get('Operation.ViewMachineCatFormTitle'));

        $viewId='view_machine_cat';
        $m->addView($viewId)->addGroup4View($viewId,[$groupId1])->pagination4View($viewId,'Operation.Machine.Cat.View.Data')->addTitle4View($viewId,\Lang::get('Operation.ViewMachineCatShort'));

        $m1=$m->finalReturnForTableFile();
        //dd($m1);
        $data=[
            'tableId'=>implode('_',[self::$modCode,'MachineCatExtra']),
            'tableName'=>implode('_',[self::$modCode,'MachineCatExtra']),
            'connection'=>self::$c_m,
        ];
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']);
        //dd( \MS\Core\Helper\MSTableSchema::getTableDataForField(self::$modCode,$data['tableId'],$data['tableName'],$data['connection']));
        return array_merge($m1,$m2);
    }

    private function setUpMachine(){
        $data=[
            'tableId'=>implode('_',[self::$modCode,'MachineMaster']),
            'tableName'=>implode('_',[self::$modCode,'MachineMaster']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        //_{MachineCat.UniqId}_{MachineMaster.UniqId}
        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemName','vName'=>\Lang::get('Operation.AddMachineField1'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemDescription','vName'=>\Lang::get('Operation.AddMachineField2'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemCatId','vName'=>\Lang::get('Operation.AddMachineField3'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemMake','vName'=>\Lang::get('Operation.AddMachineField4'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemModel','vName'=>\Lang::get('Operation.AddMachineField5'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemMachineNoArray','vName'=>\Lang::get('Operation.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $m->setFields(['name'=>'ItemMachinePower','vName'=>\Lang::get('Operation.AddMachineField13'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemMachineRPM','vName'=>\Lang::get('Operation.AddMachineField14'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemMachineCapacity','vName'=>\Lang::get('Operation.AddMachineField15'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $m->setFields(['name'=>'ItemMachineNoArray','vName'=>\Lang::get('Operation.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemTotalPrice','vName'=>\Lang::get('Operation.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemTotalUnit','vName'=>\Lang::get('Operation.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemStatus','vName'=>\Lang::get('Operation.AddMachineField12'),'type'=>'string','input'=>'radio',"validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]]);

       // $m->setFields(['name'=>'ItemS','dbOff'=>true,'vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemUnitPrice','dbOff'=>true,'vName'=>\Lang::get('Operation.AddMachineField6'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemMachineNo','dbOff'=>true,'vName'=>\Lang::get('Operation.AddMachineField7'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemYom','dbOff'=>true,'vName'=>\Lang::get('Operation.AddMachineField8'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemRatioCapacity','dbOff'=>true,'vName'=>\Lang::get('Operation.AddMachineField9'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemInsuranceConnect','dbOff'=>true,'vName'=>\Lang::get('Operation.AddMachineField12'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $groupId1=\Lang::get('Operation.AddMachineGroup1');
        $groupFields1=['ItemName','ItemDescription','ItemCatId','ItemStatus'];
        $m->addGroup($groupId1)->addField($groupId1,$groupFields1);

        $groupId2=\Lang::get('Operation.AddMachineGroup2');
        $groupFields2=['ItemMake','ItemModel','ItemMachinePower','ItemMachineRPM','ItemMachineCapacity'];
        $m->addGroup($groupId2)->addField($groupId2,$groupFields2);

        $groupId3=\Lang::get('Operation.AddMachineGroup3');
        $groupFields3=['ItemUnitPrice','ItemMachineNo','ItemYom','ItemRatioCapacity'];
        $m->addGroup($groupId3)->addField($groupId3,$groupFields3);
        $m->makeGroupMultiple($groupId3);
        $action1=[
            "btnColor"=>"bg-green",
            "route"=>"MOD.User.Master.Add.toDB",
            "btnIcon"=>"far fa-save",
            'btnText'=>\Lang::get('Operation.AddMachineBtn1')
        ];
        $actionId1='add';
        $m->addAction($actionId1,$action1);

        $formId1='add_machine';
        $m->addForm($formId1)->addGroup4Form($formId1,[$groupId1,$groupId2,$groupId3])->addAction4Form($formId1,[$actionId1])->addTitle4Form($formId1,\Lang::get('Operation.AddMachineFormTitle'));




        $m2=$m->finalReturnForTableFile() ;

//dd($m2);


        $data=[
            'tableId'=>implode('_',[self::$modCode,'MachineStock']),
            'tableName'=>implode('_',[self::$modCode,'MachineStock']),//_{MachineCat.UniqId}_{MachineMaster.UniqId}
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        //_{MachineCat.UniqId}_{MachineMaster.UniqId}_{MachineStock.UniqId}
        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemUnit','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemUnitPrice','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemModel','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemMachineNo','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemYom','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemRatioCapacity','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemInsuranceConnect','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'ItemInsuranceConnectId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $m3=$m->finalReturnForTableFile() ;

        return array_merge($m2,$m3);



    }

    private function setUpVendor(){
        $data=[
            'tableId'=>implode('_',[self::$modCode,'VendorMaster']),
            'tableName'=>implode('_',[self::$modCode,'VendorMaster']),//_{MachineCat.UniqId}_{MachineMaster.UniqId}
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);
        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'VendorName','vName'=>\Lang::get('Operation.AddVendorField1'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'VendorDescription','vName'=>\Lang::get('Operation.AddVendorField2'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'VendorSalesConnect','vName'=>\Lang::get('Operation.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'VendorSalesConnectId','vName'=>\Lang::get('Operation.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'VendorPurchaseConnect','vName'=>\Lang::get('Operation.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'VendorPurchaseConnectId','vName'=>\Lang::get('Operation.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'VendorInventoryConnect','vName'=>\Lang::get('Operation.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'VendorInventoryConnectId','vName'=>\Lang::get('Operation.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>false,]]);
        $m->setFields(['name'=>'VendorStatus','vName'=>\Lang::get('Operation.AddVendorField3'),'type'=>'string','input'=>'radio',"validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]]);

        $action1=[
            "btnColor"=>"bg-green",
            "route"=>"MOD.User.Master.Add.toDB",
            "btnIcon"=>"far fa-save",
            'btnText'=>\Lang::get('Operation.AddVendorBtn1')
        ];
        $actionId1='add';
        $m->addAction($actionId1,$action1);

        $groupId1=\Lang::get('Operation.AddVendorGroup1');
        $groupFields1=['VendorName','VendorDescription','VendorStatus'];
        $m->addGroup($groupId1)->addField($groupId1,$groupFields1);

        $formId1='add_vendor';
        $m->addForm($formId1)->addGroup4Form($formId1,[$groupId1])->addAction4Form($formId1,[$actionId1])->addTitle4Form($formId1,\Lang::get('Operation.AddVendorFormTitle'));

        $m1=$m->finalReturnForTableFile() ;




        return $m1;
        dd($m);
    }

    public function getItemCatModel(){
        $m= new \MS\Core\Helper\MSDB('MS\Mod\B\Operation',implode('_',[self::$modCode,'MachineCat']));
        return $m;
    }
 public function getVendorModel(){
        $m= new \MS\Core\Helper\MSDB('MS\Mod\B\Operation',implode('_',[self::$modCode,'VendorMaster']));
        return $m;
    }

    public  function getItemCatExtraModel(){
        $m= new \MS\Core\Helper\MSDB('MS\Mod\B\Operation',implode('_',[self::$modCode,'MachineCatExtra']));
        return $m;
    }
    public  function getItemModel(){
        $m= new \MS\Core\Helper\MSDB('MS\Mod\B\Operation',implode('_',[self::$modCode,'MachineMaster']));
        return $m;
    }
    public  function getItemStockModel($perFix=''){
        $m= new \MS\Core\Helper\MSDB('MS\Mod\B\Operation',implode('_',[self::$modCode,'MachineStock']),[$perFix]);
        return $m;
    }

    //TODO Finish Below Methods

    private function add($data){
        $fdata=[];
        $req=['ItemName','ItemCatId','ItemMake'];
        $process=[
            'addEntryToItemTable'=>$data,
            'migrateTableForItemStock'=>$data,
            'addEntryToItemTableStock'=>$data,

        ];
        if(count($fdata)>0)foreach ($process as $method=>$methodData)$fdata[$method]=$this->$method($methodData);
        return $fdata;

    }
    private function edit($data){}
    private function delete($data){}


    private function addEntryToItemTable($d){
        $m=$this->getItemModel();
        return $m->rowAdd($d);
    }
    private function migrateTableForItemStock($d){
        $MachineCode=$d['UniqId'];
        $m=$this->getItemModel($MachineCode);
        return $m->migrate();
    }
    private function addEntryToItemTableStock($d){
        //TODO Finish This |||LAST||||
        $m=$this->getItemModel();
        return $m->rowAdd($d);
    }
}
