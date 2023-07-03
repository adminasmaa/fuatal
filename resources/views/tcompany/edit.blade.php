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
                    <h5 class="py-5">Update Tel Company Detail</h5>
                    <form method="POST" enctype="multipart/form-data" action="{{url('/admin/update/tcompany/'.$tcompany->id)}}">
                        @csrf
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">Company Logo</label>

                                <input class="form-control" value="" type="file" name="logo">

                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Company Prefix</label>

                                <input class="form-control" value="{{$tcompany->prefix}}" type="text" name="prefix" required="required">

                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Company Name</label>

                                <input class="form-control" value="{{$tcompany->name}}" type="text" name="name" required="required">

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="control">

                                    <button type="submit" class="w-100 btn btn-primary">Save</button>
                                </div>
                            </div>
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
        window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>