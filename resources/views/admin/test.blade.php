@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<style>
    img {
/* display: block; */
max-width: 100%;
}
.preview {
overflow: hidden;
width: 150px; 
height: 150px;
margin: 40px;
border: 1px solid red;
}
.modal-lg{
max-width: 1000px !important;
}
    .navbar-dropdown a.navbar-item:focus, .navbar-dropdown a.navbar-item:hover{
    text-decoration: none !important;
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
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Edit Product Detail' }}
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
            @php session()->forget('success');  @endphp
        
    </div>
    @endif
                <div class="card-content" style="padding-bottom: 2rem;">
                    <div class="container-fluid">
       
    <form method="POST" enctype="multipart/form-data" action="{{url('admin/update/product')}}">
         @csrf
          <input type="hidden" name="trans_id" value="{{$dataObj->trans_id}}">
     <input type="hidden" name="lang_name" value="{{$dataObj->lang_name}}">
     <div class="field">
     <label class="label">Backgorund Color for Image (Mobile Application)</label>
     <input type="color" name="color_code" value="{{$dataObj->color_code}}" required />
     </div>
        <div class="field">
    <label class="label">Category</label>
    <div class="control">
            <select class="input" name="parent_id">
                {!!$view!!}
            </select>

    </div>
   
</div>

            <div class="field">
    <label class="label">Product Title*</label>
    <div class="control">
         <input class="input" value="{{$dataObj->title}}" type="text" name="title" required>

    </div>
   
</div>

 <div class="field">
    <label class="label">Product Size*</label>
    <div class="control">
                <input class="input" value="{{$dataObj->product_size}}" type="number" name="product_size" required>

    </div>
   
</div>

  <div class="field">
    <label class="label">SKU*</label>
    <div class="control">
     <input class="input" placeholder="120 ml e.g" value="{{$dataObj->sku}}" type="text" name="sku" required>

    </div>
   
</div>
  
<div class="field">
    <label class="label">Product Price*</label>
    <div class="control">
         <input class="input" value="{{$dataObj->price}}" type="number" name="price" required/>

    </div>
   
</div>


            <div class="field">
    <label class="label">Description*</label>
    <div class="control">
 
 <textarea name="description" class="textarea trumbowyg-textarea" required>{!! $dataObj->description !!}</textarea>

    </div>
   
</div>


<div class="field">
    <label class="label">Nutritional Info. *</label>
    <div class="control">
                

  <textarea id="editor_new" name="nutritional_info" class="textarea ckeditor trumbowyg-textarea">{!! $dataObj->nutritional_info !!}</textarea>

    </div>
   
</div>

<div class="alert alert-success" id="error" style="background: #FF1B2D;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;
    display: none;
    ">
        
     Maximum 5 images are allowed,Please choose images again. 
        
    </div>
<div class="control">

                <label class="label">Product Image(s)</label>
               @php   $images=explode(',',$dataObj->image);        @endphp 

             @foreach($images as $img)
              <img style="border: 1px solid silver;padding: 8px;border-radius: 8px;" width="150px" src="{{URL::asset('uploads/categories/'.$img)}}">
             @endforeach
            
     <!-- <input onchange="checkImages()" type="file" name="image[]" class="input" style="height: 60px !important;margin-bottom:13px" accept="image/*" max-uploads = 6 multiple> -->
     <input id="image_select" type="file" name="image_before" class="inputimage" style="height: 60px !important;margin-bottom:13px" required>
     <input onchange="checkImages()" id="image_original" type="hidden" name="image" class="inputimage" style="height: 60px !important;margin-bottom:13px" accept="image/*" max-uploads = 6 multiple>
     
     <br>
     <label class="label" style="display: inline; margin-bottom: 20px;" for="offer">Offer?</label>
     <input type="checkbox" name="offer" {{$dataObj->offer == 1 ? 'checked' : ''}} value="1" style="margin-bottom: 20px; "/>
     <input type="hidden" name="filename" value="{{$dataObj->image}}">
 </div>
     <input type="hidden" name="id" value="{{$dataObj->id}}">
            
<div class="control">
    <button id="sbmit" type="submit" class="button is-info is-fullwidth is-large">Save</button>
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
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-primary" id="crop">Crop</button>
</div>
</div>
</div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable();});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<script>
    $(document).ready(function(){
        // $('.ckeditor').ckeditor();
    $('#image_select').on('change', function(){
        console.log('here in change function of image');
    });
    //  $('#modal') = $('#modal');
var image = document.getElementById('image');
console.log(image);

var cropper;
var json_array = [];
$("#image_select").on("change", function(e){
var files = e.target.files;
var done = function (url) {
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
reader.onload = function (e) {
done(reader.result);
};
reader.readAsDataURL(file);
}
}
});
$('#modal').on('shown.bs.modal', function () {
cropper = new Cropper(image, {
aspectRatio: 1,
viewMode: 3,
preview: '.preview'
});
}).on('hidden.bs.modal', function () {
cropper.destroy();
cropper = null;
});
$("#crop").click(function(){
canvas = cropper.getCroppedCanvas({
width: 98,
height: 98,
});
canvas.toBlob(function(blob) {
url = URL.createObjectURL(blob);
var reader = new FileReader();
reader.readAsDataURL(blob); 
reader.onloadend = function() {
var base64data = reader.result; 

var prev_value = $('#image_original').val();
console.log(prev_value);
if(prev_value && prev_value !== '')
{
    console.log('here in if');
    // json_array_val = JSON.parse(prev_value);
    // json_array_val[json_array_val.length] = base64data;
    // console.log(json_array_val);
    json_array.push(base64data);
    $('#image_original').val(JSON.stringify(json_array));
}
else{
    console.log('here in else');
    
    json_array.push(base64data);
    $('#image_original').val(JSON.stringify(json_array));
}
// $('#image_original').val(base64data);
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

 function checkImages(){
     var arra = JSON.parse($('#image_original').val());
    //    var $fileUpload = $("input[type='file']");
    //    if(parseInt($fileUpload.get(0).files.length) > 5){
       if(arra > 5){
        $('#error').show(); 
        $('#sbmit').prop( "disabled", true );
                 //alert("You are only allowed to upload a maximum of 5 files");
        }
        else{
        $('#error').hide(); 
        $('#sbmit').prop( "disabled", false );
        }
    
 }

</script>

