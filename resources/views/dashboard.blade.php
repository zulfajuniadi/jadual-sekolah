@extends(backpack_view('blank'))

@section('content')
@include('schedule')
<div class="text-center">
    <a href="/s/{{backpack_user()->public_slug}}">Add this link in your child's browser: <?=url('/s/' . backpack_user()->public_slug)?></a>
</div>
<br>
<br>
@endsection