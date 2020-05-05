<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 16-03-2019
 * Time: 03:48 AM
 */

namespace MS\Core\Model;

use \Illuminate\Notifications\Notifiable;

use   \Illuminate\Database\Eloquent\Model;

class Master  extends Model  implements BaseMaster{

    use Notifiable;
    public $namespace,$tableID,$perFix,$ms_base,$base_Field,$g,$ms_action;

    public function __construct(string $nameSpace,$tableID=false, $perFix=false, $tableData=[],$tableConnection=false,$glue="_")
    {


        $this->namespace=$nameSpace;
        $this->g=$glue;
        $this->ms_base="\\".$nameSpace."\\B";
        $this->ms_action=(count($tableData)>0 && array_key_exists('action',$tableData))? $tableData['action'] : $this->ms_base::getAction($tableID);
        //$this->ms_action=$this->ms_base::getAction($tableID);
        $this->tableID=$tableID;
        if($tableID){

            //$this->tableID=$tableID;
            if($perFix){
                if(count($perFix)>0)$perFix=implode($glue,$perFix);
                $perFix=$this->g.$perFix;
                $this->table=$this->ms_base::getTable($tableID).$perFix;
                $this->perFix=$perFix;
            }else{

                $this->table=(count($tableData)>0 && array_key_exists('tableName',$tableData))? $tableData['tableName'] : $this->ms_base::getTable($tableID);
         //   if (count($tableData)>0)dd($this->table);
               // $this->table=$this->ms_base::getTable($tableID);
            }
            if($tableConnection){$this->connection=$tableConnection;}else{$this->connection=$this->ms_base::getConnection($tableID);}

            $this->base_Field=(count($tableData)>0 && array_key_exists('fields',$tableData))? $tableData['fields']:$this->ms_base::getField($tableID);

            $this->base_Field=$this->ms_base::getField($tableID);

        //    if (count($tableData)>0)dd( $this);
        }
        else
        {


                if($perFix){
                    $this->perFix=$perFix;
                    $this->table=$this->ms_base::getTable().$glue.$perFix;
                }else{
                    $this->table=$this->ms_base::getTable();
                }


                $this->connection=$this->ms_base::getConnection();
                $this->base_Field=$this->ms_base::getField();
            }

        $this->fillable=['id'];
       // dd($this->base_Field);

        foreach ($this->base_Field as $key => $value) {
            $this->fillable[]=$value['name'];
        }

        parent::__construct();
    }



    public function genuniqid(){
        return $this->ms_base::genUniqID();
    }


    public function MS_all(){
        $row=$this->all();
        return $row;
    }

    public function MS_delete($data,$id,$dataArray=[]){


        if(count($data)!=1)return  ['status'=>'422','msg'=>"data Invalid Size"];

        if(!array_key_exists("UniqId", $data)){


            $m=new static($id);

            $connection=$m->connection;

            $table=$m->table;


        }else{


            $uniEx=explode("_", $data['UniqId']);

            if(count($uniEx)>0)
            {

                $m=new static($id,reset($uniEx));
            }else{

                $m=new static($id,$data['UniqId']);

            }



            $connection=$m->connection;

            $table=$m->table;

        }
        //dd($data['UniqId']);



        if(count($dataArray)==1){

            //dd( $table);

            $value=reset($dataArray);
            $column=key($dataArray);
            \DB::connection($connection)->table($table)->where($column,"=",$value)->delete();
            return ['status'=>'200','msg'=>"Data Succesfully removed from MSDB."];

        }


        dd( \DB::connection($connection)->table($table)->where('UniqId',"=",$data['UniqId'])->delete());


        return ['status'=>'200','msg'=>"Data Succesfully removed from MSDB."];
    }


    public function MS_Check_Last($id,$current){

        $model=new static($id);

        $formData=$model->get()->toArray();

        $last=count($formData)-1;
        $lastData=$formData[$last];

        $e=1;


        if(array_key_exists('_token', $current))unset($current['_token']);
        if(array_key_exists('UniqId', $current))unset($current['UniqId']);

        foreach ($current as $key => $value) {


            if(!($e && $lastData[$key]==$value))return true;

        }


        return false;

    }

    public function MS_update($data,$UniqId){
        $m=implode('\\', ['',$this->namespace,'Model']);


        if(array_key_exists('_token', $data))unset($data['_token']);
        if(!array_key_exists('updated_at', $data))$data['updated_at']=\Carbon::now()->toDateTimeString();

        $data2=\DB::connection($this->connection)->table($this->table)->where('UniqId',$UniqId)->update($data);
        \MS\Core\Helper\Comman::DB_flush();

        return ['status'=>'200','msg'=>"Data Succesfully added to MSDB."];
    }

    public function MS_add($data,$id=0){


        if($id===0)$id=$this->Ms_id;

        if($this->code!=null){
            $code=$this->code;
            //$model=new $mString($id);
        }




        $m=implode('\\', ['',$this->namespace,'Model']);
        // dd();
        if($id)
        {

            if(isset($code)){
                $row=new $m($id,$code);
            }else{
                $row=new $m($id);
            }

        }else{
            $row=new $m();
        }
        //  $data['AttachmentsArray']="array";
        // if(!(array_key_exists('Attachments', $data)))$data['Attachments']="array";
        if(array_key_exists('_token', $data))unset($data['_token']);
        if(!array_key_exists('UniqId', $data))$data['UniqId']=\B\Panel\Base::genUniqID();
        if(!array_key_exists('created_at', $data))$data['created_at']=\Carbon::now()->toDateTimeString();
        if(!array_key_exists('updated_at', $data))$data['updated_at']=\Carbon::now()->toDateTimeString();
        foreach ($data as $key => $value) {
            $row->$key=$value;

        }



        if($row->checkSave()['error']){
            return ['status'=>'200'];
        }
        return ['status'=>'200','msg'=>$row->checkSave()];
    }


    public function checkSave(){


        $error=\MS\Core\Helper\Comman::findDuplicate($this,'UniqId',$this->UniqId);
        // dd($error);
        if(!$error['error']){
            $this->save();
            $error=['error'=>false,'msg'=>"User Succesfully added to Database."];
            return $error;
        }
        return $error;
    }


    public function deleteTable(){
        \MS\Core\Helper\Comman::deleteTable($this->table,$this->connection);
    }

    public static function checkTableinDB($connection,$table){

        return \Schema::connection($connection)->hasTable($table);

    }

    public function checkCurrentTable(){

        $connection=$this->connection;
        $table=$this->table;

        return \Schema::connection($connection)->hasTable($table);


    }


    public function checkTableExist($id,$namespace){



    }
}
