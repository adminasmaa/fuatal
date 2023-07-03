@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
<style>
    #galleryImages, #cropper{
  width: 100%;
  float: left;
}
canvas{
  max-width: 100%;
  display: inline-block;
}
#cropperImg{
  /*max-width: 0;
  max-height: 0;*/
}
#cropImageBtn{
  display: none;
}
img{
  /* width: 100%; */
}
.img-preview{
  float: left;
}
.singleImageCanvasContainer{
  max-width: 300px;
  display: inline-block;
  position: relative;
  margin: 2px;
}
.singleImageCanvasCloseBtn{
  position: absolute;
  top: 5px;
  right: 5px;
}
.navbar.is-dark .navbar-brand > a.navbar-item:focus, .navbar.is-dark .navbar-brand > a.navbar-item:hover, .navbar.is-dark .navbar-brand > a.navbar-item.is-active, .navbar.is-dark .navbar-brand .navbar-link:focus, .navbar.is-dark .navbar-brand .navbar-link:hover, .navbar.is-dark .navbar-brand .navbar-link.is-active{
    text-decoration: none !important;
}
.card{
    display: block !important;
}
.breadcrumb{
    background-color: transparent !important;
    padding: 0 !important;
}
.card-header{
    padding: 0 !important;
    background-color: transparent !important;
    display: block !important;
    border-bottom: unset !important;
}
.card-footer:first-child, .card-content:first-child, .card-header:first-child{
    border-top-left-radius: 0.25rem !important;
    border-top-right-radius: 0.25rem !important;
}
a:hover{
    text-decoration: none !important;
}
.navbar{
    padding: 0 !important;
}
.navbar-brand{
    font-size: unset !important;
    display: flex !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-right: 0 !important;
}
.navbar > .container{
    align-items: stretch !important;
}
</style>
<section class="section">
    <div class="container-fluid">
        <div class="card no-box-shadow-mobile">
            <!-- <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Edit Product Detail' }}
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif
                    </p>
                </header> -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
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
            @if(Session::has('error'))
            <div class="alert alert-danger" id="error" style="background: red;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;">

                {{ Session::get('error') }}
                @php session()->forget('error'); @endphp

            </div>
            @endif
            <div class="card-content" style="padding-bottom: 2rem;">
                <div class="container-fluid">
                    <h1 class="py-5"> {{ 'Edit Product Detail' }}</h1>
                    <form method="POST" enctype="multipart/form-data" action="{{url('admin/update/product')}}">
                        @csrf
                        <input type="hidden" name="trans_id" value="{{$dataObj->trans_id}}">
                        <input type="hidden" name="lang_name" value="{{$dataObj->lang_name}}">
                        <div class="row mb-5">
                        <label class="fs-5 fw-bold mb-2">Product Image(s)</label>
                            @php $images=explode(',',$dataObj->image); @endphp
                            <div class="row">
                                @foreach($images as $img)
                                    <div class="col-md-2">
                                        <img style="border: 1px solid silver;padding: 8px;width:100%;border-radius: 8px;" width="150px" src="{{URL::asset('uploads/categories/'.$img)}}">
                                        <a style="font-size: 12px; padding: 5px 10px;" class="btn btn-danger" href="/admin/delete-image/{{$dataObj->id}}/{{$img}}">Delete</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <div class="field">
                                    <input id="imageCropFileInput" onchange="checkImages()" type="file" name="image_before[]" class="form-control" max-uploads=6 multiple accept="image/*">
                                    <input id="profile_img_data" type="hidden" name="image" class="input image" style="height: 46px !important;">
                                    <input type="hidden" id="post_img_data" name="image_data_url">
                                    <span>360px x 360px</span>
                                </div>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="label">Backgorund Color for Image (Mobile Application)</label>
                                <input type="color" name="color_code" value="{{$dataObj->color_code}}" required />
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">Video link</label>
                                <textarea rows="1" name="video" class="form-control">{{$dataObj->video}}</textarea>

                            </div>
                            <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">Category</label>
                            
                                <select data-control="select2" data-placeholder="Select category..." class="form-select" name="parent_id">
                                    {!!$view!!}
                                </select>

                            </div>
                        </div>
                    <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">Product Title</label>
                            
                            <input class="form-control" value="{{$dataObj->title}}" type="text" name="title" required>

                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">Product Title Arabic</label>
                            <input class="form-control" value="{{$dataObj->title_ar}}" type="text" name="title_ar" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">Product Size</label>
                            <input min="1" class="form-control" value="{{$dataObj->product_size}}" type="number" name="product_size" required>
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="required fs-5 fw-bold mb-2">SKU</label>
                            <input class="form-control" placeholder="120 ml e.g" value="{{$dataObj->sku}}" type="text" name="sku"> 

                        </div>
                    </div>
                    <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Description</label>

                                <textarea id="editor_new" class="ckeditor textarea trumbowyg-textarea" name="description">{!! $dataObj->description !!}</textarea>
                                <!-- <textarea  name="description" class="textarea trumbowyg-textarea" rows="10" tabindex="-1" style="height: 333.313px;" required="required"></textarea> -->
                                <!--  <input class="input" value="" type="text" name="description"> -->
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Nutritional Info.</label>
                                <textarea id="editor_new" class="ckeditor textarea trumbowyg-textarea" name="nutritional_info">{!! $dataObj->nutritional_info !!}</textarea>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">Description Arabic</label>

                                <textarea dir="rtl" id="description" name="description_ar" class="textarea trumbowyg-textarea">{!! $dataObj->description_ar !!}</textarea>

                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-bold mb-2">Nutritional Info. Arabic</label>

                                <textarea dir="rtl" id="editor_new_nutrition" name="nutritional_info_ar" class="textarea trumbowyg-textarea">{!! $dataObj->nutritional_info_ar !!}</textarea>



                            </div>
                        </div>
                      

                        <div class="alert alert-success" id="error" style="background: #FF1B2D;color: white;width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;
    display: none;
    ">

                            Maximum 5 images are allowed,Please choose images again.

                        </div>
                        <!-- <label class="label" style="display: inline; margin-bottom: 20px;" for="offer">Offer?</label> -->
                        <!-- <input type="checkbox" name="offer" {{$dataObj->offer == 1 ? 'checked' : ''}} value="1" style="margin-bottom: 20px; "/> -->
                        <input type="hidden" name="filename" value="{{$dataObj->image}}">
                        <input type="hidden" name="id" value="{{$dataObj->id}}">
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Product Price</label>
                                <input min="1" class="form-control" value="{{$dataObj->price}}" type="number" name="price" required />
                            </div>
                            <div class="col-md-6">
                                <div class="control">
                                    <button id="sbmit" type="submit" class="button btn btn-primary w-100" style="margin-top:35px;">Save</button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>



            </div>
        </div>
    </div>

    <div class="modal" id="cropperModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select to crop each image</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body p-4">
                    <div class="img-preview"></div>
                    <div id="galleryImages"></div>
                    <div id="cropper">
                        <canvas id="cropperImg" width="0" height="0"></canvas>
                        <button type="button" class="cropImageBtn btn btn-danger" style="display:none;" id="cropImageBtn">Crop</button>
                    </div>
                    <div id="imageValidate" class="text-danger"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
                    <!-- <button type="submit" class="btn btn-primary">Upload</button> -->
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
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<script src="{{asset('dist/ckeditor/jquery.min.js')}}"></script>
<script src="{{ asset('dist/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('dist/ckeditor/ar.js') }}"></script>
<script>
    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#editor_new_nutrition'), {
                language: {
                    ui: 'ar',
                    content: 'ar'
                }
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
        ClassicEditor
            .create(document.querySelector('#description'), {
                language: {
                    ui: 'ar',
                    content: 'ar'
                }
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
        $("body").on("change", "#imageCropFileInput", function(e) {
            $('.singleImageCanvasContainer').remove();
            $('#post_img_data').val('');
        });
    })
</script>
<script>
    //Multiple image cropper and preview on creating post
    var c;
    var galleryImagesContainer = document.getElementById('galleryImages');
    var imageCropFileInput = document.getElementById('imageCropFileInput');
    var cropperImageInitCanvas = document.getElementById('cropperImg');
    var cropImageButton = document.getElementById('cropImageBtn');
    // Crop Function On change
    function imagesPreview(input) {
        var cropper;
        //cropImageButton.className = 'show';
        var img = [];
        if (input.files.length) {
            var i = 0;
            var index = 0;
            for (let singleFile of input.files) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var blobUrl = event.target.result;
                    img.push(new Image());
                    img[i].onload = function(e) {
                        // Canvas Container
                        var singleCanvasImageContainer = document.createElement('div');
                        singleCanvasImageContainer.id = 'singleImageCanvasContainer' + index;
                        singleCanvasImageContainer.className = 'singleImageCanvasContainer';
                        // Canvas Close Btn
                        var singleCanvasImageCloseBtn = document.createElement('button');
                        var singleCanvasImageCloseBtnText = document.createTextNode('X');
                        // var singleCanvasImageCloseBtnText = document.createElement('i');
                        // singleCanvasImageCloseBtnText.className = 'fa fa-times';
                        singleCanvasImageCloseBtn.id = 'singleImageCanvasCloseBtn' + index;
                        singleCanvasImageCloseBtn.className = 'singleImageCanvasCloseBtn';
                        singleCanvasImageCloseBtn.classList.add("btn", "btn-sm");
                        singleCanvasImageCloseBtn.onclick = function() {
                            removeSingleCanvas(this)
                        };
                        singleCanvasImageCloseBtn.appendChild(singleCanvasImageCloseBtnText);
                        singleCanvasImageContainer.appendChild(singleCanvasImageCloseBtn);
                        // Image Canvas
                        var canvas = document.createElement('canvas');
                        canvas.id = 'imageCanvas' + index;
                        canvas.className = 'imageCanvas singleImageCanvas';
                        canvas.width = e.currentTarget.width;
                        canvas.height = e.currentTarget.height;
                        canvas.onclick = function() {
                            cropInit(canvas.id);
                        };
                        singleCanvasImageContainer.appendChild(canvas)
                        // Canvas Context
                        var ctx = canvas.getContext('2d');
                        ctx.drawImage(e.currentTarget, 0, 0);
                        // galleryImagesContainer.append(canvas);
                        galleryImagesContainer.appendChild(singleCanvasImageContainer);
                        // while (document.querySelectorAll('.singleImageCanvas').length == input.files.length) {
                        //     var allCanvasImages = document.querySelectorAll('.singleImageCanvas')[0].getAttribute('id');
                        //     console.log(allCanvasImages);
                        //     //commented by sam
                        //     //cropInit(allCanvasImages);
                        //     break;
                        // };
                        urlConversion();
                        index++;
                    };
                    img[i].src = blobUrl;
                    i++;
                }
                reader.readAsDataURL(singleFile);
            }
        }
    }

    imageCropFileInput.addEventListener("change", function(event) {

        $('#cropperModal').modal('show');
        var mediaValidation = validatePostMedia(event.target.files);
        if (!mediaValidation) {
            var $el = $('#file');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            return false;
        }

        $('#mediaPreview').empty();
        $('.singleImageCanvasContainer').remove();
        if (cropperImageInitCanvas.cropper) {
            cropperImageInitCanvas.cropper.destroy();
            cropperImageInitCanvas.width = 0;
            cropperImageInitCanvas.height = 0;
            cropImageButton.style.display = 'none';
        }
        imagesPreview(event.target);
    });
    // Initialize Cropper
    function cropInit(selector) {
        c = document.getElementById(selector);

        if (cropperImageInitCanvas.cropper) {
            cropperImageInitCanvas.cropper.destroy();
        }
        var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
        for (let element of allCloseButtons) {
            element.style.display = 'block';
        }
        c.previousSibling.style.display = 'none';
        // c.id = croppedImg;
        var ctx = c.getContext('2d');
        var imgData = ctx.getImageData(0, 0, c.width, c.height);
        var image = cropperImageInitCanvas;
        image.width = c.width;
        image.height = c.height;
        var ctx = image.getContext('2d');
        ctx.putImageData(imgData, 0, 0);

        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            format: "png",
            preview: '.img-preview',
            crop: function(event) {
                cropImageButton.style.display = 'block';
            }
        });

    }

    function image_crop() {
        if (cropperImageInitCanvas.cropper) {
            var cropcanvas = cropperImageInitCanvas.cropper.getCroppedCanvas({
                width: 360,
                height: 360
            });
            // document.getElementById('cropImages').appendChild(cropcanvas);
            var ctx = cropcanvas.getContext('2d');
            var imgData = ctx.getImageData(0, 0, cropcanvas.width, cropcanvas.height);
            // var image = document.getElementById(c);
            c.width = cropcanvas.width;
            c.height = cropcanvas.height;
            var ctx = c.getContext('2d');
            ctx.putImageData(imgData, 0, 0);
            cropperImageInitCanvas.cropper.destroy();
            cropperImageInitCanvas.width = 0;
            cropperImageInitCanvas.height = 0;
            cropImageButton.style.display = 'none';
            var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
            for (let element of allCloseButtons) {
                element.style.display = 'block';
            }
            urlConversion();
        } else {
            alert('Please select any Image you want to crop');
        }
    }
    cropImageButton.addEventListener("click", function() {
        image_crop();
    });
    // Image Close/Remove
    function removeSingleCanvas(selector) {
        selector.parentNode.remove();
        urlConversion();
    }

    function urlConversion() {
        var allImageCanvas = document.querySelectorAll('.singleImageCanvas');
        var convertedUrl = '';
        canvasLength = allImageCanvas.length;
        for (let element of allImageCanvas) {
            convertedUrl += element.toDataURL('image/png');
            convertedUrl += 'img_url';
        }
        document.getElementById('post_img_data').value = convertedUrl;
    }

    function validatePostMedia(files) {

        $('#imageValidate').empty();
        let err = 0;
        let ResponseTxt = '';
        if (files.length > 5) {
            err += 1;
            ResponseTxt += '<p> You can select maximum 5 files. </p>';
        }
        // $(files).each(function(index, file) {
        //     if(file.size > 1048576){
        //         err +=  1;
        //         ResponseTxt += 'File : '+file.name + ' is greater than 1MB';
        //     }
        // });

        if (err > 0) {
            $('#imageValidate').html(ResponseTxt);
            return false;
        }
        return true;

    }
</script>
@endsection
<script type="text/javascript">
    function checkImages() {
        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length) > 5) {
            $('#error').show();
            $('#sbmit').prop("disabled", true);
            //alert("You are only allowed to upload a maximum of 5 files");
        } else {
            $('#error').hide();
            $('#sbmit').prop("disabled", false);
        }

    }
</script>