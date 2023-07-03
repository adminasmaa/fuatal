<div id="time-item-section">
    <h4>{{$winner_setting->start_date . ' To ' . $winner_setting->end_date}}</h4>
    <div class="row mt-5">
        @if(count($errors))
        <ul>
            @foreach($errors as $key => $value)
            @if(count($value))
            @foreach($value as $error)
            <li class="alert alert-danger">
                {{$error}}
            </li>
            @endforeach
            @endif
            @endforeach
        </ul>
        @endif
        <div class="col-md-2">
            <label class="text-bold">Add No. of Winners:</label>
            <input class="form-control" value="{{isset($request->no_winners) && $request->no_winners ? $request->no_winners : ''}}" type="number" id="no_winners_{{$winner_setting->id}}" />
        </div>
        <div class="col-md-2">
            <label>Winners out of:</label>
            <input class="form-control" value="{{isset($request->winner_out_of) && $request->winner_out_of ? $request->winner_out_of : ''}}" type="number" id="winner_out_of_{{$winner_setting->id}}" />
        </div>
        <div class="col-md-3">
            <label>Start Time:</label>
            <input class="form-control" value="{{isset($request->start_time) && $request->start_time ? $request->start_time : ''}}" type="time" id="start_time_{{$winner_setting->id}}" />
        </div>
        <div class="col-md-3">
            <label>End Time:</label>
            <input class="form-control" value="{{isset($request->end_time) && $request->end_time ? $request->end_time : ''}}" type="time" id="end_time_{{$winner_setting->id}}" />
        </div>
        <div class="col-md-2">
            <button class="btn btn-success mt-5 add-time" data-id="{{$winner_setting->id}}"><i class="fa fa-plus"></i></button>
        </div>
        @if($winner_setting->times && count($winner_setting->times))
        @foreach($winner_setting->times as $time)
        <div class="row mt-5">
            <div class="col-md-2">
                <label class="text-bold">No. of Winners:</label>
                <input disabled class="form-control" value="{{$time->no_winners}}" type="number" id="no_winners_{{$time->id}}" />
            </div>
            <div class="col-md-2">
                <label>Winners out of:</label>
                <input disabled class="form-control" value="{{$time->winner_out_of}}" type="number" id="winner_out_of_{{$time->id}}" />
            </div>
            <div class="col-md-3">
                <label>Start Time:</label>
                <input disabled class="form-control" value="{{$time->start_time}}" type="time" id="start_time_{{$time->id}}" />
            </div>
            <div class="col-md-3">
                <label>End Time:</label>
                <input disabled class="form-control" value="{{$time->end_time}}" type="time" id="end_time_{{$time->id}}" />
            </div>
            <div class="col-md-2">
                <button class="btn btn-danger mt-5 delete-time" data-id="{{$time->id}}"><i class="fa fa-trash"></i></button>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>