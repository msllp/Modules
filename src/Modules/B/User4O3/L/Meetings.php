<?php


namespace MS\Mod\B\User4O3\L;


use Illuminate\Support\Facades\Lang;
use MS\Core\Helper\MSTableSchema;
use MS\Core\Module\Logic;
class Meetings extends Logic
{
    public static $userConstructData = [
        'UniqId' => 'string',
        'MeetingHeadUserId'=>'string',
        'MeetingUsers'=>'array'
    ];

    public static $c_m = 'O3_Users_Master';
    public static $c_d = 'O3_Users_Data';
    public static $c_c = 'O3_Users_Config';
    public static $modCode = 'User4O3';
    public $MeetingId;
    public $DB=[];

    public function __construct($data = [])
    {
        $data['namespace']="MS\Mod\B\User4O3";

        parent::__construct($data);
        $this->UservMeet=implode('_', [self::$modCode, 'Meetings']);

    }

    public function addNewMeetForm($data=[]){
      //  dd($data);
        return view('MOD::B.User4O3.V.vMeet.addNewMeet')->with('data',$data);
    }

    public static function getTableRaw()
    {
        $methodToCall = [
            'setUpMasterMeetingTable' => [],

        ];
        return parent::makeTableRaw($methodToCall);
    }

    public function getMeetingModel(){
       // dd($this->ModNameSpace);
        return parent::getModel($this->ModNameSpace,$this->UservMeet);
    }
    private function setUpMasterMeetingTable()
    {

        $data = [
            'tableId' => $this->UservMeet,
            'tableName' => implode('_', [$this->ModCode, 'Meeting']),
            'connection' => $this->DB['d'],
        ];
        $m = new  MSTableSchema($data);
        $m->setFields(['name' => 'UniqId', 'type' => 'string']);
        $m->setFields(['name' => 'MeetingHeadUserId', 'type' => 'string']);
        $m->setFields(['name' => 'MeetingUsersId', 'type' => 'string']);
        $m->setFields(['name' => 'MeetingScheduleTime', 'type' => 'string']);
        $m->setFields(['name' => 'MeetingScheduleDate', 'type' => 'string']);
        $m->setFields(['name' => 'MeetingCurrentUserIdCount', 'type' => 'string',]);
        $m->setFields(['name' => 'MeetingAbsentUserIdCount', 'type' => 'string',]);
        $m->setFields(['name' => 'MeetingStatus', 'type' => 'string']);
        $m->setFields(['name' => 'MeetingStartTime', 'type' => 'string']);
        $m->setFields(['name' => 'MeetingEndTime', 'type' => 'string',]);
        $m->setFields(['name' => 'MeetingAttendance', 'type' => 'string',]);
        $m->setFields(['name' => 'MeetingData', 'type' => 'string',]);
        $m1 = $m->finalReturnForTableFile();

        return array_merge($m1);
    }
}
