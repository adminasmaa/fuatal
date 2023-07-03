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
                                        {{ 'All Generated Codes [Telecom]' }}
                                        @if (isset($link))
                                        <a class="navbar-item" href="{{ $link }}">
                                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg></span>
                                        </a>
                                        @endif
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
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
                                                <a href="{{url('/admin/export-lottery-numbers', ['type' => 'telecom'])}}" class="btn btn-info btn-sm">Export Excel</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(count($lotteryListing))
                                    <div class="col-md-6">
                                        <form name="exportPdfQrcodes" action="{{url('/admin/export-pdf-qrcodes', ['type' => 'telecom'])}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input placeholder="Start number (Minumum 1)" class="form-control" type="number" min="1" name="from" />
                                                </div>
                                                <div class="col-md-5">
                                                    <input placeholder="End number (>= start)" class="form-control" type="number" min="1" name="to" />
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="btn btn-primary" name="submit" value="Print" type="submit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-3">
                                        <form name="exportPdfQrcodes" action="{{url('/admin/print-text-telecom-codes')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input placeholder="Number of Codes" class="form-control" type="number" min="1" name="no_of_codes" />
                                                </div>
                                                <div class="col-md-4 d-flex">
                                                    <input class="btn btn-default btn-success" name="submit" value="Text Print" type="submit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                <div class="filters">
                                    <h4>Customize your Search</h4>
                                    <form name="filters-form" id="filters-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="from_date">From Date</label>
                                                <input value="{{request('from_date')}}" type="date" class="form-control" id="from_date" name="from_date" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="to_date">To Date</label>
                                                <input value="{{request('to_date')}}" type="date" class="form-control" id="to_date" name="to_date" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="status">Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">---Select Option---</option>
                                                    <option {{'0' == request('status') ? 'selected' : ''}} value="0">Used</option>
                                                    <option {{'1' == request('status') ? 'selected' : ''}} value="1">Unused</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="company">Select Product</label>
                                                <select class="form-control" name="product">
                                                    <option value="">---Select Option---</option>
                                                    @if(count($products))
                                                    @foreach($products as $product)
                                                    <option {{$product->id == request('product') ? 'selected' : ''}} value="{{$product->id}}">{{$product->title}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-md-2">
                                                <button type="reset" class="btn btn-warning w-100">Reset</button>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-success w-100">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th>Random Number</th>
                                            <th>Product</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
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
                                            <td>
                                                @php
                                                $text_class = is_null($item->phone_number) ? 'alert-success' : 'alert-danger';
                                                @endphp
                                                <span class="alert {{$text_class}}">{{is_null($item->phone_number) ? "Unused" : "Used"}}</span>
                                            </td>
                                            <td>
                                                {{date('d-m-Y', strtotime($item->created_at))}}
                                            </td>
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
                                    {{ $lotteryListing->appends(request()->input())->links('pagination::bootstrap-4') }}
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
            filename: 'telecom.csv'
        });
    })

    $('#pdf').on('click', function() {
        $("#dataTableBuilder").tableHTMLExport({
            type: 'pdf',
            filename: 'telecom.pdf'
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