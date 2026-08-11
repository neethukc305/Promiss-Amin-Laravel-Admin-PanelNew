@if(is_default_lang())
    <div class="panel">
       <div class="panel-title"><strong>{{__("Opening Times")}}</strong></div>
        <div class="panel-body">
            <div class="form-group d-none">
                <label>{{__('Allowed full day booking')}}</label>
                <br>
                <label>
                    <input type="checkbox" name="allow_full_day" @if($row->allow_full_day) checked @endif value="1"> {{__("Enable full day booking")}}
                </label>
                <div class="small">
                    {{__("You can book room with full day")}} <br>
                    {{__("Eg: booking from 22-23, then all days 22 and 23 are full, other people cannot book")}}
                </div>
            </div>
           @php
    $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
    $opening_hours = json_decode($row->opening_hours ?? '', true) ?: [];
@endphp
<div class="opening-hours-fields">
    @foreach($days as $day)
        <div class="row" style="margin-bottom:8px;">
            <div class="col-md-3">
                <label style="text-transform:capitalize;">{{__($day)}}</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="opening_hours[{{$day}}][open]" class="form-control" value="{{$opening_hours[$day]['open'] ?? ''}}" placeholder="{{__('Eg: 10:00 AM')}}">
            </div>
            <div class="col-md-4">
                <input type="text" name="opening_hours[{{$day}}][close]" class="form-control" value="{{$opening_hours[$day]['close'] ?? ''}}" placeholder="{{__('Eg: 8:00 PM')}}">
            </div>
        </div>
    @endforeach
</div>
            @if(is_default_lang())
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">{{__("Minimum advance reservations")}}</label>
                            <input type="number" name="min_day_before_booking" class="form-control" value="{{$row->min_day_before_booking}}" placeholder="{{__("Ex: 3")}}">
                            <i>{{ __("Leave blank if you dont need to use the min day option") }}</i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif