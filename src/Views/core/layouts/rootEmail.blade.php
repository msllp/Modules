
<div class="header">
    @include('MS::core.layouts.Email.Static.Header')
    @yield('header')
</div>
<div class="body" style="padding: 10px;">
    @yield('body')
</div>
<div class="footer">
    @include('MS::core.layouts.Email.Static.Footer')
    @yield('footer')
</div>

