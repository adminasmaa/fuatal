@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="login" method="POST" action="{{ route('auth.login.post') }}">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">Sign In to Fusteka</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<!-- <div class="text-gray-400 fw-bold fs-4">New Here?
								<a href="../../demo1/dist/authentication/layouts/basic/sign-up.html" class="link-primary fw-bolder">Create an Account</a></div> -->
								<!--end::Link-->
							</div>
                            @if(Session::has('invaliduser'))
                            <span style="color: #f14668;">
                                  {{ Session::get('invaliduser') }}
                                 @php session()->forget('invaliduser');  @endphp
                            </span>

                            @endif
                            @include('partials.admin.errors')
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Email</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" value="{{ old('email') ?? '' }}" type="text" name="email" placeholder="{{ __('auth.login.email') }} OR Phone" autofocus />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
									<!--end::Label-->
									<!--begin::Link-->
									<!-- <a href="../../demo1/dist/authentication/layouts/basic/password-reset.html" class="link-primary fs-6 fw-bolder">Forgot Password ?</a> -->
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" placeholder="{{ __('auth.login.password') }}" />
								<!--end::Input-->
							</div>
                            @if ($hasCaptcha)
                                <div class="field has-addons has-addons-centered">
                                    <div class="control">
                                        {!! NoCaptcha::display() !!}
                                    </div>
                                </div>
                            @endif
                            <input type="checkbox" name="remember" value="1" checked> {{ __('auth.login.remember') }}
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
                                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Login</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<!--end::Submit button-->
								<!--begin::Separator-->
							
								<!--end::Separator-->
								
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
			
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
@endsection

@if ($hasCaptcha)
    @section('scripts')
        {!! NoCaptcha::renderJs('en') !!}
    @endsection
@endif

