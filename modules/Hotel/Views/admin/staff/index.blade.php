@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="title-bar">{{__('Team Management')}} — {{$hotel->title}}</h1>
        @include('admin.message')

        <div class="panel">
            <div class="panel-title"><strong>{{__('Add Team Member')}}</strong></div>
            <div class="panel-body">
                <form action="{{route('hotel.admin.staff.store', ['hotel_id'=>$hotel->id,'id'=>-1])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('Name')}} <span class="text-danger">*</span></label>
                                <input type="text" required name="name" class="form-control" placeholder="{{__('Staff name')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('Title / Role')}}</label>
                                <input type="text" name="title" class="form-control" placeholder="{{__('Eg: Senior Barber')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('Photo')}}</label>
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id', null) !!}
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">{{__('Add')}}</button>
                </form>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title"><strong>{{__('All Team Members')}}</strong></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{__('Photo')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Title')}}</th>
                            <th>{{__('Status')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td><img src="{{$row->getImageUrl('thumb')}}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;"></td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->title}}</td>
                                <td>{{$row->status}}</td>
                                <td>
                                    <a href="{{route('hotel.admin.staff.edit',['hotel_id'=>$hotel->id,'id'=>$row->id])}}">{{__('Edit')}}</a>
                                    |
                                    <a href="{{route('hotel.admin.staff.delete',['hotel_id'=>$hotel->id,'id'=>$row->id])}}" onclick="return confirm('{{__('Are you sure?')}}')">{{__('Delete')}}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$rows->links()}}
            </div>
        </div>
    </div>
@endsection