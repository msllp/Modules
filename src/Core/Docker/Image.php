<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-08-2019
 * Time: 02:09 AM
 */

namespace MS\Core\Docker;


define('DEFAULT_IMAGE_DIR',["MS","Deploy",'Docker']);

class Image
{


    public $imageName,$run,$from,$env,$copy,$workdir,$vol,$expose,$user,$tag;

    public function __construct($data=[])
    {
        $this->default();
        $this->user="msllp";
        $this->tag="0.0.1";
        $this->imageName="ms_auto";//_";. \MS\Core\Helper\Comman::random();
    }

    public function setName($data){

        $this->imageName=$data;
    return $this;
    }


    public function setBaseImage($data){

        $this->from=$data;
        return $this;
    }
    public function setWorkdir($data){
        $this->workdir=$data;
        return $this;
    }



    public function env($data){

        $this->env[]=$data;
        return $this;

    }
    public function run($data){

        $this->run[]=$data;
        return $this;

    }
    public function copy($data){
        $this->copy[]=$data;
        return $this;
    }
    public function out($data){

        $this->expose[]=$data;
        return $this;

    }
    public function vol($data){

        $this->vol[]=$data;
        return $this;

    }

    public function getImageName(){
        return $this->imageName;

    }
    public function getTag(){
        return $this->tag;
    }

    public function getImageForCompose(){
        return implode(':',[$this->imageName,$this->tag]);
    }

    public function makeImage(){
        $m=new Box();
      //  dd();
       // $m->makeFromImage($this);
       // dd($m->makeFromImage($this));
        //$this->makeDockerFile();
        //$this->deleteALlImages();
     //  dd ($this->deleteALlImages()) ;
//dd(implode('/',DEFAULT_IMAGE_DIR));
        //$this->imageName='ms_auto';
        //exec("cd ../");
        chdir("../");
     chdir(implode('/',DEFAULT_IMAGE_DIR));

        $excuteComman="echo %CD%";

       // dd(exec($excuteComman));
        $excuteComman=
            implode(' ',["docker","build","-t",implode(':',[implode("/",[$this->user,$this->imageName]),$this->tag]),"."]);

//dd($excuteComman);

     try{
         system($excuteComman);
         return  $this;
     }catch (\Exception $e){
         dd($e);
     }

    }

//docker-compose run bash
    public function deleteALlImages(){
        $c="docker rmi $(docker images -a -q)";
        system($c);
}
    public static function dirReverse(){
        foreach (DEFAULT_IMAGE_DIR as $value){
            chdir("../");
        }
        chdir("public");
        $excuteComman="echo %CD%";
        return  exec ($excuteComman);
    }



    public function deleteImageCommand($name){

        $comman="docker image rm ".$name." -f";
    }



    public function makeDockerFile(){

        $basePath=[base_path(implode(DS,DEFAULT_IMAGE_DIR))];
        $dockerfileName="dockerfile";
        $basePath[]=$dockerfileName;

        $file=fopen(implode(DS,$basePath), "w");
        //dd($this);
        //foreach ($this)
        $text[]=implode(" ",['FROM',$this->from]);
        foreach ($this->env as $value){
            foreach ($value as $k1=>$v1)
            $text[]=implode(" ",['env',implode('=',[ $k1,"'$v1'"])]);
        }
        foreach ($this->copy as $value){
            foreach ($value as $k1=>$v1)
                $text[]=implode(" ",['COPY',implode(' ',[ $k1,$v1])]);
        }
        foreach ($this->run as $value){
            foreach ($value as $k1=>$v1)
                $text[]=implode(" ",['RUN',$v1]);
        }
        foreach ($this->vol as $value){
            foreach ($value as $k1=>$v1)
                $text[]=implode(" ",['VOLUME', $v1]);
        }
        foreach ($this->expose as $value){
            $text[]=implode(" ",['EXPOSE', implode(' ',$value)]);

        }
        $text=implode('
         ',$text);
      //  dd($text);
        fwrite($file, $text);
        //dd( );
    }
    public function default(){

        $this->setBaseImage("webdevops/php-apache:7.3");
        $this->env(['PHP_DATE_TIMEZONE'=>"Asia/Kolkata",'PHP_MEMORY_LIMIT'=>"1073741824","WEB_ALIAS_DOMAIN"=>"nc1.msllp.in","PHP_MAX_EXECUTION_TIME"=>"300","PHP_POST_MAX_SIZE"=>"50M","PHP_UPLOAD_MAX_FILESIZE"=>"50MB"]);
        $this->copy(['conf/etc/httpd/vhost.conf'=>'/opt/docker/etc/httpd/vhost.conf',]);
        $this->run(['apt update -y','apt upgrade -y','apt install apt-utils -y','apt install curl  -y','apt install git -y','cd /app','cd /app && curl -sL https://deb.nodesource.com/setup_12.x | bash && apt-get install nodejs -y','git clone https://github.com/msllp/Laravel_boilerplate.git /app','cd /app && curl -s https://getcomposer.org/installer | php','cd /app && composer install','cd /app && npm install','cd /app && npm update','cd /app && chown -R www-data:www-data /app','chmod -R 777 /app']);
        $this->vol(['/app']);
        $this->setWorkdir('/app');
        $this->out(['80','443','90','22']);


    }

    private function addImageEntryToDB($data){

        dd($data);
    }
    private function deleteImageEntryToDB($data){

        dd($data);
    }

    private function editImageEntryToDB($data){

    }
}
