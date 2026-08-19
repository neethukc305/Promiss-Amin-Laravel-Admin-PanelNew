<div class="table-responsive">
    <table class="table table-striped table-inverse mb-1">
        <tbody>
        <tr>
            <td>{{__('Service')}}</td>
            <td class="text-right">{{$booking->service->title ?? ''}}</td>
        </tr>
        <tr>
            <td>{{__('Date & Time')}}</td>
            <td class="text-right">{{display_date($booking->start_date)}}</td>
        </tr>
        <tr>
            <td>{{__('Professional')}}</td>
            <td class="text-right">
                @if($booking->staff_id)
                    @php $staff = \Modules\Hotel\Models\HotelStaff::find($booking->staff_id); @endphp
                    {{$staff->name ?? __('N/A')}}
                @else
                    {{__('Any professional')}}
                @endif
            </td>
        </tr>
        <tr>
            <td>{{__('Price')}}</td>
            <td class="text-right">{{format_money($booking->total)}}</td>
        </tr>
        @if($booking->customer_notes)
            <tr>
                <td>{{__('Notes')}}</td>
                <td class="text-right">{{$booking->customer_notes}}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>