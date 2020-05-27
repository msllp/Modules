<?php


namespace MS\Mod\B\Mod4O3\L;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use MS\Core\Helper\MSDB;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;

class App extends Logic
{

    public static $c_m = 'O3_Sales_Master';
    public static $c_d = 'O3_Sales_Data';
    public static $c_c = 'O3_Sales_Config';
    public static $modCode = 'Sales4O3';
    public $DB=[];

    public function getAllowedCompany(){
        $user=ms()->user();

        $allowedCompany=[];
        if(array_key_exists('CompanyPost',$user)){
           $c=new \MS\Mod\B\User4O3\L\SubUser();
           $m=$c->getUserRolePermissionsModel(implode('_',[$user['RootId'],$user['CompanyPost']]));
           $all=collect($m->rowAll());
           $allowedCompany=array_keys($all->groupBy('CompanyId')->toArray());
        }
        return $allowedCompany;
    }
    public function getAllowedModules(){
        $user=ms()->user();
        $currentCompany=ms()->user()['currentCompany'];
        $allowedCompany=[];
        if(array_key_exists('CompanyPost',$user)){
           $c=new \MS\Mod\B\User4O3\L\SubUser();
           $m=$c->getUserRolePermissionsModel(implode('_',[$user['RootId'],$user['CompanyPost']]));
           $all=collect($m->rowAll());
           $allowedCompany=array_keys($all->where('CompanyId',$currentCompany)->groupBy('ModuleId')->toArray());
        }
        return $allowedCompany;
    }
    public function getAllowedModulesWithSub($sub){
        $user=ms()->user();

        $allowedCompany=[];
        $currentCompany=ms()->user()['currentCompany'];
      //  dd($currentCompany);
        if(array_key_exists('CompanyPost',$user)){
           $c=new \MS\Mod\B\User4O3\L\SubUser();
           $m=$c->getUserRolePermissionsModel(implode('_',[$user['RootId'],$user['CompanyPost']]));
           $all=collect($m->rowAll());
           $allowedCompany=array_keys($all->where('CompanyId',$currentCompany)->where('ModuleId',$sub)->groupBy('ModuleSubId')->toArray());
        }
        return $allowedCompany;
    }

    public function genrateApiTokenForFrontEnd ($data){
        $r=$data['r'];
        $debug=0;
        $er=[
            '419'=>['Dont try to be smart . You are not only who think smart.']
        ];
        if(!$debug && !$r->headers->has('MS-APP-ID'))return $this->throwError($er['419']);
        $appId=$r->headers->get('MS-APP-ID');
        return $this->throwData(['csrf'=>\MS\Core\Helper\Comman::encodeLimit($appId,120)]);


    }

    public function getPermisions(){

        $data=[
            $this->getSalesPermisions(),
            $this->getPurchasePermisions(),
            $this->getInventoryPermisions(),
            $this->getHRPermisions(),
    //        $this->getCompanyPermisions(),
            $this->getAccountsPermisions(),
        ];

        return $data;

    }

    public function checkPermission($method,$sampleData=[]){

        if(count($sampleData)<1){

        }

        $mapFunction=function ($ar)use ($method){
            $ar['ModuleActionMethod']=json_decode($ar['ModuleActionMethod'],true);
            if(in_array($method,$ar['ModuleActionMethod']))return $ar;
        };
        $foundPermision=array_filter(array_map($mapFunction,$sampleData));
        return (count($foundPermision)>0)?true:false;


    }

    public function getMethods($mod,$section,$action){
       // dd($section);
        $allData=$this->getPermisions();
        $allCollection=collect($allData);
        $foundMod=$allCollection->where('id',$mod)->toArray();
        $foundMod=reset($foundMod);
        $foundModCollection=collect($foundMod['action']);
        $foundSection=$foundModCollection->where('id',$section)->toArray();
        $foundSection=reset($foundSection);
        $foundSectionCollection=collect($foundSection['action']);
        $foundAction=$foundSectionCollection->where('id',$action)->toArray();
        $foundSection=reset($foundAction);
        //return $foundSection['methods'];
        return  collect($foundSection['methods'])->toJson();
    }

    public static function getProccessedPermissionForTableEntry($data){
        $th=new Self();
        $allCompany=$data['companies'];
        $modules=$data['modules'];
        $subModules=$data['subModules'];
      //  dd($data);
        $data=[
            'CompanyId'=>'',
            'ModuleId'=>'',
            'ModuleSubId'=>'',
            'ModuleActionId'=>'',
            'ModuleActionMethod'=>''
        ];
        $outData=[];
        foreach ($allCompany as $companyId=>$v){
            $enabledModulesForCompany=[];

            if($v){

                $enabledModulesForCompany=(array_key_exists($companyId,$modules) && $modules)?$modules[$companyId]:[];

                foreach ($enabledModulesForCompany as $mod=>$v2){

                    if($v2){

                        foreach ($subModules[$companyId][$mod] as $section=>$v3){

                            if(count($v3)>0){
                                foreach ($v3 as $action=>$v4){

                                    if($v4){
                                        $outData[]=[
                                            'CompanyId'=>$companyId,
                                            'ModuleId'=>$mod,
                                            'ModuleSubId'=>$section,
                                            'ModuleActionId'=>$action,
                                            'ModuleActionMethod'=>$th->getMethods($mod,$section,$action)
                                        ];

                                    }
                                }

                            }


                        }


                    }


                }
            }
        }


            return $outData;
    }

    private function getSalesPermisions(){

        $data=[
            'name'=>'Sales',
            'id'=>'sales',
            'action'=>[
                [
                    'section'=>'Customer',
                    'id'=>'customer',
                    'action'=>[
                        [
                            'name'=>'Add Customer',
                            'id'=>'addCustomer',
                            'methods'=>['\MS\Mod\B\User4O3\C@CreateUserRole','\MS\Mod\B\User4O3\C@SaveUserRole']
                        ],
                        [
                            'name'=>'Edit Customer',
                            'id'=>'editCustomer',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Customer',
                            'id'=>'viewCustomer',
                            'methods'=>[]
                        ],
                    ]
                ],
                [
                    'section'=>'Lead',
                    'id'=>'lead',
                    'action'=>[
                        [
                            'name'=>'Add Lead',
                            'id'=>'addLead',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Lead',
                            'id'=>'editLead',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View All Lead',
                            'id'=>'viewLead',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Lead',
                            'id'=>'viewOwnLead',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Transfer/Allot Lead',
                            'id'=>'allorLead',
                            'methods'=>[]
                        ]
                    ]
                ],
                [
                    'section'=>'Quotation',
                    'id'=>'quotation',
                    'action'=>[
                        [
                            'name'=>'Add Quotation',
                            'id'=>'addQuotation',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Quotation',
                            'id'=>'editQuotation',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View All Quotation',
                            'id'=>'viewQuotation',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Quotation',
                            'id'=>'viewOwnQuotation',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Revise  Quotation',
                            'id'=>'reviseQuotation',
                            'methods'=>[]
                        ]
                    ]
                ],
                [
                    'section'=>'Invoice',
                    'id'=>'invoice',
                    'action'=>[
                        [
                            'name'=>'Add Invoice',
                            'id'=>'addInvoice',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Invoice',
                            'id'=>'editInvoice',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Invoice',
                            'id'=>'viewInvoice',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Invoice',
                            'id'=>'viewOwnInvoice',
                            'methods'=>[]
                        ]
                    ]
                ],
                [
                    'section'=>'Payment',
                    'id'=>'payments',
                    'action'=>[
                        [
                            'name'=>'Add Payment',
                            'id'=>'addPayment',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Payment',
                            'id'=>'editPayment',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Payment',
                            'id'=>'viewPayment',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Payment',
                            'id'=>'viewOwnPayment',
                            'methods'=>[]
                        ]
                    ]
                ],

            ]
        ];

        return $data;
    }
    private function getPurchasePermisions(){

        $data=[
            'name'=>'Purchase',
            'id'=>'purchase',
            'action'=>[

                [
                    'section'=>'Cash Purchase',
                    'id'=>'cashpurchase',
                    'action'=>[
                        [
                            'name'=>'Add Cash Purchase',
                            'id'=>'addCashPurchsae',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Cash Purchase',
                            'id'=>'editCashPurchase',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View All Cash Purchase',
                            'id'=>'viewCashPurchase',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Cash Purchase',
                            'id'=>'viewOwnCashPurchase',
                            'methods'=>[]
                        ]
                    ]
                ],
                [
                    'section'=>'Invoice Purchase',
                    'id'=>'invoicepurchase',
                    'action'=>[
                        [
                            'name'=>'Add Invoice Purchase',
                            'id'=>'addInvoicePurchase',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Invoice Purchase',
                            'id'=>'editInvoicePurchase',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View All Invoice Purchase',
                            'id'=>'viewInvoicePurchase',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Invoice Purchase',
                            'id'=>'viewOwnInvoicePurchase',
                            'methods'=>[]
                        ],
                    ]
                ],
                [
                    'section'=>'Vendor',
                    'id'=>'vendor',
                    'action'=>[
                        [
                            'name'=>'Add Vendor',
                            'id'=>'addVendor',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Vendor',
                            'id'=>'editVendor',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Vendor',
                            'id'=>'viewVendor',
                            'methods'=>[]
                        ],
                    ]
                ],
                [
                    'section'=>'Payment',
                    'id'=>'payments',
                    'action'=>[
                        [
                            'name'=>'Add Payment',
                            'id'=>'addPayment',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Payment',
                            'id'=>'editPayment',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Payment',
                            'id'=>'viewPayment',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Payment',
                            'id'=>'viewOwnPayment',
                            'methods'=>[]
                        ]
                    ]
                ],

            ]
        ];

        return $data;
    }
    private function getInventoryPermisions(){

        $data=[
            'name'=>'Inventory',
            'id'=>'inventory',
            'action'=>[

                [
                    'section'=>'Stocks',
                    'id'=>'stocks',
                    'action'=>[
                        [
                            'name'=>'Inward Stocks',
                                'id'=>'inStocks',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Outward Stock',
                            'id'=>'outStocks',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Shift Stock',
                            'id'=>'shiftStock',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Stock',
                            'id'=>'viewStocks',
                            'methods'=>[]
                        ]
                    ]
                ],
                [
                    'section'=>'Locations',
                    'id'=>'purchase',
                    'action'=>[
                        [
                            'name'=>'Add Location',
                            'id'=>'addLocation',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Location',
                            'id'=>'editLocation',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Location',
                            'id'=>'viewLocation',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Loaction',
                            'id'=>'viewOwnLocation',
                            'methods'=>[]
                        ],
                    ]
                ],
                [
                    'section'=>'Suppliers',
                    'id'=>'suppliers',
                    'action'=>[
                        [
                            'name'=>'Add Suppliers',
                            'id'=>'addSuppliers',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Suppliers',
                            'id'=>'editSuppliers',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Suppliers',
                            'id'=>'viewSuppliers',
                            'methods'=>[]
                        ],
                    ]
                ],


            ]
        ];

        return $data;
    }
    private function getHRPermisions(){

        $data=[
            'name'=>'Human Resource',
            'id'=>'hr',
            'action'=>[

                [
                    'section'=>'Employee',
                    'id'=>'employee',
                    'action'=>[
                        [
                            'name'=>'Add Employee',
                            'id'=>'addEmployee',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Employee',
                            'id'=>'editEmployee',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View All Employee',
                            'id'=>'viewEmployee',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Employee',
                            'id'=>'viewOwnEmployee',
                            'methods'=>[]
                        ]
                    ]
                ],
                [
                    'section'=>'Attendance & Leave',
                    'id'=>'attendancenLeave',
                    'action'=>[
                        [
                            'name'=>'Feed Attendance',
                            'id'=>'feedAttedance',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Invoice Purchase',
                            'id'=>'editInvoicePurchase',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View All Invoice Purchase',
                            'id'=>'viewInvoicePurchase',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'View Own Invoice Purchase',
                            'id'=>'viewOwnInvoicePurchase',
                            'methods'=>[]
                        ],
                    ]
                ],
                [
                    'section'=>'Salary',
                    'id'=>'salary',
                    'action'=>[
                        [
                            'name'=>'Generate Salary Slip',
                            'id'=>'generateSalrarySlip',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Edit Salary Vendor',
                            'id'=>'editSalrarySlip',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Salary Report',
                            'id'=>'salaryReport',
                            'methods'=>[]
                        ],
                    ]
                ],


            ]
        ];

        return $data;
    }

    private function getAccountsPermisions(){

        $data=[
            'name'=>'Accounts',
            'id'=>'accounts',
            'action'=>[

                [
                    'section'=>'Ledgers',
                    'id'=>'ledgers',
                    'action'=>[
                        [
                            'name'=>'Income Ledgers',
                            'id'=>'incomeledger',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Expense Ledgers',
                            'id'=>'expenseledger',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Client Ledger',
                            'id'=>'clientledger',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Vendor Ledger',
                            'id'=>'vendorledger',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Cash Ledger',
                            'id'=>'cashledger',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Bank Ledger',
                            'id'=>'bankledger',
                            'methods'=>[]
                        ]
                    ]
                ],
                [
                    'section'=>'Reports',
                    'id'=>'reports',
                    'action'=>[
                        [
                            'name'=>'Sales Report',
                            'id'=>'salesreport',
                            'methods'=>[]
                        ],
                        [
                            'name'=>'Purchase Report',
                            'id'=>'purchasereport',
                            'methods'=>[]
                        ],

                    ]
                ],

            ]
        ];

        return $data;
    }

}
