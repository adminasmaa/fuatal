@php categoryTree(); 
function categoryTree($parent_id = 0, $sub_mark = ''){
   $catObj1=DB::table('categories')->where(['parent_id'=>$parent_id,'lang_name'=>'English'])
   ->orderBy('trans_id','Asc')->get();

       foreach($catObj1 as $item){  
            echo '<option value="'.$item->id.'">'.$sub_mark.$item->title.'</option>';
            categoryTree($item->id, $sub_mark.'--');
        }
    
}

@endphp