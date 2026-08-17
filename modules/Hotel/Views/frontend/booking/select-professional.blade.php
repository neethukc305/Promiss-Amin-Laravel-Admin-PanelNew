@extends('layouts.app')
@section('content')
<div class="container" style="max-width:600px;margin:40px auto;">
    <h2>{{__('Select a Professional')}}</h2>
    <p class="text-muted">{{$shop->title}} — {{$service->title}}</p>

    <form action="{{route('hotel.booking.professional.store')}}" method="post">
        @csrf
        <div class="professional-list" style="display:flex;flex-direction:column;gap:12px;margin:24px 0;">
            <label class="professional-option" style="display:flex;align-items:center;gap:12px;border:1px solid #e5e5e5;border-radius:10px;padding:16px;cursor:pointer;">
                <input type="radio" name="staff_id" value="" checked>
                <span>{{__('Any professional')}}</span>
            </label>
            @foreach($staffs as $staff)
                <label class="professional-option" style="display:flex;align-items:center;gap:12px;border:1px solid #e5e5e5;border-radius:10px;padding:16px;cursor:pointer;">
                    <input type="radio" name="staff_id" value="{{$staff->id}}">
                    <img src="{{$staff->getImageUrl('thumb')}}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                    <span>{{$staff->name}} @if($staff->title)<small class="text-muted">— {{$staff->title}}</small>@endif</span>
                </label>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary btn-block">{{__('Continue')}}</button>
    </form>
</div>
@endsection