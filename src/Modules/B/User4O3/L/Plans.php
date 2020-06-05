<?php
namespace MS\Mod\B\User4O3\L;

class Plans
{

    public static $starterPlan=[];
    public static $PaidPlan=[];
    public static $PremiumnPlan=[];

    public static $c_m='O3_Users_Master';
    public static $c_d='O3_Users_Data';
    public static $c_c='O3_Users_Config';
    public static $modCode='Users4O3';

    public static function getTableRaw(){

        $methodToCall=[
            'setUpPlanCategory'=>[],
          // 'setUpPlanCatergoryLimits'=>[],
            ];
        $c=new self() ;
        $d=[];
        foreach ($methodToCall as $method=>$data)if(method_exists($c,$method))$d=array_merge($d,$c->$method($data));
        return $d;
        dd($d);



    }

    private function setUpPlanCategory(){

        $data=[
            'tableId'=>implode('_',[self::$modCode,'Plans']),
            'tableName'=>implode('_',[self::$modCode,'Plans']),
            'connection'=>self::$c_m,
        ];
        $m=new  \MS\Core\Helper\MSTableSchema($data);

        $m->setFields(['name'=>'UniqId','type'=>'string']);
        $m->setFields(['name'=>'PlanIcon','type'=>'string']);
        $m->setFields(['name'=>'PlanName','type'=>'string']);
        $m->setFields(['name'=>'PlanDescriptionShort','type'=>'string',]);
        $m->setFields(['name'=>'PlanDescriptionLong','type'=>'string',]);
        $m->setFields(['name' => 'Invoice', 'type' => 'string']);
        $m->setFields(['name' => 'Purchase', 'type' => 'string',]);
        $m->setFields(['name' => 'Product', 'type' => 'string',]);
        $m->setFields(['name' => 'Company', 'type' => 'string',]);
        $m->setFields(['name' => 'PerCompanyUser', 'type' => 'string',]);
        $m->setFields(['name' => 'PerMonth', 'type' => 'string',]);
        $m->setFields(['name' => 'PerMonthFor6Month', 'type' => 'string',]);
        $m->setFields(['name' => 'PerMonthFor1Year', 'type' => 'string',]);
        $m->setFields(['name' => 'PerMonthFor2Year', 'type' => 'string',]);
        $m->setFields(['name' => 'BaseCurrency', 'type' => 'string',]);
        $m->setFields(['name' => 'TotalUsers', 'type' => 'string',]);
        $m->setFields(['name' => 'PlanStatus', 'type' => 'boolean',]);

        $m1=$m->finalReturnForTableFile();

        return array_merge($m1);
    }

    private function setUpPlanCatergoryLimits()
    {
        $data = [
            'tableId' => implode('_', [self::$modCode, 'Plans']),
            'tableName' => implode('_', [self::$modCode, 'Plans']),
            'connection' => self::$c_m,
        ];
        $m = new  \MS\Core\Helper\MSTableSchema($data);


        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'PlanId', 'type' => 'string']);
        $m->setFields(['name' => 'Invoice', 'type' => 'string']);
        $m->setFields(['name' => 'Purchase', 'type' => 'string',]);
        $m->setFields(['name' => 'Product', 'type' => 'string',]);
        $m->setFields(['name' => 'Company', 'type' => 'string',]);
        $m->setFields(['name' => 'PerCompanyUser', 'type' => 'string',]);
        $m->setFields(['name' => 'PerMonth', 'type' => 'string',]);
        $m->setFields(['name' => 'PerMonthFor6Month', 'type' => 'string',]);
        $m->setFields(['name' => 'PerMonthFor1Year', 'type' => 'string',]);
        $m->setFields(['name' => 'PerMonthFor2Year', 'type' => 'string',]);
        $m->setFields(['name' => 'BaseCurrency', 'type' => 'string',]);
        $m->setFields(['name' => 'TotalUsers', 'type' => 'string',]);


        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }


    public static function migrate(){

        $c = new \MS\Core\Helper\MSDB('MS\Mod\B\User4O3',implode('_', [self::$modCode, 'Plans']));
       // $c->migrate();
        dd($c->migrate());
    }




    public function getAllPlan(){

        $c = new \MS\Core\Helper\MSDB('MS\Mod\B\User4O3',implode('_', [self::$modCode, 'Plans']));

        return $c->rowGet();






    }

    public function getAllPlanForWebsite(){
        $c = new \MS\Core\Helper\MSDB('MS\Mod\B\User4O3',implode('_', [self::$modCode, 'Plans']));
        $d=$c->rowGet();
        $d=array_map(function ($array){
            $array['max']= round($array['PerMonth']*1.20,0,PHP_ROUND_HALF_UP ) ;

            $per=($array['PerMonthFor1Year']*100)/$array['PerMonth'];
            //var_dump($array);


            $array['PerMonthFor6Month']=$array['PerMonth']-(( $array['PerMonthFor6Month'] *$array['PerMonth'])/100);
            $array['PerMonthFor1Year']=$array['PerMonth']-(( $array['PerMonthFor1Year'] *$array['PerMonth'])/100);
            $array['PerMonthFor2Year']=$array['PerMonth']-(( $array['PerMonthFor2Year'] *$array['PerMonth'])/100);


           // if($array['id']==3)dd($array);

           // $array['planDetail']=$smpl;
            switch ($array['id']){
                case '1':
                  //  $array['PerMonth']=0;
                $array['imageStyle']=['background-color'=>'rgba(0,167,157,0.5)',
                        'border-radius'=>'10%'];
                    break;
                case '2':
                    $array['imageStyle']=['background-color'=>'rgba(247,148,29,0.5)',
                        'border-radius'=>'10%'];
                    break;
                case '3':
                    $array['imageStyle']=['background-color'=>'rgba(113,48,170,0.5)',
                        'border-radius'=>'10%'];
                    break;
                case '3':
                    $array['imageStyle']=['background-color'=>'rgba(0,0,0,0.5)',
                        'border-radius'=>'10%'];
                    break;
            }
            $hidden=['created_at','updated_at','id'];

            foreach ($hidden as $k)
            if(array_key_exists($k,$array))unset($array[$k]);
           // dd($array);
            return $array;
        },$d);
      //      dd(implode('_', [self::$modCode, 'Plans']));
      //  dd(collect($d)->pluck(['id','UniqId']));
       // dd($d);
        return response()->json($d);
        //dd($d);
        //return $c->rowGet();
    }

    public static function getAllPlanS(){

        $c = new \MS\Core\Helper\MSDB('MS\Mod\B\User4O3',implode('_', [self::$modCode, 'Plans']));

        return $c->rowGet();
    }

}
