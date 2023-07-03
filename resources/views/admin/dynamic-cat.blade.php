<?php
use App\Models\Category;
?>
@php categoryTree(); @endphp

@php
function categoryTree($parent_id = 0, $sub_mark = ''){
$catObj1=DB::table('categories')->where('parent_id',$parent_id)->where('lang_name', 'English')->orderBy('trans_id','desc')->get();
$color_count = 0;
foreach($catObj1 as $item){  

    $count = Category::where('trans_id', $item->trans_id)->count();
    
@endphp
												<!--begin::Table row-->
												<tr>
													<!--end::Checkbox-->
													<!--begin::User=-->
													<td class="d-flex align-items-center">
														<!--begin:: Avatar -->
														@if(is_null($item->cat_image))
														<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
            													<img width="70px" src="{{URL::asset('uploads/categories/')}}">
														</div>
            											@else
														<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
															<a href="{{URL::asset('uploads/categories/'.$item->cat_image)}}" data-lightbox="myImg150" data-title="t15">
																<div class="symbol-label">
																	<img src="{{URL::asset('uploads/categories/'.$item->cat_image)}}"  alt="category" class="w-100" data-lightbox="myImg150"/>
																</div>
															</a>
														</div>
														@endif
														
													</td>
													<td>{{$sub_mark}}{{$item->title}}</td>
            										<td>{{$sub_mark}}{{$item->title_ar}}</td>
                   
													<!--begin::Joined-->
													<!--begin::Action=-->
													<td class="text-end">
														<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon svg-icon-5 m-0">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon--></a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
															<!--begin::Menu item-->
															@if($item->lang_name=='English')
															<div class="menu-item px-3">
																<a href="{{url('admin/category/'.$item->id.'/edit')}}" class="menu-link px-3">Edit</a>
															</div>
															@endif
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" onclick="deleteRecord({{$item->id}})" data-kt-users-table-filter="delete_row">Delete</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu-->
													</td>
													<!--end::Action=-->
												</tr>
											
    @php 

    categoryTree($item->id, $sub_mark.'--'); 

} 
}

     @endphp