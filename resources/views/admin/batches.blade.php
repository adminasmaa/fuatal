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
                                        {{ 'All Print Text Batches' }}
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
                                           {{--  @if(count($batches))
                                            <div class="col-md-6">
                                                <a href="{{url('/admin/export-lottery-numbers', ['type' => 'telecom'])}}" class="btn btn-info btn-sm">Export Excel</a>
                                            </div>
                                            @endif --}}
                                        </div>
                                    </div>
                                </div>
                                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th>Batch Date</th>
                                            <!-- <th>Total Files</th> -->
                                            <th>Action</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach($batches as $item)

                                        <tr>
                                            <td class="pe-0">{{$loop->iteration}}</td>
                                            <td class="pe-0">{{date('d-m-Y i:s')}}</td>
                                            <!-- <td class="pe-0">1</td> -->
                                            <td><a class="btn btn-warning btn-sm" href="{{url('admin/print-text-batch-files?batch_id='.$item->id)}}">View Files</a></td>
                                            <!-- -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 mt-4 custom-footer">
                                    {{ $batches->appends(request()->input())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- {{ $batches->onEachSide(5)->links() }} -->
<!-- {{ $batches->links() }} -->

<!-- {{ $batches->appends($_GET)->links() }} -->
@endsection

@section('scripts')
<script type="text/javascript">
    // $(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable({
    //     'iDisplayLength': false

    //     });
    // });
    document.getElementById('pagination').onchange = function() {
        window.location = "{!! $batches->url(1) !!}&limit=" + this.value;
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