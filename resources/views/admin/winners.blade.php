@php
use Carbon\Carbon;
@endphp
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
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <header class="card-header">
                <h3 class="card-header-title">
                    {{ 'Codes of ' . $bundle->name }}
                    @if (isset($link))
                    <a class="navbar-item" href="{{ $link }}">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                    </a>
                    @endif

                </h3>

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



                <table id="dataTableBuilder" class="table dataTable no-footer">
                    <thead>

                        <th>#</th>
                        <th>User</th>
                        <th>Code Number</th>
                        <th>Gift Type</th>
                        <th>Product</th>
                        <th>QR-Code</th>
                        <th>Winning Status</th>
                        <th>Status</th>

                    </thead>
                    <tbody>

                        @foreach($winners as $winner)
                        <tr class="odd">
                            <td class="sorting_1">2</td>
                            <td>
                                @if($winner->user)
                                {{$winner->user->full_name}} - {{$winner->user->phone}}
                                - {{$winner->user->email}}
                                @else
                                Not assigned yet
                                @endif
                            </td>
                            <td>{{$winner->random_number}}</td>
                            <td>{{$winner->type == 'gift' ? 'Instant Gift' : ($winner->type == 'lottery' ? 'Lottery' : '-')}}</td>
                            <td>{{$winner->product->title}}</td>
                            <td>
                                @if($winner->qr_code)
                                <img style="width:67px;" src="{{asset('uploads/qrcodes/lotteries/'.$winner->qr_code)}}">
                            </td>
                            @else
                            Generating. please wait..
                            @endif
                            <td>
                                @if($winner->win_status)
                                <img width="50px" src="{{URL::asset('uploads/categories/winner.png')}}">
                                @else
                                -
                                @endif

                            </td>
                            <td>
                                @if($winner->bundle->package->end_date < Carbon::now()) <label class="badge badge-danger">Expired</label>
                                    @else
                                    <label class="badge badge-success">Active</label>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

@endsection