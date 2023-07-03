@php
use Carbon\Carbon;
@endphp
@extends('layouts.admin')

@section('content')
<style>
    .pagination {
        float: right;
    }
</style>
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
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
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
                                        {{ 'All Credit Numbers'}}
                                    </p>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form>
                                                    Show <select class="" id="pagination">
                                                        <option value="10" @if($limit==10) selected @endif>10</option>
                                                        <option value="25" @if($limit==25) selected @endif>25</option>
                                                        <option value="50" @if($limit==50) selected @endif>50</option>
                                                        <option value="100" @if($limit==100) selected @endif>100</option>
                                                    </select>
                                                    entries
                                                </form>
                                            </div>
                                            @if(count($numbers))
                                            <div class="col-md-6">
                                                <a href="{{url('/admin/export-credit-numbers')}}" class="btn btn-info btn-sm">Export Excel</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(count($numbers))
                                    <div class="col-md-8">
                                        <form name="exportPdfNumbers" action="{{url('/admin/export-pdf-numbers')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input placeholder="Start number (Minumum 1)" class="form-control" type="number" min="1" name="from" />
                                                </div>
                                                <div class="col-md-5">
                                                    <input placeholder="End number (>= start)" class="form-control" type="number" min="1" name="to" />
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-primary btn-sm" type="submit">Print</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                <div class="filters">
                                    <h4>Customize your Search</h4>
                                    <form name="filters-form" id="filters-form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="search">Search</label>
                                                <input placeholder="---Search---" class="form-control" type="text" name="search" value="{{request('search')}}" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="status">Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">---Select Option---</option>
                                                    <option {{'1' == request('status') ? 'selected' : ''}} value="1">Used</option>
                                                    <option {{'0' == request('status') ? 'selected' : ''}} value="0">Unused</option>
                                                </select>
                                            </div>
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
                                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5  dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th>Number</th>
                                            <th>Company</th>
                                            <th>Credit Amount</th>
                                            <th>Expire Date</th>
                                            <th>Status</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @php
                                        $cnt =1;
                                        @endphp
                                        @foreach($numbers as $num)
                                        <tr>
                                            <td class="pe-0">{{$cnt}}</td>

                                            <td class="pe-0">{{$num->number}}</td>
                                            <td class="pe-0">{{$num->company->name}}</td>
                                            <td class="pe-0">{{$num->credit_amount}}</td>
                                            <td class="pe-0">{{$num->expire_date ? date('d-m-Y', strtotime($num->expire_date)) : '-'}}</td>
                                            <td>
                                                @php
                                                $date_facturation = \Carbon\Carbon::parse($num->expire_date);
                                                @endphp
                                                @if($num->expired)
                                                <label class="badge badge-danger">Used</label>
                                                @elseif(!$num->expired && $date_facturation->isPast())
                                                <label class="badge badge-warning">Expired</label>
                                                @else
                                                <label class="badge badge-success">Unused</label>
                                                @endif
                                            </td>

                                        </tr>
                                        @php
                                        $cnt++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 mt-4 custom-footer">
                                    {{ $numbers->appends(request()->input())->links('pagination::bootstrap-4') }}
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

@section('scripts')
<script>
    document.getElementById('pagination').onchange = function() {
        window.location = "{!! $numbers->url(1) !!}&limit=" + this.value;
    };
</script>
@endsection