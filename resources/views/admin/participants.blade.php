@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">
                    <br>
                </div>
                <div class="post d-flex flex-column-fluid">
                    <div id="kt_content_container-fluid" class="container-fluid">
                        <div class="card card-flush">
                            <!--begin::Card header-->
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="display:block">
                                <div class="card-title">
                                    <p class="card-header-title">
                                        {{ 'Participants Report' }}
                                    </p>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="filters">
                                    <h4>Customize your Search</h4>
                                    <form name="filters-form" id="filters-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="from_date">From Date</label>
                                                <input value="{{request('from_date')}}" type="date" class="form-control" id="from_date" name="from_date" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="to_date">To Date</label>
                                                <input value="{{request('to_date')}}" type="date" class="form-control" id="to_date" name="to_date" />
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-md-4">
                                                <label for="company">Select Company</label>
                                                <select class="form-control" name="company">
                                                    <option value="">---Select Option---</option>
                                                    @if(count($companies))
                                                    @foreach($companies as $company)
                                                    <option {{$company->prefix == request('company') ? 'selected' : ''}} value="{{$company->prefix}}">{{$company->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="company">Select Product</label>
                                                <select class="form-control" name="product">
                                                    <option value="">---Select Option---</option>
                                                    @if(count($products))
                                                    @foreach($products as $product)
                                                    <option {{$product->id == request('product') ? 'selected' : ''}} value="{{$product->id}}">{{$product->title}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="company">Select Participant Type</label>
                                                <select class="form-control" name="participant_type">
                                                    <option value="">---Select Option---</option>
                                                    @if(count($types))
                                                    @foreach($types as $key => $value)
                                                    <option {{$key == request('participant_type') ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-md-2">
                                                <button type="reset" class="btn btn-warning w-100">Reset</button>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-success w-100">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <table class="table table-stripped table-hover mt-5">
                                    <caption class="caption-top">Particpants List</caption>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Phone Number</th>
                                            <th>System Code</th>
                                            <th>Tele. Company Code</th>
                                            <th>Tele. Company Name</th>
                                            <th>Submit Date</th>
                                            <th>Submit Time</th>
                                            <th>Product Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($participants))
                                        @foreach($participants as $participant)
                                        <?php
                                        $date = new DateTime($participant->scan_date);
                                        $date_result = $date->format('Y-m-d');
                                        $time_result = $date->format('H:i:s');
                                        $am_pm = $date->format('a');
                                        ?>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$participant->phone_number}}</td>
                                            <td>{{$participant->random_number}}</td>
                                            <td>{{$participant->credit_number ? $participant->credit_number : '-'}}</td>
                                            <td>{{$participant->company ? $participant->company->name : '-'}}</td>
                                            <td>{{$date_result}}</td>
                                            <td>{{$time_result . ' ' . $am_pm}}</td>
                                            <td>{{$participant->product->title}}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7">
                                                <h4 class="text-center">Not Found</h4>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {!! $participants->appends(request()->input())->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection