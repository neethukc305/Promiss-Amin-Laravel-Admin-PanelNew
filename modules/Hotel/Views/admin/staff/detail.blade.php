@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="title-bar">{{__('Edit: :name',['name'=>$row->name])}}</h1>
        @include('admin.message')

        <form action="{{route('hotel.admin.staff.store',['hotel_id'=>$hotel->id,'id'=>$row->id])}}" method="post">
            @csrf
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Name')}} <span class="text-danger">*</span></label>
                                <input type="text" required value="{{$row->name}}" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Title / Role')}}</label>
                                <input type="text" value="{{$row->title}}" name="title" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__('Photo')}}</label>
                        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id', $row->image_id) !!}
                    </div>
                    <div class="form-group">
                        <label><input type="radio" name="status" value="publish" @if($row->status=='publish') checked @endif> {{__('Publish')}}</label>
                        <label><input type="radio" name="status" value="draft" @if($row->status=='draft') checked @endif> {{__('Draft')}}</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">{{__('Save Changes')}}</button>
        </form>
    </div>
@endsection