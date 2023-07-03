@extends('layouts.admin')

@section('content')

<style>
    .alert.alert-success a {
        color: black;
        font-weight: bold;
    }
    .form-control[readonly]{
        background-color: lightgray;
    }
</style>
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <header class="card-header">
                <h1 class="py-5"> {{ 'Generate QR Codes' }}</h1>
                <p class="card-header-title">
                    @if (isset($link))
                    <a class="navbar-item" href="{{ $link }}">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg></span>
                    </a>
                    @endif
                </p>
            </header>
            @if(Session::has('success'))
            <div class="alert alert-success" id="success" style="background: limegreen;
    color: white;
    width: 70%;
    padding: 13px;
    text-align: center;
    margin-left: 15%;
    margin-top: 13px;">
                {!! Session::get('success') !!}
                <!-- {{ Session::get('success') }} -->
                @php session()->forget('success'); @endphp

            </div>
            @endif
            @if ($errors->any())
            <div class="">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="alert alert-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">

                    <form method="POST" enctype="multipart/form-data" action="{{url('admin/save/randomnumbers')}}">
                        @csrf
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Is it telecommunication code?</label>
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" value="0" checked type="radio" name="telecom" />
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check" style="margin-left: 20px;">
                                        <input class="form-check-input" value="1" type="radio" name="telecom" />
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Select No. of digits in code</label>
                                <input readonly value="6" type="number" min="1" max="30" name="total_digits" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Minimum No. of Alphabets</label>
                                <input readonly value="2" type="number" min="0" max="30" name="alphabets" class="form-control" />
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Minimum No. of Numerics</label>
                                <input readonly value="2" type="number" min="0" max="30" name="numbers" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Product</label>

                                <select data-control="select2" data-placeholder="Select Product..." class="form-select" name="product" required>
                                    <option value="" selected="selected">---Select Product---</option>
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Limit of QR Codes</label>
                                <input readonly value="100000"  placeholder="Enter number eg. 100" class="form-control" min="1" type="number" name="counter_lottery" required>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6" style="margin: 0 auto;">
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5 text-center">
                            <span style="color: red; font-weight: bold;">Please be patient! This may take few minutes for large number of Codes</span>
                        </div>
                        <!-- </div> -->


                </div>
                </form>
                <br>
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
    });
</script>

@endsection
<script type="text/javascript">
    function deleteRecord(id) {
        if (confirm('Are you sure?')) {
            var url = "{{url('admin/delete/cities')}}";
            //alert(url);
            $.get(url, {
                id: id
            }, function(arg) {
                location.reload();
                // body...
            });
        }
    }
</script>