<?php


namespace MS\Core\Helper;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MSMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $msData;
    protected $msView;
    protected $msAttch;
    protected $msTitle;
    protected function __construct($view,$data,$attachments=[])
    {
        $this->msData=$data;
        $this->msView=$view;
        $this->msAttch=$attachments;
        $this->msSender=env('MS_DEFAULT_MAIL');
        $this->mailSubject=(array_key_exists('mailSubject',$data))?$data['mailSubject']:'';
        $this->msSenderName=env('MS_DEFAULY_MAIL_NAME');


    }
    public static function SendMail($to='',$view='',$data=[],$attach=[]){
      $data['toEmail']=$to;
      return  Mail::to($to)->send(new self($view,$data));
    }

    public function build()
    {
        if(count($this->msAttch)==0)
        return $this->subject($this->mailSubject)->from($this->msSender,$this->msSenderName)->view($this->msView)
            ->with(['data'=>$this->msData]);


    }


}
