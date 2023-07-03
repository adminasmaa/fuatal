@extends('layouts.admin')

@section('content')
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <header class="card-header">
                <p class="card-header-title">
                    {{ 'Instant Gifts (Assign Winners)' }}
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




                <table id="dataTableBuilder" class="table dataTable no-footer">
                    <thead>

                        <th>#</th>
                        <th>Action</th>
                        <th>User</th>
                        <th>Gift Number</th>
                        <th>QR-Code</th>


                    </thead>
                    <tbody>
                        @foreach($userObj as $user)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                @if($user->win_status==0)
                                <button id="btn_{{$user->random_number}}" value="{{$user->random_number}}" onclick="makeWinner(this.value)" style="background:#25E86F;color: white;">Make Winner</button>
                                <img width="50px" src="" style="display:none;" id="img_{{$user->random_number}}">
                                @else
                                <img width="50px" src="{{URL::asset('uploads/categories/winner.png')}}">
                                @endif

                            </td>
                            <td>{{$user->first_name}} {{$user->sur_name}} - {{$user->phone}}
                                @if(!is_null($user->email) && $user->email != "")
                                - {{$user->email}}
                                @endif
                            </td>
                            <td>{{$user->random_number}}</td>
                            <td>
                                @if($user->qr_code)
                                <img style="width:67px;" src="{{asset('uploads/qrcodes/gifts/'.$user->qr_code)}}">
                                @else
                                Not Found
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
    });

    function makeWinner(random_number) {


        $.get("{{url('admin/make/giftwinner')}}", {
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