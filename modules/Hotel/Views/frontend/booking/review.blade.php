@extends('layouts.app')
@section('content')
<div class="container" style="max-width:600px;margin:40px auto;">
    <h2>{{__('Review & Confirm')}}</h2>

    <div class="review-summary" style="border:1px solid #e5e5e5;border-radius:12px;padding:24px;margin:24px 0;">
        <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
            <strong>{{__('Shop')}}</strong>
            <span>{{$shop->title}}</span>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
            <strong>{{__('Service')}}</strong>
            <span>{{$service->title}} ({{$service->duration}} {{__('min')}})</span>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
            <strong>{{__('Professional')}}</strong>
            <span>{{$staff ? $staff->name : __('Any professional')}}</span>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
            <strong>{{__('Date & Time')}}</strong>
            <span>{{display_date($date)}} {{$time}}</span>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
            <strong>{{__('First visit')}}</strong>
            <span>{{$is_first_visit ? __('Yes') : __('No')}}</span>
        </div>
        <hr>
        <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:700;">
            <strong>{{__('Total')}}</strong>
            <span>{{format_money($service->price)}}</span>
        </div>
    </div>

    <form action="{{route('hotel.booking.confirm')}}" method="post">
        @csrf
        <div class="form-group" style="margin:16px 0;">
            <label>{{__('Comments or requests (optional)')}}</label>
            <textarea name="note" class="form-control" rows="3" placeholder="{{__('Any special requests?')}}"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">{{__('Confirm Booking')}}</button>
    </form>
</div>
@endsection