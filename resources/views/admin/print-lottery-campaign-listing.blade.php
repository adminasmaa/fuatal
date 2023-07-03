@extends('layouts.admin')

@section('content')
<style type="text/css">
    .navbar,.breadcrumb{
        display:none;

    }
</style>
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            
                <div class="card-content" style="padding: 2rem;">
            

<!-- <button onclick="printTble()" style="display:none;margin-bottom: 14px;color: white;padding: 7px;background: #F5707A;width: 72px;
    border: 1px saddlebrown;">Print</button> -->

           
            	<table id="dataTableBuilder" class="table dataTable no-footer">
            	<thead>
                    
                    <th>#</th>
                    <th>Gift/Lottery Number</th>
                    <th>Product</th>
                    <th>BAR-Code</th>
                    <th>QR-Code</th>
            		
            	
            	</thead>
            	<tbody>
            		@foreach($giftListing as $item)
            		
            		<tr>
                      <td class="pe-0">{{$loop->iteration}}</td> 
                      <td class="pe-0">{{$item->random_number}}</td>
            		<td class="pe-0">{{isset($item->product->title) ? $item->product->title : '-'}}</td>
                     
            		<td class="pe-0"> 
                        @if($item->bar_code)
                        <img style="width:67px;" src="{{asset('uploads/barcodes/lotteries/'.$item->bar_code)}}">
                        @else
                        Generating. please wait...
                        @endif
                    </td>
                    <!-- -->	
            		<td class="pe-0">
                        @if($item->qr_code)
                        <img style="width:67px;" src="{{asset('uploads/qrcodes/lotteries/'.$item->qr_code)}}">
                        @else
                        Generating. please wait..
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
    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder2").DataTable({
        'iDisplayLength': 50

        });});

  function printTble() {
  
    var divToPrint = document.getElementById('dataTableBuilder');
   /* var htmlToPrint = '' +
        '<style type="text/css">' +
        'table td,th {' +
        'border:0.25px solid silver;' +
        'padding:0.5em;' +
        'text-align:left;' +
        '}' +
        'table td,th {' +
        'text-align:left;' +
        'font-size:11px;'+
        '}'+  
       
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("","","width=900,height=710");
    newWin.document.write(htmlToPrint);
    newWin.print();*/
    divToPrint.print();
    newWin.close();
    
 }
</script>

@endsection
 

