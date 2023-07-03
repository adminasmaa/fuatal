@extends('layouts.admin')

@section('content')
<section class="section">
<div class="container-fluid">
        <div class="card no-box-shadow-mobile">
             @if(Session::has('success'))
            <div class="alert alert-success" id="success" style="background: limegreen;color: white;width: 30%;padding: 13px;text-align: center;margin-left: 35%;margin-top: 13px;">
            
                {{ Session::get('success') }}
                @php session()->forget('success');  @endphp
            
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-success" id="success" style="background: #f14668;color: white;width: 30%;padding: 13px;text-align: center;margin-left: 35%;margin-top: 13px;">
        
                {{ Session::get('error') }}
                @php session()->forget('error');  @endphp
        
             </div>
            @endif

        </div>
        <div class="card-content" style="padding-bottom: 2rem;">
            <div class="post d-flex flex-column-fluid">
                <div id="kt_content_container-fluid" class="container-fluid">
                    <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="display:block">
                        <div class="card-title">
                        <p class="card-header-title">
                                    {{ 'Users' }}
                                    @if (isset($link))
                                        <a class="navbar-item" href="{{ $link }}">
                                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                                        </a>
                                    @endif
                                </p>
                        </div>
                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer p-2">
            	<thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th>Sr.no</th>
                        <th>Status</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Ops</th>
                    </tr>
            	</thead>
                <tbody>
                
                    @foreach($users as $user)
                    
                        <tr>
                            <td class="pe-0"> 
                                {{$user->id}}
                            </td>
                            <td class="pe-0"> 
                                {{$user->is_active ? 'Active' : 'InActive'}}
                            </td>
                            <td class="pe-0"> 
                                {{$user->phone}}
                            </td>
                            <td class="pe-0">
                                {{$user->email ?? '-'}}
                            </td>
                            <td class="pe-0">
                                {{$user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i a') : '-'}}
                            </td>
                            <td class="pe-0">
                                {{$user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d-m-Y H:i a') : '-'}}
                            </td>
                            <td  class="pe-0">
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
                                    <a class="menu-link px-3" data-toggle="tooltip" title="Edit User"  href="{{ route(implode('.', ['admin', 'user', 'edit']), ['user' => $user->id]) }}">Edit</a>
                                    </div>
                                    <div class="menu-item px-3">
                                    <a class="menu-link px-3" data-toggle="tooltip" title="Update Password"  href="{{ route(implode('.', ['admin', 'user', 'user-password']), ['user' => $user->id]) }}">Password</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a class="menu-link px-3" data-toggle="tooltip" title="Dectivate User" href="{{ route(implode('.', ['admin', 'user', $user->is_active ? 'inactive' : 'active']), ['user' => $user->id]) }}" >{{ $user->is_active ? 'Deactivate' : 'Activate'}}</a>
                                    </div>
                                
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <form class="is-inline" method="POST" action="{{ route(implode('.', ['admin', 'user', 'destroy']), ['user' => $user->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="menu-link px-3"  data-toggle="tooltip" title="Delete User" style="border: 0; background:white"  type="submit" onclick="return confirm('{{ __('admin.ops.confirmation') }}')">Delete </button>
                                             
                                            <!-- <span class="icon">
                                                    <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                                                    </svg>
                                                </span> -->
                                                <!-- <span>{{ __('admin.ops.delete') }}</span> -->
                                            </a>
                                        </form>
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
        </div>
        </div>
</section>
@endsection

@section('scripts')
    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable({
        'iDisplayLength': 10
        });});
</script>

@endsection