@extends('MS::core.layouts.root')
@section('body')
    <?php
        $logo="logo_tr.png";

        if (isset($data) && array_key_exists('logo',$data))$logo=$data['logo'];


        $link=asset(implode('/',['images',$logo]));

    ?>
<form class="form-signin card text-center ms-box" >
    <center>
    <img class="mt-3 card-img-top" src="{{$link}}" style="max-height: 72px;max-width:120px;padding: 5px;background-color: aliceblue;    border-radius: calc(0.25rem - 1px);">
    </center>
    <div class="card-body" id="msapp">

        {{--<h1 class="h4  font-weight-normal card-title">Sign in </h1>--}}
<div class="card-text">
        <h4 class="small mb-3" style="color: aliceblue;">To continue, first verify it's you who can access</h4>


    <?php

    $array=[
        'name'=>"Username",
        'type'=>"datetime",
        'vName'=>"Username or Email",
        'prefix'=>"lock text-info",
        'perfix'=>"asterisk text-danger",
        'inputOnly'=>true,
        'required'=>true,
        'validation'=>[
           // 'minSize'=>5,
            'required'=>1
        ],


    ];
    $arrayJson=collect($array)->toJson();

    ?>

    <inputtext :ms-data="{{$arrayJson}}"     ></inputtext>


        <?php

        $array=[
            'name'=>"password",
            // 'type'=>"text",
            'vName'=>"Password",

            'prefix'=>"key text-info",
            'perfix'=>"asterisk text-danger",
            'inputOnly'=>true,
            'required'=>true,
            'validation'=>[
                // 'type'=>'password',
                //  'minSize'=>5,
                'required'=>1
            ],


        ];
        $arrayJson=collect($array)->toJson();

        ?>
        <inputtext :ms-data="{{$arrayJson}}"     ></inputtext>



            <button class="btn btn-lg btn-primary btn-block card-link" type="submit"><i class="fa fa-user-check"></i> Verify Me</button>
            <p class="mt-2 text-muted card-subtitle">© 2017-2019</p>

</div>

    </div>
    <div class="ms-copyright">  a Genuine <img src="{{asset("images/m.png")}}" >illion certified Product </div>
</form>

    <script type="text/javascript">



    </script>
{{--<script src="https://cdn.jsdelivr.net/npm/vue"></script>--}}
@endsection
