<!-- <section class="content-header">
    @php $route = Route::currentRouteName() @endphp
    @php $index = substr($route, 0, strrpos($route, '.') + 1) . 'index' @endphp
    <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('root') }}">{{ config('settings.site_title') }}</a></li>
            <li><a href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard.index') }}</a></li>
            @if (strpos($route, 'root') === false && Route::has($index))
                @php $isIndex = strpos($route, 'index') !== false @endphp
                @php $parent_text= __($isIndex ? $route : $index) @endphp
                <li class="{{ $isIndex ? 'is-active' : '' }}">
                    @if($isIndex)
                        <a href="#" aria-current="page">{{ empty($t) ? $parent_text : $t }}</a>
                    @else
                        <a href="{{ route($index) }}">{{ $parent_text }}</a>
                    @endif
                </li>
                @if(!$isIndex)<li class="is-active"><a href="#" aria-current="page">{{ empty($t) ? __($route) : $t }}</a></li>@endif
            @endif
        </ul>
    </nav>
</section> -->
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar" style="top: -1px !important; position:absolute;background: #1e1e2d;">
							<!--begin::Container-->
							<div id="kt_toolbar_container-fluid" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									
									<!--end::Title-->
									<!--begin::Separator-->
									
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
										<!--begin::Item-->
										<!-- <li class="breadcrumb-item text-muted">
                                            <a class="text-muted text-hover-primary" href="{{ route('root') }}">{{ config('settings.site_title') }}</a>
										</li> -->
										<!--end::Item-->
										<!--begin::Item-->
										<!-- <li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li> -->
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item" style="color: white;"><a class="text-muted text-hover-primary" href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard.index') }}</a></li>
										<!--end::Item-->
										<!--begin::Item-->
										
										<!--end::Item-->
										<!--begin::Item-->
                                        @if (strpos($route, 'root') === false && Route::has($index))
                                            @php $isIndex = strpos($route, 'index') !== false @endphp
                                            @php $parent_text= __($isIndex ? $route : $index) @endphp
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-300 w-5px h-2px"></span>
											</li>
                                            <li class="{{ $isIndex ? 'breadcrumb-item is-active' : 'breadcrumb-item' }}">
											<?php 
											
											// if(strpos($parent_text, 'product'))
											// {
											// 	$parent_text = 'Product';
											// } 
											// if(strpos($parent_text, 'slider'))
											// {
											// 	$parent_text = 'Slider';
											// } 
											// if(strpos($parent_text, 'category'))
											// {
											// 	$parent_text = 'Category';
											// }
											// if(strpos($parent_text, 'stick'))
											// {
											// 	$parent_text = 'Category';
											// }
											                                                                  
											?>
                                                @if($isIndex)
                                                    <a href="#" aria-current="page">{{ __(empty($t) ? $parent_text : $t )}}</a>
                                                @else
													
                                                    <a href="{{ route($index) }}">{{ _($parent_text) }}</a>
                                                @endif
                                            </li>
										
											@if(!$isIndex)
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
                                       
										
										<?php 
											if(strpos($route, 'edit'))
											{
												$route = 'Edit';
											} 

										
											if(strpos($route, 'create'))
											{
												$route = 'Create';
											} 
										?>
										<li class="is-active breadcrumb-item text-dark"><a href="#" aria-current="page">{{ empty($t) ? __($route) : $t }}</a></li>@endif
										
                                        @endif
										<!--end::Item-->
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page title-->
								<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
									@include('partials.admin.nav.logout', ['class' => 'is-hidden-tablet'])
									</div>
							</div>
							<!--begin::User menu-->
							
									<!--end::User menu-->
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->