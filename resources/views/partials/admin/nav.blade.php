<style>
	/* .aside-menu, .aside.aside-dark .aside-logo {
		background: #f6f8fa !important;
	} */
</style>
<!--begin::Aside-->
<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
	<!--begin::Brand-->
	<div class="aside-logo flex-column-auto" id="kt_aside_logo">
		<!--begin::Logo-->
		<a class="menu-link" href="{{ route('root') }}">
			<!-- <span  class="menu-dots">{!! icon('home') !!}</span> -->
			<!-- <span  class="menu-dots"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></span> -->
			<span><b>{{ 'Fusteka Ice-Cream App' }}</b></span>
		</a>
		<!--end::Logo-->
		<!--begin::Aside toggler-->
		<!-- <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize"> -->
		<!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
		<!-- <span class="svg-icon svg-icon-1 rotate-180">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black" />
									<path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black" />
								</svg>
							</span> -->
		<!--end::Svg Icon-->
		<!-- </div> -->
		<!--end::Aside toggler-->
	</div>
	<?php $name = \Request::route()->getName();
	//echo $name;
	?>
	<!--end::Brand-->
	<!--begin::Aside menu-->
	<div class="aside-menu flex-column-fluid">
		<!--begin::Aside Menu-->
		<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
			<!--begin::Menu-->
			<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
				@if(Auth::user()->hasPermission(['view_company', 'view_credit_number']))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'tcompany') !== false || strpos($name, 'numbers') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
							<span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
									<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
									<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
									<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Tel. Companies</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item ">
							@if(Auth::user()->hasPermission('view_company'))
							<a <?= ((strpos($name, 'tcompany.index') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('/admin/tcompany/index')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Companies Listing</span>
							</a>
							@endif
							@if(Auth::user()->hasPermission('view_credit_number'))
							<a <?= ((strpos($name, 'allnumbers.listing') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('/admin/all-credit-numbers')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">All Credit Numbers</span>
							</a>
							@endif
						</div>
					</div>
				</div>
				@endif
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'slider') !== false || strpos($name, 'sliders') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
							<span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
									<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
									<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
									<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Sliders</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item ">
							@if(Auth::user()->hasPermission('add_slider'))
							<a <?= ((strpos($name, 'slider.index') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/slider')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Create Slider</span>
							</a>
							@endif
							<a <?= ((strpos($name, 'all.sliders') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/listing/sliders')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Listing</span>
							</a>
						</div>
					</div>
				</div>
				@if(Auth::user()->hasPermission('view_category'))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'category') !== false || strpos($name, 'categories') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<span class="svg-icon svg-icon-2">
								<i class="fa fa-th-list" aria-hidden="true"></i>

							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Categories</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							@if(Auth::user()->hasPermission('add_category'))
							<a <?= ((strpos($name, 'category.index') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/category')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Create Category</span>
							</a>
							@endif
							<a <?= ((strpos($name, 'all.categories') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/listing/categories')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Listing</span>
							</a>

						</div>
					</div>
				</div>
				@endif
				@if(Auth::user()->hasPermission('view_product'))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'product') !== false || strpos($name, 'products') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<span class="svg-icon svg-icon-2">
								<i class="fa fa-product-hunt" aria-hidden="true"></i>
							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Products</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							@if(Auth::user()->hasPermission('add_product'))
							<a <?= ((strpos($name, 'product.index') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/product')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Create Product</span>
							</a>
							@endif
							<a <?= ((strpos($name, 'listing.products') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/listing/products/')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Listing</span>
							</a>
						</div>
					</div>
				</div>
				@endif

				@if(Auth::user()->hasPermission('view_stick'))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'stick') !== false || strpos($name, 'sticks') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<span class="svg-icon svg-icon-2">
								<i class="fa fa-sticky-note" aria-hidden="true"></i>
							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Sticks</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							@if(Auth::user()->hasPermission('add_product'))
							<a <?= ((strpos($name, 'sticks.create') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/sticks/create')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Create Sticks Range</span>
							</a>
							@endif
							<a <?= ((strpos($name, 'sticks.listings') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/sticks/listing')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Listing</span>
							</a>
						</div>
					</div>
				</div>
				@endif
				@if(Auth::user()->hasPermission(['view_gift_campaign', 'view_mekano_campaign', 'generate_gift_codes']))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'lottery.listings') !== false || strpos($name, 'batches.listing') !== false || strpos($name, 'telecom.listings') !== false || strpos($name, 'instant') !== false || strpos($name, 'lotteryrandom.numbers') !== false)  ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<span class="svg-icon svg-icon-2">
								<i class="fa fa-adn" aria-hidden="true"></i>

							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">QR Codes</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							@if(Auth::user()->hasPermission('generate_codes'))
							<a <?= ((strpos($name, 'lotteryrandom.numbers') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/lotteryrandom/numbers')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Generate QR Codes</span>
							</a>
							@endif
							@if(Auth::user()->hasPermission('view_gift_campaign'))
							<a <?= ((strpos($name, 'lottery.listings') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/lottery/listing')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Lottery QR Codes</span>
							</a>
							<a <?= ((strpos($name, 'instant.listings') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/instant/listing')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Gift QR Codes</span>
							</a>
							<a <?= ((strpos($name, 'telecom.listings') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/telecom/listing')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Telecom QR Codes</span>
							</a>
							<a <?= ((strpos($name, 'batches.listing') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/print-text-batches')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Print Text Batches</span>
							</a>
							@endif
						</div>
					</div>
				</div>
				@endif
				@if(Auth::user()->hasPermission(['view_package', 'view_bundle']))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'packages') !== false || strpos($name, 'package') !== false || strpos($name, 'bundle') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z" fill="black" />
									<path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z" fill="black" />
									<path opacity="0.3" d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z" fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Gift packages</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							@if(Auth::user()->hasPermission('make_gift_winner'))
							<a <?= ((strpos($name, 'packages.index') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/packages')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Listing/Make Lottery Winner</span>
							</a>
							@endif
							@if(Auth::user()->hasPermission('view_bundle'))

							<a <?= ((strpos($name, 'bundles.index') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/bundles')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">All Bundles</span>
							</a>
							@endif
						</div>
					</div>
				</div>
				@endif



				@if(Auth::user()->hasPermission(['view_gift_campaign', 'view_mekano_campaign']))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'lottery.winners') !== false || strpos($name, 'winners.settings') !== false || strpos($name, 'participants.report') !== false || strpos($name, 'gift.winners') !== false || strpos($name, 'mekano.listing') !== false)  ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<span class="svg-icon svg-icon-2">
								<i class="fa fa-adn" aria-hidden="true"></i>

							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Winners</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							@if(Auth::user()->hasPermission('view_gift_campaign'))
							<a <?= ((strpos($name, 'lottery.winners') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/lottery-winners')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Lottery Winners</span>
							</a>
							@endif
							@if(Auth::user()->hasPermission('view_gift_campaign'))
							<a <?= ((strpos($name, 'gift.winners') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/gift-winners')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Gift Winners</span>
							</a>
							@endif
							@if(Auth::user()->hasPermission('view_mekano_campaign'))
							<a <?= ((strpos($name, 'mekano.listing') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/mekano/listing')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Mekano Winners</span>
							</a>
							@endif
							<a <?= ((strpos($name, 'winners.settings') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/settings/winners')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Winners Settings</span>
							</a>
							<a <?= ((strpos($name, 'participants.report') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/participants/report')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Participants Report</span>
							</a>
						</div>
					</div>
				</div>
				@endif


				@if(Auth::user()->hasPermission('view_user'))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'user') !== false || strpos($name, 'users') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<i class="fa fa-users" aria-hidden="true"></i>

							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Users</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							@if(Auth::user()->hasPermission('add_user'))
							<a <?= ((strpos($name, 'user.create') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/user/create')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Create user</span>
							</a>
							@endif
							<a <?= ((strpos($name, 'user.index') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/user')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Listing</span>
							</a>
						</div>
					</div>
				</div>
				@endif

				@if(Auth::user()->hasPermission('view_admin'))
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'create.admin') !== false || strpos($name, 'list.admin') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<span class="svg-icon svg-icon-2">
								<i class="fa fa-user" aria-hidden="true"></i>

							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Admin users</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							@if(Auth::user()->hasPermission('add_admin'))
							<a <?= ((strpos($name, 'create.admin') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/create/admin')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Create admin</span>
							</a>
							@endif
							<a <?= ((strpos($name, 'list.admin') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{url('admin/listing/admin')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Listing</span>
							</a>
						</div>
					</div>
				</div>
				@endif

				@if(Auth::user()->role_id == '2')
				<div data-kt-menu-trigger="click" <?= ((strpos($name, 'roles') !== false || strpos($name, 'role') !== false) ? 'class="menu-item here show  menu-accordion"' : 'class="menu-item  menu-accordion"') ?>>
					<span class="menu-link">
						<span class="menu-icon">
							<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
							<span class="svg-icon svg-icon-2">
								<i class="fa fa-user-circle-o" aria-hidden="true"></i>
							</span>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-title">Admin Roles</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							<a <?= ((strpos($name, 'roles.add') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{route('admin.roles.add')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Create New Role</span>
							</a>

							<a <?= ((strpos($name, 'roles.all') !== false) ? 'class="menu-link active"' : 'class="menu-link"') ?> href="{{route('admin.roles.all')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Listing</span>
							</a>
						</div>
					</div>
				</div>
				@endif
			</div>
			<!--end::Menu-->
		</div>
		<!--end::Aside Menu-->
	</div>
	<!--end::Aside menu-->

</div>
<!--end::Aside-->