@php 

categoryTree(0,'',$id); 
function categoryTree($parent_id, $sub_mark ,$id){
   $catObj1=DB::table('categories')
   ->where(['parent_id'=>$parent_id,'lang_name'=>'English'])
   ->orderBy('trans_id','Asc')->get();

    foreach($catObj1 as $item){ 

			    if($id ==0){
			    	echo '<option value="0" selected="selected">Parent</option>';
			    } 
			    else if($id == $item->id){
			        echo '<option selected="selected" value="'.$item->id.'">'.$sub_mark.$item->title.'</option>';
			    }
			    
			    else{
			         echo '<option value="'.$item->id.'">'.$sub_mark.$item->title.'</option>';
			     }
			        categoryTree($item->id, $sub_mark.'--',$id);
    }
    
}

@endphp