@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .lightgoldenrodyellow{
        background-color: lightgoldenrodyellow;
    }
    .active-class{
        color: white;
        padding: 5px;
        background-color: lightgreen;
        font-weight: bold;
        border-radius: 3px;
    }
    .inactive-class{
        color: white;
        padding: 5px;
        background-color: #f03a5f;
        /* font-weight: bold; */
        border-radius: 3px;
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
            @php session()->forget('success');  @endphp
        
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-success" id="success" style="background: #f14668;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;">
        
            {{ Session::get('error') }}
            @php session()->forget('error');  @endphp
        
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
                        {{ 'Admin Users' }}
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif
                    </p>
            </div>
            	<table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
            	<thead>
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
            		<th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>User Status</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Ops</th>
                </tr>
            	</thead>
            	<tbody>
            		@foreach($admins as $item)
            		<tr>
                    <td class="pe-0">{{$item->full_name}}</td>   
            		<td class="pe-0">{{$item->phone}}</td>
            		<!-- <td><a href="{{url('admin/view/product/'.$item->id)}}">{{$item->title}}</a></td> -->
                    <td class="pe-0">{{$item->email}}</td>
                    <td class="pe-0">
                    <label class="{{$item->is_active ? 'active-class' : 'inactive-class'}}">{{$item->is_active ? 'Active' : 'Inactive'}}</label>    
                    </td>
                    <td class="pe-0">{{$item->created_at}}</td>
                    <td class="pe-0">{{$item->updated_at}}</td>
            		<!-- <td>{!! $item->description !!}</td>	 -->
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
                               
                                <div class="menu-item px-3">
                                    <a  class="menu-link px-3" href="{{url('admin/edit/'.$item->id)}}">Edit</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a class="menu-link px-3"  href="{{route('admin.roles', $item->id)}}">Roles</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a class="menu-link px-3"  href="{{ route(implode('.', ['admin', $item->is_active ? 'inactive' : 'active']), ['user' => $item->id]) }}">Status</a>
                                </div>
                              
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" href="{{route('admin.delete.admin', ['user' => $item->id])}}" onclick="return confirm('Are you sure?')" >Delete</a>
                                </div>
                                <!--end::Menu item-->
                    </td>
            		</tr>
            		@endforeach
            	</tbody>	
            	</table>
               
               
            </div>  
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable({
        'iDisplayLength': 50
        });});
</script>

@endsection

