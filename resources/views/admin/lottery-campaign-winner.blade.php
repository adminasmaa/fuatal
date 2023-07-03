@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<style>
    .navbar.is-dark .navbar-brand>a.navbar-item:focus,
    .navbar.is-dark .navbar-brand>a.navbar-item:hover,
    .navbar.is-dark .navbar-brand>a.navbar-item.is-active,
    .navbar.is-dark .navbar-brand .navbar-link:focus,
    .navbar.is-dark .navbar-brand .navbar-link:hover,
    .navbar.is-dark .navbar-brand .navbar-link.is-active {
        text-decoration: none !important;
    }

    .card {
        display: block !important;
    }

    .breadcrumb {
        background-color: transparent !important;
        padding: 0 !important;
    }

    .card-header {
        padding: 0 !important;
        background-color: transparent !important;
        display: block !important;
        border-bottom: unset !important;
    }

    .card-footer:first-child,
    .card-content:first-child,
    .card-header:first-child {
        border-top-left-radius: 0.25rem !important;
        border-top-right-radius: 0.25rem !important;
    }

    a:hover {
        text-decoration: none !important;
    }

    .navbar {
        padding: 0 !important;
    }

    .navbar-brand {
        font-size: unset !important;
        display: flex !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        margin-right: 0 !important;
    }

    .navbar>.container {
        align-items: stretch !important;
    }
</style>
@php
$limit_auto_win = 0;
if(count($package->bundles))
{
foreach($package->bundles as $bundle)
{
$limit_auto_win = $limit_auto_win + ($bundle->limit - $bundle->assigned);
}
}
if(count($lotteries) < $limit_auto_win) { $limit_auto_win=count($lotteries); } @endphp <section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile" style="padding: 20px;">
            <header class="card-header">
                <h5 class="card-header-title">List of SCANNED Codes for Lottery</h5>
                <!-- <p class="card-header-title" style="font-size: 17px;">
                        {{ 'Lottery (Assign Winners)' }}
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif
                    </p> -->
                <h5 class="card-header-title">{{$package->name}}</h5>
                <span class="badge badge-danger badge-pill">{{'Maximum Limit for winners against this package is '.$limit_auto_win}}</span>

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
                <center><img id="loading_img" style="display:none;" width="90px" src="{{URL::asset('uploads/categories/loading_img.gif')}}"></center>
                <label>Gift type: </label> <select id='gift_type' style='margin-right:15px;'>
                    <option value='lottery'>Lottery</option>
                    <!-- <option value='gift'>Instant gift</option> -->
                </select>
                <label>Campaign type: </label> <select id='distinct' style='margin-right:15px;'>
                    <option value='multiple'>Multiple codes</option>
                    <option value='single'>Single Code</option>
                </select>
                <label>No. of winners:</label>
                <input type="number" value="0" min="0" max="{{$limit_auto_win}}" name="auto_win" id="auto_win" />
                <input type="hidden" value="{{count($lotteries)}}" id="lotteries_count" />
                <!-- <select id='auto_win' style='margin-right:15px;'>
<option value='0'>--Select--</option>
<option value='2'>2</option>
<option value='50'>50</option>
<option value='100'>100</option>
<option value='500'>500</option>
<option value='1000'>1000</option>
<option value='10000'>10000</option>
<option value='50000'>50000</option>
</select> -->
                <input type="hidden" value="{{$package->id}}" name="package_id" id="package_id" />
                <button style='padding: 4px 10px 4px 10px;margin-bottom: 5px;' class="btn btn-primary" onclick='makeWinnerAuto(this.value)'>Make a winner</button>

                <table id="dataTableBuilder" class="table dataTable no-footer">
                    <thead>

                        <th>#</th>
                        <!-- <th>Action</th> -->
                        <th>User</th>
                        <th>Code Number</th>
                        <!-- <th>Gift Type</th> -->
                        <th>Product</th>
                        <th>QR-Code</th>

                    </thead>
                    <tbody>
                        @foreach($lotteries as $lottery)
                        @if($lottery->win_status == 0)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <!-- <td>
                        @if($lottery->win_status==0)
                        <button class="make-winner-btn" disabled id="btn_{{$lottery->random_number}}" value="{{$lottery->random_number}}"  onclick="makeWinner(this.value)" style="background:#25E86F;color: white;">-</button>
                        <img width="50px" src="" style="display:none;" id="img_{{$lottery->random_number}}">
                        @else
                        <img width="50px" src="{{URL::asset('uploads/categories/winner.png')}}"> 
                         @endif

                    </td>     -->
                            <td>{{$lottery->user->first_name}} {{$lottery->user->sur_name}} - {{$lottery->user->phone}}
                                @if(!is_null($lottery->user->email) && $lottery->user->email != "")
                                - {{$lottery->user->email}}
                                @endif
                            </td>
                            <td>{{$lottery->random_number}}</td>
                            <!-- <td>{{$lottery->win_status ? 'Lottery' : '-'}}</td>    -->
                            <td>{{$lottery->product->title}}</td>
                            <td>
                                @if($lottery->qr_code)
                                <img style="width:67px;" src="{{asset('uploads/qrcodes/lotteries/'.$lottery->qr_code)}}">
                                @else
                                Not Found
                                @endif
                            </td>


                        </tr>
                        @endif
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

            // $('#dataTableBuilder_length label').prepend("");
        });

        function makeWinnerAuto() {
            var max_auto_winners = $('#auto_win').attr('max');
            var max_lotteries = $('#lotteries_count').val();
            if (max_lotteries < max_auto_winners) {
                max_auto_winners = max_lotteries;
            }
            console.log(max_auto_winners);
            var auto_winners = $('#auto_win').val();
            console.log(auto_winners);
            var gift_type = $('#gift_type').val();
            var algo_type = $('#distinct').val();
            if (auto_winners == 0 || auto_winners == '') {
                alert('Please enter number more than 0');
            } else {
                if (parseInt(auto_winners) > parseInt(max_auto_winners)) {
                    if (max_auto_winners == 0) {
                        alert('this package has no more gift bundles');
                    } else {
                        alert('plese enter number less than or equal to ' + max_auto_winners);
                    }
                } else {
                    $('#loading_img').show();
                    $.get("{{url('admin/make/lotteryautowinner')}}", {
                        'auto_winners': auto_winners,
                        'gift_type': gift_type,
                        'algo_type': algo_type,
                        'package_id': $('#package_id').val()
                    }, function(msg, status) {
                        console.log(msg);
                        if (status == 'success') {
                            $('#loading_img').hide();
                            //location.reload();
                        }
                    });
                }
            }

        }

        function makeWinner(random_number) {

            //console.log(random_number)

            $.get("{{url('admin/make/lotterywinner')}}", {
                'random_number': random_number,
                'package_id': $('#package_id').val()
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $('#gift_type').on('change', function() {
            if ($(this).val() == 'gift') {
                $('.make-winner-btn').text('Make winner');
                $('.make-winner-btn').attr('disabled', false);
            } else {
                $('.make-winner-btn').text('-');
                $('.make-winner-btn').attr('disabled', true);
            }
        });
    </script>

    @endsection