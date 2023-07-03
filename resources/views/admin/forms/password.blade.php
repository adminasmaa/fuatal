@extends('layouts.admin')

@section('content')
@include('partials.admin.form.init')

<div class="container mt-5">
    <div class="field col-6 mb-5">
        <label class="required label fs-5 fw-bold mb-2">Password</label>
        <div class="control">
            <input min="6" max="15" class="input form-control" value="" type="password" name="password" required>
        </div>
    </div>
    <div class="field col-6">
        <label class="required label fs-5 fw-bold mb-2">Re Enter Password</label>
        <div class="control">
            <input min="6" max="15" class="input form-control" value="" type="password" name="password_confirmation" required>
        </div>
    </div>

</div>
@include('partials.admin.form.password')
@endsection