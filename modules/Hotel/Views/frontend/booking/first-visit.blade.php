@extends('layouts.app')
@section('content')
<div class="container" style="max-width:600px;margin:40px auto;">
    <h2>{{__('Is this your first visit?')}}</h2>
    <p class="text-muted">{{__('Is this your first visit to :shop?', ['shop' => $shop->title])}}</p>

    <form action="{{route('hotel.booking.first_visit.store')}}" method="post">
        @csrf
        <div style="display:flex;gap:16px;margin:24px 0;">
            <button type="submit" name="is_first_visit" value="1" class="btn btn-outline-primary" style="flex:1;padding:16px;">{{__('Yes')}}</button>
            <button type="submit" name="is_first_visit" value="0" class="btn btn-outline-primary" style="flex:1;padding:16px;">{{__('No')}}</button>
        </div>
    </form>
</div>
@endsection