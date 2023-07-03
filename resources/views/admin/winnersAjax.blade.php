<div class="col-md-12">
    @if($success == false && count($errors))
    <ul>
        @foreach($errors as $key => $error)
        @if(count($error))
        @foreach($error as $value)
        <li class="alert alert-danger">{{$value}}</li>
        @endforeach
        @endif
        @endforeach
    </ul>
    @endif
</div>
<div class="col-md-5">
    <label>Start Date and Time:</label>
    <input class="form-control" value="{{isset($request->start_date) && $request->start_date ? $request->start_date : ''}}" type="date" id="start_date" />
</div>
<div class="col-md-5">
    <label>End Date and Time:</label>
    <input class="form-control" value="{{isset($request->end_date) && $request->end_date ? $request->end_date : ''}}" type="date" id="end_date" />
</div>
<div class="col-md-2">
    <button class="btn btn-success mt-5" id="add-setting"><i class="fa fa-plus"></i>Save</button>
</div>

<div class="row mt-5">
    @if(count($winner_settings))
    @foreach($winner_settings as $setting)
    <div class="col-md-5">
        <label>Start Date and Time:</label>
        <input disabled value="{{$setting->start_date}}" class="form-control" type="date" />
    </div>
    <div class="col-md-5">
        <label>End Date and Time:</label>
        <input disabled value="{{$setting->end_date}}" class="form-control" type="date" />
    </div>
    <div class="col-md-2">
        <button class="btn btn-warning assign-times mt-5" data-bs-toggle="modal" data-bs-target="#assignTimes" data-id="{{$setting->id}}"><i class="fa fa-list"></i></button>
        <button class="btn btn-danger delete-setting mt-5" data-id="{{$setting->id}}"><i class="fa fa-trash"></i></button>
    </div>
    @endforeach
    @else
    <div class="col-md-12 text-center">
        <h5>Settings Not found</h5>
    </div>
    @endif
    <div></div>
</div>
