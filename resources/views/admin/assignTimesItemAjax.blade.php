<div class="row mt-5">
    <label>{{$setting->date}}</label>
    @if($error)
    <label class="alert alert-danger">{{$error}}</label>
    @endif

    <div class="col-md-2">
        <label class="text-bold">Add No. of Winners:</label>
        <input class="form-control" value="{{isset($request->no_winners) && $request->no_winners ? $request->no_winners : ''}}" type="number" id="no_winners_{{$date->id}}" />

    </div>
    <div class="col-md-2">
        <label>Winners out of:</label>
        <input class="form-control" value="{{isset($request->winner_out_of) && $request->winner_out_of ? $request->winner_out_of : ''}}" type="number" id="winner_out_of_{{$date->id}}" />
    </div>
    <div class="col-md-3">
        <label>Start Time:</label>
        <input class="form-control" value="{{isset($request->start_time) && $request->start_time ? $request->start_time : ''}}" type="time" id="start_time_{{$date->id}}" />
    </div>
    <div class="col-md-3">
        <label>End Time:</label>
        <input class="form-control" value="{{isset($request->end_time) && $request->end_time ? $request->end_time : ''}}" type="time" id="end_time_{{$date->id}}" />
    </div>
    <div class="col-md-2">
        <button class="btn btn-success mt-5 add-time" data-id="{{$date->id}}"><i class="fa fa-plus"></i></button>
    </div>
    @if($date->times && count($date->times))
    @foreach($date->times as $time)
    <div class="col-md-2">
        <label class="text-bold">No. of Winners:</label>
        <input disabled class="form-control" value="{{$time->no_winners}}" type="number" id="no_winners_{{$time->id}}" />
    </div>
    <div class="col-md-2">
        <label>Winners out of:</label>
        <input disabled class="form-control" value="{{$time->winner_out_of}}" type="number" id="winner_out_of_{{$date->id}}" />
    </div>
    <div class="col-md-3">
        <label>Start Time:</label>
        <input disabled class="form-control" value="{{$time->start_time}}" type="time" id="start_time_{{$date->id}}" />
    </div>
    <div class="col-md-3">
        <label>End Time:</label>
        <input disabled class="form-control" value="{{$time->end_time}}" type="time" id="end_time_{{$date->id}}" />
    </div>
    <div class="col-md-2">
        <button class="btn btn-danger mt-5 delete-time" date-id="{{$time->id}}"><i class="fa fa-trash"></i></button>
    </div>
    @endforeach
    @endif
</div>