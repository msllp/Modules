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

$m->addGroup($fieldGroupName)->addField($fieldGroupName,['UniqId','Table']);
$m->addForm($formId)->addTitle4Form($formTitle)->addGroup4Form($formId,['UniqId','Table'])->addAction4Form($formId,['add'])->addIcon4Form($viewId);
$m->addView($viewId)->addTitle4View($formTitle)->addGroup4View($viewId,['UniqId','Table'])->addAction4View($viewId,['add'])->addIcon4View($viewId)->addMassAction4View(['add'])->pagination4View('paginationLink');
//TODO Finish below method & Test // Important //
//dd($m);
return $m->finalReturnForTableFile();
