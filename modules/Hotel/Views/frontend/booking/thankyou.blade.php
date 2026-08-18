@extends('layouts.app')
@section('content')
<div class="container" style="max-width:600px;margin:40px auto;text-align:center;">
    <h2>{{__('Booking Confirmed!')}}</h2>
    <p class="text-muted">{{__('Your booking code')}}: <strong>{{$booking->code}}</strong></p>
    <p>{{__('We look forward to seeing you.')}}</p>

    @if($booking->staff_id)
        @php $staff = \Modules\Hotel\Models\HotelStaff::find($booking->staff_id); @endphp
        @if($staff)
            <div style="border:1px solid #e5e5e5;border-radius:12px;padding:24px;margin:24px 0;">
                <p>{{__('Rate your experience with :name', ['name' => $staff->name])}}</p>
                <form action="{{route('hotel.booking.rate_staff')}}" method="post" class="star-rating-form">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{$booking->id}}">
                    <input type="hidden" name="staff_id" value="{{$staff->id}}">
                    <div class="star-rating-input" style="font-size:28px;display:flex;justify-content:center;gap:8px;margin:16px 0;">
                        @for($i = 1; $i <= 5; $i++)
                            <label>
                                <input type="radio" name="rating" value="{{$i}}" style="display:none;" required>
                                <i class="fa fa-star-o star-icon" data-value="{{$i}}" style="cursor:pointer;color:#ccc;"></i>
                            </label>
                        @endfor
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('Submit Rating')}}</button>
                </form>
            </div>
        @endif
    @endif

    <a href="{{route('user.booking_history')}}" class="btn btn-outline-primary">{{__('View My Bookings')}}</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var stars = document.querySelectorAll('.star-icon');
    stars.forEach(function(star) {
        star.addEventListener('click', function() {
            var value = parseInt(this.getAttribute('data-value'));
            stars.forEach(function(s) {
                var v = parseInt(s.getAttribute('data-value'));
                if (v <= value) {
                    s.classList.remove('fa-star-o');
                    s.classList.add('fa-star');
                    s.style.color = '#f5a623';
                } else {
                    s.classList.remove('fa-star');
                    s.classList.add('fa-star-o');
                    s.style.color = '#ccc';
                }
            });
            this.closest('.star-rating-input').querySelector('input[value="'+value+'"]').checked = true;
        });
    });
});
</script>
@endsection