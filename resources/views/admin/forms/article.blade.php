@extends('layouts.admin')

@section('content')
    @include('partials.admin.form.init')
    <div class="field">
<label class="label">Category*</label>
    <div class="control">
        <div class="select is-medium is-fullwidth">
            <select name="category_id" required="required">
                @if($myroute=='edit')
                {!!$view !!}
                @else
                {!!$catView !!}
                @endif

                            </select>
        </div>
    </div> 
</div>
  <input type="hidden" name="published_at" value="{{date('d-m-Y')}}">
     <div class="field" style="display:none;">
<label class="label">Date</label>
  <div class="control">
   
                <!-- <input class="inputdatepicker flatpickr-input"  type="text" name="published_at" readonly="readonly">-->
    </div> 
</div>


    @foreach (['title', 'description'] as $a)
        @include('partials.admin.form.text', ['attribute' => $a])
    @endforeach
    @include('partials.admin.form.textarea', ['attribute' => 'content'])
    


<div class="field">
    <label class="label">Image</label>
    @if($myroute=='edit')
  <img style="border: 1px solid silver;padding: 8px;border-radius: 8px;" width="150px" src="{{URL::asset('uploads/categories/'.$article->article_image)}}">

<input type="hidden" name="filename" value="{{$article->article_image}}">

    @endif
    <div class="control">

     <input class="input" type="file" name="recipe_image">

<input type="hidden" name="recipe_form" value="recipe_form">
    </div>
   <br>
</div>
    @include('partials.admin.form.submit')
@endsection
