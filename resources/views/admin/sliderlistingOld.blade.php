@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Sliders Listing' }}
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif

                    </p>

                </header>
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


           
            	<table id="dataTableBuilder" class="table dataTable no-footer">
            	<thead>
                    
            		<th>Slider</th>
                    @if(Auth::user()->hasPermission(['delete_slider', 'update_slider']))
            		<th>Action</th>
                    @endif
            	</thead>
            	<tbody>
            		@foreach($sliders as $item)
                    <tr>
                       
            		<td>
                    <a href="{{URL::asset('uploads/sliders/'.$item->image)}}" data-lightbox="myImg150" data-title="t15">
                                        <img src="{{URL::asset('uploads/sliders/'.$item->image)}}" width="70" data-lightbox="myImg150">
                                        </a> 
            		</td>
                    @if(Auth::user()->hasPermission(['delete_slider', 'update_slider']))
                     <td>

            @if(Auth::user()->hasPermission('delete_slider'))
    <button class="button is-small is-danger" type="button" onclick="deleteRecord({{$item->id}})">
                <span class="icon">
                    <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                    </svg>
                </span>
                <span>Delete</span>
            </button> 
            @endif
            @if(Auth::user()->hasPermission('update_slider'))

            <a class="button is-small is-primary" href="{{url('admin/edit/slider/'.$item->id)}}">
            <span class="icon">
                <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z"></path>
                </svg>
            </span>
            <span>Edit</span>
        </a>  
        @endif
                        </td>
                        @endif
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
  <script type="text/javascript">

        
function deleteRecord(id){
    //alert(id)
        if(confirm('Are you sure?')){
        var url="{{url('admin/delete/slider')}}";
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

