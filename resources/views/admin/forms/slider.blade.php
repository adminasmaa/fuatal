@extends('layouts.admin')

@section('content')
    @include('partials.admin.form.init')
    
    <label class="label">Parent</label>
    
    @foreach (['title', 'description'] as $a)
        @include('partials.admin.form.text', ['attribute' => $a])
    @endforeach

     @if($resource=='slider')
       <label class="label">Slider Image</label>
       <img width="70px" src="{{URL::asset('uploads/sliders/'.$slider->image)}}">
     <input type="file" name="image" class="input" style="height: 60px !important;margin-bottom:13px" required>
     <input type="hidden" name="slider_form" value="slider_form">
    @endif

    @include('partials.admin.form.submit')
@endsection
