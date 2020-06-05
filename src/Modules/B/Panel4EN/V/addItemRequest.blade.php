@extends('MS::core.layouts.root')

@section('body')
<?php

$data=[];
if(isset($msData))$data=$msData;
//dd($data);
$json=collect($data)->toJson();


?>

    <mslistmaker :ms-data="{{$json}}"></mslistmaker>
@endsection
