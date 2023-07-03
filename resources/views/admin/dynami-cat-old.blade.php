<!-- <?php
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
            		
@if($count > 1)
                                @if($color_count == 0)
                                <tr style="background-color: #eaf4ed;">
                                @else
                                <tr style="background-color: #daf5e0;">
                                @endif
                                @else
                                <tr>
                                @endif
                                @php
                                if($item->lang_name == 'English')
                                {
                                    if($color_count == 0)
                                    {
                                        $color_count = 1;
                                    }
                                    else{
                                        $color_count = 0;
                                    }
                                }
                                @endphp
                       
            		<td>
            			@if(is_null($item->cat_image))
            			<img width="70px" src="{{URL::asset('uploads/categories/')}}">
            			@else
                        <div style="max-width: 100px;padding: 15px;background: {{$item->color_code}};border-radius: 10px;" class="image-section">
                        <a href="{{URL::asset('uploads/categories/'.$item->cat_image)}}" data-lightbox="myImg150" data-title="t15">
                                        <img src="{{URL::asset('uploads/categories/'.$item->cat_image)}}" width="70" data-lightbox="myImg150">
                                        </a>        
                        </div>
            			
            			@endif
            		</td>
            		<td>{{$sub_mark}}{{$item->title}}</td>
            		<td>{{$sub_mark}}{{$item->title_ar}}</td>
                   

                     <td>

            
    <button class="button is-small is-danger" type="button" onclick="deleteRecord({{$item->id}})">
                <span class="icon">
                    <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                    </svg>
                </span>
                <span>Delete</span>
            </button> 

@if($item->lang_name=='English')
            <a class="button is-small is-primary" href="{{url('admin/category/'.$item->id.'/edit')}}">
            <span class="icon">
                <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z"></path>
                </svg>
            </span>
            <span>Edit</span>
        </a>    

@endif

@if($item->lang_name=='Arabic')
    <a title="Edit Translation" class="button is-small" href="{{url('admin/translate/category/edit'.'/'.$item->id)}}">
          Edit Translation
        </a> 

@endif             

                        </td>
            		</tr>
    @php 

    categoryTree($item->id, $sub_mark.'--'); 

} 
}

     @endphp -->