<div id="hotel-services" class="hotel_services_list">
    <h3 class="heading-section">{{__('Services')}}</h3>

    @php
        $services = \Modules\Hotel\Models\HotelRoom::where('parent_id', $row->id)
            ->where('status', 'publish')
            ->get();
    @endphp

    <div class="services-list">
        @forelse($services as $service)
            <div class="service-card">
                <div class="service-info">
                    <h4 class="service-name">{{ $service->title }}</h4>
                    @if($service->duration)
                        <span class="service-duration">{{ $service->duration }} {{__('min')}}</span>
                    @endif
                    <div class="service-price">{{__('from')}} {!! format_money($service->price) !!}</div>
                </div>
                <div class="service-book">
                    <a href="#" class="btn-book">{{__('Book')}}</a>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">{{__('No services available yet.')}}</div>
        @endforelse
    </div>
    
</div>

<style>
.hotel_services_list {
    margin: 40px 0;
}
.hotel_services_list .heading-section {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 24px;
}
.services-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.service-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #e5e5e5;
    border-radius: 12px;
    padding: 20px 24px;
    transition: box-shadow 0.2s ease;
}
.service-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.service-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.service-name {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    color: #1a1a1a;
}
.service-duration {
    font-size: 14px;
    color: #888;
}
.service-price {
    font-size: 15px;
    font-weight: 600;
    color: #1a1a1a;
    margin-top: 4px;
}
.service-book {
    flex-shrink: 0;
}
.btn-book {
    display: inline-block;
    padding: 10px 28px;
    border: 1px solid #1a1a1a;
    border-radius: 24px;
    color: #1a1a1a;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;
}
.btn-book:hover {
    background: #1a1a1a;
    color: #fff;
    text-decoration: none;
}
</style>

<div id="hotel-team" class="hotel_team_list">
    <h3 class="heading-section">{{__('Team')}}</h3>

    @php
        $staffs = \Modules\Hotel\Models\HotelStaff::where('parent_id', $row->id)
            ->where('status', 'publish')
            ->get();
    @endphp

    <div class="team-list">
        @forelse($staffs as $staff)
            <div class="team-card">
                <div class="team-photo">
                    <img src="{{ $staff->getImageUrl('thumb') }}" alt="{{ $staff->name }}">
                </div>
                <div class="team-name">{{ $staff->name }}</div>
                @if($staff->title)
                    <div class="team-title">{{ $staff->title }}</div>
                @endif
            </div>
        @empty
            {{-- no team members yet, show nothing --}}
        @endforelse
    </div>
</div>

<style>
.hotel_team_list {
    margin: 40px 0;
}
.hotel_team_list .heading-section {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 24px;
}
.team-list {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
}
.team-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: 120px;
}
.team-photo {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    margin-bottom: 10px;
    background: #f0f0f0;
}
.team-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.team-name {
    font-weight: 600;
    font-size: 15px;
    color: #1a1a1a;
}
.team-title {
    font-size: 13px;
    color: #888;
    margin-top: 2px;
}
</style>