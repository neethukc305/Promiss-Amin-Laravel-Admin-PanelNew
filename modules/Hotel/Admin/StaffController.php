<?php
namespace Modules\Hotel\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelStaff;

class StaffController extends AdminController
{
    protected $hotelClass;
    protected $staffClass;
    protected $currentHotel;

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/hotel');
        $this->hotelClass = Hotel::class;
        $this->staffClass = HotelStaff::class;
    }

    public function callAction($method, $parameters)
    {
        if (!Hotel::isEnable()) {
            return redirect('/');
        }
        return parent::callAction($method, $parameters);
    }

    protected function hasHotelPermission($hotel_id = false)
    {
        if (empty($hotel_id)) return false;

        $hotel = $this->hotelClass::find($hotel_id);
        if (empty($hotel)) return false;

        if (!$this->hasPermission('hotel_manage_others') and $hotel->create_user != Auth::id()) {
            return false;
        }

        $this->currentHotel = $hotel;
        return true;
    }

    public function index(Request $request, $hotel_id)
    {
        $this->checkPermission('hotel_view');

        if (!$this->hasHotelPermission($hotel_id)) {
            abort(403);
        }

        $query = $this->staffClass::query();
        $query->where('parent_id', $hotel_id);
        $query->orderBy('id', 'desc');

        if (!empty($s = $request->input('s'))) {
            $query->where('name', 'LIKE', '%' . $s . '%');
        }

        $data = [
            'rows' => $query->paginate(20),
            'hotel' => $this->currentHotel,
            'row' => new $this->staffClass(),
            'breadcrumbs' => [
                ['name' => __('Hotels'), 'url' => 'admin/module/hotel'],
                ['name' => __('Shop: :name', ['name' => $this->currentHotel->title]), 'url' => 'admin/module/hotel/edit/' . $this->currentHotel->id],
                ['name' => __('Team Management'), 'class' => 'active'],
            ],
            'page_title' => __("Team Management"),
        ];
        return view('Hotel::admin.staff.index', $data);
    }

    public function edit(Request $request, $hotel_id, $id)
    {
        $this->checkPermission('hotel_update');

        if (!$this->hasHotelPermission($hotel_id)) {
            abort(403);
        }

        $row = $this->staffClass::find($id);
        if (empty($row) or $row->parent_id != $hotel_id) {
            return redirect(route('hotel.admin.staff.index', ['hotel_id' => $hotel_id]));
        }

        $data = [
            'row' => $row,
            'hotel' => $this->currentHotel,
            'breadcrumbs' => [
                ['name' => __('Hotels'), 'url' => 'admin/module/hotel'],
                ['name' => __('Shop: :name', ['name' => $this->currentHotel->title]), 'url' => 'admin/module/hotel/edit/' . $this->currentHotel->id],
                ['name' => __('All Team Members'), 'url' => 'admin/module/hotel/staff/' . $this->currentHotel->id . '/index'],
                ['name' => __('Edit: :name', ['name' => $row->name]), 'class' => 'active'],
            ],
            'page_title' => __("Edit: :name", ['name' => $row->name]),
        ];
        return view('Hotel::admin.staff.detail', $data);
    }

    public function store(Request $request, $hotel_id, $id)
    {
        if (!$this->hasHotelPermission($hotel_id)) {
            abort(403);
        }

        if ($id > 0) {
            $this->checkPermission('hotel_update');
            $row = $this->staffClass::find($id);
            if (empty($row) or $row->parent_id != $hotel_id) {
                return redirect(route('hotel.admin.staff.index', ['hotel_id' => $hotel_id]));
            }
        } else {
            $this->checkPermission('hotel_create');
            $row = new $this->staffClass();
            $row->status = "publish";
            $row->parent_id = $hotel_id;
            $row->create_user = Auth::id();
        }

     $dataKeys = [
    'name',
    'title',
    'image_id',
];

foreach ($dataKeys as $key) {
    $row->{$key} = $request->input($key);
}

if ($request->has('status')) {
    $row->status = $request->input('status');
}

        $row->save();

        if ($id > 0) {
            return redirect()->back()->with('success', __('Team member updated'));
        } else {
            return redirect(route('hotel.admin.staff.index', ['hotel_id' => $hotel_id]))->with('success', __('Team member created'));
        }
    }

    public function delete(Request $request, $hotel_id, $id)
    {
        if (!$this->hasHotelPermission($hotel_id)) {
            abort(403);
        }
        $this->checkPermission('hotel_delete');

        $row = $this->staffClass::find($id);
        if (!empty($row) and $row->parent_id == $hotel_id) {
            $row->delete();
        }

        return redirect()->back()->with('success', __('Deleted successfully'));
    }
}