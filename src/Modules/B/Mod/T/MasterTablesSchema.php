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

$m->addGroup($fieldGroupName)->addField($fieldGroupName,['UniqId','Table']);

$m->addAction($actionId,$actionData);

$m->addForm($formId)->addTitle4Form($formId,$formTitle)->addGroup4Form($formId,[$fieldGroupName])->addAction4Form($formId,['add'])->addIcon4Form($viewId);
dd($m);
$m->addView($viewId)->addTitle4View($formTitle)->addGroup4View($viewId,['UniqId','Table'])->addAction4View($viewId,['add'])->addIcon4View($viewId)->addMassAction4View(['add'])->pagination4View('paginationLink');
$m->addLogin($loginId)->addTitle4Login($loginId,$formTitle)->addForm4Login($loginId,$formId);

//TODO Finish below method & Test // Important //
//dd($m);
return $m->finalReturnForTableFile();
