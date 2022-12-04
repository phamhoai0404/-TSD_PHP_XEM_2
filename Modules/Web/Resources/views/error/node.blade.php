@if(Session::has('error'))
    <p class="danger" style="color: indianred">{{ Session::get('error') }}</p>
@endif
