@extends('layouts.app')
@section('content')
<div class="container" style="max-width:600px;margin:40px auto;text-align:center;">
    <h2>{{__('Booking Confirmed!')}}</h2>
    <p class="text-muted">{{__('Your booking code')}}: <strong>{{$booking->code}}</strong></p>
    <p>{{__('We look forward to seeing you.')}}</p>
    <a href="{{route('user.booking_history')}}" class="btn btn-primary">{{__('View My Bookings')}}</a>
</div>
@endsection