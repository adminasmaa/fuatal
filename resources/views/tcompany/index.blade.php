@php
use Carbon\Carbon;
@endphp
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


                    <br>
                </div>
                <div class="post d-flex flex-column-fluid">
                    <div id="kt_content_container-fluid" class="container-fluid">
                        <div class="card card-flush">
                            <!--begin::Card header-->
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="display:block">
                                <div class="card-title">
                                    <p class="card-header-title">
                                        {{ 'Telecom Companies' }}
                                        @if(Auth::user()->hasPermission('add_company'))
                                        <a class="navbar-item" href="{{ url('/admin/tcompany/create') }}">
                                            <span class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </span>
                                        </a>
                                        @endif
                                        @if(Auth::user()->hasPermission('add_credit_number'))
                                        <a href="{{url('/admin/download-number-import-sample')}}" class="btn btn-warning btn-sm">Download Import Sample</a>
                                        @endif

                                    </p>

                                </div>
                                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5  dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>Logo</th>
                                            <th>ID</th>
                                            <th>Prefix</th>
                                            <th>Name</th>
                                            @if(Auth::user()->hasPermission('add_credit_number'))
                                            <th>Import Excel</th>
                                            {{-- <th>Credit Numbers</th> --}}
                                            @endif
                                            @if(Auth::user()->hasPermission(['view_number', 'add_quota', 'view_quota', 'update_company', 'delete_company']))
                                            <th>Action</th>
                                            @endif
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @php
                                        $cnt =1;
                                        @endphp
                                        @foreach($tcompanies as $tcompany)
                                        <tr>
                                            <!-- <td class="pe-0">{{$tcompany->id}}</td>  -->
                                            <td>
                                                <a href="{{asset('uploads/categories/'.$tcompany->logo)}}" data-lightbox="myImg150" data-title="t15">
                                                    <img src="{{asset('uploads/categories/'.$tcompany->logo)}}" width="70" data-lightbox="myImg150">
                                                </a>
                                                <!-- <img src="{{asset('uploads/categories/'.$tcompany->logo)}}" style="width: 100px; height: 70px;"/> -->
                                            </td>
                                            <td>{{$tcompany->id}}</td>

                                            <td class="pe-0">{{$tcompany->prefix}}</td>
                                            <td class="pe-0">{{$tcompany->name}}</td>
                                            @if(Auth::user()->hasPermission('add_credit_number'))
                                            <td>
                                                <form class="d-flex" action="{{url('/admin/credit-numbers/import')}}" method="post" name="numberImport" enctype="multipart/form-data">
                                                    @csrf
                                                    <input class="form-control" type="file" name="file" required />
                                                    <button type="submit" class="btn btn-success btn-sm">Import</button>
                                                </form>
                                            </td>
                                            {{-- <td>
                                                <form class="d-flex" name="addCreditNumber" method="post" action="{{url('/admin/add-credit-number')}}">
                                                    @csrf
                                                    <input type="hidden" name="company_id" value="{{$tcompany->id}}" />
                                                    <input placeholder="Enter 14 to 16 digits" required class="form-control" type="text" name="number" />
                                                    <button type="submit" class="btn btn-info btn-sm">Add Single Number</button>
                                                </form>
                                            </td> --}}
                                            @endif
                                            @if(Auth::user()->hasPermission(['view_number', 'add_quota', 'view_quota', 'update_company', 'delete_company']))
                                            <td>
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">
                                                    <!--begin::Menu item-->
                                                    @if(count($tcompany->numbers))
                                                    @if(Auth::user()->hasPermission('view_number'))
                                                    <div class="menu-item px-3">
                                                        <a class="menu-link px-3" href="{{url('/admin/credit-numbers/'.$tcompany->id)}}">View Numbers</a>
                                                    </div>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('add_quota'))
                                                    <div class="menu-item px-3">
                                                        <a class="menu-link px-3" href="{{url('/admin/assign-quota/'.$tcompany->id)}}">Create New Quota</a>
                                                    </div>
                                                    @endif
                                                    @endif
                                                    @if(Auth::user()->hasPermission('view_quota'))
                                                    <div class="menu-item px-3">
                                                        <a class="menu-link px-3" href="{{url('/admin/tcompany/quota/'.$tcompany->id)}}">See Quota</a>
                                                    </div>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('update_company'))
                                                    <div class="menu-item px-3">
                                                        <a class="menu-link px-3" href="{{url('/admin/tcompany/'.$tcompany->id.'/edit')}}">Edit</a>
                                                    </div>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('delete_company'))
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a onclick="return confirm('Are you sure to delete?');" href="{{ url('/admin/delete/tcompany/'.$tcompany->id) }}" class="menu-link px-3">Delete</a>
                                                    </div>
                                                    @endif
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            </td>
                                            @endif
                                        </tr>
                                        @php
                                        $cnt++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>

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
<script type="text/javascript">
    $(function() {

        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            'iDisplayLength': 50

        });

        // $('#dataTableBuilder_length label').prepend("");
    });
</script>


@endsection