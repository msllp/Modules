<?php


namespace MS\Core\Helper;


class MSLang
{

    public static $allowedMod=['Sales','Purchase','Company','Accounts','Operation'];

    public static $allowedLan=['en','gj','hin'];
    public static function  getCore($lang='en'){
        $finalData=[];
       if(in_array($lang,self::$allowedLan)) switch ($lang){
            case 'en':
                $finalData=self::getCoreEn();
                break;
        }


        return $finalData;
    }
    public static function getMod($modId){
        $finalData=[];
        $methodName=implode('',['get',$modId]);
        if(in_array($modId,self::$allowedMod) ) $finalData=self::$methodName();


      //  dd($finalData);
        return $finalData;
    }

    public static function getUI($lang='en',$version='O3'){
        $finalData[$version]=[
            'company'=>['en'=>'Company'],
            'sales'=>['en'=>'Sales'],
            'accounts'=>['en'=>'Accounts'],
            'inventory'=>['en'=>'Inventory'],
            'hr'=>['en'=>'Human Resource'],

            'companyDashboard'=>['en'=>'Company One View'],
            'companyManage'=>['en'=>'Manage Company'],
            'companyDetails'=>['en'=>'Company Details'],
            'companyBank'=>['en'=>'Bank Accounts Details'],
            'companyProductNServices'=>['en'=>'Product & Services'],
            'companyMasterItem'=>['en'=>'Master Items & Services'],
            'companyMasterUnit'=>['en'=>'Master Unit'],
            'companyPaymentTerms'=>['en'=>'Payment Terms & Conditions'],
            'companyTax'=>['en'=>'Tax & Ledgers'],
            'companyMasterTaxSlab'=>['en'=>'Master Tax slab'],
            'companyHSNSAC'=>['en'=>'Master HSN/SAC Code'],
            'companyVendorPayment'=>['en'=>'Vendor Payment Terms'],
            'companyPurchaseType'=>['en'=>'Purchase Category'],

            'hrDashboard'=>['en'=>'HR One View'],
            'hrManageRoles'=>['en'=>'Roles & User'],
            'hraddRoles'=>['en'=>'Add User Role'],
            'hrmanageRoles'=>['en'=>'Manage User Roles'],
            'hraddUsers'=>['en'=>'Add User'],
            'hrmanageUsers'=>['en'=>'Manage Users'],
            'hrleaveNAtta'=>['en'=>'Leave & Attendance'],
            'hrmanegeAtta'=>['en'=>'Manage Attendance'],
            'hrmanageLeave'=>['en'=>'Manage Leave'],
            'hrUserFunction'=>['en'=>'User Function'],
            'hrUserAppointment'=>['en'=>'Appointment Latter'],
            'hrUserExperience'=>['en'=>'Experience Latter'],
            'hrUserSalary'=>['en'=>'Salary Receipt'],
            'acDashboard'=>['en'=>'Account One View'],
            'acManageLedger'=>['en'=>'Manage Ledgers'],
            'acCashLedger'=>['en'=>'Cash Ledgers'],
            'acVendorLedger'=>['en'=>'Vendor Ledgers'],
            'acCustomerLedger'=>['en'=>'Customer Ledgers'],
            'acProfitLedger'=>['en'=>'Profit Ledgers'],
            'acReports'=>['en'=>'Reports'],
            'acSaleReports'=>['en'=>'Sales Report'],
            'acPurchaseReports'=>['en'=>'Purchase Reports'],
            'acGSTReports'=>['en'=>'GST Monthlt Reports'],
            'acBalanceSheet'=>['en'=>'Balance Sheet'],
            'acProfitLoss'=>['en'=>'Profit-Loss Sheet'],

            'invDashboard'=>['en'=>'Inventory One View'],
            'invStock'=>['en'=>'Stock Entries'],
            'invInward'=>['en'=>'Inward Entry'],
            'invOutward'=>['en'=>'Outward Entry'],
            'invLocation'=>['en'=>'Locations'],
            'invAddLocation'=>['en'=>'Add Locations'],
            'invAllLocation'=>['en'=>'Manage Locations'],
            'invLive'=>['en'=>'Live Stock Report'],
            'invLiveItemWiese'=>['en'=>'Stock By Item'],
            'invLiveLocation'=>['en'=>'Stock By Location'],
            'purDashboard'=>['en'=>'Purchase One View'],
            'purPurchase'=>['en'=>'Manage Purchase'],
            'purAddPurchase'=>['en'=>'Add Purchase'],
            'purAllPurchase'=>['en'=>'View All Purchase'],
            'purVendor'=>['en'=>'Vendors'],
            'purAddVendor'=>['en'=>'Add Vendors'],
            'purAllVendor'=>['en'=>'View All Vendors'],

            'salesDashboard'=>['en'=>'Sales One View'],
            'salesManageSales'=>['en'=>'Manage Sales'],
            'salesAddSales'=>['en'=>'Add Sales'],
            'salesAllSales'=>['en'=>'View All Sales'],
            'salesManageCust'=>['en'=>'Customers'],
            'salesAddCust'=>['en'=>'Add Customer'],
            'salesAllCust'=>['en'=>'View All Customers'],

            'panelLoginId'=>['en'=>implode(' / ',['Username','Email','Mobile No.'])],
            'panelLoginPassword'=>['en'=>'Password'],
            'loginForOwner'=>['en'=>'Please login to proceed']


            ];
        return self::processDataForOut($finalData[$version],$lang) ;
    }
    public static function getCoreEn(){
        $finalData=[
            'tableId' => 'Table ID',
            'tableName' => 'Table Name',
            'Status' => 'Status',
            'UniqId'=>'ID',

            'fieldName'=>'Name of Fields',
            'fieldDisplayName'=>'Display Name of Fields',
            'fieldStoreToDB'=>'Store to DB',
            'fieldType'=>'DB Type',
            'fieldInput'=>'Input Type',
            'fieldValidation'=>'Validation Details',

            'actionRoute'=>'',
            'actionBtnText'=>'',
            'actionBtnIcon'=>'',
            'actionBtnColor'=>'',
            'actionRoutePara'=>'',
            'actionMsLinkKey'=>'',
            'actionMsLinkText'=>'',
            'actionDoubleConFirm'=>'',
            'actionDoubleConFirmText'=>'',
            'actionOwnTab'=>'',


            'productCategory'=>'Product Category Details',
            'productCategoryAddBtn'=>'Add Product',
            'productCategoryAddFormTitle'=>'Add new Product',

       //     'VendorCategory'=>'Product Category Details',
            'vendorGroup1'=>'Basic Details',
            'vendorGroup2'=>'Legal Details',
            'vendorGroup3'=>'Address Details',
            'vendorGroup4'=>'Contact Details',
            'vendorGroup5'=>'Module Connect',

            ''





        ];


        return $finalData;
    }
    public static function getSales($lang='en'){
        $finalData=[
            'Navtitle1'=>['en'=>'Manage Leads & Quotations'],

            'NavSub0'=>['en'=>'Sales Dashboard'],
            'NavSub11'=>['en'=>'Get Lead'],
            'NavSub12'=>['en'=>'Generate Quotation'],
            'NavSub14'=>['en'=>'View all Quotation'],
            'NavSub13'=>['en'=>'View all Leads'],

            'Navtitle2'=>['en'=>'Manage Invoices & Payments'],
            'NavSub21'=>['en'=>'Receive Payment'],
            'NavSub22'=>['en'=>'Generate Invoices'],
            'NavSub24'=>['en'=>'View all Payment'],
            'NavSub23'=>['en'=>'View all Invoices'],

            'Navtitle3'=>['en'=>'Manage Customers'],
            'NavSub31'=>['en'=>'Add New Customer'],
            'NavSub32'=>['en'=>'View all Customer'],

            'Navtitle4'=>['en'=>'Manage Templates'],
            'NavSub41'=>['en'=>'Add Quotation Templates'],
            'NavSub42'=>['en'=>'Add Invoices Templates'],
            'NavSub43'=>['en'=>'View all Quotation Templates'],
            'NavSub44'=>['en'=>'View all Invoices Templates'],

            'Navtitle5'=>['en'=>'Manage Product & Services'],
            'NavSub51'=>['en'=>'Add Product or Service'],
            'NavSub52'=>['en'=>'View Product & Services'],

            'DashboardManageLeads'=>['en'=>'Manage Leads'],
            'DashboardManageQuotations'=>['en'=>'Manage Quotations'],
            'DashboardManageInvoices'=>['en'=>'Manage Invoices'],
            'DashboardManageCustomers'=>['en'=>'Manage Customers'],
            'DashboardManageProductsNServices'=>['en'=>'Manage Products & Services'],


        ];

        $finalData4O3=[
            'Navtitle1'=>['en'=>'Manage Leads & Quotations'],

            'NavSub0'=>['en'=>'Sales Dashboard'],
            'NavSub11'=>['en'=>'Add Lead'],
            'NavSub12'=>['en'=>'Generate Quotation'],
            'NavSub14'=>['en'=>'View all Quotation'],
            'NavSub13'=>['en'=>'View all Leads'],

            'Navtitle2'=>['en'=>'Manage Invoices & Payments'],
            'NavSub21'=>['en'=>'Receive Payment'],
            'NavSub22'=>['en'=>'Generate Invoices'],
            'NavSub24'=>['en'=>'View all Payment'],
            'NavSub23'=>['en'=>'View all Invoices'],

            'Navtitle3'=>['en'=>'Manage Customers'],
            'NavSub31'=>['en'=>'Add New Customer'],
            'NavSub32'=>['en'=>'View all Customer'],

            'Navtitle4'=>['en'=>'Manage Templates'],
            'NavSub41'=>['en'=>'Add Quotation Templates'],
            'NavSub42'=>['en'=>'Add Invoices Templates'],
            'NavSub43'=>['en'=>'View all Quotation Templates'],
            'NavSub44'=>['en'=>'View all Invoices Templates'],

            'Navtitle5'=>['en'=>'Manage Product & Services'],
            'NavSub51'=>['en'=>'Add Product or Service'],
            'NavSub52'=>['en'=>'View Product & Services'],

            'DashboardManageLeads'=>['en'=>'Manage Leads'],
            'DashboardManageQuotations'=>['en'=>'Manage Quotations'],
            'DashboardManageInvoices'=>['en'=>'Manage Invoices'],
            'DashboardManageCustomers'=>['en'=>'Manage Customers'],
            'DashboardManageProductsNServices'=>['en'=>'Manage Products & Services'],


        ];

        return self::processDataForOut($finalData,$lang) ;
    }
    public static function getPurchase($lang='en'){
        $finalData=[
            'NavSub0'=>['en'=>'Purchase Dashboard'],
            'Navtitle1'=>['en'=>'Manage  Purchase'],


            'NavSub11'=>['en'=>'Add Cash Purchase'],
            'NavSub12'=>['en'=>'Add Invoice Purchase'],
            'NavSub13'=>['en'=>'View all Cash Purchase'],
            'NavSub14'=>['en'=>'View all Invoice Purchase'],

            'Navtitle2'=>['en'=>'Manage Dues'],
            'NavSub21'=>['en'=>'Clear Cash Purchase'],
            'NavSub22'=>['en'=>'Payment for Invoices'],
            'NavSub24'=>['en'=>'View all Payment'],
            'NavSub23'=>['en'=>'View all Invoices'],

            'Navtitle3'=>['en'=>'Manage Vendor'],
            'NavSub31'=>['en'=>'Add New Vendor'],
            'NavSub32'=>['en'=>'View all Vendors'],


            'Navtitle4'=>['en'=>'Manage Product & Services'],
            'NavSub41'=>['en'=>'Add Product or Service'],
            'NavSub42'=>['en'=>'View Product & Services'],


            'Nav_purchase'=>['en'=>'Purchase'],
            'Nav_purchase_1'=>['en'=>'Manage Item Requirements'],
            'Nav_purchase_1_1'=>['en'=>'Request Items'],
            'Nav_purchase_1_2'=>['en'=>'Approve Items'],

            'Nav_purchase_2'=>['en'=>'Manage PO'],
            'Nav_purchase_2_1'=>['en'=>'Generate PO'],
            'Nav_purchase_2_2'=>['en'=>'Process PO'],
            'Nav_purchase_2_3'=>['en'=>'View all PO'],

            'Nav_purchase_3'=>['en'=>'Manage Items'],
            'Nav_purchase_3_1'=>['en'=>'Add new Item'],
            'Nav_purchase_3_2'=>['en'=>'View All Item'],
            'Nav_purchase_3_3'=>['en'=>'Item Stock'],

            'Nav_purchase_4'=>['en'=>'Manage Vendors'],
            'Nav_purchase_4_1'=>['en'=>'Add new Vendor'],
            'Nav_purchase_4_2'=>['en'=>'View All Vendor'],
            'Nav_purchase_4_3'=>['en'=>'Vendor Accounts'],


        ];

        return self::processDataForOut($finalData,$lang) ;
    }
    public static function getCompany($lang='en'){


        $finalData=[
            'Nav_User_1'=>['en'=>'Users'],
            'Nav_User_h1'=>['en'=>'Users Dashboard'],
            'Navtitle1'=>['en'=>'Manage  Company'],
            'NavSub11'=>['en'=>'Manage Basic Details'],
            'NavSub12'=>['en'=>'Manage Branches'],
            'NavSub13'=>['en'=>'Manage Bank Accounts'],

            'Navtitle2'=>['en'=>'Manage Roles & Users'],
            'NavSub21'=>['en'=>'Add Role'],
            'NavSub22'=>['en'=>'Add User'],
            'NavSub23'=>['en'=>'View Roles'],
            'NavSub24'=>['en'=>'View Users'],

            'Navtitle3'=>['en'=>'Manage Subscription'],
            'NavSub31'=>['en'=>'Upgrade Subscription'],
            'NavSub32'=>['en'=>'Current Subscription'],
            'NavSub33'=>['en'=>'View all Vendor'],
            'NavSub34'=>['en'=>'View all Company'],

            'Navtitle4'=>['en'=>'Support'],
            'NavSub41'=>['en'=>'Ask MAMA'],
            'NavSub42'=>['en'=>'Chat with us'],
            'NavSub43'=>['en'=>'WhatsApp us'],
            'NavSub44'=>['en'=>'Mail us'],
            'NavSub45'=>['en'=>'Call us'],

            'id'=>['en'=>'CompanyID'],
            'name' =>['en'=>'Company Name'],
            'shortname'=>['en'=>'Company Short Code'],
            'city'=>['en'=>'City/Town'],
            'ad1'=>['en'=>'Address Line 1'],
            'ad2'=>['en'=>'Address Line 2'],
            'ad3'=>['en'=>'Address Line 3'],
            'pincode'=>['en'=>'Pincode'],
            'state'=>['en'=>'State'],
            'pincode'=>['en'=>'Pincode'],
            'gst'=>['en'=>'GST No.'],
            'pan'=>['en'=>'PAN/TAN No.'],
            'cin'=>['en'=>'CIN No.'],
            'type'=>['en'=>'Type of Company'],
            'con'=>['en'=>'Contact No.'],
            'email'=>['en'=>'Email'],
            'role'=>['en'=>'Role'],
            'hasbranch'=>['en'=>'Has a Branches ?'],
            'combasic'=>['en'=>'Company Basic Details'],
            'comlegal'=>['en'=>'Legal Details'],
            'comaddress'=>['en'=>'Address Details'],
            'comdconde'=>['en'=>'Contact Details'],
            'comadd'=>['en'=>'Add Company'],
            'commanage'=> ['en'=>'Manage Company Master'],
            'comviewall'=>['en'=>'View All Company']


        ];

        return self::processDataForOut($finalData,$lang) ;
    }
    public static function getOperation($lang='en'){
        $finalData=[

            'mainTitle'=>['en'=>'Operations'],
            'Navtitle1'=>['en'=>'Manage  Machines'],
            'NavSub11'=>['en'=>'Add Vendor'],
            'NavSub12'=>['en'=>'Add Machine'],
            'NavSub13'=>['en'=>'View All Machine'],
            'NavSub14'=>['en'=>'View All Vendor'],
            'NavSub15'=>['en'=>'Add Machine Category'],
            'NavSub16'=>['en'=>'View All Machine Category'],

            'Navtitle2'=>['en'=>'Manage Machines Health'],
            'NavSub21'=>['en'=>'Check Machine Health'],
            'NavSub22'=>['en'=>'Update Insurance Info'],
            'NavSub23'=>['en'=>'View all Machine Health'],
            'NavSub24'=>['en'=>'View All Insurance'],

            'Navtitle3'=>['en'=>'Manage Location & Departments'],
            'NavSub31'=>['en'=>'Add Location'],
            'NavSub32'=>['en'=>'Add Department to Location'],
            'NavSub33'=>['en'=>'Manage Department assigned Machine'],
            'NavSub34'=>['en'=>'View All Location'],
            'NavSub35'=>['en'=>'View All Department'],

            'AddMachineCatFormTitle'=>['en'=>'Add Machine Category'],
            'AddMachineCatGroup1'=>['en'=>'Basic Details of Machine Category'],
            'AddMachineCatField1'=>['en'=>'Category'],
            'AddMachineCatField2'=>['en'=>'Description'],
            'AddMachineCatBtn1'=>['en'=>'Add Category'],

            'AddMachineFormTitle'=>['en'=>'Add Machine'],
            'AddMachineGroup1'=>['en'=>'Basic Details of Machine'],
            'AddMachineGroup2'=>['en'=>'Machine Specification'],
            'AddMachineGroup3'=>['en'=>'Machine Details'],
            'AddMachineBtn1'=>['en'=>'Add Machine'],

            'AddMachineField1'=>['en'=>'Name'],
            'AddMachineField2'=>['en'=>'Description'],
            'AddMachineField3'=>['en'=>'Category'],
            'AddMachineField4'=>['en'=>'Made'],
            'AddMachineField5'=>['en'=>'Model'],
            'AddMachineField6'=>['en'=>'Machine Cost'],
            'AddMachineField7'=>['en'=>'Machine No.'],
            'AddMachineField8'=>['en'=>'Year of Manf.'],
            'AddMachineField9'=>['en'=>'Machine Capacity/Ratio'],
            'AddMachineField10'=>['en'=>'Machine Name'],
            'AddMachineField11'=>['en'=>'Insurance'],
            'AddMachineField12'=>['en'=>'Status'],
            'AddMachineField13'=>['en'=>'Power'],
            'AddMachineField14'=>['en'=>'RPM'],
            'AddMachineField15'=>['en'=>'Capacity'],


            'AddVendorFormTitle'=>['en'=>'Add Vendor'],
            'AddVendorGroup1'=>['en'=>'Basic Details of Vendor'],
            'AddVendorBtn1'=>['en'=>'Add Vendor'],
            'AddVendorField1'=>['en'=>'Name'],
            'AddVendorField2'=>['en'=>'Description'],
            'AddVendorField3'=>['en'=>'Status'],

            'ViewMachineCatFormTitle'=>['en'=>'View all Machine Category'],
            'ViewMachineCatShort'=>['en'=>'View all Machine Category'],




            ];

        return self::processDataForOut($finalData,$lang) ;
    }



    ////Methods
    ///
    public static function processDataForOut($inData,$lang='en'){

        $outData=[];
        foreach ($inData as $id=>$data){
          //  dd(!array_key_exists($id,$outData) && array_key_exists($lang,self::$allowedLan));

            if(!array_key_exists($id,$outData) && in_array($lang,self::$allowedLan) && array_key_exists($lang,$data))$outData[$id]=$data[$lang];
        }

        return $outData;
    }
}
