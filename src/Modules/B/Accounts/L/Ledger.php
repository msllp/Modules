<?php
namespace MS\Mod\B\Accounts\L;
class Ledger{

    public static function msreversefly($companyId=null){

        if($companyId!=null)$d=$companyId;
        if(!isset($d))$d=\MS\Mod\B\Company\L\Company::getCurrentCompany();
        $m=[\MS\Mod\B\Accounts\F::getIncomeModelForCurrent($d),\MS\Mod\B\Accounts\F::getExpenseModelForCurrent($d)];

        foreach ($m as $table){
            if($table->checkTableExist()){
                $table->delete();
            }
        }
    }

    public static function msfly($companyId=null){

        if($companyId!=null)$d=$companyId;
        if(!isset($d))$d=\MS\Mod\B\Company\L\Company::getCurrentCompany();
        $m=[\MS\Mod\B\Accounts\F::getIncomeModelForCurrent($d),\MS\Mod\B\Accounts\F::getExpenseModelForCurrent($d)];

        foreach ($m as $table){
            if(!$table->checkTableExist()){
                $table->migrate();
            }
        }

    }

    public static function getTotalRevenue(){

    $m=\MS\Mod\B\Accounts\F::getIncomeModel();
    $out=number_format(0,2);
    if(count($m->rowGet())>0){
        $data=collect($m->rowGet());
        $out=number_format($data->sum('IncomeTotalAmount'),2);
    }


    return (string)$out;

}
    public static function getTotalExpense(){

        $m=\MS\Mod\B\Accounts\F::getExpenseModel();
        $out=number_format(0,2);
        if(count($m->rowGet())>0){
            $data=collect($m->rowGet());
            $out=number_format($data->sum('ExpenseTotalAmount'),2);
        }


        return (string)$out;

    }

}
