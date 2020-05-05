<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 30-06-2019
 * Time: 03:00 AM
 */

namespace MS\Core\Notification;


//use function foo\func;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class Master extends Notification
{
    use Queueable;

    public $msData,$defaultEmail;

    public function __construct($data=[])
    {
       // dd($data);
        if(!array_key_exists('from',$data))$data['from']="MS Application : System Genarated Mail";
        if(!array_key_exists('type',$data))$data['type']='MS::core.layouts.Email.NewAccount';
        if(!array_key_exists('mail',$data))$data['mail']=env("MS_DEFAULT_MAIL");
        if(!array_key_exists('title',$data))$data['title']="MS Mail System Test Title";



        $this->msData=$data;
        $this->defaultEmail=env("MS_DEFAULT_MAIL");


    }

    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {

//        return (new MailMessage)->from('maxirooney@gmail.com', 'MS Application')->greeting('Hello!');

        $data=$this->msData;



        return (new MailMessage)->from($data['mail'], $data['from'])->view(
            $data['type'], ['data' => $data]
        );

    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }


    private function getKeyFrom(){

        if(array_key_exists('',$this->msData)){

            //return
            }

    }





}

