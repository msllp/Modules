@extends('MS::core.layouts.rootEmail')
@section('body')
<div >
    Hello, {{ (array_key_exists('name',$data))?$data['name']:'Test Name ' }}<br><br>

    <strong style="font-size: 18px">{{(array_key_exists('otp',$data))?$data['otp']:'123456789 '}}</strong>  is your OTP for e-mail verification. This is valid for 2 hours.

    <span style="display:block;text-align: left;width: 100% ;padding: 20px;padding-left: 80px">or</span>

    <button>Click here to verify you Email</button>


</div>

    @endsection
