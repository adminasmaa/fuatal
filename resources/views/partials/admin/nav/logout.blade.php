<div class="navbar-item {{ $class ?? '' }}">
    <form method="POST" action="{{ route('auth.logout') }}">
        @csrf
        <p class="field">
            <button style="margin-top: 14px;padding: 10px 15px 10px 15px;" type="submit" class="btn btn-warning">
            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg></span>
                <!-- <span class="icon">{!! icon('log-out') !!}</span> -->
                <span>{{ __('auth.logout') }}</span>
            </button>
        </p>
    </form>
</div>
