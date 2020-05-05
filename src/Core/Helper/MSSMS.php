<?php


namespace MS\Core\Helper;


class MSSMS
{

    private $toNumber,$countrCode,$channelId,$FinalStr,$StrData,$error,$apiResponse,$templateId;

    private $sendId='0';

    private $offline=true;

    private $finalReturnData=[];
    private $allTemplates=[
    //    'OTPforUser'=>'{OTP} is your OTP for O3 ERP . For more information log on: https://www.o3erp.com',
        'OTPforUser'=>'{OTP} is your OTP for O3 ERP . https://www.o3erp.com',
      //  'OTPforUserTest'=>'{OTP} is your OTP for O3 ERP . https://www.o3erp.com'


    ];

    private $AllSenders=[
        [
            'name'=>'SMS Gateway Hub',
            'apiKey'=>'9bb90d43-7f4e-47b4-92e3-7f9f4fce36bd',
            'senderId'=>'MSLLPI'
        ],
        [
            'name'=>'Exotel',
            'apiKey'=>'millionsolutionsllp',
            'apiToken'=>'01a849e855d1f95abbfdf8db1637b7e413172397',
        ]

    ];


    public function __construct($to,$data)
    {

        (strlen($to)==10)?$this->setToNumber($to):$this->setError('Invalid Mobile Number');

        if(array_key_exists('countryCode',$data) && $data!='')$this->setCountrCode($data['countryCode']);
        if(array_key_exists('channelId',$data) && $data!='')$this->setChannelId($data['channelId']);
        (array_key_exists('strData',$data) && $data!='')?$this->setStrData($data['strData']):$this->setStrData([]);
        if(array_key_exists('templateId',$data) && $data!='')$this->setTemplateId($data['templateId']);
        if(array_key_exists('channel',$data) && $data!='')$this->setSendId($data['channel']);
    }

    public static function SendSMS($to,$data){
        $c=new self($to,$data);
        $c->sendApiRequest();
        return $c->returnData();

    }

    private function returnData(){
        $finalReturnData=$this->getFinalReturnData();
        if(!array_key_exists('status',$finalReturnData))$finalReturnData['status']=409;
       // dd($this);
        return $finalReturnData;
    }

    private function sendApiRequest(){
    switch ($this->getSendId()){
        case 0:
            $this->apiCallForSMSGateHub();

            break;
        case 1:
            $this->apiCallForExotel();
            break;
    }



    }

    private function apiCallForSMSGateHub(){


        $mData=$this->getAllSenders(0);
        $senderId=$mData['senderId'];
        $apikey=$mData['apiKey'];
        $str=$this->getAllTemplates($this->getTemplateId());
        $strData=$this->getStrData();
      //  dd($strData);
        if(count($strData)>0)foreach ($this->getStrData() as $k=>$v){
            $str=str_replace('{'.$k.'}',$v,$str);
        }
        $this->setFinalStr($str);
        //dd($this);
        $url='https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$senderId.'&channel=2&DCS=0&flashsms=0&number='.$this->getToNumber().'&text='.$this->getFinalStr().'&route=1';
//dd($url);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $url);
        ($res->getStatusCode()== 200)?$this->setApiResponse($res): $this->setError('Api Call Failed');

        $resPonse=$this->getApiResponse();
        if($res->getStatusCode()==200){
            $this->setFinalReturnData('200','status');
            $this->setFinalReturnData('OTP SMS Sent Successfully.','msg');
        }
    }

    private function apiCallForExotel(){


        $str=$this->getAllTemplates($this->getTemplateId());
        $strData=$this->getStrData();
        //  dd($strData);
        if(count($strData)>0)foreach ($this->getStrData() as $k=>$v){
            $str=str_replace('{'.$k.'}',$v,$str);
        }
        $this->setFinalStr($str);

        $post_data = array(
            // 'From' doesn't matter; For transactional, this will be replaced with your SenderId;
            // For promotional, this will be ignored by the SMS gateway
            'From'   => '07941057527',
            'To'    => $this->getToNumber(),
            'Body'  =>  $this->getFinalStr(),
        );
        //dd($this);
        $mData=$this->getAllSenders(1);
        $exotel_sid = $mData['apiKey']; // Your Exotel SID
        $exotel_token = $mData['apiToken']; // Your exotel token

        $url = "https://".$exotel_sid.":".$exotel_token."@twilix.exotel.in/v1/Accounts/".$exotel_sid."/Sms/send";


        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('POST', $url,['form_params'=>$post_data]);
        }catch (\Exception $e){

        //    dd($e);
        }

        ($res->getStatusCode()== 200)?$this->setApiResponse($res): $this->setError('Api Call Failed');

        $resPonse=$this->getApiResponse();
        if($res->getStatusCode()==200){
            $this->setFinalReturnData('200','status');
            $this->setFinalReturnData('OTP SMS Sent Successfully.','msg');
        }

     //   dd($res);

    }

    /**
     * @return mixed
     */
    public function getFinalReturnData()
    {
        return $this->finalReturnData;
    }

    /**
     * @param mixed $finalRetuenData
     */
    public function setFinalReturnData($finalReturnData,$key)
    {
        $this->finalReturnData[$key] = $finalReturnData;
    }



    /**
     * @return array
     */
    public function getAllTemplates($key): string
    {

        return(array_key_exists($key,$this->allTemplates))? $this->allTemplates[$key]:'';
    }




    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param mixed $templateId
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
    }




    /**
     * @return array
     */
    public function getAllSenders($key): array
    {
        return(array_key_exists($key,$this->AllSenders))? $this->AllSenders[$key]:[];
    }




    /**
     * @return string
     */
    public function getSendId(): string
    {
        return $this->sendId;
    }

    /**
     * @param string $sendId
     */
    public function setSendId(string $sendId)
    {
        $this->sendId = $sendId;
    }


    /**
     * @return mixed
     */
    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * @param mixed $apiResponse
     */
    public function setApiResponse($apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }


    /**
     * @return mixed
     */
    public function getError($key)
    {
        return $this->error[$key];
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error[] = $error;
    }
    /**
     * @return mixed
     */
    public function getStrData()
    {
        return $this->StrData;
    }

    /**
     * @param mixed $StrData
     */
    public function setStrData($StrData)
    {
        $this->StrData = $StrData;
    }

    /**
     * @return mixed
     */
    public function getToNumber()
    {
        return $this->toNumber;
    }

    /**
     * @param mixed $toNumber
     */
    public function setToNumber($toNumber)
    {
        $this->toNumber = $toNumber;
    }

    /**
     * @return mixed
     */
    public function getCountrCode()
    {
        return $this->countrCode;
    }

    /**
     * @param mixed $countrCode
     */
    public function setCountrCode($countrCode)
    {
        $this->countrCode = $countrCode;
    }

    /**
     * @return mixed
     */
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * @param mixed $channelId
     */
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
    }

    /**
     * @return mixed
     */
    public function getFinalStr()
    {
        return $this->FinalStr;
    }

    /**
     * @param mixed $FinalStr
     */
    public function setFinalStr($FinalStr)
    {
        $this->FinalStr = $FinalStr;
    }




}
