<?php

namespace MS\Mod\B\Mod4O3;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\Comman;
use Razorpay\Api;
use function GuzzleHttp\Promise\all;
use Socialite;
class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;


    protected $data=[];

    protected $ln='en';


    public function genrateApiToken(Request $r){
        $data=['r'=>$r];
        return L\App::fromController([['method'=>'genrateApiTokenForFrontEnd','data'=>$data]]) ;

    }





}
