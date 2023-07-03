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
                                        {{ 'Gift Packages' }}
                                        @if(Auth::user()->hasPermission('add_package'))
                                        <a class="navbar-item" href="{{ url('/admin/packages/create') }}">
                                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg></span>
                                        </a>
                                        @endif

                                    </p>
                                </div>
                                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th></th>
                                            <th>Action</th>
                                            <!-- <th>Status</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $cnt=1;
                                        @endphp
                                        @foreach($packages as $package)
                                        @php
                                        $remaining_codes = 0;
                                        $action = true;
                                        if(count($package->bundles))
                                        {
                                        $action = false;
                                        foreach($package->bundles as $bundle)
                                        {
                                        $remaining_codes += $bundle->limit - $bundle->assigned;
                                        }
                                        }
                                        @endphp
                                        <tr>

                                            <td>{{$cnt}}</td>
                                            <td>
                                                <div id="accordion" class="permissions-collapses">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            @if(count($package->bundles))
                                                            <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#collapse-{{$package->id}}">
                                                                <!--begin::Icon-->
                                                                <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                                                    <span class="svg-icon toggle-on svg-icon-primary svg-icon-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black" />
                                                                            <rect x="6.0104" y="10.9247" width="12" height="2" rx="1" fill="black" />
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                                    <span class="svg-icon toggle-off svg-icon-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black" />
                                                                            <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="black" />
                                                                            <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="black" />
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </div>
                                                                <!--end::Icon-->
                                                                <!--begin::Title-->
                                                                <h4 class="text-gray-700 fw-bolder cursor-pointer mb-0">{{$package->name}}</h4>
                                                                <!--end::Title-->
                                                            </div>
                                                            @else
                                                            <p class="card-link pl-2">{{$package->name}}
                                                            <p>
                                                                @endif
                                                        </div>
                                                        @if(count($package->bundles))
                                                        <div id="collapse-{{$package->id}}" class="collapse fs-6 ms-1">
                                                            <div class="card-body">
                                                                <ul>
                                                                    @php
                                                                    foreach($package->bundles as $bundl)
                                                                    {
                                                                    @endphp
                                                                    <li><a href="{{url('/admin/winners/'.$bundl->id)}}">{{$bundl->name}}</a></li>
                                                                    @php
                                                                    }
                                                                    @endphp
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{date('d-m-Y', strtotime($package->start_date))}}</td>
                                            <td>{{date('d-m-Y', strtotime($package->end_date))}}</td>
                                            <td>
                                                @if($package->end_date < Carbon::now()) <label class="badge badge-danger">Expired</label>
                                                    @elseif(count($package->bundles) < 1) <label class="badge badge-info">Empty Gift Bundles</label>
                                                        @else
                                                        <a href="{{url('/admin/lottery/winners/'.$package->id)}}" class="btn btn-success btn-sm">Make Lottery Winners</a>
                                                        <a href="{{url('/admin/assign-instant/'.$package->id)}}" class="btn btn-warning btn-sm">Assign Instant Gifts</a>
                                                        @endif
                                            </td>
                                            @if(Auth::user()->hasPermission(['add_bundle', 'update_package', 'delete_package']))
                                            <td>
                                                @if(Auth::user()->hasPermission('add_bundle'))
                                                <a href="{{url('admin/bundles/create')}}" class="btn btn-secondary btn-sm">Add New Bundle</a>
                                                @endif
                                                @if(Auth::user()->hasPermission(['update_package', 'delete_package']))
                                                @if($action)
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

                                                    <div class="menu-item px-3">
                                                        <a class="menu-link px-3" href="{{url('/admin/packages/'.$package->id.'/edit')}}">Edit</a>
                                                    </div>


                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="{{ url('/admin/delete/package/'.$package->id) }}" class="menu-link px-3">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->

                                                @else
                                                <label class="badge badge-info">Not allowed</label>
                                                @endif
                                                @endif
                                            </td>
                                            @endif
                                            <!-- <td>Expired</td>  -->
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