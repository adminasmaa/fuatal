@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Cities' }}
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
                <div class="card-content" style="padding-bottom: 2rem;">
                    <div class="container-fluid">
        
   
<br>
</div>

<!-- <button onclick="exportData()">
    <span class="glyphicon glyphicon-download"></span>
    Download list
</button> -->
           
            	<table id="dataTableBuilder" class="table dataTable no-footer">
            	<thead>
                    
            		<th>Country</th>
                    <th>City</th>
            		
            		
            		<th>Action</th>
            	</thead>
            	<tbody>
            		@foreach($subObj as $item)
            		
            		<tr>
                        
            		<td>{{$item->country_id}}</td>    
            		<td>{{$item->city_name}}</td>
                    <td>
<button style="display:none;" class="button is-small is-danger" type="button" onclick="deleteRecord({{$item->id}})">
                <span class="icon">
                    <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                    </svg>
                </span>
                <span>Delete</span>
            </button> 
@if($item->lang_name=='English')
            <a class="button is-small is-primary" href="{{url('admin/city/'.$item->id.'/edit')}}">
            <span class="icon">
                <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z"></path>
                </svg>
            </span>
            <span>Edit</span>
        </a>    
 @endif

@if($item->lang_name=='English' AND $item->trans_status==0)
 <a title="Add Translation" class="button is-small" href="{{url('admin/translate/city'.'/'.$item->id)}}">
           Add Translation
        </a> 
@endif

@if($item->lang_name=='Arabic')
    <a title="Edit Translation" class="button is-small" href="{{url('admin/translate/city/edit'.'/'.$item->id)}}">
          Edit Translation
        </a> 
@endif   
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
  <!--   <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable({
        'iDisplayLength': 50,
        "dom":"Bfrtip",
        "buttons":["excel","csv","reload","pdf"],

        });});
</script> -->


@endsection
  <script type="text/javascript">

        
function deleteRecord(id){
    
        if(confirm('Are you sure?')){
        var url="{{url('admin/delete/cities')}}";
        //alert(url);
        $.get(url,{id:id},function(arg) {
          location.reload();
            // body...
        });
    }
}

function exportData(){
    /* Get the HTML data using Element by Id */
    var table = document.getElementById("dataTableBuilder");
 
    /* Declaring array variable */
    var rows =[];
 
      //iterate through rows of table
    for(var i=0,row; row = table.rows[i];i++){
        //rows would be accessed using the "row" variable assigned in the for loop
        //Get each cell value/column from the row
        column1 = row.cells[0].innerText;
        column2 = row.cells[1].innerText;
        column3 = row.cells[2].innerText;
        
 
    /* add a new records in the array */
        rows.push(
            [
                column1,
                column2,
                column3,
               
            ]
        );
 
        }
        csvContent = "data:text/csv;charset=utf-8,";
         /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
        rows.forEach(function(rowArray){
            row = rowArray.join(",");
            csvContent += row + "\r\n";
        });
 
        /* create a hidden <a> DOM node and set its download attribute */
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Stock_Price_Report.csv");
        document.body.appendChild(link);
         /* download the data file named "Stock_Price_Report.csv" */
        link.click();
}

</script>

