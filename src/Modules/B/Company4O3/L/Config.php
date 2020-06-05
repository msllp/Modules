<?php


namespace MS\Mod\B\Company4O3\L;


class Config
{

public static function allStates(){
    $data=[
        [
            'name'=>'Andaman and Nicobar Islands',
            'value'=>35,
            'stateCode'=>'an'
        ] ,
        [
            'name'=>'Andhra Pradesh (OLD)',
            'value'=>28,
            'stateCode'=>'ap'

        ] ,

        [
            'name'=>'Andhra Pradesh (NEW)',
            'value'=>37,
            'stateCode'=>'ad'
        ] ,
        [
            'name'=>'Arunachal Pradesh',
            'value'=>12,
            'stateCode'=>'ar'
        ] ,
        [
            'name'=>'Assam',
            'value'=>18,
            'stateCode'=>'as'
        ] ,
        [
            'name'=>'Bihar',
            'value'=>10,
            'stateCode'=>'bh'
        ] ,
        [
            'name'=>'Chandigarh',
            'value'=>4,
            'stateCode'=>'cd'
        ] ,
        [
            'name'=>'Chattisgarh',
            'value'=>22,
            'stateCode'=>'ct'
        ] ,
        [
            'name'=>'Dadra and Nagar Haveli',
            'value'=>26,
            'stateCode'=>'dn'
        ] ,
        [
            'name'=>'Daman and Diu',
            'value'=>25,
            'stateCode'=>'dd'
        ] ,
        [
            'name'=>'Delhi',
            'value'=>7,
            'stateCode'=>'dl'
        ] ,
        [
            'name'=>'Goa',
            'value'=>30,
            'stateCode'=>'ga'
        ] ,
        [
            'name'=>'Gujarat',
            'value'=>24,
            'stateCode'=>'gj'

        ] ,
        [
            'name'=>'Haryana',
            'value'=>6,
            'stateCode'=>'hr'
        ] ,
        [
            'name'=>'Himachal Pradesh',
            'value'=>2,
            'stateCode'=>'hp'
        ] ,
        [
            'name'=>'Jammu and Kashmir',
            'value'=>1,
            'stateCode'=>'jk'
        ] ,
        [
            'name'=>'Jharkhand',
            'value'=>20,
            'stateCode'=>'jh'
        ] ,
        [
            'name'=>'Karnataka',
            'value'=>29,
            'stateCode'=>'ka'
        ] ,
        [
            'name'=>'Kerala',
            'value'=>32,
            'stateCode'=>'kl'
        ] ,
        [
            'name'=>'Lakshadweep Islands ',
            'value'=>31,
            'stateCode'=>'ld'
        ] ,
        [
            'name'=>'Madhya Pradesh',
            'value'=>23,
            'stateCode'=>'mp'
        ] ,
        [
            'name'=>'Maharashtra',
            'value'=>27,
            'stateCode'=>'mh'
        ] ,
        [
            'name'=>'Manipur',
            'value'=>14,
            'stateCode'=>'mn'
        ] ,
        [
            'name'=>'Meghalaya',
            'value'=>17,
            'stateCode'=>'me'
        ] ,
        [
            'name'=>'Mizoram',
            'value'=>15,
            'stateCode'=>'mi'
        ] ,
        [
            'name'=>'Nagaland',
            'value'=>13,
            'stateCode'=>'nl'
        ] ,
        [
            'name'=>'Odisha',
            'value'=>21,
            'stateCode'=>'or'
        ] ,
        [
            'name'=>'Pondicherry',
            'value'=>34,
            'stateCode'=>'py'
        ] ,
        [
            'name'=>'Punjab',
            'value'=>3,
            'stateCode'=>'pb'
        ] ,
        [
            'name'=>'Rajasthan',
            'value'=>8,
            'stateCode'=>'rj'
        ] ,
        [
            'name'=>'Sikkim',
            'value'=>11,
            'stateCode'=>'sk'
        ] ,
        [
            'name'=>'Tamil Nadu',
            'value'=>33,
            'stateCode'=>'tn'
        ] ,
        [
            'name'=>'Telangana',
            'value'=>36,
            'stateCode'=>'ts'
        ] ,
        [
            'name'=>'Tripura',
            'value'=>16,
            'stateCode'=>'tr'
        ] ,
        [
            'name'=>'Uttar Pradesh',
            'value'=>9,
            'stateCode'=>'up'
        ] ,
        [
            'name'=>'Uttarakhand',
            'value'=>5,
            'stateCode'=>'ut'
        ] ,
        [
            'name'=>'West Bengal',
            'value'=>19,
            'stateCode'=>'wb'
        ]
    ];
    return $data;
}

public static function allCategory(){
    $data=[

        [
            'name'=>'Accounting Services',
            'value'=>'as',
        ] ,
        [
            'name'=>'Consultants,Doctors,Lawyers & Similar',
            'value'=>'consultants',
        ] ,
        [
            'name'=>'Information Technology',
            'value'=>'it',
        ] ,
        [
            'name'=>'Professional, Scientific & Technical Services ',
            'value'=>'ts',
        ] ,
        [
            'name'=>'Manufacturing',
            'value'=>'man',
        ] ,
        [
            'name'=>'Resturants/Bars & Similar',
            'value'=>'res',
        ] ,
        [
            'name'=>'Retail & Similar',
            'value'=>'retail',
        ] ,
        [
            'name'=>'Other Financial Services',
            'value'=>'ofs',
        ] ,
        [
            'name'=>'Other Services',
            'value'=>'os',
        ] ,
        [
            'name'=>'Tours & Travel/Hospitality',
            'value'=>'tours',
        ] ,
        [
            'name'=>'Wholesale Trade',
            'value'=>'wt',
        ] ,
        [
            'name'=>'Logistics Transportation',
            'value'=>'lt',
        ] ,
        [
            'name'=>'Other',
            'value'=>'other',
        ] ,

    ];
    return $data;
}

public static function allTypeOfBusiness(){
    $data=[

        [
            'name'=>'Sole proprietorship',
            'value'=>'solo',
        ] ,
        [
            'name'=>'Partnership Firm',
            'value'=>'partnership',
        ] ,
        [
            'name'=>'Limited Liability Partnership (LLP)',
            'value'=>'llp',
        ] ,
        [
            'name'=>'Private Ltd Company (Pvt. Ltd.)',
            'value'=>'private',
        ] ,
        [
            'name'=>'Public Ltd Company',
            'value'=>'public',
        ] ,
        [
            'name'=>'Co-operatives Firm',
            'value'=>'coop',
        ] ,
    ];
    return $data;
}
public static function allTypeOfLedgerTransaction(){
    $data=[

        [
            'name'=>'Invoice',
            'value'=>'invoice',
        ] ,
        [
            'name'=>'Purchase',
            'value'=>'purchase',
        ] ,
        [
            'name'=>'Salary',
            'value'=>'salary',
        ] ,
        [
            'name'=>'Open',
            'value'=>'open',
        ] ,
        [
            'name'=>'Deposit',
            'value'=>'deposit',
        ] ,
        [
            'name'=>'Withdraw',
            'value'=>'withdraw',
        ] ,
        [
            'name'=>'Cash Received',
            'value'=>'cashin',
        ] ,
        [
            'name'=>'Cash Given',
            'value'=>'cashout',
        ] ,
    ];
    return $data;
}

public static function getStateByCode($code){

    $data=collect(self::allStates());
    $found=$data->where('value','=',$code);
    return ($found->count()>0)?$found->first()['name']:'';
}
public static function getCategory($code){

    $data=collect(self::allCategory());
    $found=$data->where('value','=',$code);
    return ($found->count()>0)?$found->first()['name']:'';
}
public static function getTypeOfBusiness($code){

    $data=collect(self::allTypeOfBusiness());
    $found=$data->where('value','=',$code);
    return ($found->count()>0)?$found->first()['name']:'';
}


}
