@extends('layouts.admin')
@section('content')

<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <!-- <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Gift Package' }} 
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif
                       
                    </p>
                </header> -->
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
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">
                    <h5 class="py-5">Edit Gift Package Detail</h5>
                    <form method="POST" enctype="multipart/form-data" action="{{url('/admin/update/package')}}">
                        <!-- <form method="POST" enctype="multipart/form-data" action="{{route('admin.category.store')}}"> -->
                        @csrf
                        <input type="hidden" name="id" value="{{$package->id}}" />

                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Package Name</label>

                                <input class="form-control" value="{{$package->name}}" type="text" name="name" required="required">

                            </div>

                        </div>
                        <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Start Date</label>

                                <input class="form-control" pattern="dd-mm-YYYY" value="{{date('Y-m-d', strtotime($package->start_date))}}" data-provide="datepicker" type="date" name="start_date" required="required">

                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">End Date</label>

                                <input class="form-control" pattern="dd-mm-YYYY" value="{{date('Y-m-d', strtotime($package->end_date))}}" data-provide="datepicker" type="date" name="end_date" required="required">

                            </div>

                        </div>


                        <div class="row">
                            <input type="hidden" name="category_form" value="subcategory_form">
                            <div class="col-md-6 fv-row">
                                <button type="submit" class="w-100 button btn btn-primary">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
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
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.datepicker').datetimepicker();
    })
</script>