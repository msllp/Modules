@extends((env('MS_DEBUG'))? 'MS::core.layouts.root':'MS::core.layouts.rootRaw')

@section('body')
<?php

$msData=collect($data['UserDetails']);
unset($data['UserDetails']);
$msDataExtra=collect($data);
//dd($msDataExtra);
//dd($msData);
?>

    <profile :ms-data="{{$msData}}" :ms-extra="{{$msDataExtra}}"></profile>


@endsection
