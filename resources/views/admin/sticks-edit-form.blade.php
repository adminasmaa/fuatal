@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <!-- <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Sticks' }} 
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif
                       
                    </p>
                </header> -->
            @if(Session::has('success'))
            <div class="alert alert-success" id="success" style="background: limegreen;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;">

                {{ Session::get('success') }}
                @php session()->forget('success'); @endphp

            </div>
            @endif
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">
                    <h1 class="title">Update Sticks Range</h1>
                    <form method="POST" enctype="multipart/form-data" action="{{route('admin.sticks.update')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$stick->id}}" />
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">From</label>
                                <select class="form-control" name="from">
                                    @for ($i = 1; $i <= 99; $i++) <option {{$i == $stick->from ? 'selected' : ''}} value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">To</label>
                                <select class="form-control" name="to">
                                    @for ($i = 1; $i <= 99; $i++) <option {{$i == $stick->to ? 'selected' : ''}} value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="sticks_form" value="sticks_form">
                                <div class="control">
                                    <button type="submit" class="w-100 button btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                </div>


            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop Image Before Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function() {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable();
    });
</script>
@endsection