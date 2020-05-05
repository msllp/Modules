<?php


namespace MS\Core\Helper;

use MS\Core\Helper\MSDB;
use Illuminate\Foundation\Inspiring;
class MSLogin
{

    public $formData,$pageData,$msdb,$mPageData,$verifyData,$verifySource,$OtherSource;

    public function __construct(MSDB $db,$pageData)
    {

        if(!array_key_exists('verifyBy',$pageData))$pageData['verifyBy']= ['MS ID','Google'];
        $this->setMPageData($pageData);
        $this->setMsdb($db);
        $this->formData=[];
        $this->pageData=[];

        $this->OtherSource=false;
      //  dd( $this);
        if(array_key_exists('verifyBy',$this->getMPageData()) && count($this->getMPageData()['verifyBy'])>0 ){
            $this->OtherSource=true;
            $outAPI=new \MS\Mod\B\Users\L\OutLoginApi();

            $name=reset($this->getMPageData()['verifyBy']);



            if(array_key_exists('verifyByDefault',$this->getMPageData())
            && array_key_exists($this->getMPageData()['verifyByDefault'],$this->getMPageData()['verifyBy'])
            ){
                $name=$this->getMPageData()['verifyBy'][$this->getMPageData()['verifyByDefault']];

            }


            $d=$outAPI->getSourceByName($name);

            $data=$d;

            if(array_key_exists('VerifyUrl',$data) && array_key_exists('VerifyCallback',$data)){
                $data['VerifyUrl']=route($data['VerifyUrl']);
                $data['VerifyCallback']=route($data['VerifyCallback']);
            }

            $this->setVerifyData($data);
            $tf=json_decode($data['VerifyData'],true,5);
          //  dd($tf[$data['VerifyDataDefault']]);
            $this->setVerifySource($tf[$data['VerifyDataDefault']],$data['UniqId']);
            //dd($outAPI->getSourceByName($name));





            if(count($this->getMPageData()['verifyBy'])>1){
                $d2=$this->getMPageData()['verifyBy'];
                unset($d2[array_key_first($this->getMPageData()['verifyBy'])]);

                foreach ($d2 as $sname){
                    $data=$outAPI->getSourceByName($sname);
                    if(array_key_exists('VerifyUrl',$data) && array_key_exists('VerifyCallback',$data)){
                        $data['VerifyUrl']=route($data['VerifyUrl']);
                        $data['VerifyCallback']=route($data['VerifyCallback']);
                    }

                  $key=  $this->setVerifyData($data);


                  //  if($data==false)   dd($sname);

                    $d=json_decode($data['VerifyData'],true,5);
                  //  dd($this->getVerifyData($data)[$key]['verifyDataDefault']);
//dd(array_key_exists('VerifyDataDefault',$this->getVerifyData($data)[$key]));
                 //   if(!array_key_exists('verifyDataDefault',$this->getVerifyData($data)[$key]))dd($this->getVerifyData($data)[$key]['VerifyDataDefault']);
                //  dd($this->getVerifyData());
                    if(array_key_exists($this->getVerifyData($data)[$key]['VerifyDataDefault'],$d)){
                   //     dd($outAPI->getSourceByName($sname));
                        $this->setVerifySource($d[$outAPI->getSourceByName($sname)['VerifyDataDefault']],$data['UniqId']);
                    }else{

                        $this->setVerifySource($d,$data['UniqId']);
                    }


                }


            }

        }

     //   dd($this );

      //  dd($this->getMPageData());
        //$this->bPageData=

    }

    /**
     * @return array
     */
    public function getFormData()
    {
        return $this->formData;
    }

    /**
     * @param array $formData
     */
    public function setFormData($formData)
    {
        $this->formData = $formData;
    }

    /**
     * @return \MS\Core\Helper\MSDB
     */
    public function getMsdb()
    {
        return $this->msdb;
    }

    /**
     * @param \MS\Core\Helper\MSDB $msdb
     */
    public function setMsdb($msdb)
    {
        $this->msdb = $msdb;
    }

    /**
     * @return mixed
     */
    public function getVerifyData()
    {
        return $this->verifyData;
    }

    /**
     * @param mixed $verifyData
     */
    public function setVerifyData($verifyData)
    {
        $this->verifyData[] = $verifyData;
        return count($this->getVerifyData())-1;
    }

    /**
     * @return mixed
     */
    public function getVerifySource()
    {
        return $this->verifySource;

    }

    /**
     * @param mixed $verifySource
     */
    public function setVerifySource($verifySource,$key=null)
    {
        if($key!=null){
            if(is_array($this->getVerifySource()) && !array_key_exists($key,$this->getVerifySource()))
            {
                $this->verifySource[$key] = $verifySource;
                return count($this->getverifySource())-1;
            }else{

                $this->verifySource[$key] = $verifySource;
            }


            return count($this->getverifySource())-1;
        }

        $this->verifySource = $verifySource;
    }

    /**
     * @return mixed
     */
    public function getMPageData()
    {
        return $this->mPageData;
    }

    /**
     * @param mixed $mPageData
     */
    public function setMPageData($mPageData)
    {
        $this->mPageData = $mPageData;
    }


    public function displayLoginPageFromMSDB(){


        $this->pageData=$this->makeArrayForVueForPageData();

        $d=$this->pageData;

        return view("MS::core.layouts.MS.loginPage")->with("d",$this->jsonOut($d));

    }


    private function getVerifyLogin(){
        $d=$this->getVerifyData();

        if(array_key_exists('VerifyUrl',$d) && $d['VerifyUrl'])return route($d['VerifyUrl']);
        return url('/');
    }

    private function getFormIDs(){
        $id=[];
        $mD=$this->getMPageData();
        if(array_key_exists('groups',$mD) && count($mD['groups']) > 0)return $mD['groups'];

        return $id;
    }

    private function makeArrayForVueForPageData(){
        $f=[];
        $d=$this->getMPageData();
        $formId=$this->getFormIDs();


      $d3=$this->getVerifyData();

        //TODO return only required fields


       $asd=collect($d3)->map(function ($item, $key) {
           return collect($item)->only(['UniqId','VerifyName','VerifyCallback','VerifyUrl','VerifyIcon'])->toArray();
       })->toArray();
   //=    dd((array_key_exists('CompanyIcon',$d)) ? $d['CompanyIcon'] : asset('images/logo.png'));
        $f=[
            //'bgImg'=>asset('images/bg1.png'),

            'ClientIcon'=>(array_key_exists('CompanyIcon',$d)) ? $d['CompanyIcon'] : asset('images/logo_v1_black.svg'),
            'MasterIcon'=>asset('images/logo_master.png'),
            'formData'=>$this->makeArrayForVueForFormData($formId),
            'loginPostUrl'=>$this->getVerifyLogin(),
            'inspire'=>Inspiring::quote(),
            'copyrightPre'=> implode(' ',[ '©',implode('-',[date("Y"),date("Y")+1]),',','All rights reserved by' ]),
            'copyrightPer'=>"Million Solutions LLP",
            'OtherSource'=>$this->OtherSource,
            'AllSoucesData'=>$asd,
            'helpLine'=>implode(' | ',['Mail us: help@o3erp.com','WhatsApp:+917990563470','Call us: 079 3006 1009'])
         //   'OtherSource'=>false
        //    'CheckUsernamePostUrl'=>'',
          //  ''
        ];
       // if(array_key_exists('VerifyUrl',$d) && $d['VerifyUrl'])
     //   dd($f);

        return $f;
    }
    private function makeArrayForVueForFormData($ids){
        //dd($ids);
        $f=[];
        foreach ($ids as $group){
            $f[$group]=$this->msdb->getDisplayFormArray($group);
        }
        return reset($f);

        return $this->msdb->getDisplayFormArray($ids);
        return $f;
    }

    private function jsonOut($d){
        return collect($d)->toJson();
    }


}
