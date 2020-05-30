<?php

namespace MS\Mod\B\Sales4O3;

//use B\MAS\R\AddMSCoreModule;
use Illuminate\Http\Request;
use MS\Core\Module\MasterController;
use Socialite;

class C extends MasterController
{


    protected $data = [];

    protected $ln = 'en';

    public function test()
    {


        dd(F::setupSalesForCompany('test'));

    }

//    public function AddCategoryForm()
//    {
//        $inputData = [
//            // 'id'=>$id
//        ];
//        return \MS\Mod\B\Sales4O3\L\Product::fromController([['method' => ms()->getFuncitonName(__METHOD__), 'data' => $inputData]]);
//
//    }

    public function AddCategoryFormPost(Request $r)
    {
        $inputData = [
            'r' => $r
        ];
        return \MS\Mod\B\Sales4O3\L\Product::fromController([['method' => ms()->getFuncitonName(__METHOD__), 'data' => $inputData]]);

    }


}
