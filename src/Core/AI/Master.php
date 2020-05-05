<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 24-06-2019
 * Time: 05:23 AM
 */

namespace MS\Core\AI;

class Master
{


    public static $masterWord=[

        '998'=>[

            'lawyer','legal','Repair','services','maintenance','plastic','installation'

        ],

        '621'=>[
            'garments',"clothes"
        ]



    ];
    public static $nearWord=[

        'legal'=>['lawyer','law'],
        'men women'=>['clothes'],

    ];
    public $str,$sysWord,$get1st,$get2nd,$getCatCode;


    public function __construct($str)
    {
        $this->str=$str;
    }

    private function findCatagaoryCode(){
        $masterWor=self::$masterWord;
        $nearWord=self::$nearWord;
        $returnStr="";
        foreach ($masterWor as $code=>$words){
            if(in_array($this->str,$words)) {

                $this->getCatCode=$code;
            }

            }


        foreach ($nearWord as $mainName=>$toFindin){

            if(in_array($this->str,$toFindin)){

                $this->get1st=$mainName;


            }

        }


       // dd($this);

        if($this->getCatCode != null)$returnStr.=" ".$this->getCatCode;
        if($this->get1st != null)$returnStr.=" ".$this->get1st;
        if($this->get2nd != null)$returnStr.=" ".$this->get2nd;
        //dd($this);
        if($returnStr != "")return $returnStr;
        return $this->str;
        }



    public static function  getLazyGiveAccurate(string $str ):string {

    $strExplode=explode(" ",$str);
       // dd($strExplode);
        $cl=new Self($str);
        //dd($cl->findCatagaoryCode());

        return $cl->findCatagaoryCode()." ".$str;


      //  $url = "https://books.zoho.com/api/v3/meta/hsnsaccodes?search_text=".urlencode ($input['key']); // http://localhost:8000/template/1/11
        //$html =  file_get_contents($url)  ;

    }


}
