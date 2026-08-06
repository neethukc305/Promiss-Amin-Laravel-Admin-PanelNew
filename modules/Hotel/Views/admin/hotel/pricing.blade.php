@if(is_default_lang())
    <div class="panel">
        <div class="panel-title"><strong>{{__("Check in/out time")}}</strong></div>
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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__("Time for check in")}}</label>
                        <input type="text" value="{{$row->check_in_time}}" placeholder="{{__("Eg: 12:00AM")}}" name="check_in_time" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__("Time for check out")}}</label>
                        <input type="text" value="{{$row->check_out_time}}" placeholder="{{__("Eg: 11:00AM")}}" name="check_out_time" class="form-control">
                    </div>
                </div>
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