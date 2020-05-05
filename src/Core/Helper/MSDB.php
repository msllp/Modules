<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 16-03-2019
 * Time: 02:09 AM
 */

namespace MS\Core\Helper;

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

//use Illuminate\Notifications\Notification;

class MSDB implements MasterNoSql
{


    public $model,$database,$masterNamespace,$e,$fTableName,$connection,$CurrentError,$MSmodel,$mod_Tables,$msData;

    /**
     * @return mixed
     */
    public function getFTableName()
    {
        return $this->fTableName;
    }

    /**
     * @param mixed $fTableName
     */
    public function setFTableName($fTableName)
    {
        $this->fTableName = $fTableName;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->MSmodel;
    }
    public $dataToProcess=[];
    public $currentFiles=[];
    public $ms_id="0";

    public $r=null;

    private $filePaths=[];

    public function __construct(string $nameSpace, string $id=null, array $perFix=[],array $tableData=[])
    {

       // dd(func_get_args());
        $nameSpace=$nameSpace;
        $base=$nameSpace."\B";
        $this->masterNamespace= $nameSpace;

        $this->ms_id=$id;
        $this->database=[
            'namespace'=>"\\".$nameSpace."\\M",
            'id'=>$id,
        ];


        if(count($perFix)>0 )$this->database['perfix']=$perFix;





//        if(array_key_exists('perfix',$this->database)) {
//            $this->model = new $this->database['namespace'] ($nameSpace, $id, $this->database['perfix']);
//        }else{
//            //  if('\MS\Mod\B\Users4O3\M'==$this->database['namespace'])     dd($this);
//            $this->model = new $this->database['namespace'] ($nameSpace, $id);
//        }
       // dd($nameSpace);
        //dd($this->model->ms_base);
        //parent::__construct($nameSpace, $id, $perFix);
        $baseNameSpace=implode('\\',['',$nameSpace,'b']);
        //$this->mod_Tables[$this->ms_id]=$this->model->ms_base::getTableArray($this->ms_id,$tableData);
        $this->mod_Tables[$this->ms_id]=$baseNameSpace::getTableArray($this->ms_id,$tableData);
        //   if(!is_array($this->mod_Tables))dd($this->mod_Tables);

        $connection=$this->getConnectionName();
      //  $tableName=$this->model->getTable();
        $tableName=$this->getTable();
        $this->fTableName=$tableName;
        $this->connection=$connection;
        $this->MSmodel =\DB::connection($connection)->table($tableName);


    }

    private function getConnectionName(){
        if($this->connection!=null)return $this->connection;
        return  $this->mod_Tables[$this->ms_id]['connection'];
    }

    private function getTable(){
        if($this->fTableName!=null)return $this->fTableName;
     $tableArray=   $this->mod_Tables[$this->ms_id];
    // dd($tableArray);
    $dv='_';
      $tableName=$tableArray['tableName'];
        if(array_key_exists('perfix',$this->database))return (implode($dv,[$tableName,implode($dv,$this->database['perfix'])]));
        return $tableName;
    }

    public function attachTableData($tableData){
    //    dd($tableData);

        if(is_array($this->mod_Tables) && array_key_exists($this->ms_id,$this->mod_Tables) && array_key_exists($this->ms_id,$tableData)){

            $this->mod_Tables[$this->ms_id]=$tableData[$this->ms_id];
          //  $this->model = new $this->database['namespace'] ( $this->masterNamespace, $this->ms_id,[],$tableData[$this->ms_id]);


            $connection=$this->getConnectionName();
            $tableName=$this->getTable();
            $this->fTableName=$tableName;
            $this->connection=$connection;
            $this->MSmodel =\DB::connection($connection)->table($tableName);

        }

    // dd($this);
        return $this;
    }




    private static $dbStore=['MS','DB','Master' ];

    private static $dbSource=['MS','DB','Master','blank','blank' ];

    private static $dbBackUpPath=['MS','DB','Master','backup', ];

    public $perPage=5;

    public function attachR($r){
        $this->r=$r;
        return $this;
    }

    /**
     * Static Raw drop Table Function
     * @param string $tableName
     * @param array $columnArray
     * @param string $tableConnection
     * @return bool
     */
    public static function makeTable(string $tableName, array $columnArray, string $tableConnection = "MSDB"): bool
    {


        try{

            if($tableConnection!="MSDB"){
                Schema::connection($tableConnection)->dropIfExists($tableName);


                Schema::connection($tableConnection)->create($tableName, function (Blueprint $table)use ($columnArray)  {
                    $table->increments('id');
                    foreach ($columnArray as $value) {

                        if(array_key_exists('name',$value) && array_key_exists('name',$value) )
                          if(!array_key_exists('type',$value))$value['type']='string';

                        if(!(array_key_exists('dbOff',$value) && $value['dbOff'] ) )self::makeTableColumnWhenTableMaking($table,$value['name'],$value['type']);
                    }

                    $table->timestamps();
                    // dd($table);
                });
            }else{
                Schema::dropIfExists($tableName);
                Schema::create($tableName, function (Blueprint $table) use ($columnArray) {
                    $table->increments('id');
                    foreach ($columnArray as $value) {

                        self::makeTableColumnWhenTableMaking($table,$value['name'],$value['type']);
                    }
                    $table->timestamps();
                });
            }

        }catch(Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $tableClass
     * @param string $columnName
     * @param string $columnType
     * @param string $defaultValue
     * @return bool
     */
    public static function makeTableColumnWhenTableMaking($tableClass, string $columnName, string $columnType = "string", $defaultValue = ""): bool
    {
       //  dd($tableClass);
        switch ($columnType) {
            case 'boolean':
                $tableClass->boolean($columnName)->default(false);
                break;
            case 'integer':
                $tableClass->integer($columnName)->default(0);
                break;

            case 'blob':
                $tableClass->binary($columnName);
                break;


            default:
                if(($defaultValue !=" ") or ($defaultValue !="")){
                    $tableClass->string($columnName)->default($defaultValue);
                }else{
                    $tableClass->string($columnName)->nullable();
                }
                break;
        }
        return true;
    }

    /**
     * Static Raw drop Table Function
     * @param string $tableName
     * @param string $tableConnection
     * @return bool
     */
    public static function deleteTable(string $tableName, string $tableConnection = "MSDB"): bool
    {
        //dd( Schema::connection($tableConnection)->drop($tableName));
        try{
            Schema::connection($tableConnection)->drop($tableName);
        }catch (Exception $e){return false;}
        return true;
    }

    /**
     * Static drop Module Table Function
     * @param bool $namespace
     * @param bool $id
     * @param bool $perFix
     * @return bool|mixed
     */
    public static function dropTable($namespace=false, $id=false, $perFix=false){
        $baseName="\\".$namespace."\\B";
        if(!$id)$id= array_key_first($baseName::$tables);
        if (is_array($perFix)){
            $m=new self($namespace,$id,$perFix);
        }else{
            $m=new self ($namespace,$id);
        }
        return $m->delete();
    }

    /**
     * @param bool $id
     * @param bool $perFix
     * @return bool
     */
    public function checkTableExist($id=false, $perFix=false):bool{

            //$connection=$this->model->getConnectionName();
            $connection=$this->getConnectionName();
            $table=$this->getTable();

        return Schema::connection($connection)->hasTable($table);
    }

    /**
     * Create Module Table
     * @param bool $id
     * @param bool $perFix
     * @return bool
     */

    public static function massMigrate($namespace,$id,$perFix=[]){

        if ( is_array($id)  ){


            if(count($perFix)>0){

            }else{

                foreach ($id as $name){
                    $m=new Self($namespace,$name,$perFix);
                    $m->migrate();
                }

            }


        }else {


            $m=new Self($namespace,$id,$perFix);
            $m->migrate();


        }
    return true;

    }

    public function migrate($id=false, $perFix=false):bool {


        if ( (is_array($id) && is_array($perFix)) && ( count($id) == count($perFix) ) ){


        }else{


            $table=$this->getTable();
            $connection=$this->getConnection();
            $fields=$this->mod_Tables[$this->ms_id]['fields'];


        }

    //    dd($this->checkTableExist($id,$perFix));
        if(!$this->checkTableExist($id,$perFix)){
            return self::makeTable($table,$fields,$connection);
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }


    /**
     * Delete Module Table
     * @return bool
     */
    public function delete():bool {

        $table=$this->getTable();
        $connection=$this->getConnectionName();
        return self::deleteTable($table,$connection);


    }

    /**
     * Add Row to desired Database
     * @param array $columnArray
     * @param array $uniqArray
     * @return bool
     */

    public function rowAll(){
        $foundRow=$this->MSmodel->get()->toArray();

        if($foundRow>0){

            $mapFunction=function ($array){
                return (gettype($array) == 'object')?(array)$array:$array;
            };
            return  array_map($mapFunction,$foundRow);
        }

        return [];

    }
    public function rowAdd(array $columnArray, array $uniqArray=[], bool $debug=false):bool
    {

        if(!array_key_exists('created_at',$columnArray))$columnArray['created_at']=now()->toDateTimeString();



        $columnArray= $this->makeRowSafe($columnArray);

        try{



            $connection=$this->getConnectionName();
            $table=$this->getTable();


           // if(array_key_exists('RouteCode',$columnArray))    dd($table);
            $tableName=$table;
            // $connection=$this->database['namespace']::getConnection($this->database['id']).$this->database['perfix'];

            $fieldCollection=collect($this->mod_Tables[$this->ms_id]['fields']);


            $fields=$this->mod_Tables[$this->ms_id]['fields'];
            foreach ($fields as $input){

                if(!array_key_exists('dbOff',$input))$input['dbOff']=false;
                if(array_key_exists('dbOff',$input)  && !$input['dbOff'] ) {



                    if(array_key_exists('validation',$input) && is_array($input['validation']) ){
                        if( array_key_exists('unique',$input['validation']) && $input['validation']['unique']){
                            $uniqArray[$input['name']]=$input;
                        }

                        //  var_dump(array_key_exists('unique',$input['validation']));
                    }

                   if(array_key_exists('input',$input)) switch ($input['input']){
                        case 'generated':
                            goto fn_auto;
                            break;

                        case 'locked':
                            fn_auto:
                            if(!array_key_exists($input['name'],$columnArray) && array_key_exists('callback',$input)){
                                $sClass=implode('\\',[ $this->masterNamespace,'F']);

                                $sMethod="::".$input['callback'];
                                $columnArray[$input['name']]=call_user_func($sClass . $sMethod);

                            }
                            break;



                    }



                }





            }

           // dd("adfss");


            $valdationError=0;

           //  if ($debug)dd($debug."dasdasd");
            if(count($uniqArray)>0){

                $valdationError=true;
                $model=\DB::connection($connection)->table($tableName);
                $valdationErrorArray=[];

                foreach ($uniqArray as $name =>$data){
                    $name=$data;
                   // if(array_key_exists('RouteCode',$columnArray))dd($tableName);
                    //var_dump($data);
                 //   dd(array_key_exists($name,$columnArray));
                    if(array_key_exists($name,$columnArray)){
                        $model=\DB::connection($connection)->table($tableName);
                     //   dd($model);
                        $model=$model->where($name,$columnArray[$name]);

                      //  dd($model);
                        //dd($model->get()->count());
                        if($model->get()->count() > 0){

                            $valdationErrorArray[$name]="Duplicate Found for Column name: ".$name ." \n Error casued by class::method = ".__METHOD__;
                        }
                     //   if($name=="Username")dd(($model->get()->count()));
                    }


                }

                if($valdationError==true)if(count($valdationErrorArray) < 1 )$valdationError=false;
              //  if($valdationError==true)dd($valdationErrorArray);
            }

             if($valdationError==true)goto ms_error_found;
            if($valdationError==false) {

                return $this->getModel()->insert($columnArray);
            }

        }
        catch (\Exception $e){
           // dd($e);
            ms_error_found:
           if(1){
              if(isset($valdationErrorArray)){
                  if(count($valdationErrorArray)>0) $er['validationArray']=$valdationErrorArray;
              }
          //    dd($er);

          }
       //     if($debug)dd($e);
          //  if(array_key_exists('RouteCode',$columnArray))   dd($valdationError );
            goto ms_final_return;



        }



        ms_final_return:
        //dd($valdationError);
        //if(count($er)>0)dd($valdationError==true);
        if(!isset($valdationError))$valdationError=true;
        if($valdationError==true)return false;
        return true;

        // TODO: Implement rowAdd() method.
    }

    private function makeRowSafe($array){

        $rArray=[];
        foreach ($array as $k=>$v){

            //var_dump($k.": ");
            //var_dump(gettype($v));
           // if($k == 'test10')   dd($this->r->hasFile($k));
            switch (gettype($v)){
                case 'integer':
                    $rArray[$k]=$v;
                    break;
                case 'double':
                    $rArray[$k]=$v;
                    break;
                case 'NULL':
                   // dd($k);
                   // $rArray[$k]=(string)"";
                    break;
                case 'object':
                   // dd($v);
                    $rArray[$k]=(string)collect($v->toArray())->toJson();
                    break;
                case 'string':
                   // dd($v);
                    if($v!="")$rArray[$k]=(string)$v;
                    break;
                case 'boolean':
                    ($v)?$rArray[$k]=true:$rArray[$k]=false;
                    break;
                case 'array':

                    //dd($this->r->hasFile($k));
                    if(($this->r !="") && $this->r->hasFile($k) ){



                        $fileData=[];



                        if(array_key_exists('length',$v)){
                            if($v[0]->isValid()){
                                $fileData[]=$this->storeFileFromRequest($v[0],$k);

                            }
                        }else{

                            foreach ($v as $k1=>$v1){
                                if(gettype($v1) == 'string')dd($k1);
                                //dd($v1->isValid());
                                //dd($v);
                                if($v1->isValid()){
                                    $fileData[]=$this->storeFileFromRequest($v1,$k);

                                }
                            }

                        }



                        $rArray[$k]=(string)collect($fileData)->toJson();

                    }else{
                        $rArray[$k]=(string)collect($v)->toJson();
                    }

                    break;
            }


        }

        if(!array_key_exists('updated_at',$array))$rArray['updated_at']=now()->toDateTimeString();
       return $rArray;

    }

    ///File Store Functions START
    private function getArrayFromString($str,$type=1){
        $returnData=[];
        switch ($type){
            case 1 : // storeTo => Path to Save File
                //dd($str);
                $ex1=explode(':',$str);
                $path['driver']=$ex1[0];
                $ex2=explode('->',$ex1[1]);
                $path['filename']=last($ex2);
                //dd($ex2);
                unset($ex2[array_key_last($ex2)]);
               // dd($this->dataToProcess);
                if(array_key_exists($path['filename'],$this->dataToProcess)){

                    $path['filename']=$this->dataToProcess[$path['filename']];
                }
                $ex3=explode('.',$ex2[0]);
                foreach ($ex3 as $k1=>$v1){
                    if(array_key_exists($v1,$this->dataToProcess)){
                        $ex3[$k1]=$this->dataToProcess[$v1];
                    }
                }
                $path['path']=implode("/",$ex3);

                $returnData=$path;
                break;
        }

        return $returnData;
    }
    private function storeFileFromRequest($file,$inputName){

        //dd($inputName);

            //dd(collect($this->model->base_Field)->where('name',$inputName."0")->first());
        $inputData=collect($this->mod_Tables[$this->ms_id]['fields'])->where('name',$inputName);
      //  dd($inputData->count());
            if(($inputData->count()>0) && array_key_exists('storeTo',$inputData->first())){
                $inputData=$inputData->first();
                $storeTo=$inputData['storeTo'];

                $storeData=$this->getArrayFromString($inputData['storeTo']);
                //dd();


                $storeData['filename'].='.'.$file->getClientOriginalExtension();
                //dd(Storage::disk($storeData['driver'])->exists(implode("/",[ str_replace('\\','/',$storeData['path']),$storeData['filename'] ])));
                if(Storage::disk($storeData['driver'])->exists(implode("/",[ str_replace('\\','/',$storeData['path']),$storeData['filename'] ]))){
                    //dd($storeData);
                    $storeData=$this->FileNameExistSoChangeTheFileName($storeData);
                }
                $file->storeAs($storeData['path'], $storeData['filename'], $storeData['driver']);
                $this->filePaths[]=$storeData;
                return $storeData;
                //dd($file->storeAs($storeData['path'], $storeData['filename'].'.'.$file->getClientOriginalExtension(), $storeData['driver']));
            }


    }
    private function FileNameExistSoChangeTheFileName($fileData){

        $ex1=explode(".",$fileData['filename']);
        $name=$ex1[0];
        $ext=$ex1[1];

        $x=1;
            while(Storage::disk($fileData['driver'])->exists(implode("/",[ str_replace('\\','/',$fileData['path']),$fileData['filename'] ]))){
                $name=explode('_',$name)[0]  ."_".$x;
                $filname=implode('.',[$name,$ext]);

                //var_dump($x);
                $fileData['filename']=$filname;
               // var_dump();
                $x++;
            }
        return $fileData;


}
    ///File Store Functions END

    ///Table Functions START
    /**
     * Edit Row From any valid Column Value
     * @param array $identifier
     * @param array $columnArray
     * @return bool
     */
    public function rowEdit(array $identifier, array $columnArray):bool
    {
        // TODO: Implement rowEdit() method.
        $connection=$this->getConnectionName();
        $table=$this->getTable();
        $fields=$this->mod_Tables[$this->ms_id]['fields'];
        if(!array_key_exists('updated_at',$columnArray))$columnArray['updated_at']=now()->toDateTimeString();
        if(count($identifier) > 1){
           // dd(reset($identifier));
            //$objFields=collect($fields)->where(array_key_first($identifier),reset($identifier) );
           // dd($objFields);
            $m2=  \DB::connection($connection)->table($table);
            $mf=null;
            foreach ($identifier as $k=>$v){
                $m3=$mf->where($k,$v)->get();
                if($m3->count() > 0 ){
                    $mf=$mf->where($k,$v);
                }else{
                    return false;
                }
            }

            if($mf!=null){
                $mf->update( $columnArray);
                return true;
            }
                return false;
        }else{

            $objFields=collect($fields)->where('name',array_key_first($identifier))->count();
            if ($objFields > 0){

                \DB::connection($connection)->table($table)->where(array_key_first($identifier),reset($identifier))->update( $columnArray);
                return true;
            }

        }

        return false;
    }

    /**
     * Delete Row From any valid Column Value
     * @param array $identifier
     * @return bool
     */
    public function rowDelete(array $identifier):bool
    {
        $connection=$this->getConnectionName();
        $table=$this->getTable();
        $fields=$this->mod_Tables[$this->ms_id]['fields'];

        if(count($identifier) < 2){
            //dd(reset($identifier));
            goto a;
            //$objFields=collect($fields)->where(array_key_first($identifier),reset($identifier) );
        }else{
            a:
            $objFields=collect($fields)->where('name',array_key_first($identifier))->count();
            if ($objFields > 0){
            \DB::connection($connection)->table($table)->where(array_key_first($identifier),reset($identifier))->delete();
                return true;
            }

        }

        return false;

    }

    /**
     * Get Row From any valid Column Value
     * @param array $identifier
     * @return array
     */
    public function rowGet(array $identifier=[]): array
    {
        $connection=$this->getConnectionName();
        $table=$this->getTable();
        $fields=$this->mod_Tables[$this->ms_id]['fields'];


        $return=[];
        if(count($identifier) > 1){

            $row=\DB::connection($connection)->table($table);

            foreach ($identifier as $n=>$v){
                if($row->count()>0)
                $row=$row->where($n,$v);
            }

            if($row->count()>0)$return=$row->get()->map(function ($item){
                return json_decode(json_encode($item),true);
            })->toArray();



        }
        elseif(count($identifier) < 1) {


            $row=\DB::connection($connection)->table($table)->get();

            if ($row->count() > 0)$return=collect($row->all())->map(function ($item){
                return json_decode(json_encode($item),true);
            })->toArray();
            goto fn_final;
        }elseif(count($identifier) == 1) {
            ms_default:
            $objFields=collect($fields)->where('name',array_key_first($identifier))->count();
          //  dd($objFields);
            if ($objFields > 0){
                $row=\DB::connection($connection)->table($table)->where(array_key_first($identifier),reset($identifier))->get();
                if ($row->count() > 0)$return=$row->map(function ($item){
                    return json_decode(json_encode($item),true);
                })->toArray();
                goto fn_final;
            }
        }

        fn_final:
        return $return;

    }
    ///Table Functions END

    public function getAllTable(string $connection=null):array {
        if($connection !=""){
            return \DB::connection($this->getConnectionName())->getDoctrineSchemaManager()->listTableNames();
        }

    }

    ///View Functions START
    private function getPerFix(){
        $perFix="";
        if(array_key_exists('perFix',$this->database) && (count($this->database['perFix']) > 0) ){
            $perFix=implode('_',$this->database['perFix']);
        }
        return $perFix;
    }

    public function editForm($formId=null,array $data=[]){
        $perFix=$this->getPerFix();
        $this->database['formData']=$data;
        $f=new \MS\Core\Helper\MSForm($this->masterNamespace,$this->database['id'],$perFix,['formID'=>$formId,'formData'=>$data]);
        return $f->fromModel($this)->view();
    }

    public function displayForm($formId=null,$data=[]){

        if($formId != null){
            $f=new \MS\Core\Helper\MSForm($this->masterNamespace,$this->database['id'],null,['formID'=>$formId]);
        }else{
            $f=new \MS\Core\Helper\MSForm($this->masterNamespace,$this->database['id']);
        }


       return $f->fromModel($this)->view();
    }

    public function getDisplayFormArray($formId=null,$data=[]){
        if($formId != null){
            $f=new \MS\Core\Helper\MSForm($this->masterNamespace,$this->database['id'],null,['formID'=>$formId]);
        }else{
            $f=new \MS\Core\Helper\MSForm($this->masterNamespace,$this->database['id']);
        }
        return $f->fromModel($this)->viewRaw();
    }

    public function viewData($viewId=null){

        if($viewId != null){

            $f=new \MS\Core\Helper\MSTable($this->masterNamespace,$this->database['id'],null,['viewID'=>$viewId]);
        }else{
            $f=new \MS\Core\Helper\MSTable($this->masterNamespace,$this->database['id']);
        }
        //dd($f);

        return $f->fromModel($this)->view();
    }
    ///View Functions END

    public function notify(){

        $tableData=$this->getNotifyDetailsFromArray();
        $dataOut=[];

        if ( isset($this->msData) && count($this->msData) >  0){

            foreach($this->msData as $row) {

                foreach ($tableData as $dKey=>$dValue){
                    $explode=explode('.',$dValue);

                    if(count($explode)< 2){
                        if($dValue!=null && $dValue!=" ")
                            if($row->$dValue!=null && $row->$dValue!="" )
                            $dataOut[$dKey]=$row->$dValue;
                    }
                    else{
                       $str=[];

                        foreach ($explode as $multistr){
                            //dd($row->$multistr);
                            $str[]=$row->$multistr;
                        }
                        $dataOut[$dKey]=implode(' ',$str);
                    }

                }




                \Notification::route('mail', $dataOut['mail'])
                    ->notify(new \MS\Core\Notification\Master($dataOut));
            }

        }
        dd($dataOut);

        //;
    }


    public function getNotifyDetailsFromArray(){

        $notificationArray=[];
        if(array_key_exists('notification',$this->mod_Tables[$this->ms_id]))$notificationArray=$this->mod_Tables[$this->ms_id]['notification'];
       // dd($notificationArray);
        return $notificationArray;


    }

    private function filterData($data){

        $fData=[];
        foreach ($data as $k=>$v ){

            if($v!='null' && $v!='' && $v!=' ')$fData[$k]=$v;
        }
       // dd($fData);
        return $fData;
    }

    public function checkRulesForData($r=null){

        if($r==null)$r=$this->r;

        $data= $this->filterData($r->all());
        $this->dataToProcess=$data;

        if(count($this->dataToProcess) > 0){
            $r=$this->dataToProcess;
        }else{
            $r=$r->all();
        }

        $b=implode('\\',[$this->masterNamespace,'B']);

       $rules= $b::getAllRules($this->ms_id);

       //dd($b::getAllMessage($this->ms_id,$rules));
       //foreach ()
        //displayFromdd($b::getAllAttr($this->ms_id,$rules));
        $message=$b::getAllMessage($this->ms_id,$rules);
      //  dd($message);
        $attr=$b::getAllAttr($this->ms_id,$rules);
//dd($this->makeRulesForValidation($rules))

       // dd($r->validate($this->makeRulesForValidation($rules),$message,$attr));

        $validator = Validator::make( $data,$this->makeRulesForValidation($rules),$message,$attr);

        //$validator->passes();
        //dd($validator->errors());
        $e=$validator->errors();
        $this->CurrentError=$e;
        //dd(count($e));
       // dd($e);
        $this->dataToProcess=$data;
      //  $this->e=$e;
        if(count($e)< 1){
            return true;
        }
        return false;
        dd($validator->errors());
        //if()





    }

    public function toJson(){

        $c=collect($this->dataToProcess)->toJson();
        return $c;
    }
    public function toArray(){

        //$c=collect($this->dataToProcess)->toJson();
        return $this->e;
    }

    public function errors(){

        return [ 'errors'=> $this->toArray()];
    }


    private function makeRulesForValidation($data){

        $outArray=[];
        foreach ($data as $inputName=>$inputRules){


           // $inputRules=  array_merge(['bail'],$inputRules);
            //var_dump($inputRules);
         //   switch ( $iputRules)
            $ruleAdded=0;
            //var_dump($inputRules);
            if (in_array('required',$inputRules)){
         //     unset($inputRules[array_search('required',$inputRules)]);
           //     $inputRules=array_merge($inputRules,['required']);
              //  dd( $inputRules);
                $outArray[$inputName]=implode('|',$inputRules);
                $ruleAdded=1;
            }
            if(!$ruleAdded)$outArray[$inputName]=implode('|',$inputRules);
        }

       // dd($outArray);
        return $outArray;

    }

    public static function getDBPath($path=[]){
        $dbPath=self::$dbStore;
        if(count($path)>0)foreach ($path as $row)$dbPath[]=$row;
        return base_path( implode(DS,self::$dbStore) );
    }
    public static function getBlankDBPath(){
        return base_path( implode(DS,self::$dbSource) );
    }
    public static function getBackDBPath(){
        $d=[Carbon::now()->timestamp];
        $path=array_merge(self::$dbBackUpPath,$d);
        $path=base_path( implode(DS,$path ));
       // dd($path);
        mkdir($path);
        return  $path;
    }
    public static function makeDB(string $name,array $path=[]){
        $path['storePath']=implode(DS,[self::getDBPath($path),$name]) ;
        $path['sourcePath']=self::getBlankDBPath();
        return copy ( $path['sourcePath'],  $path['storePath'] );
    }

    public static function deleteDB(string $name,array $path=[]){
        if(!self::checkDB($name,$path))return false;
        $path['sourcePath']=implode(DS,[self::getDBPath($path),$name]) ;
        return unlink($path['sourcePath']);
    }

    public static function checkDB(string $name,array $path=[]){
        $path['sourcePath']=implode(DS,[self::getDBPath($path),$name]) ;
        return file_exists($path['sourcePath']);
    }

    public static function backUpDB(string $name=null){
        $path['storePath']=implode(DS,[self::getDBPath(),$name]) ;
        $path['backUpPath']= implode(DS,[self::getBackDBPath(),$name]) ;
        return copy ($path['storePath'], $path['backUpPath']);
    }


    public function ForPagination($page){
        $input=$page->all();
        $data=[];
        $page=$input['page'];
      //  dd($input);
        if(array_key_exists('perpage',$input))$this->perPage=$input['perpage'];
        if(array_key_exists('page',$input) && array_key_exists('q',$input) &&  array_key_exists('by',$input) ){

            $data['fromV']= [
                // 'tableTitle'=>"",
                // 'tableColumns'=>[],
                'tableData'=>$this->MSmodel->where($input['by'],'like',"%".$input['q']."%")->latest()->paginate( $this->perPage, ['*'], 'page', $page )
            ];
           // dd($data);

        }elseif (array_key_exists('page',$input) ){
            $data['fromV']= [
                // 'tableTitle'=>"",
                // 'tableColumns'=>[],
                'tableData'=>$this->MSmodel->latest()->paginate( $this->perPage, ['*'], 'page', $page )
            ];
        }





        return response()->json(  $data ,200);
       // return $this->MSmodel->paginate( 1, ['*'], 'page', $page );
    }


    public function add(){
        if(count($this->dataToProcess)>0){
            return $this->rowAdd($this->dataToProcess);
        }else{
            return false;
        }

    }
    public function jsonOutNext($t,$nextData=[],$e=[]){
        $valid=0;
        if(count($nextData) < 3)$nextData=\MS\Core\Helper\Comman::makeNextData('Home','Default Page',route('MOD.User.Master.View.All'));
        foreach ($t as $t=>$s){
            if(!$s)$e[$t]=$s;
        }

        if(count($e)==0)$valid=1;
        if($valid){
            return response()->json(['ms'=>[

                'status'=>200,
                'ProcessStatus'=>$t,
                'nextData'=>$nextData

            ]],200);
        }
        else{
            return self::jsonOutError($e);
        }

    }
    public function jsonOut($t,$nextData=[],$e=[]){
        $valid=0;
        if(count($nextData) < 3)$nextData=\MS\Core\Helper\Comman::makeNextData('Home','Default Page',route('MOD.User.Master.View.All'));
        foreach ($t as $t=>$s){
            if(!$s)$e[$t]=$s;
        }
      //  dd($e);
        if(count($e)==0)$valid=1;
        if($valid){
            return response()->json(['ms'=>[

                'status'=>200,
                // 'Rdata'=> $r->input(),
                'ProcessStatus'=>$t,
                'nextData'=>$nextData

            ]],200);
        }
        else{
            return self::jsonOutError($e);
        }

    }


    public function jsonOutError($e=[],$errcode=418){
        return response()->json([
                'errorsRaw' => implode(' , ',$e),
            ],$errcode);
    }

    public function processForSave($r,$d=[],$tasks=[],$nextData=[]){

        $m=$this;
        $m->attachR($r);
        // $m->migrate();
        $d1=$r->all();
        $valid=true;
        $valid=$m->checkRulesForData();

        foreach ($d as $k=>$v){
            $d1[$k]=$v;
            }
        $d=$d1;

        if($valid){

            //F::makeUser($r,$m);

            return response()->json(['ms'=>[

                'status'=>200,
                // 'Rdata'=> $r->input(),
                'ProcessStatus'=>$tasks,
                'nextData'=>$nextData

            ]],200);
        }
        else{
            return response()->json([
                'errors' => $m->CurrentError
            ],418);
        }


    }

    public function loginPage($Id=null){
        //TODO: Complete this for login page
        $tableArray=$this->mod_Tables[$this->ms_id];
        ($Id == null  && array_key_exists('MSLogin',$tableArray) )?$LoginId= array_key_first ($tableArray['MSLogin']):$LoginId=$Id;



        if( array_key_exists('MSLogin',$tableArray)  && array_key_exists($LoginId,$tableArray['MSLogin'])){
            $lData=$tableArray['MSLogin'][$LoginId];
        }else{
       // dd($this);
           return $this->jsonOutError(['No Login Page Found'],404);
        }

        $loginPage=new MSLogin($this,$lData);
        return $loginPage->displayLoginPageFromMSDB();
    }

}
