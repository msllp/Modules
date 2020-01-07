<?php


namespace MS\Mod\B\Mod\L;


class Nav
{
private $fData,$fromData;


    public static function getNav(){
        $c=new self();
        return $c->getDefaultData();



    }


    public function addL1($id,$data){

        $this->setFromData($id,$data);
        return $this;
    }

    public function addL2Link($id,$data){
        $bdata=[
            'type'=>'link',
        ];
        $bdata=array_merge($bdata,$data);
        $this->addL2($id,$bdata);
        return $this;
    }
    public function addL2Title($id,$data){
        $bdata=[
            'type'=>'title',
        ];
        $bdata=array_merge($bdata,$data);

        $this->addL2($id,$bdata);
     //  dd($this);
        return $this;
    }

    public function addL2($id,$data){
        //dd($this->getFromData());
        $setData=$this->getFromData();
        if(is_array($setData) && array_key_exists($id,$setData))$setData[$id]['sub'][]=$data;

       // dd($setData);

        $this->setFromData($id,$setData[$id]);
        return $this;
    }

    private function processData(){
        $bdata=[
            'type'=>'mainNav',
        ];
        $setData=$this->getFromData();
        $fData=[];
        if(is_array($setData))foreach ($setData as $id=>$data){
         if(!array_key_exists('name',$data)) $bdata['text']=$id;
        $fData[$id]=array_merge($bdata,$data);

        }
     //   dd($fData);
        return $fData;


    }

    private function getDefaultData(){

        $id=\Lang::get('UI.company');
        $this->addL1($id,['icon'=>'fi2 flaticon-ui-3 msicon-r-270']);



        $user=\Lang::get('UI.sales');
        $this->addL1($user,['icon'=>'fi2 flaticon-payment']);
        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle1'),'icon'=> 'fi2 flaticon-msicon-for-manageleadsnquataions']);

        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub11'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub12'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addquotation ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub13'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub14'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewquotation ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle2'),'icon'=> 'fi2 flaticon-msicon-for-manageinvoicenpayment']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub21'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addpayment ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub22'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addinvoice ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub23'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewinvoice ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub24'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewpayments ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle3'),'icon'=> 'fi2 flaticon-msicon-for-managecustomer']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub31'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addcustomer ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub32'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewcustomer ']);

        $this->addL2Title($user,['text'=>\Lang::get('Sales.Navtitle4'),'icon'=> 'fi2 flaticon-msicon-for-managetemplates']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub41'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub42'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-addquotation ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub43'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewlead ']);
        $this->addL2Link($user,['text'=>\Lang::get('Sales.NavSub44'),'link'=> route('MOD.User.Master.AddForm'),'icon'=>' fi2 flaticon-msicon-for-viewquotation ']);


        $id=\Lang::get('UI.purchase');
        $this->addL1($id,['icon'=>'fi2 flaticon-payment msicon-fh-180']);

        $id=\Lang::get('UI.accounts');
        $this->addL1($id,['icon'=>'fi2 flaticon-list']);

        return $this->processData();
       // dd();
        $data=[
            [
                'text'=>\Lang::get('UI.users'),
                'type'=>'mainNav',
                'icon'=>'fi2 flaticon-user-2',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Root User',
                        'icon'=> 'fi flaticon-problem'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Add Root User',
                        'link'=> route('MOD.User.Master.AddForm'),
                        'icon'=>'fi flaticon-partner'
                    ]

                    ,

                    [
                        'type'=> 'link',
                        'text'=> 'View All Root Users',
                        'link'=> route('MOD.User.Master.View.All'),
                        'icon'=>'fi flaticon-users-group'
                    ],
                    [
                        'type'=> 'title',
                        'text'=> 'Manage App User Roles',
                        'icon'=> 'fas fa-cogs'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Add User Role',
                        'link'=> route('MOD.User.Master.Roles.AddForm'),
                        'icon'=>'fi flaticon-partner'
                    ]

                    ,

                    [
                        'type'=> 'link',
                        'text'=> 'View All User Roles',
                        'link'=> route('MOD.User.Master.Roles.View.All'),
                        'icon'=>'fi flaticon-users-group'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Add App User',
                        'link'=> route('MOD.User.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ],

                ],
            ],


            [
                'text'=>\Lang::get('UI.modules'),
                'type'=>'mainNav',
                'icon'=>'fi2 flaticon-pyramid-graphic',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Modules',
                        'icon'=> 'fi flaticon-execution'
                    ], [
                        'type'=> 'link',
                        'text'=> 'Add Module',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ]
                    ,[
                        'type'=> 'link',
                        'text'=> 'View All Modules',
                        'link'=> route('MOD.Mod.Master.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],
                    [
                        'type'=> 'title',
                        'text'=> 'Manage Routes',
                        'icon'=> 'fi flaticon-execution'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Add Route',
                        'link'=> route('MOD.Mod.Master.Route.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'View All Routes',
                        'link'=> route('MOD.Mod.Master.Route.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Events',
                        'icon'=> 'fi flaticon-commerce-and-shopping-1'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Add Event',
                        'link'=> route('MOD.Mod.Master.Event.AddForm'),
                        'icon'=>'fi flaticon-add'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'View All Events',
                        'link'=> route('MOD.Mod.Master.Event.View.All'),
                        'icon'=>'fi flaticon-plan'
                    ],



                ],
            ],

            [

                'text'=>\Lang::get('UI.company'),
                'type'=>'mainNav',
                'icon'=>'fi2 flaticon-architecture-and-city',
                'sub' =>[
                    [
                        'type'=> 'title',
                        'text'=>\Lang::get('Company.commanage'),
                        'icon'=> 'fi2 flaticon-ui-3 msicon-r-270'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> \Lang::get('Company.comadd'),
                        'link'=> route('Company.AddForm'),
                        'icon'=>'fi2 flaticon-secure-payment'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> \Lang::get('Company.comviewall'),
                        'link'=> route('Company.viewForm'),
                        'icon'=>'fi2 flaticon-news-report'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Manage Structure',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-diagram'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Bank Accounts',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-rupee'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Manage Branch/Agency',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-hierarchical-structure-1'
                    ]




                ]
            ],
            [

                'text'=>\Lang::get('UI.purchase'),
                'type'=>'mainNav',
                'icon'=>'fi2 flaticon-payment msicon-fh-180',
                'sub' =>[

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Purchase',
                        'icon'=> 'fi2 flaticon-ui-3 msicon-r-270'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Add Purchase/PO',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-plus '
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'View All Purchase',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-menu'
                    ],


                    [
                        'type'=> 'title',
                        'text'=> 'Manage Item/Metrial',
                        'icon'=> 'fi2 flaticon-ui-3 msicon-r-270'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Add Items',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-plus'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'View All Items/Metrial',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-menu'
                    ],

                    [
                        'type'=> 'title',
                        'text'=> 'Manage Vendors',
                        'icon'=> 'fi2 flaticon-ui-3 msicon-r-270'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> \Lang::get('UI.add_vendor'),
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-plus'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> \Lang::get('UI.view_all_vendor'),
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-menu'
                    ]




                ]
            ],

            [

                'text'=>\Lang::get('UI.inventory'),
                'type'=>'mainNav',
                'icon'=>'fi2 flaticon-stats',
                'sub' =>[
                    [
                        'type'=> 'title',
                        'text'=> 'Manage Company Matser',
                        'icon'=> 'fi2 flaticon-ui-3 msicon-r-270'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Basic Details',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-secure-payment'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Structure',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-diagram'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Bank Accounts',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-rupee'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Manage Branch/Agency',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-hierarchical-structure-1'
                    ]




                ]
            ],

            [

                'text'=>\Lang::get('UI.sales'),
                'type'=>'mainNav',
                'icon'=>'fi2 flaticon-payment ',
                'sub' =>[
                    [
                        'type'=> 'title',
                        'text'=> 'Manage Lean Matser',
                        'icon'=> 'fi2 flaticon-ui-3 msicon-r-270'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Basic Details',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-secure-payment'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Structure',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-diagram'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Bank Accounts',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-rupee'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Manage Branch/Agency',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-hierarchical-structure-1'
                    ]




                ]
            ],

            [

                'text'=>\Lang::get('UI.accounts'),
                'type'=>'mainNav',
                'icon'=>'fi2 flaticon-list',
                'sub' =>[



                    [
                        'type'=> 'link',
                        'text'=> 'Dashboard',
                        'link'=> route('Account.Index'),
                        'icon'=>'fi2 flaticon-ui-3 msicon-r-270'
                    ],
                    [
                        'type'=> 'title',
                        'text'=> 'Master Ledgers',
                        'icon'=> 'fi2 flaticon-agenda'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Income Ledger',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-down-left-arrow text-green-600'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Expense Ledger',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-down-left-arrow msicon-h-180 text-red-600'
                    ],






                ]
            ]
            ,
            [

                'text'=>\Lang::get('UI.hr'),
                'type'=>'mainNav',
                'icon'=>'fi2 flaticon-conference',
                'sub' =>[
                    [
                        'type'=> 'title',
                        'text'=> 'Manage Company Matser',
                        'icon'=> 'fi2 flaticon-ui-3 msicon-r-270'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Basic Details',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-secure-payment'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Structure',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-diagram'
                    ],
                    [
                        'type'=> 'link',
                        'text'=> 'Manage Bank Accounts',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-rupee'
                    ],

                    [
                        'type'=> 'link',
                        'text'=> 'Manage Branch/Agency',
                        'link'=> route('MOD.Mod.Master.AddForm'),
                        'icon'=>'fi2 flaticon-hierarchical-structure-1'
                    ]




                ]
            ]



        ];
        $this->setFData($data);
        return $this->getFData();
    }

    /**
     * @return mixed
     */
    private function getFData()
    {
        return $this->fData;
    }

    /**
     * @param mixed $fData
     */
    private function setFData($fData)
    {
        if(is_array($this->fData))$fData=array_merge($this->fData,$fData);
        $this->fData = $fData;
    }
    /**
     * @return mixed
     */
    private function getFromData()
    {
        return $this->fromData;
    }

    /**
     * @param mixed $fromData
     */
    private function setFromData($id,$fromData)
    {
        $this->fromData[$id] = $fromData;
    }


}
