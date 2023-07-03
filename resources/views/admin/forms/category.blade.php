@extends('layouts.admin')

@section('content')
    @include('partials.admin.form.init')
    
    <label class="label">Parent</label>
    
    <select class="input" name="parent_id">
        <option value="0" selected="selected">--Select--</option>

        @foreach($catObj as $cat)
<option value="{{$cat->id}}" {{$category->id == $cat->id ? 'selected':''}}>{{$cat->title}}</option>
        @endforeach

    </select>
    @foreach (['title', 'description'] as $a)
        @include('partials.admin.form.text', ['attribute' => $a])
    @endforeach

     @if($resource=='category')
       <label class="label">Category Image</label>
       <img width="70px" src="{{URL::asset('uploads/categories/'.$category->cat_image)}}">
     <input type="file" name="cat_image" class="input" style="height: 60px !important;margin-bottom:13px" required>
     <input type="hidden" name="category_form" value="category_form">
    @endif

    @include('partials.admin.form.submit')
@endsection
