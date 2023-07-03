@extends('layouts.admin')
@section('content')

<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
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
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">{{$error}}</div>
            @endforeach
            @endif
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">
                    <h5 class="py-5">Assign Quota ({{$company->name}})</h5>
                    @if($available > 0)
                    <form method="POST" enctype="multipart/form-data" action="{{url('/admin/assign-quota/save')}}">
                        @csrf
                        <input type="hidden" name="company_id" value="{{$company->id}}" />
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Percentage Quota from {{$available}}</label>
                                <input class="form-control" value="" type="text" name="percentage" required="required">
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="form-label required fs-5 fw-bold mb-2">Date Range</label>
                                <input name="date_range" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1" />
                                <!-- <input class="form-control" value="" type="text" name="name" required="required"> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control">

                                    <button type="submit" class="w-100 btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <h6 class="badge badge-warning badge-lg">There is no Quota available against {{$company->name}}</h6>
                    @endif
                    <br>
                </div>


            </div>
        </div>
    </div>
</section>
@php
$today = date('d-m-Y', strtotime(now()));
@endphp
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#kt_daterangepicker_1").daterangepicker({
            locale: {
                format: "D-MM-YYYY",
                startDate: new Date(),
                // minDate: "{{$today}}"
            }
        });
    });
</script>
@endsection