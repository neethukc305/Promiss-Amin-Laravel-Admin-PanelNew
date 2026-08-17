@extends('layouts.app')
@section('content')
<div class="container" style="max-width:600px;margin:40px auto;">
    <h2>{{__('Select Date & Time')}}</h2>
    <p class="text-muted">{{$shop->title}} — {{$service->title}} ({{$service->duration}} {{__('min')}})</p>

    <form action="{{route('hotel.booking.datetime.store')}}" method="post">
        @csrf
        <div class="form-group" style="margin:16px 0;">
            <label>{{__('Date')}}</label>
            <input type="date" name="date" class="form-control" required min="{{date('Y-m-d')}}">
        </div>
        <div class="form-group" style="margin:16px 0;">
            <label>{{__('Time')}}</label>
            <input type="time" name="time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">{{__('Continue')}}</button>
    </form>
</div>
@endsection