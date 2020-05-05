<?php
namespace MS\Core\Helper;
//TODO Make table schema For Table
use phpDocumentor\Reflection\Types\Boolean;

class MSTableSchema {

    public $tableId,$tableName,$connection,
           $fields,$fieldGroup,$validationMessage,
           $fieldGroupMultiple,$action,
           $MSforms,$MSViews,$MSLogin;

    private $modId,$modNameSpcae;

    public static $allowedKeyTypes=['MSforms','MSViews','MSLogin','MasterTable','Field'];

    private static $allowedKeys=[
        'tableId'=>'tableId',
        'tableName'=>'tableName',
        'connection'=>'connection',
        'fields'=>'fields',
        'fieldGroup'=>'fieldGroup',
        'validationMessage'=>'validationMessage',
        'fieldGroupMultiple'=>'fieldGroupMultiple',
        'action'=>'action',
        'MSforms'=>'MSforms',
        'MSViews'=>'MSViews',
        'MSLogin'=>'MSLogin'


    ];

    private static $requireKeys=[
        'tableId'=>'Test',
        'tableName'=>'Test',
        'connection'=>'MS_Core',
        'fields'=>[
//            [
//            'name'=>'UniqId',
//            'vName'=>'ID',
//            'type'=>'string',
//            'input'=>'text',
//            "validation"=>['required'=>true,]
//        ]
        ],
    ];

    private static $allowedKeysFields=[
        'name','vName','type','input','validation'
    ];

    private static  $requireKeysFields=[
        'name','type'
    ];

    private static $dbType=[
        'Config'=>'Config',
        'Master'=>'Master',
        'Data'=>'Data',
    ];

    public function __construct($data=[]){
        foreach (self::$allowedKeys as $setName){
            if (array_key_exists($setName,$data))$this->$setName=$data[$setName];
        }
        foreach (self::$requireKeys as $key=>$dValue){
            if($this->$key==null)$this->$key=$dValue;
        }

    //dd($this);

    }



    public function finalReturnForTableFile(){
        $d=[];
        foreach (self::$allowedKeys as $setName){
            //var_dump($setName);
           // var_dump($this->$setName);
            if($setName !='tableId'){
                if(property_exists ( $this,$setName ) && $this->$setName !=null) $d[$this->getTableId()][$setName]=$this->$setName;
            }else{
                $d[$this->$setName]=[];
                //
            }

        }

        return $d;
    }

    public static function getTableDataFor($type,$namespace,$modCode){

        if(in_array($type,self::$allowedKeyTypes)){

            switch ($type){

                case 'MasterTable':
                    return self::getTableDataForTable($modCode);
                    break;
                case 'Field':
                    return self::getTableDataForField($modCode);
                    break;
                case 'MSViews':
                    return self::getTableDataForMSViews($modCode);
                    break;
                case 'MSLogin':
                    return self::getTableDataForMSLogin($modCode);
                    break;
                case 'MSforms':
                    return self::getTableDataForMSForms($modCode);
                    break;


            }

        }
    }

    public static function getTableDataForTable($modCode){
        $dbType=self::$dbType['Config'];
        $data=[
            'tableId'=>implode('_',[$modCode,'MasterCoreTable']),
            'tableName'=>implode('_',[$modCode,'Master_Core_Table']),
            'connection'=>implode('_',['MS',$modCode,$dbType]),
        ];
        $m=new self($data);
        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'tableId','vName'=>\Lang::get('Core.tableId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'tableName','vName'=>\Lang::get('Core.tableName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'FieldGroupMultiple','vName'=>\Lang::get('Core.tableName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m1=$m->finalReturnForTableFile();
        return $m1;
    }
    public static function getTableDataForField($modCode,$tableid=null,$tablename=null,$connection=null){
        $dbType=self::$dbType['Config'];
        $data=[
            'tableId'=> ($tableid!=null)? $tableid: implode('_',[$modCode,'MasterCoreTable_field']),
            'tableName'=>($tablename!=null)? $tablename:implode('_',[$modCode,'Master_Core_Table_field']),
            'connection'=>($connection!=null)? $connection:implode('_',['MS',$modCode,$dbType]),
        ];
        $m=new self($data);
        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'name','vName'=>\Lang::get('Core.fieldName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'vName','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'type','vName'=>\Lang::get('Core.fieldType'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'input','vName'=>\Lang::get('Core.fieldInput'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'validation','vName'=>\Lang::get('Core.fieldValidation'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'dbOff','vName'=>\Lang::get('Core.fieldStoreToDB'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m2=$m->finalReturnForTableFile();
        return $m2;
    }
    public static function getTableDataForAction($modCode){
        $dbType=self::$dbType['Config'];
        $data=[
            'tableId'=>implode('_',[$modCode,'MasterCoreTable_action']),
            'tableName'=>implode('_',[$modCode,'Master_Core_Table_action']),
            'connection'=>implode('_',['MS',$modCode,$dbType]),
        ];
        $m=new self($data);
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
        $m2=$m->finalReturnForTableFile();
        return $m2;
    }
    public static function getTableDataForMSForms($modCode){
        $dbType=self::$dbType['Config'];
        $data=[
            'tableId'=>implode('_',[$modCode,'MasterCoreTable_msForms']),
            'tableName'=>implode('_',[$modCode,'Master_Core_Table_msForms']),
            'connection'=>implode('_',['MS',$modCode,$dbType]),
        ];
        $m=new self($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'title','vName'=>\Lang::get('Core.msFormTitle'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'groups','vName'=>\Lang::get('Core.msFormGroups'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'actions','vName'=>\Lang::get('Core.msFormAction'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $m2=$m->finalReturnForTableFile();
        return $m2;
    }
    public static function getTableDataForMSViews($modCode){

        $dbType=self::$dbType['Config'];
        $data=[
            'tableId'=>implode('_',[$modCode,'MasterCoreTable_msViews']),
            'tableName'=>implode('_',[$modCode,'Master_Core_Table_msViews']),
            'connection'=>implode('_',['MS',$modCode,$dbType]),
        ];
        $m=new self($data);


        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'viewId','vName'=>\Lang::get('Core.msViewsTitle'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'title','vName'=>\Lang::get('Core.msViewsTitle'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'groups','vName'=>\Lang::get('Core.msViewsGroups'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'actions','vName'=>\Lang::get('Core.msViewsAction'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'icon','vName'=>\Lang::get('Core.msViewsIcon'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'massAction','vName'=>\Lang::get('Core.msViewsMassAction'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);

        $m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);


        $m2=$m->finalReturnForTableFile();
        return $m2;


    }
    public static function getTableDataForMSLogin($modCode){
        $dbType=self::$dbType['Config'];
        $data=[
            'tableId'=>implode('_',[$modCode,'MasterCoreTable_login']),
            'tableName'=>implode('_',[$modCode,'Master_Core_Table_login']),
            'connection'=>implode('_',['MS',$modCode,$dbType]),
        ];
        $m=new self($data);

        $m->setFields(['name'=>'UniqId','vName'=>\Lang::get('Core.UniqId'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'loginId','vName'=>\Lang::get('Core.fieldDisplayName'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'PageTitle','vName'=>\Lang::get('Core.fieldType'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'verifyBy','vName'=>\Lang::get('Core.fieldInput'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'loginPost','vName'=>\Lang::get('Core.fieldValidation'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'identifier','vName'=>\Lang::get('Core.fieldStoreToDB'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'checkID','vName'=>\Lang::get('Core.fieldStoreToDB'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'CompanyIcon','vName'=>\Lang::get('Core.fieldStoreToDB'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);
        $m->setFields(['name'=>'Status','vName'=>\Lang::get('Core.Status'),'type'=>'string','input'=>'text',"validation"=>['required'=>true,]]);


        $m2=$m->finalReturnForTableFile();
        return $m2;

    }


    public static function setUpForMod($modCode){
        $m1=\MS\Core\Helper\MSTableSchema::getTableDataForTable($modCode);
        $m2=\MS\Core\Helper\MSTableSchema::getTableDataForField($modCode);
        $m3=\MS\Core\Helper\MSTableSchema::getTableDataForAction($modCode);
        $m4=\MS\Core\Helper\MSTableSchema::getTableDataForMSForms($modCode);
        $m5=\MS\Core\Helper\MSTableSchema::getTableDataForMSViews($modCode);
        $m6=\MS\Core\Helper\MSTableSchema::getTableDataForMSLogin($modCode);
        $mf=array_merge($m1,$m2,$m3,$m4,$m5,$m6);
        return $mf;
    }


    public function addGroup($groupid){
        $fg=$this->getFieldGroup();
        if(is_array($fg) && !array_key_exists($groupid,$fg)){
            $fg[$groupid]=[];
        }elseif($fg==null){
            $fg=[$groupid=>[]] ;
        }
        $this->setFieldGroup($fg);
        return $this;
    }

    public function addField($groupId,$fields){
        $fg=$this->getFieldGroup();
        $f=collect($this->getFields());
        foreach ($fields as $field)
        if( is_array($fg)  &&
            ( array_key_exists($groupId,$fg) && $f->where('name','=',$field)->count()>0 )
            && !in_array($field,$fg[$groupId])
        )$fg[$groupId][]=$field;
        $this->setFieldGroup($fg);
        //dd($this);
        return $this;
    }

    public function addAction($acId,$acData){
            $ac=$this->getAction();
            if($ac==null)$ac=[];
        //    dd(!array_key_exists($acId,$ac));
            if(is_array($ac) && !array_key_exists($acId,$ac))
            {
                $ac[$acId]=$acData;
            }

            $this->setAction($ac);
            return $this;
    }

    public function addForm($formId){
        $mf=$this->getMSforms();
        if(is_array($mf) && !array_key_exists($formId,$mf)){
            $mf[$formId]=[];
        }elseif($mf==null){
            $mf=[$formId=>[]] ;
        }
        $this->setMSforms($mf);
        return $this;
    }
    public function addTitle4Form($formId,$title){
        $mf=$this->getMSforms();

        if(is_array($mf) && array_key_exists($formId,$mf) )$mf[$formId]['title']=$title;

        $this->setMSforms($mf);
        return $this;

    }

    public function addGroup4Form($formId,$groupId){
        $mf=$this->getMSforms();
        $fg=$this->getFieldGroup();
        //dd($formId);
        foreach ($groupId as $group)//dd(is_array($mf) && array_key_exists($formId,$mf) && array_key_exists($group,$fg));
        if(is_array($mf) && array_key_exists($formId,$mf) && array_key_exists($group,$fg) )$mf[$formId]['groups'][]=$group;
        $this->setMSforms($mf);
        return $this;


    }

    public function addAction4Form($formId,$actionId){
        $mf=$this->getMSforms();
        $fg=$this->getAction();
        if($fg==null)$fg=[];
        foreach ($actionId as $action)//dd($formId);
            //dd(is_array($mf) && is_array($fg) && array_key_exists($formId,$mf) && array_key_exists($action,$fg)  && ( array_key_exists('action',$mf[$formId]) or true ) );
            if(is_array($mf) && is_array($fg) && array_key_exists($formId,$mf) && array_key_exists($action,$fg) )$mf[$formId]['actions'][]=$action;
        $this->setMSforms($mf);
        return $this;
    }

    public function addIcon4Form($formId,$icon){
        $mf=$this->getMSforms();

        //dd($fg);

            if(is_array($mf) && array_key_exists($formId,$mf) )$mf[$formId]['icon']=$icon;
        $this->setMSforms($mf);
        return $this;
    }

    public function addView($viewId){
        $mf=$this->getMSViews();
        if(is_array($mf) && !array_key_exists($viewId,$mf)){
            $mf[$viewId]=[];
        }elseif($mf==null){
            $mf=[$viewId=>[]] ;
        }
        $this->setMSViews($mf);
        return $this;
    }

    public function addTitle4View ($viewId,$title){
        $mf=$this->getMSViews();

        if(is_array($mf) && array_key_exists($viewId,$mf) )$mf[$viewId]['title']=$title;

        $this->setMSViews($mf);
        return $this;
    }

    public function addGroup4View($viewId,$groupId){

          $mf=$this->getMSViews();
        $fg=$this->getFieldGroup();
//dd($fg);
        foreach ($groupId as $group)//dd(is_array($mf) && array_key_exists($formId,$mf) && array_key_exists($group,$fg));
        if(is_array($mf) && array_key_exists($viewId,$mf) && array_key_exists($group,$fg) )$mf[$viewId]['groups'][]=$group;
        $this->setMSViews($mf);
        return $this;
}

    public function pagination4View($viewId,$name){
        $mf=$this->getMSViews();
        $fg=$this->getFieldGroup();

        //dd($fg);

        if(is_array($mf) && array_key_exists($viewId,$mf) && !array_key_exists($viewId,$fg) ){$mf[$viewId]['paginationLink']=$name;$mf[$viewId]['pagination']=true;}else{$mf[$viewId]['pagination']=false;}
        $this->setMSViews($mf);
        return $this;
    }


    public function addIcon4View($viewId,$icon){
        $mf=$this->getMSViews();
        $fg=$this->getFieldGroup();
        //dd($fg);

        if(is_array($mf) && array_key_exists($viewId,$mf))$mf[$viewId]['icon']=$icon;
        $this->setMSViews($mf);
        return $this;
    }

    public function addAction4View($viewId,$actionId){
        $mf=$this->getMSViews();
        $fg=$this->getAction();
        if($fg==null)$fg=[];
        foreach ($actionId as $action)//dd($formId);
            //dd(is_array($mf) && is_array($fg) && array_key_exists($formId,$mf) && array_key_exists($action,$fg)  && ( array_key_exists('action',$mf[$formId]) or true ) );
            if(is_array($mf) && is_array($fg) && array_key_exists($viewId,$mf) && array_key_exists($action,$fg) )$mf[$viewId]['actions'][]=$action;
        $this->setMSViews($mf);
        return $this;
    }

    public function addMassAction4View($viewId,$actionId){
        $mf=$this->getMSViews();
        $fg=$this->getAction();
        if($fg==null)$fg=[];
        foreach ($actionId as $action)//dd($formId);
            //dd(is_array($mf) && is_array($fg) && array_key_exists($formId,$mf) && array_key_exists($action,$fg)  && ( array_key_exists('action',$mf[$formId]) or true ) );
            if(is_array($mf) && is_array($fg) && array_key_exists($viewId,$mf) && array_key_exists($action,$fg) )$mf[$viewId]['massAction'][]=$action;
        $this->setMSViews($mf);
        return $this;
    }

    public function addLogin($loginId){
        $mf=$this->getMSLogin();
        if(is_array($mf) && !array_key_exists($loginId,$mf)){
            $mf[$loginId]=[];
        }elseif($mf==null){
            $mf=[$loginId=>[]] ;
        }
        $this->setMSLogin($mf);
        return $this;
    }

    public function addTitle4Login($loginId,$title){
        $mf=$this->getMSLogin();
        if(is_array($mf) && array_key_exists($loginId,$mf) )$mf[$loginId]['title']=$title;
        $this->setMSLogin($mf);
        return $this;
    }
    public function setPost4Login($loginId,$routeName){
        $mf=$this->getMSLogin();
        if(is_array($mf) && array_key_exists($loginId,$mf) )$mf[$loginId]['loginPost']=$routeName;
        $this->setMSLogin($mf);
        return $this;
    }
    public function setClientLogo($loginId,$path){
        $mf=$this->getMSLogin();
        if(is_array($mf) && array_key_exists($loginId,$mf) )$mf[$loginId]['CompanyIcon']=asset($path);
        $this->setMSLogin($mf);
        return $this;
    }


    public function addGroup4Login($loginId,$groupId){
        $mf=$this->getMSLogin();
        $fg=$this->getFieldGroup();
        foreach ($groupId as $group)if(is_array($mf) && array_key_exists($loginId,$mf) && array_key_exists($group,$fg) )$mf[$loginId]['groups'][]=$group;
        $this->setMSLogin($mf);
        return $this;
    }

    public function makeGroupMultiple($id){
        $gMD=$this->getFieldGroupMultiple();
        $gd=$this->getFieldGroup();
        if($gMD==null)$gMD=[];
        if(array_key_exists($id,$gd) && !in_array($id,$gMD) )$this->setFieldGroupMultiple($id);
        return $this;
    }

    //TODO Make a function to get Data From Connected Tables
    public function connectWithTable($data,$identifier){
        if(is_object($data)){
        //TODO Make provision For Direct DB Class
        $this->proccessMSDBClassForData($data,$identifier);



        }elseif(is_array($data) && count($data)> 1 && array_key_exists('namespace',$data) && array_key_exists('tableId',$data) ){
            //TODO Make provision For Row Table Data
        }
    }

    private function proccessMSDBClassForData($data,$identifier){
        $m=$data;
        $mM=$m->getModel();
        $mM2=$mM;
        foreach ($identifier as $column=>$value)if(is_object($mM2))$mM2=$mM2->where($column,'=',$value);

    }
    /**
     * @return mixed
     */
    private function getTableId()
    {
        return $this->tableId;
    }

    /**
     * @param mixed $tableId
     */
    private function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }

    /**
     * @return mixed
     */
    private function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param mixed $tableName
     */
    private function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return mixed
     */
    private function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    private function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    private function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields=[])
    {
        $d=$this->filterFields($fields);

        if ($this->checkFields($d))$this->fields[] = $d;

    }

    private function checkFields($d) {
        if ((count($d)> (count(self::$requireKeysFields)-1) ) && collect($this->getFields())->where('name','=',$d['name'] )->count() <1  )return true;
        return false;
    }
    private function filterFields($d){
        $fD=[];
        foreach (self::$allowedKeysFields as $keName){
            if(array_key_exists($keName,$d)) $fD[$keName]=$d[$keName];
        }
        return $fD;
    }

    /**
     * @return mixed
     */
    private function getFieldGroup()
    {
        return $this->fieldGroup;
    }

    /**
     * @param mixed $fieldGroup
     */
    private function setFieldGroup($fieldGroup)
    {
        $this->fieldGroup = $fieldGroup;
    }

    /**
     * @return mixed
     */
    private function getValidationMessage()
    {
        return $this->validationMessage;
    }

    /**
     * @param mixed $validationMessage
     */
    private function setValidationMessage($validationMessage)
    {
        $this->validationMessage = $validationMessage;
    }

    /**
     * @return mixed
     */
    private function getFieldGroupMultiple()
    {
        return $this->fieldGroupMultiple;
    }

    /**
     * @param mixed $fieldGroupMultiple
     */
    private function setFieldGroupMultiple($fieldGroupMultiple)
    {
        $this->fieldGroupMultiple[] = $fieldGroupMultiple;
    }

    /**
     * @return mixed
     */
    private function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    private function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    private function getMSforms()
    {
        return $this->MSforms;
    }

    /**
     * @param mixed $MSforms
     */
    private function setMSforms($MSforms)
    {
        $this->MSforms = $MSforms;
    }

    /**
     * @return mixed
     */
    private function getMSViews()
    {
        return $this->MSViews;
    }

    /**
     * @param mixed $MSViews
     */
    private function setMSViews($MSViews)
    {
        $this->MSViews = $MSViews;
    }

    /**
     * @return mixed
     */
    private function getMSLogin()
    {
        return $this->MSLogin;
    }

    /**
     * @param mixed $MSLogin
     */
    private function setMSLogin($MSLogin)
    {
        $this->MSLogin = $MSLogin;
    }

    /**
     * @return mixed
     */
    private function getModId()
    {
        return $this->modId;
    }

    /**
     * @param mixed $modId
     */
    private function setModId($modId)
    {
        $this->modId = $modId;
    }

    /**
     * @return mixed
     */
    private function getModNameSpcae()
    {
        return $this->modNameSpcae;
    }

    /**
     * @param mixed $modNameSpcae
     */
    private function setModNameSpcae($modNameSpcae)
    {
        $this->modNameSpcae = $modNameSpcae;
    }

}
