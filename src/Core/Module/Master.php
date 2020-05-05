<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 16-03-2019
 * Time: 04:18 AM
 */

namespace MS\Core\Module;


class Master implements BaseMaster
{

    public static $routeTableHook=[

        'name'=>'RouteName',
        'route'=>'RouteUrl',
        'method'=>'RouteMethod',
        'type'=>'RouteType',

    ];

    public static $ds=DIRECTORY_SEPARATOR;

    public static function getBasics(){
        $return=[
            'dbList'=>[],
            'basePath'=>null
        ];
        $ex=explode('\\',static::$controller);
        $end=explode('\\',static::$controller)[0];
        $module=explode('\\',static::$controller)[1];
        $modulePath=[base_path(),'MS',$end,'M',$module,'T'];
        $moduleDBPath=implode(self::$ds,$modulePath);
        $return['basePath']=implode(self::$ds,$modulePath);


        if(count($return['dbList'])<1 && (count(explode('\\',static::$controller)) > 3) ){
            //dd(explode('\\',static::$controller));

            $end=explode('\\',static::$controller)[2];
            $module=explode('\\',static::$controller)[3];
            $modulePath=[base_path(),'vendor','msllp','modules','src','Modules',$end,$module,'T'];
            $moduleDBPath=implode(self::$ds,$modulePath);
            $return['basePath']=implode(self::$ds,$modulePath);
           // dd($return);
            //dd(is_dir($moduleDBPath));
        }
        if(!is_dir($moduleDBPath))return $return;

        $return['dbList']=array_diff( scandir($moduleDBPath),['.','..']);

        return $return;
    }

    public static function getModuleTables(){

            $base=self::getBasics();

        $return=[];
        $returnArray=[];
        $allExistDB=$base['dbList'];
        $moduleDBPath=$base['basePath'];

        foreach ($allExistDB as $fileName){

            $dbData= include (implode(self::$ds,[$moduleDBPath,$fileName]));


           if(is_array($dbData)) foreach ($dbData as $tableID=>$tableDetails){
                if(!array_key_exists($tableID,$returnArray))$returnArray[$tableID]=$tableDetails;
            }

        }
       // dd($return);
        $return=array_merge(  static::$tables,$returnArray);

      return $return;
    }

    public static function getTable($tableID=false,$perFix=false):string
    {

        $table= self:: getModuleTables() ;
        if(!$tableID)$tableID=array_key_first($table);

        if(array_key_exists($tableID,$table)){

            if(substr($table[$tableID]['tableName'], -1)=="_"){

                if(is_array($perFix)){
                    return $table[$tableID]['tableName'].implode("_",$perFix);
                }else{
                    return $table[$tableID]['tableName'].$perFix;
                }

            }

            return $table[$tableID]['tableName'];
        }
        if(count($table) > 0){
            return reset($table)['tableName'];
        }
        return"No Module Table Found";

    }
    public static function getTableArray($tableID=false,$tableData=[]):array
    {

        $table= self:: getModuleTables() ;
        if(count($tableData) > 0)$table=array_merge($table,$tableData);
     //   dd($tableID);

        if(!$tableID)$tableID=array_key_first($table);

        if(array_key_exists($tableID,$table)){


            return $table[$tableID];
        }
        if(count($table) > 0){
            return [];
            return reset($table);
        }
        return"No Module Table Found";

    }


    public static function getConnection($tableID=false):string
    {
        $table= self:: getModuleTables() ;

        if(!$tableID)$tableID=array_key_first($table);
        if(array_key_exists($tableID,$table)){
            return $table[$tableID]['connection'];
        }
        if(count($table) > 0){
            return reset($table)['connection'];
        }
        return"No Connection Found";
    }

    public static function getField($tableID=false):array
    {
        $table= self:: getModuleTables() ;

        if(!$tableID)$tableID=array_key_first($table);
        if(array_key_exists($tableID,$table)){
            return $table[$tableID]['fields'];
        }
        if(count($table) > 0){
            return reset($table)['fields'];
        }
        return ["No Connection Found"];
    }

    public static function getRoutes(){
        return static ::$route;
    }

    public static function getAction($tableID=false) :array {
        $table= self:: getModuleTables() ;

        if(!$tableID)$tableID=array_key_first($table);
      //  dd($tableID);
        if(array_key_exists($tableID,$table)){
          //  dd($table[$tableID]['action']);
            if(!array_key_exists('action',$table[$tableID]))return [];
            return $table[$tableID]['action'];
        }
        if(count($table) < 1){
            if(array_key_exists('action',$table))return reset($table)['action'];
        }
        return [];
    }

    public static function testAllModRoutes($class ){

        $allRoute=self:: getRoutes();
        $k=0;
        $resData=[];
        $resDataError=[];
        $error=0;
        foreach ($allRoute as $route){

            switch ($route['type'])
            {
                case 'get':
                    $res= $class->get(route( $route['name']));
                    $resData[$k]['name']=$route['name'];
                    $resData[$k]['result']= $res->status();
                    break;
                    case 'post';
                        \Session::start();
                        //dd();
                        $res = $class->call('POST', route( $route['name'], array(
                            '_token' => csrf_token(),
                              "modName" => 'Master',
                              "modDesc" => "Core Module to Work as platform or MS Appliacation.",
                              "modCode" => "MAS",
                              "modIcon" => "fa-home",
                              "modPrefix" => "MAS",
                              "modForSuperAdmin" => 1,
                              "modForAdmin" => 0,
                         //     "modHomeAction" => 'MAS.Index',
                          //    "modDataAction" => 'MAS.Index',
                            'modStatus'=>1,
                         //   'id'=>1
                        )));
                        $resData[$k]['name']=$route['name'];
                        $resData[$k]['result']= "402";


                        break;
            }

            if(!$error && array_key_exists($k,$resData )&& array_key_exists('result',$resData[$k])  &&($resData[$k]['result'] ==500)){

                $resDataError[$k]['name']=$resData[$k]['name'];
                $resDataError[$k]['result']= $resData[$k]['result'];
                $error=1;
            }
           $k++;



        }

        dd($resData);
        if(!$error){

            return true;


        }
            return $resDataError;

    }

    public static function getAllRules($tableID=false){


        $targeTable=self::getTableArray($tableID);
        //dd($targeTable);
        $outArray=[];
        foreach ($targeTable['fields'] as $field){

            if(array_key_exists('validation',$field) && is_array($field['validation']) && (count($field['validation']) > 0)){


                foreach ($field['validation'] as $ruleType=>$ruleString){

                    switch ($ruleType){

                        case 'required':
                            if($ruleString) $outArray[$field['name']][]= 'required';
                            break;

                    }



                }



            }

        }
     //   dd($outArray);
        return $outArray;
     //   dd($outArray);

}

    public static function getAllMessage($tableID=false,$rules){
        $targeTable=self::getTableArray($tableID);
        $outArray=[];
        if(array_key_exists('validationMessage',$targeTable)){

            if(count($rules)>0){

               // dd($rules);
                foreach ($rules as  $inputName=>$ruleArray){


                    foreach ($ruleArray as $ruleLine){
                        switch ($ruleLine){

                            case 'required':
                                $ruleMade=implode(".",[$inputName,$ruleLine]);
                            if(array_key_exists($ruleMade,$targeTable['validationMessage']))$outArray[$ruleMade]=$targeTable['validationMessage'][$ruleMade];
                                break;

                            case defualt;
                                break;
                        }
                    }

                }

            }



            }



        //dd($data);
        //dd($outArray);
        return $outArray;
    }

    public static function getAllAttr($tableID=false,$rules){

        $targeTable=self::getTableArray($tableID);
        $outArray=[];




            if(count($rules)>0) {

                // dd($rules);
                foreach ($rules as $inputName => $ruleArray) {
                    foreach (self::getField($tableID) as $inputArray){

                        $outArray[$inputArray['name']]=$inputArray ['vName'];

                    }

                }
            }
      //  dd($outArray);
        return $outArray;
    }

    public static function migrateRoutesToDb(){
        $rM=\MS\Mod\B\Mod\F::getRouteModel ();
        $r=self::getRoutes();



        $rF=array_map(function($array){
            $fA=[];
            $dT=self::$routeTableHook;
            $modCode=explode('.',$array['name']) ;
            $modCode=reset($modCode);
            foreach ($dT as $k=>$Nk){
                if($k=='route'){

                        $path=explode('.',route($array['name']));

                      if (count($path)==2) unset($path[0]);
                    if (count($path)==3) {unset($path[0]);unset($path[1]);}


                   $fA[$Nk]=reset($path);
                    //dd(route($array['name']));
                }elseif ($k=='method'){
                    $fA[$Nk]=implode('@',[static::$controller,$array[$k]] );
                }else{
                    $fA[$Nk]=$array[$k];
                }

            }


            if(!array_key_exists('UniqId',$fA))$fA['UniqId']= \MS\Core\Helper\Comman::random(6,4);
            if(!array_key_exists('Status',$fA))$fA['Status']=true;
            if(!array_key_exists('ModuleCode',$fA))$fA['ModuleCode']=$modCode;

            return $fA;
        },$r);

        return $rF;

        dd($rF);

    }

}
