<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 19-06-2019
 * Time: 04:06 AM
 */

namespace MS\Core\Helper;

use Razorpay\Api\Api;

class MSPay
{
    private $amount,$data,$gateway,$paymentApi;



    private $required=[
        'description','customerEmail','customerNumber'
    ];

    private $allGateways=[
        [
            'name'=>'Razor Pay Test',
            'keyId'=>'rzp_test_hWAPfGnN0KwMXK',
            'keySecret'=>'f2CxU8JV3aWiTAjMY2X5y630'
            ],

        [
            'name'=>'Razor Pay Production',
            'keyId'=>'rzp_live_ERLQL9js3neD1A',
            'keySecret'=>'zM7WI1LMVvsKPEUpU4fiv02h'
            ]
        ];

    public function  __construct($amount=0,$data=[])
    {

        $this->setAmount($amount);
        $this->setData($data);
        (array_key_exists('channel',$data))? $this->setGateway($data['channel']) :$this->setGateway(0);
        $this->setPaymentApi(new Api($this->getApiId(),$this->getApiSecret()));
    }


    public static function makePaymentLink($amount,$data):array{


        $class=new self($amount,$data);

        $razorPay=$class->getPaymentApi();

        $idata=[

            'receipt' => $data['invoiceId'],
            'amount' => $amount * 100,
            'payment_capture' => 1,
            'currency' => 'INR',

         //   'callback'=>'https://www.o3erp.com'

        ];
//        if(array_key_exists('customerEmail',$data) && $data['customerEmail']!='')$idata['customer']['email']=$data['customerEmail'];
//        if(array_key_exists('customerNumber',$data) && $data['customerNumber']!='')$idata['customer']['contact']=$data['customerNumber'];


        $order = $razorPay->order->create($idata);
      //  dd($order);

        $return =[
            'id'=>$order->id,
            'invoiceid'=> $data['invoiceId'],
            'amount'=>$order->amount_due

        ];


      //  dd($razorPay->payment->fetch('pay_29QQoUBi66xm2f'));

//        $return =[
//            'link'=>$razorPayMaster->short_url,
//            'expired_at'=>$razorPayMaster->expired_at,
//            'invoiceid'=> $razorPayMaster->id,
//            'created_at'=>$razorPayMaster->created_at
//        ];


//
//        $return =[
//            'link'=>$razorPayMaster->short_url,
//            'expired_at'=>$razorPayMaster->expired_at,
//            'invoiceid'=> $razorPayMaster->id,
//            'created_at'=>$razorPayMaster->created_at
//        ];
//        $return=[];
         return $return ;

    }

    public function requiredDataCheck(){
        foreach ( $this->required as $v){
            if(!array_key_exists($v,$this->data))return false;
        }
        return true;
    }


    public  static function fetchPaymentApi(){
        $c=new self();

        return $c->getPaymentApi();

    }

    public static function getPaymentStatus($id):array{
        $razorPay=self::fetchPaymentApi();
        $in=$razorPay->order->fetch($id);
        $userId=explode('_',$in->receipt)[0];
        $rD=[
            'LadgerId'=>$in->receipt,
            'UserId'=>$userId,
            'amount'=>$in->amount/100,
            'amountPaid'=>$in->amount_paid/100,
                'status'=>($in->status=='paid' &&  ($in->amount-$in->amount_paid)==0 )?true:false,
        ];

        return $rD;
    }


    public function getApiId(){
        $k=$this->getGateway();
        return $this->getAllGateways()[$k]['keyId'];
    }
    public function getApiSecret(){
        $k=$this->getGateway();
        return $this->getAllGateways()[$k]['keySecret'];
    }

    /**
     * @return Api
     */
    public function getPaymentApi(): Api
    {
        return $this->paymentApi;
    }

    /**
     * @param Api $paymentApi
     */
    public function setPaymentApi(Api $paymentApi)
    {
        $this->paymentApi = $paymentApi;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @param mixed $gateway
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @return array
     */
    public function getAllGateways(): array
    {
        return $this->allGateways;
    }

    /**
     * @param array $allGateways
     */
    public function setAllGateways(array $allGateways)
    {
        $this->allGateways = $allGateways;
    }






}
