@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ __(Route::getCurrentRoute()->getName()) }}
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif
                    </p>
                </header>
                <div class="card-content" style="padding-bottom: 2rem;">
            	<table id="dataTableBuilder" class="table dataTable no-footer">
            	<thead>
            		<th>Image</th>
            		<th>Category</th>
            		<th>Description</th>
            		
            	</thead>
            	<tbody>
            		@php $item=$object  @endphp
            		
            		<tr>
            		<td>
            			@if(is_null($item->cat_image))
            			<img width="70px" src="{{URL::asset('uploads/categories/')}}">
            			@else
            			<img width="70px" src="{{URL::asset('uploads/categories/'.$item->cat_image)}}">
            			@endif
            		</td>
            		<td>{{$item->title}}</td>	
            		<td>{{$item->description}}</td>	
            		</tr>
            		
            	</tbody>	
            	</table>
               
            </div>  
            </div>
        </div>
    </section>
@endsection

@section('scripts')
  
@endsection
