<div class="col-md-6 fv-row mt-2">
    <label class="required fs-5 fw-bold mb-2">{{ __('admin.fields.' . $resource . '.' . $attribute) }} @if($attribute!=='email') @endif</label>
    
        @php $value = (${$resource}->$attribute ?? old($attribute)) @endphp
       	@if($attribute!=='email')
        <input required="required" class="form-control {{ ($class ?? '') }}" value="{{ empty($value) ? ($default ?? '') : $value }}" type="{{ $type ?? 'text' }}" name="{{ $attribute }}">
        @else
              <input class="form-control {{ ($class ?? '') }}" value="{{ empty($value) ? ($default ?? '') : $value }}" type="{{ $type ?? 'text' }}" name="{{ $attribute }}">
        @endif
   
</div>
