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
                                        {{ 'All Quota for '. $company->name}}
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
                                        </div>
                                    </div>
                                </div>
                                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5  dataTable no-footer">
                                <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Quota</th>
                                            <th>Used</th>
                                            <th>Status</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @php
                                        $cnt =1;
                                        @endphp
                                        @foreach($quotas as $q)
                                        <tr>
                                            <td class="pe-0">{{$cnt}}</td>

                                            <td class="pe-0">{{date('d-m-Y', strtotime($q->from))}}</td>
                                            <td class="pe-0">{{date('d-m-Y', strtotime($q->to))}}</td>
                                            <td>{{$q->qouta}}</td>
                                            <td>{{$q->used}}</td>
                                            <td>
                                                @if($q->to >= now() && $q->qouta > $q->used)
                                                <label class="badge badge-info">Active</label>
                                                @else
                                                <label class="badge badge-danger">Expired</label>
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
                                    {{ $quotas->appends(compact('limit'))->links('pagination::bootstrap-4') }}
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
        window.location = "{!! $quotas->url(1) !!}&limit=" + this.value;
    };
</script>
@endsection