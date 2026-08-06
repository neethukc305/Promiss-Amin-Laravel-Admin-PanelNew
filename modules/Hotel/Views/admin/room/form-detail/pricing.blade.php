@if(is_default_lang())
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__("Price")}} <span class="text-danger">*</span></label>
                <input type="number" required value="{{$row->price}}" min="1" placeholder="{{__("Price")}}" name="price" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__("Number of room")}} <span class="text-danger">*</span></label>
                <input type="number" required value="{{$row->number ?? 1}}" min="1" max="100" placeholder="{{__("Number")}}" name="number" class="form-control">
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__("Duration (minutes)")}} <span class="text-danger">*</span></label>
              <input type="number" required value="{{$row->duration ?? 30}}" min="1" placeholder="{{__("Ex: 45")}}" name="duration" class="form-control">
            </div>
        </div>
    </div>
    <hr>
@endif