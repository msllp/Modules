<?php

return [


    "Account_Paid_Status"=>[

        'tableName'=>'Accounts_Master_Paid_Status',
        'connection'=>'AC',
        'fields'=>[

            [
                'name'=>'UniqId',
                'vName'=>'ID',
                'type'=>'string',
                'input'=>'auto',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'PaidStatusValue',
                'vName'=>'Name of Role',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'PaidStatusName',
                'vName'=>'Name of Role',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'Status',
                'vName'=>'Status',
                'type'=>'boolean',
                'input'=>'radio',
                "validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]
            ],
        ],
        'fieldGroup'=>[

        ],
        'fieldGroupMultiple'=>[

        ],
        'action'=>[





        ],
        'validationMessage'=>[
        ],
        'MSforms'=>[

        ],
        'MSViews'=>[


        ],
    ],

    "Account_Income_Type"=>[

        'tableName'=>'Accounts_Master_Income_Type',
        'connection'=>'AC',
        'fields'=>[

            [
                'name'=>'UniqId',
                'vName'=>'ID',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'IncomeTypeName',
                'vName'=>'Name of Role',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'IncomeTypeDescription',
                'vName'=>'Name of Role',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'IncomeTypeData',
                'vName'=>'Name of Role',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'Status',
                'vName'=>'Status',
                'type'=>'boolean',
                'input'=>'radio',
                "validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]
            ],
        ],
        'fieldGroup'=>[

        ],
        'fieldGroupMultiple'=>[

        ],
        'action'=>[





        ],
        'validationMessage'=>[
        ],
        'MSforms'=>[

        ],
        'MSViews'=>[


        ],
    ],
    "Account_Expense_Type"=>[

        'tableName'=>'Accounts_Master_Expense_Type',
        'connection'=>'AC',
        'fields'=>[

            [
                'name'=>'UniqId',
                'vName'=>'ID',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'ExpenseTypeName',
                'vName'=>'Name of Role',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
            [
                'name'=>'ExpenseTypeDescription',
                'vName'=>'Name of Role',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'ExpenseTypeData',
                'vName'=>'Name of Role',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],

            [
                'name'=>'Status',
                'vName'=>'Status',
                'type'=>'boolean',
                'input'=>'radio',
                "validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]
            ],
            ],


            'fieldGroup'=>[

            ],
            'fieldGroupMultiple'=>[

            ],
            'action'=>[





            ],
            'validationMessage'=>[
            ],
            'MSforms'=>[

            ],
            'MSViews'=>[


            ],

    ],



    "Account_Income"=>[

        'tableName'=>'Accounts_Master_Income',
        'connection'=>'AM',
        'fields'=>
            [

                [
                    'name'=>'UniqId',
                    'vName'=>'ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'IncomeType',
                    'vName'=>'Name of Role',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],


                [
                    'name'=>'IncomeId',
                    'vName'=>'Role Icon',
                    'type'=>'string',
                    'input'=>'option',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_UI_ICON_1]
                ],

                [
                    'name'=>'IncomeAmount',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IncomeTaxAmount',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IncomeTotalAmount',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IncomePaidStatus',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'Status',
                    'vName'=>'Status',
                    'type'=>'boolean',
                    'input'=>'radio',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]
                ],




            ],
        'fieldGroup'=>[

            //  'User Role Details 2'=>['UserTypeName','UserTypeIcon','UserTypeDesc','UserTypeLoginLink','Status'],

        ],
        'fieldGroupMultiple'=>[

        ],

        'action'=>[

            // 'edit'=>"",

        ],

        'validationMessage'=>[

        ],


        'MSforms'=>[

        ],


        'MSViews'=>[







        ],


    ],
    "Account_Expense"=>[

        'tableName'=>'Accounts_Master_Expense',
        'connection'=>'AM',
        'fields'=>
            [

                [
                    'name'=>'UniqId',
                    'vName'=>'ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'ExpenseType',
                    'vName'=>'Name of Role',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],


                [
                    'name'=>'ExpenseId',
                    'vName'=>'Role Icon',
                    'type'=>'string',
                    'input'=>'option',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_UI_ICON_1]
                ],

                [
                    'name'=>'ExpenseAmount',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'ExpenseTaxAmount',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'ExpenseTotalAmount',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'ExpensePaidStatus',
                    'vName'=>'Role Description',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'Status',
                    'vName'=>'Status',
                    'type'=>'boolean',
                    'input'=>'radio',
                    "validation"=>['required'=>true,'existIn'=>MSCORE_UI_BOOL_1]
                ],




            ],
        'fieldGroup'=>[

            //  'User Role Details 2'=>['UserTypeName','UserTypeIcon','UserTypeDesc','UserTypeLoginLink','Status'],

        ],
        'fieldGroupMultiple'=>[

        ],

        'action'=>[

            // 'edit'=>"",

        ],

        'validationMessage'=>[

        ],


        'MSforms'=>[

        ],


        'MSViews'=>[







        ],


    ],



    "Account_Income_Type_Sub"=>[

        'tableName'=>'MS_Master_Income_Type',//_IncomeTypeCode
        'connection'=>'AD',
        'fields'=>
            [
                [
                    'name'=>'UniqId',
                    'vName'=>'ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'IncomeMonth',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IncomeYear',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IncomeAmount',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IncomeTax',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IncomeDay',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],


                [
                'name'=>'IncomeDetail',
                'vName'=>'Event ID',
                'type'=>'string',
                'input'=>'text',
                "validation"=>['required'=>true,]
            ],
                [
                    'name'=>'IncomeDetailID',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],






            ],
        'fieldGroup'=>[

        ],
        'fieldGroupMultiple'=>[

        ],
        'action'=>[





        ],
        'validationMessage'=>[
        ],
        'MSforms'=>[

        ],
        'MSViews'=>[


        ],

    ],

    "Account_Expense_Type_Sub"=>[

        'tableName'=>'MS_Master_Expense_Type',//_ExpenseTypeCode
        'connection'=>'AD',
        'fields'=>
            [
                [
                    'name'=>'UniqId',
                    'vName'=>'ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'Day',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'Month',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'Year',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'ExpenseAmount',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'ExpenseTax',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],



                [
                    'name'=>'ExpenseDetail',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],


                [
                    'name'=>'ExpenseDetailID',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],




            ],
        'fieldGroup'=>[

        ],
        'fieldGroupMultiple'=>[

        ],
        'action'=>[





        ],
        'validationMessage'=>[
        ],
        'MSforms'=>[

        ],
        'MSViews'=>[


        ],

    ],

    "Account_Income_Details"=>[

        'tableName'=>'MS_Master_Income_Details',//_ExpenseTypeCode_DeatilsId
        'connection'=>'AD',
        'fields'=>
            [
                [
                    'name'=>'UniqId',
                    'vName'=>'ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IdifierId',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'Quantity',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'Amount',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'TaxAmount',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'Currency',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'TotalAmount',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'ExtraData',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],




            ],
        'fieldGroup'=>[

        ],
        'fieldGroupMultiple'=>[

        ],
        'action'=>[





        ],
        'validationMessage'=>[
        ],
        'MSforms'=>[

        ],
        'MSViews'=>[


        ],

    ],
    "Account_Expense_Details"=>[

        'tableName'=>'MS_Master_Expense_Details',//_ExpenseTypeCode_DeatilsId
        'connection'=>'AD',
        'fields'=>
            [
                [
                    'name'=>'UniqId',
                    'vName'=>'ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'IdifierId',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],

                [
                    'name'=>'Quantity',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'Amount',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'TaxAmount',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'TotalAmount',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],
                [
                    'name'=>'ExtraData',
                    'vName'=>'Event ID',
                    'type'=>'string',
                    'input'=>'text',
                    "validation"=>['required'=>true,]
                ],




            ],
        'fieldGroup'=>[

        ],
        'fieldGroupMultiple'=>[

        ],
        'action'=>[





        ],
        'validationMessage'=>[
        ],
        'MSforms'=>[

        ],
        'MSViews'=>[


        ],

    ],


];
