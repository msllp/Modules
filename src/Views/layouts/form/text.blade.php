<?php
//class
$groupClass=["form-group"];
$labelClass=false;
$inputClass="form-control";
//Requiered
$required=false;
//perfix
$preFix=false;
$preFixClass="";
//perfic
$perFix=false;
$perFixClass="";
//value
$inputValue=false;
$editLock=false;

$vData=false;
//dd($data[]);
if(array_key_exists("vData",$data)){
//dd($data);


    if(array_key_exists("labelClass",$data['vData'])){
        $labelClass= $data['vData']['labelClass'];
        $vData['labelClass']=$data['vData']['labelClass'];
    }

    if(array_key_exists("inputClass",$data['vData'])){
        $inputClass= $inputClass." ".$data['vData']['inputClass'];
        $vData['inputClass']=$data['vData']['inputClass'];
    }
    if(array_key_exists("required",$data['vData'])){
        $required=$data['vData']['required'];
        $vData['required']=$data['vData']['required'];

        if($required && !in_array('input-group',$groupClass))$groupClass=array_merge($groupClass,['input-group']);
    }


    if(array_key_exists("preFix",$data['vData'])){
        $preFixClass=$preFixClass.$data['vData']['preFix'];
        $vData['preFix']=$data['vData']['preFix'];
        $preFix=true;
        if($preFix && !in_array('input-group',$groupClass))$groupClass=array_merge($groupClass,['input-group']);

    }

    if(array_key_exists("perFix",$data['vData'])){
        $perFixClass=$perFixClass.$data['vData']['perFix'];
        $vData['preFix']=$data['vData']['perFix'];
        $perFix=true;
        if($perFix && !in_array('input-group',$groupClass))$groupClass=array_merge($groupClass,['input-group']);

    }

    if(array_key_exists("groupClass",$data['vData'])){
        $groupClass=array_merge($groupClass,$data['vData']['groupClass']);

        $vData['groupClass']=$data['vData']['groupClass'];
    }

    // dd($groupClass);

}


if(array_key_exists("value",$data)){
    $inputValue=$data['value'];
//dd($data);

}

if(array_key_exists("editLock",$data)){
    $editLock=$data['editLock'];
//dd($data);

}


if(!array_key_exists("vName",$data)) $data['vName']=ucwords($data['name']);
if(!array_key_exists("desc",$data)) $data['desc']="Enter " . $data['vName'];
if(!array_key_exists("label",$data)) $data['label']=$data['vName'];
$data['vName']=ucwords($data['vName']);
//dd($groupClass);
?>


@if($vData && array_key_exists('labelClass',$vData))
    <label class="{{  $labelClass  }}">{{ $data['label']  }}
    </label>
@else
    <label>{{ $data['label']  }}</label>
@endif
<div class="{{ implode(" ", $groupClass)  }}" title="{{$data['desc']}}">

    @if($preFix)
        <span class="input-group-addon" title="Unit prefix"><i class="{{ $preFixClass  }}"></i></span>
    @endif

    @if($inputValue)
        @if($editLock)

            @include("MS::layouts.form.locked",['data'=>[
            'inputClass'=>$inputClass,
            'inputValue'=>$inputValue,
            'name'=>$data['name'],
            ]])

        @else
            <input type="text" name="{{$data['name']}}" class="{{  $inputClass  }}" placeholder="Enter {{ $data['vName']  }} here" value=" {{$inputValue }}" >
        @endif
    @else
        <input type="text" name="{{$data['name']}}" class="{{  $inputClass  }}" placeholder="Enter {{ $data['vName']  }} here">
    @endif

    @if($perFix)
        <span class="input-group-addon" title="Unit perfix"><i class="{{ $perFixClass  }}"></i></span>
    @endif

    @if($required)
        <span class="input-group-addon" title="This Field is Required"><i class="text-danger fa fa-bullseye"></i></span>
    @endif

</div>
