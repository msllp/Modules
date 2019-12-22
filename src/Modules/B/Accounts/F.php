<?php
namespace MS\Mod\B\Accounts;

class F
{



    public static function getPaidStatusModel(){

        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Account_Paid_Status');

    }


    public static function getIncomeTypeModel(){

        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Account_Income_Type');

    }

    public static function getExpenseTypeModel(){

        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Account_Expense_Type');

    }

    public static function getIncomeModel(){

        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Account_Income');

    }
    public static function getExpenseModel(){

        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Account_Expense');

    }


    public static function getIncomeModelForCurrent($CompanyId){
        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Account_Income',[$CompanyId]);

    }
    public static function getExpenseModelForCurrent($CompanyId){
        return new \MS\Core\Helper\MSDB(__NAMESPACE__,'Account_Expense',[$CompanyId]);
    }




}
