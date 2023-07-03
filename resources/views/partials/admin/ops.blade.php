<ul style="display: flex; list-style: none;
    padding: 7px;"> 

@if($resource=='article')
<li class="is-inline">
<a title="Add Translation" class="button is-small" href="{{url('admin/translate/article'.'/'.$id)}}">
     Add Translation
        </a> 
</li>
<li class="is-inline">
<a title="Edit Translation" class="button is-small" href="{{url('admin/translate/article/edit'.'/'.$id)}}">
           Edit Translation
        </a> 
 </li>       
@endif


@if($resource=='page')
<li class="is-inline">
<a title="Add Translation" class="button is-small" href="{{url('admin/translate/page'.'/'.$id)}}">
     Add Translation
        </a> 
</li>

<li class="is-inline">
<a title="Edit Translation" class="button is-small" href="{{url('admin/translate/page/edit'.'/'.$id)}}">
           Edit Translation
        </a> 
 </li>       
@endif

    <!-- <li class="is-inline">
        <a class="button is-small is-info" href="{{ route(implode('.', ['admin', $resource, 'show']), [$resource => $id])  }}">
            <span class="icon">
                <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <circle cx="14" cy="14" r="12"></circle>
                    <path d="M23 23 L30 30"></path>
                </svg>
            </span>
            <span> {{ __('admin.ops.show') }}</span>
        </a>
    </li> -->


    <li class="is-inline p-1">
        <a class="btn btn-sm btn-success" data-toggle="tooltip" title="Edit User"  href="{{ route(implode('.', ['admin', $resource, 'edit']), [$resource => $id]) }}">
        <i class="fa fa-pencil mt-1" aria-hidden="true"></i>    
        <!-- <span class="icon">
                <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z"></path>
                </svg>
            </span> -->
            <!-- <span>{{ __('admin.ops.edit') }}</span> -->
        </a>
    </li>
    
    <li class="is-inline p-1">
        <form class="is-inline" method="POST" action="{{ route(implode('.', ['admin', $resource, 'destroy']), [$resource => $id]) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete User"  type="submit" onclick="return confirm('{{ __('admin.ops.confirmation') }}')">
            <i class="fa fa-trash mt-1" aria-hidden="true"></i>    
            <!-- <span class="icon">
                    <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                    </svg>
                </span> -->
                <!-- <span>{{ __('admin.ops.delete') }}</span> -->
            </button>
        </form>
    </li>
    @if($data->is_active)
    <li class="is-inline p-1">
            <a class="btn btn-sm btn-info" data-toggle="tooltip" title="Dectivate User" href="{{ route(implode('.', ['admin', $resource, $data->is_active ? 'inactive' : 'active']), [$resource => $id]) }}" >
            <i class="fa fa-ban mt-1" aria-hidden="true"></i>    
            <!-- <span class="icon">
                 <i class="fa fa-ban mt-1" aria-hidden="true"></i>
                </span> -->
                <!-- <span>{{ __('admin.ops.delete') }}</span> -->
            </a>
    </li>
    @else
    <li class="is-inline p-1">
       
        <a class="btn btn-sm btn-info" data-toggle="tooltip" title="Activate User" href="{{ route(implode('.', ['admin', $resource, $data->is_active ? 'inactive' : 'active']), [$resource => $id]) }}">
        <i class="fa fa-ban mt-1" aria-hidden="true"></i>    
        <!-- <span class="icon">
            <i class="fa fa-check mt-1" aria-hidden="true"></i>
            </span> -->
            <!-- <span>{{ __('admin.ops.delete') }}</span> -->
        </a>

    </li>
    @endif
    <li class="is-inline p-1">

        <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Update Password"  href="{{ route(implode('.', ['admin', $resource, 'user-password']), [$resource => $id]) }}">
        <i class="fa fa-key mt-1" aria-hidden="true"></i>    
        <!-- <span class="icon">
            <i class="fa fa-key mt-1" aria-hidden="true"></i>
            </span> -->
            <!-- <span>{{ __('admin.ops.delete') }}</span> -->
        </a>
    </li>
</ul>