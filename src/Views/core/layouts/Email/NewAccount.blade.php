<div class="card-footer">


    Hello, {{ (array_key_exists('name',$data))?$data['name']:'Test Name ' }}<br>

    Welcome to O<sub>3</sub> ERP.<br>
    Your account is now set up and ready to use. Let’s get started!

    <span class="text-right"> Best Regards,</span><br><br>
    O<sub>3</sub> ERP Support Team<br>

   <a href="https://www.o3erp.com" target="_blank"> <img  src="http://cdn.millionsllp.com/logo.peng" alt="{{asset('images/logo.png')}}" style="max-height:60px"></a><br>
    E-mail: help@o3erp.com | Website: www.o3erp.com<br>

    Presence in: Ahmadabad | Surat | Vapi | Mumbai | Noida | Bangalore | Vadodara | Chennai | United Kingdom<br>
    <p style="font-size: 8px;">This automated e-mail was sent to {{ $data['toEmail'] }}. </p>
   <span style="color: #1e7e34"> Save trees & help preserving our environment! Print this E-Mail only if necessary . </span>
</div>
