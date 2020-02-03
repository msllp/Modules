@extends('MS::core.layouts.root')
@section('body')
<?php
$msData=collect($data['UserDetails']);
//dd($msData);
?>

    <profile :ms-data="{{$msData}}"></profile>


@endsection
