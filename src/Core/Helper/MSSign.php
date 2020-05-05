<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 28-07-2019
 * Time: 02:24 AM
 */

namespace MS\Core\Helper;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;


class MSSign  extends BaseController
{




    public function check(Request $r){
        $data=$r->all();
        $data=[

            'dasdas'=>"sadasd",
            'dasdas1'=>"sadasd1"
        ];
        var_dump($data);

       // return $this->encryptArray( $data );
        dd($this->decryptArray( $this->encryptArray($data) ));
    }

    private function encryptArray(array $data){

        $outArray=[];
        $dt = \Carbon::now();
        foreach ($data as $k => $v){

            $outArray[Comman::encode($k)]=Comman::encode($v);
        }
        $outArray[Comman::encode('signedOn')]=Comman::encode($dt->timestamp);
        return $outArray;
        dd($this->decryptArray($outArray));

    }

    private function decryptArray(array $data){

        $outArray=[];
        $dt = \Carbon::now();
        foreach ($data as $k => $v){

            $outArray[Comman::decode($k)]=Comman::decode($v);
        }
        //$outArray[Comman::decode('signOn')]=Comman::encode($dt->timestamp);
       return $outArray;
        dd($outArray);
    }
}
