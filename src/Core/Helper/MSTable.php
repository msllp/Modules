<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 13-09-2019
 * Time: 03:35 AM
 */

namespace MS\Core\Helper;


use function foo\func;
use http\Env\Request;

class MSTable
{

    public $returnHTML =[];

    public $vueAllowed=[
        'msLinkKey','msLinkText','doubleConfirmText','doubleConfirm','ownTab'
    ];
    public $namespace,$id,$perFix,$data,$msdb,$fields,$dbMaster,$action;
    public $dynamicData=[];
    public $viewID=null;
    public $attachedAction=[];
    public $perPage=5;
       /**
        * MSForm constructor.
        * @param \MS\Core\Helper\string $namespace
        * @param \MS\Core\Helper\string|null $id
        * @param \MS\Core\Helper\string|null $perFix
        * @param array $data
        */
    public function __construct(string $namespace, string $id=null, string $perFix=null, array $data=[])
    {

        $this->namespace=$namespace;
        $this->id=$id;
        $this->perFix=$perFix;
        $this->data=$data;
        $base="\\".$this->namespace."\\B";
        $this->dbMaster=$base::getModuleTables()[$this->id];
        // $this->actionButton=[];


        foreach ($data as $v=>$k){

            switch ($v){

                case 'viewID':
                    $this->viewID=$k;
                    break;

                default:
                    break;

            }

            //    dd($this);

        }



//dd($this);
    }

    public function fromModel(MSDB $dbClass,$data=[]){
        $this->msdb=$dbClass;
        $this->action=  $this->msdb->model->ms_action;
        $this->fields=$this->msdb->model->base_Field;
       // if(count($data)>0)$this->newForm=false;
        $this->makeTable();
      //  dd($this);
        return $this;
    }

    public function makeArrayForVue($array){
            $fArray=[];
           // dd($this);
            $vueData=[
                'n'=>'tableTitle',
                'fc'=>'tableColumns',
                'data'=>'tableData',
                'ddata'=>'tableFromOther',
                'ac'=>'tableAction',
                'mac'=>'tableMassAction',
                'rid'=>'rowId'

            ];

            if(array_key_exists($this->viewID,$this->dbMaster['MSViews'])){
         //       dd($this->dbMaster['MSViews'][$this->viewID]);
                $vd=$this->dbMaster['MSViews'][$this->viewID];
                $fArray[$vueData['n']]=$vd['title'];
                $fArray[$vueData['fc']]=$this->makeArrayForColumns($vd['groups'] );
               // dd($this->msdb->rowAll());
                //dd($this->dbMaster['MSViews'][$this->viewID]['paginationLink']);
                $fArray[$vueData['data']]=$this->msdb->MSmodel->latest()->paginate($this->perPage)->withPath(route($vd['paginationLink']));
               // dd($this->dynamicData);
                $fArray[$vueData['ddata']]=$this->dynamicData;
                $fArray[$vueData['ac']]=$this->makeArrayForAction();
                $fArray[$vueData['mac']]=$this->makeArrayForMassAction();
                $fArray[$vueData['rid']]=$this->makeRowId();



            }
        $fArray[$vueData['data']]->links();


//dd($fArray);
            //$formName=$this;

            return $fArray;



    }

    private function makeRowId(){
        if(array_key_exists('rowId',$this->dbMaster['MSViews'][$this->viewID]))return $this->dbMaster['MSViews'][$this->viewID]['rowId'];
        return 'id';
    }

    private function makeArrayForColumns(array  $array){
//dd($array);
        $allFileds=[];

        foreach ($array as $groupId){

            if(array_key_exists($groupId,$this->dbMaster['fieldGroup'])){

                foreach ($this->dbMaster['fieldGroup'][$groupId] as $colName){

                    if(!array_key_exists($colName,$allFileds)){
                        $colD=collect($this->fields)->where('name',$colName)->first();


                        switch ($colD['input']){

                            case 'option':
                                goto ms_dyn_data;
                                break;


                            case 'radio':
                              //  dd($colD);
                                ms_dyn_data:
                                if(array_key_exists('validation',$colD)){
                                    if(array_key_exists('existIn',$colD['validation'])){
                                        $this->dynamicData[$colD['name']]=\MS\Core\Helper\MSForm::getDataFromTable($colD['validation']['existIn']);
                                        //dd(\MS\Core\Helper\MSForm::getDataFromTable($colD['validation']['existIn']));
                                    }
                                }

                                break;

                            default:
                                break;
                        }

                        switch ($colName){

                            case 'created_at':
                                $colD['vName']='Generated on';
                                $colD['input']='date';
                                goto ms_make_array;
                                break;
                            case 'updated_at':
                                $colD['vName']='Updated on';
                                $colD['input']='date';
                                goto ms_make_array;
                                break;


                            default:
                                ms_make_array:
                                $allFileds[$colName]=
                                    [
                                        'vName'=>$colD['vName'],
                                        'type'=>$colD['input']
                                    ];
                                break;
                        }


                    }
                }

            }



        }
      //  dd($this);
        return $allFileds;


    }

    private  function makeArrayForAction(){
        $fArray=[];
        if(array_key_exists('actions',$this->dbMaster['MSViews'][$this->data['viewID']]) && count($this->dbMaster['MSViews'][$this->data['viewID']]['actions'])){

            foreach ($this->dbMaster['MSViews'][$this->data['viewID']]['actions'] as $ac){


                $fArray[]=$this->getActionArray($ac);
           //     dd($this->getActionArray($ac));

            }

        return $fArray;
        }

        return [];


    }
    private  function makeArrayForMassAction(){
        $fArray=[];
        if(array_key_exists('massAction',$this->dbMaster['MSViews'][$this->data['viewID']]) && count($this->dbMaster['MSViews'][$this->data['viewID']]['massAction'])){

            foreach ($this->dbMaster['MSViews'][$this->data['viewID']]['massAction'] as $ac){


                $fArray[]=$this->getActionArray($ac);
                //     dd($this->getActionArray($ac));

            }

            return $fArray;
        }

        return [];


    }


    private function getActionArray($actioId){
        $fArray=[];
        if(array_key_exists($actioId,$this->dbMaster['action'])){



            $fArray=[

                'icon'=>$this->dbMaster['action'][$actioId]['btnIcon'],
                'text'=>$this->dbMaster['action'][$actioId]['btnText'],
                'color'=>$this->dbMaster['action'][$actioId]['btnColor'],
                'url'=>route($this->dbMaster['action'][$actioId]['route']),

                ];

            foreach ($this->vueAllowed as $vc){
                if(array_key_exists($vc,$this->dbMaster['action'][$actioId]))$fArray[$vc]=$this->dbMaster['action'][$actioId][$vc];
            }
            //if(array_key_exists('msLinkKey',$this->dbMaster['action'][$actioId]))$fArray['msLinkKey']=$this->dbMaster['action'][$actioId]['msLinkKey'];
            //if(array_key_exists('msLinkText',$this->dbMaster['action'][$actioId]))$fArray['msLinkText']=$this->dbMaster['action'][$actioId]['msLinkText'];

            // dd($this->dbMaster['action'][$actioId]);


        }

        return $fArray;
    }

    public function makeTable(){

        //dd($this->dbMaster['MSViews']);
        if(array_key_exists('MSViews',$this->dbMaster)&&  array_key_exists($this->viewID,$this->dbMaster['MSViews'])){
            $this->returnHTML['fromV']= $this->makeArrayForVue($this->dbMaster['MSViews'][$this->viewID]);
        }else{

        }




    }


   // public function

    public function view(){
       // dd($this);
     //  return view("MS::core.layouts.Table.tablePlateRaw")->with("table",$this->returnHTML);
        return view("MS::core.layouts.Table.tablePlate")->with("table",$this->returnHTML);
    }

}
