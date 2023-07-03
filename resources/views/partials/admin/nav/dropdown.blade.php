<div class="navbar-item has-dropdown is-hoverable">
    <div class="navbar-link">
        <span class="icon">{!! icon($icon) !!}</span>

        <span>
       @if($resource=='article')
        {{ empty($resource) && !empty($text) ? $text : 'Recipes'}}
        @else
         {{ empty($resource) && !empty($text) ? $text : __('admin.' . $resource . '.index') }}
        @endif
    </span>


    </div>

    <div class="navbar-dropdown">
        @if (empty($items))
            <a class="navbar-item" href="{{ route('admin.' . $resource . '.create') }}">
                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                <span>{{ __('admin.' . $resource . '.create') }}</span>
            </a>
            @if(!empty($extra))
                @foreach (\Illuminate\Support\Arr::wrap($extra) as $e => $i)

                    <a class="navbar-item" href="{{ route('admin.' . $resource . '.' . $e) }}">
                        <span class="icon">{!! icon($i) !!}</span>
                        <span>{{ __('admin.' . $resource . '.' . $e) }}</span>
                    </a>
                @endforeach
            @endif
            <a class="navbar-item" href="{{ route('admin.' . $resource . '.index') }}">
                <span class="icon">{!! icon('list') !!}</span>
                <span>{{ __('admin.' . $resource . '.index') }}</span>
            </a>
        @else
            @foreach ($items as $text => $values)
                <a class="navbar-item" href="{{ $values[0] }}">
                    <span class="icon">{!! icon($values[1]) !!}</span>
                    <span>{{ $text }}</span>
                </a>
            @endforeach
        @endif
    </div>
</div>
