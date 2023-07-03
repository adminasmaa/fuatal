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
                @php session()->forget('success'); @endphp

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
                                        {{ 'All' . (isset($type) ? ' ' . $type . ' ' : '') . 'Winners' }}
                                        @if (isset($link))
                                        <a class="navbar-item" href="{{ $link }}">
                                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                                        </a>
                                        @endif

                                    </p>
                                </div>

                                <table id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5  dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>User</th>
                                            <th>Code Number</th>
                                            <th>Gift Type</th>
                                            <th>Product</th>
                                            <th>Bundle</th>
                                            <th>QR-Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($winners as $winner)
                                        <tr class="odd">
                                            <td class="sorting_1">2</td>
                                            <td>
                                                <img width="50px" src="{{URL::asset('uploads/categories/winner.png')}}">
                                                <img width="50px" src="" style="display:none;" id="img_VKE2WT08">

                                            </td>
                                            <td class="pe-0">{{$winner->user->full_name}} - {{$winner->user->phone}}
                                                - {{$winner->user->email}}
                                            </td>
                                            <td class="pe-0">{{$winner->random_number}}</td>
                                            <td class="pe-0">{{$winner->type == 'gift' ? 'Instant Gift' : ($winner->type == 'lottery' ? 'Lottery' : '-')}}</td>
                                            <td class="pe-0">{{isset($winner->product->title) ? $winner->product->title : '-'}}</td>
                                            <td class="pe-0">{{isset($winner->bundle) && isset($winner->bundle->name) ? $winner->bundle->name : '-'}}</td>
                                            <td class="pe-0"><img style="width:67px;" src="{{asset('uploads/qrcodes/lotteries/'.$winner->qr_code)}}"></td>

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
<script type="text/javascript">
    $(function() {

        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
            'iDisplayLength': 50

        });

        // $('#dataTableBuilder_length label').prepend("");
    });

    function makeWinnerAuto() {

        var auto_winners = $('#auto_win').val();
        if (auto_winners == 0) {
            alert('Please select a number of users first');
        } else {
            $('#loading_img').show();
            $.get("{{url('admin/make/lotteryautowinner')}}", {
                auto_winners: auto_winners
            }, function(msg, status) {
                console.log(msg);
                if (status == 'success') {
                    $('#loading_img').hide();
                    //location.reload();
                }


            });
        }

    }

    function makeWinner(random_number) {

        //console.log(random_number)

        $.get("{{url('admin/make/lotterywinner')}}", {
            random_number: random_number
        }, function(msg) {
            $('#btn_' + random_number + '').hide();
            $('#img_' + random_number).attr('src', "{{URL::asset('uploads/categories/winner.png')}}");
            $('#img_' + random_number).show();

        });
    }

    function printTble() {

        var divToPrint = document.getElementById('dataTableBuilder');
        var htmlToPrint = '' +
            '<style type="text/css">' +
            'table td,th {' +
            'border:0.25px solid silver;' +
            'padding:0.5em;' +
            'text-align:left;' +
            '}' +
            'table td,th {' +
            'text-align:left;' +
            'font-size:11px;' +
            '}' +

            '</style>';
        htmlToPrint += divToPrint.outerHTML;
        newWin = window.open("", "", "width=900,height=710");
        newWin.document.write(htmlToPrint);
        newWin.print();
        newWin.close();

    }
</script>



@endsection