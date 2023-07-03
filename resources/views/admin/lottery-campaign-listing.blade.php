@extends('layouts.admin')

@section('content')
<style>
    .pagination {
        float: right;
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
                @php session()->forget('success');
                @endphp

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
                                        {{ 'All Generated Codes [Lottery]' }}
                                        @if (isset($link))
                                        <a class="navbar-item" href="{{ $link }}">
                                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                                        </a>
                                        @endif
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form>
                                                    Show <select class="" id="pagination">
                                                        <option value="10" @if($limit==10) selected @endif>10</option>
                                                        <option value="25" @if($limit==25) selected @endif>25</option>
                                                        <option value="50" @if($limit==50) selected @endif>50</option>
                                                        <option value="100" @if($limit==100) selected @endif>100</option>
                                                    </select>
                                                    entries
                                                </form>
                                            </div>
                                            @if(count($lotteryListing))
                                            <div class="col-md-6">
                                                <a href="{{url('/admin/export-lottery-numbers', ['type' => 'lottery'])}}" class="btn btn-info btn-sm">Export Excel</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(count($lotteryListing))
                                    <div class="col-md-8">
                                        <form name="exportPdfQrcodes" action="{{url('/admin/export-pdf-qrcodes', ['type' => 'lottery'])}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input placeholder="Start number (Minumum 1)" class="form-control" type="number" min="1" name="from" />
                                                </div>
                                                <div class="col-md-5">
                                                    <input placeholder="End number (>= start)" class="form-control" type="number" min="1" name="to" />
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-primary btn-sm" type="submit">Print</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th>Lottery Number</th>
                                            <th>Product</th>
                                            <th>Gift Type</th>
                                            <th>BAR-Code</th>
                                            <th>QR-Code</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach($lotteryListing as $item)

                                        <tr>
                                            <td class="pe-0">{{$loop->iteration}}</td>
                                            <td class="pe-0">{{$item->random_number}}</td>
                                            <td class="pe-0">{{isset($item->product->title) ? $item->product->title : '-'}}</td>
                                            <td class="pe-0">{{isset($item->type) ? $item->type : '-'}}</td>

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
                                <div class="col-md-12 mt-4 custom-footer">
                                    {{ $lotteryListing->appends(compact('limit'))->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- {{ $lotteryListing->onEachSide(5)->links() }} -->
<!-- {{ $lotteryListing->links() }} -->

<!-- {{ $lotteryListing->appends($_GET)->links() }} -->
@endsection

@section('scripts')
<script type="text/javascript">
    // $(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable({
    //     'iDisplayLength': false

    //     });
    // });
    document.getElementById('pagination').onchange = function() {
        window.location = "{!! $lotteryListing->url(1) !!}&limit=" + this.value;
    };

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

    function printTble(p_url) {
        let searchParams = new URLSearchParams(window.location.search);
        let limit = 10;
        let page = 1;
        if (searchParams.has('limit')) {
            limit = searchParams.get('limit');
        }
        if (searchParams.has('page')) {
            page = searchParams.get('page');
        }
        console.log(limit, page);
        window.location.href = p_url + '?limit=' + limit + '&page=' + page;

        /* var divToPrint = document.getElementById('dataTableBuilder');
         var htmlToPrint = '' +
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
         newWin.print();
         newWin.close();*/

    }
</script>

@endsection