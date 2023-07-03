@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <!-- <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Edit Slider' }}
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
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">
                    <h1 class="py-5"> {{ 'Edit Slider' }}</h1>
                    <form method="POST" enctype="multipart/form-data" action="{{url('admin/update/slider')}}">
                        @csrf

                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">

                            <!-- <label class="required fs-5 fw-bold mb-2">Slider Image</label><br> -->
                            <img style="background: lightgray;padding: 12px;border-radius: 10px;" width="170px" src="{{URL::asset('uploads/sliders/'.$dataObj->image)}}">
                            
                            </div>
                            
                        </div>
                        <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                        <label class="required fs-5 fw-bold mb-2">Slider Image</label>
                            <!-- <input type="file" name="image" class="input" style="height: 60px !important;margin-bottom:13px"> -->
                            <input id="image_select" type="file" name="image_before" class="form-control" required>
                            <input id="image_original" type="hidden" name="image" class="form-control" style="height: 46px !important;margin-bottom:13px">
                            <input type="hidden" name="filename" value="{{$dataObj->image}}">
                            <span class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">( 626px x 367px )</span>
                        </div>
                        </div>
                        <div class="row">
                        <input type="hidden" name="id" value="{{$dataObj->id}}">

                        <div class="col-md-6 fv-row">

                            <button type="submit" class="button btn btn-primary w-100">Save</button>
                        </div>
                        </div>
                    </form>
                    <br>
                </div>



            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop Image Before Upload</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<script>
    $(document).ready(function() {
        $('#image_select').on('change', function() {
            console.log('here in change function of image');
        });
        //  $('#modal') = $('#modal');
        var image = document.getElementById('image');
        console.log(image);

        var cropper;
        $("#image_select").on("change", function(e) {
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                $('#modal').modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $('#modal').on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 626 / 367,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 626,
                height: 367,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $('#image_original').val(base64data);
                    $('#modal').modal('hide');
                    // $.ajax({
                    // type: "POST",
                    // dataType: "json",
                    // url: "/admin/test/category",
                    // data: {'_token': $('input[name="_token"]').val(), 'image': base64data},
                    // success: function(data){
                    // $('#modal').modal('hide');
                    // alert("Crop image successfully uploaded");
                    // }
                    // });
                }
            });
        })
    });
</script>
@endsection
<script type="text/javascript">
    function deleteRecord(id) {
        if (confirm('Are you sure?')) {
            var url = "{{url('admin/delete/slider')}}";
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