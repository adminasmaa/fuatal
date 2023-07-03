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

    <div class="alert alert-danger" id="fail" style="background: #f14668;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;
    display:none;
    ">
        This category can not be deleted!
           
        
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
                        {{ 'Categories Listing' }}
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
            		<th>Image</th>
                    <!-- <th>Subcategory</th> -->
            		<th>Category</th>
            		<th>Arabic Title</th>
            		<!-- <th>Description</th> -->
            		<th>Action</th>
                </tr>
            	</thead>
            	<tbody>
            		{!!$view !!}
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
        'iDisplayLength': 50,
        orderable: false
        });});
</script>

@endsection
  <script type="text/javascript">

        
function deleteRecord(id){
    //alert(id)
        if(confirm('Are you sure?')){
        var url="{{url('admin/delete/cat')}}";
        //alert(url);
        $.get(url,{id:id},function(arg) {
            if(arg=="2"){
                $('#fail').show();
            } else{
           
        //    location.reload();

            }
          
            // body...
        });
    }
}



</script>

