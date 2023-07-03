@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <header class="card-header">
                <p class="card-header-title">
                    {{ 'Gifts  Detail' }}
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
                @php session()->forget('success'); @endphp

            </div>
            @endif
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">


                    <br>
                </div>

                <!-- <a href="{{url('admin/print/gifts/listing')}}"  style="margin-bottom: 14px;color: white;padding: 7px;background: #F5707A;width: 172px;
    border: 1px saddlebrown;">Print</a>
    <br> -->
                <button value="{{url('admin/print/gifts/listing')}}" onclick="printTble(this.value)" style="cursor: pointer;margin-bottom: 14px;color: white;padding: 7px;background: cornflowerblue;width: 72px;
    border: 1px saddlebrown;">Print</button>
                <!-- <button id="csv"  style="margin-bottom: 14px;color: white;padding: 7px;background:#28E871;width: 72px;
    border: 1px saddlebrown;">
    CSV
</button> -->
                <!-- <button  id="pdf" style="margin-bottom: 14px;color: white;padding: 7px;background: #F5707A;width: 72px;
    border: 1px saddlebrown;">PDF</button>            -->
                <table id="dataTableBuilder" class="table dataTable no-footer">
                    <thead>

                        <th>#</th>
                        <th>Gift Number</th>
                        <th>Bar-Code</th>
                        <th>QR-Code</th>


                    </thead>
                    <tbody>
                        @foreach($giftListing as $item)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->random_number}}</td>
                            <td>
                                @if($item->bar_code)
                                <img style="width:67px;" src="{{asset('uploads/barcodes/gifts/'.$item->bar_code)}}">
                                @else
                                Not Found
                                @endif
                            </td>
                            <!-- -->
                            <td>
                                @if($item->qr_code)
                                <img style="width:67px;" src="{{asset('uploads/qrcodes/gifts/'.$item->qr_code)}}">
                                @else
                                Not Found
                                @endif
                            </td>


                            <!-- -->



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
<script type="text/javascript">
    $(function() {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            'iDisplayLength': 50

        });
    });

    function printTble(p_url) {

        window.location.href = p_url;

    }

    $('#csv').on('click', function() {
        $("#dataTableBuilder").tableHTMLExport({
            type: 'csv',
            filename: 'gifts.csv'
        });
    })
    $('#pdf').on('click', function() {
        $("#dataTableBuilder").tableHTMLExport({
            type: 'pdf',
            filename: 'gifts.pdf'
        });
    })

    function exportData() {
        /* Get the HTML data using Element by Id */
        var table = document.getElementById("dataTableBuilder");

        /* Declaring array variable */
        var rows = [];

        //iterate through rows of table
        for (var i = 0, row; row = table.rows[i]; i++) {
            //rows would be accessed using the "row" variable assigned in the for loop
            //Get each cell value/column from the row
            column1 = row.cells[0].innerText;
            column2 = row.cells[1].innerText;
            column3 = row.cells[2].innerText;
            column4 = row.cells[3].innerText;


            /* add a new records in the array */
            rows.push(
                [
                    column1,
                    column2,
                    column3,
                    column4,

                ]
            );

        }
        csvContent = "data:text/csv;charset=utf-8,";
        /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
        rows.forEach(function(rowArray) {
            row = rowArray.join(",");
            csvContent += row + "\r\n";
        });

        /* create a hidden <a> DOM node and set its download attribute */
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Gifts.csv");
        document.body.appendChild(link);
        /* download the data file named "Stock_Price_Report.csv" */
        link.click();
    }
</script>

@endsection