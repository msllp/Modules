<?php
return

[
    [
        'UniqId'=>'001',
        'IncomeTypeName'=>'INVOICE',
        'IncomeTypeDescription'=>'Invoices Generated For Client',
        'IncomeTypeData'=>collect([])->toJson(),
        'Status'=>1
    ],
    [
        'UniqId'=>'002',
        'IncomeTypeName'=>'CAPITAL',
        'IncomeTypeDescription'=>'Capital or Opening Balance',
        'IncomeTypeData'=>collect([])->toJson(),
        'Status'=>1
    ]
];
