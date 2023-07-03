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
            @php session()->forget('success');  @endphp
        
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger" id="error" style="background: #f14668;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;
    ">
        {{ Session::get('error') }}
            @php session()->forget('error');  @endphp
           
        
    </div>
    @endif

    <div class="alert alert-danger" id="fail" style="background: #f14668;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;
    display:none;
    ">
        This slider can not be deleted!
           
        
    </div>
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
                        {{ 'Sticks Listing' }}
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
                            <th>#</th>
                            <th>Range</th>
                            <th>From</th>
                            <th>To</th>
                            <th class="text-end">Action</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        @foreach($sticks as $item)
                        <tr>
                        <td class="pe-0">{{$loop->iteration}}</td> 
                        <td>
                        {{$item->range}}
                        </td>
                        <td class="pe-0">
                        {{$item->from}}
                        </td>
                        <td class="pe-0">
                        {{$item->to}}
                        </td>
                        
                        <td class="text-end">
                            @if(count($item->mekanos))
                            <label class="badge badge-warning">Not allowed</label>
                            @else
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon--></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">
                                <!--begin::Menu item-->
                           
                                <div class="menu-item px-3">
                                    <a  class="menu-link px-3" href="{{url('admin/sticks/edit/'.$item->id)}}">Edit</a>
                                </div>
                                
                               
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" onclick="deleteRecord({{$item->id}})" >Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                            @endif
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
  <script type="text/javascript">

        
function deleteRecord(id){
    //alert(id)
        if(confirm('Are you sure?')){
        var url="{{url('admin/sticks/delete')}}";
        //alert(url);
        $.get(url,{id:id},function(arg) {
            if(arg=="2"){
                $('#fail').show();
            } else{
           
           location.reload();

            }
          
            // body...
        });
    }
}



</script>

