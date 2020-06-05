<?php


namespace MS\Mod\B\Sales;



use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use MS\Core\Helper\Comman;
use Socialite;
class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;

    public  function dashboard(){

        return view('MOD::B.Sales.V.Dashboard');


    }

}
