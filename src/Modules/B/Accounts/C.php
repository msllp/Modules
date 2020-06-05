<?php


namespace MS\Mod\B\Accounts;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use MS\Core\Helper\MSDB;


class C extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;
    protected $data=
        [

           'logo'=>"logo-a.png",
           'MOD'=>'MOD::B.Accounts.V'

        ];

    public function indexData(){
        //dd($this->data);
        return view(implode('.',[$this->data['MOD'] , 'Dashboard']));
    }
}
