<?php
$data=[
    'tableId'=>'ModTest',
    'tableName'=>'ModTableName',
    'connection'=>'MS_Core',
];
$m=new MS\Core\Helper\MSTableSchema($data);

$m->setFields(['name'=>'UniqId','vName'=>'ID','type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'Table','vName'=>'ID','type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

//TODO Finish below method & Test // Important //
$fieldGroupName='TestName';
$formId="testFormID";
$formTitle="testFormTitle";
$viewId="testViewId";

$actionId='add';
$actionData=[
    "btnColor"=>"bg-green",
    "route"=>"MOD.User.Master.Add.toDB",
    "btnIcon"=>"far fa-save",
    'btnText'=>"add root user"
];
$loginId='Tes';
$routeName='MOD.User.Master.Add.toDB';
$m->addGroup($fieldGroupName)->addField($fieldGroupName,['UniqId','Table']);

$m->addAction($actionId,$actionData);

$m->addForm($formId)->addTitle4Form($formId,$formTitle)->addGroup4Form($formId,[$fieldGroupName])->addAction4Form($formId,['add'])->addIcon4Form($formId,'msicon');

$m->addView($viewId)->addTitle4View($viewId,$formTitle)->addGroup4View($viewId,[$fieldGroupName])->pagination4View($viewId,'paginationLink')->addIcon4View($viewId,'msicon')->addAction4View($viewId,['add'])->addMassAction4View($viewId,['add']);

//dd($m);//;
$m->addLogin($loginId)->addTitle4Login($loginId,$formTitle)->addGroup4Login($loginId,[$fieldGroupName])->setPost4Login($loginId,$routeName)->setClientLogo($loginId,'images/logo_v1_black.svg');

//TODO Finish below method & Test // Important //

//dd($m);
//return $m->finalReturnForTableFile();


$data=[
    'tableId'=>'MasterCoreTable',
    'tableName'=>'Mod_Core_Table',
    'connection'=>'MS_Core',
];
$m=new MS\Core\Helper\MSTableSchema($data);

$m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'tableId','vName'=>\Lang::get('Core.tableId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'tableName','vName'=>\Lang::get('Core.tableName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

$m1=$m->finalReturnForTableFile();


$data=[
    'tableId'=>'MasterCoreTable_fields',
    'tableName'=>'Mod_Core_Table_Fields',
    'connection'=>'MS_Core',
];
$m=new MS\Core\Helper\MSTableSchema($data);

$m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'name','vName'=>\Lang::get('Core.fieldName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'vName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'type','vName'=>\Lang::get('Core.fieldType'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'input','vName'=>\Lang::get('Core.fieldInput'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'validation','vName'=>\Lang::get('Core.fieldValidation'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'dbOff','vName'=>\Lang::get('Core.fieldStoreToDB'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);


$m2=$m->finalReturnForTableFile();


$data=[
    'tableId'=>'MasterCoreTable_action',
    'tableName'=>'Mod_Core_Table_Action',
    'connection'=>'MS_Core',
];
$m=new MS\Core\Helper\MSTableSchema($data);

$m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'route','vName'=>\Lang::get('Core.actionRoute'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'btnText','vName'=>\Lang::get('Core.actionBtnText'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'btnIcon','vName'=>\Lang::get('Core.actionBtnIcon'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'btnColor','vName'=>\Lang::get('Core.actionBtnColor'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'routePara','vName'=>\Lang::get('Core.actionRoutePara'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'msLinkKey','vName'=>\Lang::get('Core.actionMsLinkKey'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'msLinkText','vName'=>\Lang::get('Core.actionMsLinkText'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'doubleConfirm','vName'=>\Lang::get('Core.actionDoubleConFirm'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'doubleConfirmText','vName'=>\Lang::get('Core.actionDoubleConFirmText'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'ownTab','vName'=>\Lang::get('Core.actionOwnTab'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

$m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);


$m3=$m->finalReturnForTableFile();


$data=[
    'tableId'=>'MasterCoreTable_MSforms',
    'tableName'=>'Mod_Core_Table_MSforms',
    'connection'=>'MS_Core',
];
$m=new MS\Core\Helper\MSTableSchema($data);

$m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'title','vName'=>\Lang::get('Core.msFormTitle'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'groups','vName'=>\Lang::get('Core.msFormGroups'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
$m->setFields(['name'=>'actions','vName'=>\Lang::get('Core.msFormAction'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

$m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);


$m4=$m->finalReturnForTableFile();


dd(array_merge($m1,$m2,$m3,$m4 ));
