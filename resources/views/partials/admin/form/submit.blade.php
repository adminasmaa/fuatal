<div class="col-md-12">
<div class="control">
    @csrf
    <input type="hidden" name="_method" value="{{ ${$resource} !== null ? 'PUT' : 'POST' }}">
    <button type="submit" class="w-100 btn btn-primary">{{ __('admin.save') }}</button>
</div>
</div>
</form>
</div>
</section>
