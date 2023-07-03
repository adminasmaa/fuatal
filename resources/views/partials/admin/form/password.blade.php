<br/>
<div class="container-fluid">
<div class="field col-6">
<div class="control">
    @csrf
    <input type="hidden" name="_method" value="{{ 'POST' }}">
    <button type="submit" class="btn btn-success w-100">{{ __('admin.password') }}</button>
</div>
</div>
</div>
</form>
</div>
</section>