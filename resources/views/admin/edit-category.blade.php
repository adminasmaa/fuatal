@extends('layouts.admin')

@section('content')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <!-- <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Edit Category' }}
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
                <h1 class="py-5">Edit Category Detail</h1>
                    <form method="POST" enctype="multipart/form-data" action="{{url('admin/update/cat')}}">
                        @csrf
                        <div class="row mb-5">
                            <div class="col-md-6 mb-5 fv-row">
                                <label class="fs-5 fw-bold mb-2">Backgorund Color for Image (Mobile Application)</label>
                                <input type="color" name="color_code" value="{{$dataObj->color_code ? $dataObj->color_code : '#ffffff'}}" required />
                            </div>
                            <div class="col-md-6 mb-5">
                            <div style="max-width: 200px;padding: 24px;background: {{$dataObj->color_code}};border-radius: 10px;" class="image-section">
                                    <img width="150px" src="{{URL::asset('uploads/categories/'.$dataObj->cat_image)}}">
                                </div>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">Parent</label>
                                    <select data-control="select2" data-placeholder="Select category..." class="form-select" name="parent_id">
                                        {!!$view!!}

                                    </select>      
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">Image</label>

                                <input id="image_select" type="file" name="cat_image_before" class="form-control">
                                <input id="image_original" type="hidden" name="cat_image" class="input image" style="height: 46px !important;">

                                <input type="hidden" name="filename" value="{{$dataObj->cat_image}}">
                                <span>360px x 360px</span>
                            </div>
                            
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">Category Title</label>
                                 <input class="form-control" value="{{$dataObj->title}}" type="text" name="title" required>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">Arabic Title</label>
                                <input class="form-control" value="{{$dataObj->title_ar}}" type="text" name="title_ar" required>
                            </div>
                        </div>
                        <div class="field" style="display:none;">
                            <label class="label">Description</label>
                            <div class="control">
                                <input class="input" value="{{$dataObj->description}}" type="text" name="description">
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{$dataObj->id}}">
                        <input type="hidden" name="trans_id" value="{{$dataObj->trans_id}}">
                        <input type="hidden" name="lang_name" value="{{$dataObj->lang_name}}">
                        <div class="row mb-5">
                            <div class="col-md-12">
                                <div class="control">
                                    <button type="submit" class="w-100 button btn btn-primary">Save</button>
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
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 360,
                height: 360,
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
            var url = "{{url('admin/delete/cat')}}";
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