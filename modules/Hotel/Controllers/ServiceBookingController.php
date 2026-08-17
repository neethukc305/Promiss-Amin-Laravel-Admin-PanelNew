<?php
namespace Modules\Hotel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelRoom;
use Modules\Hotel\Models\HotelStaff;
use Modules\Booking\Models\Booking;

class ServiceBookingController extends FrontendController
{
    public function start(Request $request, $service_id)
    {
        $service = HotelRoom::find($service_id);
        if (empty($service) || $service->status != 'publish') {
            abort(404);
        }
        $shop = Hotel::find($service->parent_id);
        if (empty($shop)) {
            abort(404);
        }

        // Reset booking session for a fresh flow
        session(['booking_flow' => [
            'service_id' => $service->id,
            'shop_id'    => $shop->id,
        ]]);

        return redirect(route('hotel.booking.professional'));
    }

    protected function getFlow()
    {
        $flow = session('booking_flow');
        if (empty($flow) || empty($flow['service_id'])) {
            return null;
        }
        return $flow;
    }

    public function professional(Request $request)
    {
        $flow = $this->getFlow();
        if (!$flow) return redirect('/');

        $service = HotelRoom::find($flow['service_id']);
        $shop = Hotel::find($flow['shop_id']);
        $staffs = HotelStaff::where('parent_id', $shop->id)->where('status', 'publish')->get();

        return view('Hotel::frontend.booking.select-professional', [
            'service' => $service,
            'shop' => $shop,
            'staffs' => $staffs,
        ]);
    }

    public function storeProfessional(Request $request)
    {
        $flow = $this->getFlow();
        if (!$flow) return redirect('/');

        $flow['staff_id'] = $request->input('staff_id') ?: null; // null = Any professional
        session(['booking_flow' => $flow]);

        return redirect(route('hotel.booking.datetime'));
    }

    public function datetime(Request $request)
    {
        $flow = $this->getFlow();
        if (!$flow) return redirect('/');

        $service = HotelRoom::find($flow['service_id']);
        $shop = Hotel::find($flow['shop_id']);

        return view('Hotel::frontend.booking.select-datetime', [
            'service' => $service,
            'shop' => $shop,
        ]);
    }

    public function storeDatetime(Request $request)
    {
        $flow = $this->getFlow();
        if (!$flow) return redirect('/');

        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $flow['date'] = $request->input('date');
        $flow['time'] = $request->input('time');
        session(['booking_flow' => $flow]);

        // Login gate
       // Login gate
if (!Auth::check()) {
    return redirect()->guest(route('login'));
}

        return redirect(route('hotel.booking.first_visit'));
    }

    public function firstVisit(Request $request)
    {
        $flow = $this->getFlow();
        if (!$flow) return redirect('/');
      if (!Auth::check()) return redirect()->guest(route('login'));

        $shop = Hotel::find($flow['shop_id']);

        return view('Hotel::frontend.booking.first-visit', [
            'shop' => $shop,
        ]);
    }

    public function storeFirstVisit(Request $request)
    {
        $flow = $this->getFlow();
        if (!$flow) return redirect('/');

        $flow['is_first_visit'] = $request->input('is_first_visit') == '1' ? 1 : 0;
        session(['booking_flow' => $flow]);

        return redirect(route('hotel.booking.review'));
    }

    public function review(Request $request)
    {
        $flow = $this->getFlow();
        if (!$flow) return redirect('/');
        if (!Auth::check()) return redirect(route('user.login'));

        $service = HotelRoom::find($flow['service_id']);
        $shop = Hotel::find($flow['shop_id']);
        $staff = !empty($flow['staff_id']) ? HotelStaff::find($flow['staff_id']) : null;

        return view('Hotel::frontend.booking.review', [
            'service' => $service,
            'shop' => $shop,
            'staff' => $staff,
            'date' => $flow['date'] ?? '',
            'time' => $flow['time'] ?? '',
            'is_first_visit' => $flow['is_first_visit'] ?? null,
        ]);
    }

    public function confirm(Request $request)
    {
        $flow = $this->getFlow();
        if (!$flow) return redirect('/');
        if (!Auth::check()) return redirect(route('user.login'));

        $service = HotelRoom::find($flow['service_id']);
        $shop = Hotel::find($flow['shop_id']);

        if (empty($service) || empty($shop)) {
            return redirect('/')->with('error', __('Service not found'));
        }

        $start = \DateTime::createFromFormat('Y-m-d H:i', $flow['date'] . ' ' . $flow['time']);
        $duration = $service->duration ?: 30;
        $end = clone $start;
        $end->modify('+' . $duration . ' minutes');

        $user = Auth::user();

        $booking = new Booking();
        $booking->status = Booking::CONFIRMED;
        $booking->object_id = $service->id;
        $booking->object_model = 'hotel_room';
        $booking->staff_id = $flow['staff_id'] ?? null;
        $booking->vendor_id = $shop->create_user;
        $booking->customer_id = $user->id;
        $booking->email = $user->email;
        $booking->first_name = $user->first_name ?? $user->name ?? '';
        $booking->last_name = $user->last_name ?? '';
        $booking->phone = $user->phone ?? '';
        $booking->start_date = $start->format('Y-m-d H:i:s');
        $booking->end_date = $end->format('Y-m-d H:i:s');
        $booking->total = $service->price;
        $booking->total_before_fees = $service->price;
        $booking->total_before_discount = $service->price;
        $booking->currency = setting_item('site_currency_main', 'USD');
        $booking->is_first_visit = $flow['is_first_visit'] ?? null;
        $booking->customer_notes = $request->input('note');
        $booking->calculateCommission();
        $booking->save();

        try {
            $booking->sendNewBookingEmails();
        } catch (\Exception $e) {}

        session()->forget('booking_flow');

        return redirect(route('hotel.booking.thankyou', ['code' => $booking->code]));
    }

    public function thankyou(Request $request, $code)
    {
        $booking = Booking::where('code', $code)->first();
        if (empty($booking)) {
            return redirect('/');
        }
        return view('Hotel::frontend.booking.thankyou', ['booking' => $booking]);
    }
}