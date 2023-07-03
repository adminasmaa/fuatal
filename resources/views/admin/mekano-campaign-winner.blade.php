@extends('layouts.admin')

@section('content')
<style>
    .upload-mekano{
        float: right;
    background: #3273dc;
    color: white;
    padding: 4px 10px 4px 10px;
    border-radius: 5px;
    }
    .upload-mekano:hover{
        color: white;
    }
</style>
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
                @if(Session::has('success'))
    <div class="alert alert-success" id="success" style="background: limegreen;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;">
        
            {{ Session::get('success') }}
            @php session()->forget('success');  @endphp
        
    </div>
    @endif
                <div class="card-content" style="padding-bottom: 2rem;">
                    <div class="container-fluid">
        
   
<br>
</div>



<div class="post d-flex flex-column-fluid">
    <div id="kt_content_container-fluid" class="container-fluid">
        <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="display:block">
            <div class="card-title" style="display: flex;">
                    <p class="card-header-title" style="width: 50%;">
                        {{ 'Mekano Campaign (Assign Winners)' }}
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif

                    </p>

                    <div style="width: 50%;"><a class="btn btn-primary upload-mekano" href="{{url('admin/upload-mekano')}}">Upload Mekano</a></div>
            </div>
            <style>
                /*----  Main Style  ----*/
#cards_landscape_wrap-2{
  text-align: center;
  background: #F7F7F7;
}
#cards_landscape_wrap-2 .container{
  /* padding-top: 80px;  */
  padding-bottom: 80px;
}
#cards_landscape_wrap-2 a{
  text-decoration: none;
  outline: none;
}
#cards_landscape_wrap-2 .card-flyer {
  border-radius: 5px;
}
#cards_landscape_wrap-2 .card-flyer .image-box{
  background: #ffffff;
  overflow: hidden;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50);
  border-radius: 5px;
}
#cards_landscape_wrap-2 .card-flyer .image-box img{
  -webkit-transition:all .9s ease; 
  -moz-transition:all .9s ease; 
  -o-transition:all .9s ease;
  -ms-transition:all .9s ease; 
  width: 100%;
  height: 200px;
}
#cards_landscape_wrap-2 .card-flyer:hover .image-box img{
  opacity: 0.7;
  -webkit-transform:scale(1.15);
  -moz-transform:scale(1.15);
  -ms-transform:scale(1.15);
  -o-transform:scale(1.15);
  transform:scale(1.15);
}
#cards_landscape_wrap-2 .card-flyer .text-box{
  text-align: center;
}
#cards_landscape_wrap-2 .card-flyer .text-box .text-container{
  padding: 30px 18px;
}
#cards_landscape_wrap-2 .card-flyer{
  background: #FFFFFF;
  margin-top: 50px;
  -webkit-transition: all 0.2s ease-in;
  -moz-transition: all 0.2s ease-in;
  -ms-transition: all 0.2s ease-in;
  -o-transition: all 0.2s ease-in;
  transition: all 0.2s ease-in;
  box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);
}
#cards_landscape_wrap-2 .card-flyer:hover{
  background: #fff;
  box-shadow: 0px 15px 26px rgba(0, 0, 0, 0.50);
  -webkit-transition: all 0.2s ease-in;
  -moz-transition: all 0.2s ease-in;
  -ms-transition: all 0.2s ease-in;
  -o-transition: all 0.2s ease-in;
  transition: all 0.2s ease-in;
  margin-top: 50px;
}
#cards_landscape_wrap-2 .card-flyer .text-box p{
  margin-top: 10px;
  margin-bottom: 0px;
  padding-bottom: 0px; 
  font-size: 14px;
  letter-spacing: 1px;
  color: #000000;
}
#cards_landscape_wrap-2 .card-flyer .text-box h6{
  margin-top: 0px;
  margin-bottom: 4px; 
  font-size: 18px;
  font-weight: bold;
  text-transform: uppercase;
  font-family: 'Roboto Black', sans-serif;
  letter-spacing: 1px;
  color: #00acc1;
}
            </style>
              <!-- Topic Cards -->
    <div id="cards_landscape_wrap-2">
        <div class="container-fluid">
            <div class="row">
            @foreach($mekanos as $mekano)
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <!-- <a href=""> -->
                        <div class="card-flyer">
                            <div class="text-box">
                                <div class="image-box">
                                <a href="{{URL::asset('uploads/categories/'.$mekano->image)}}" data-lightbox="myImg150" data-title="t15">
                                        <img src="{{URL::asset('uploads/categories/'.$mekano->image)}}" data-lightbox="myImg150">
                                        </a>  
                                </div>
                                <div class="text-container-fluid">
                                    <h6>
                                    @if($mekano->win_status==0)
                                    <button id="btn_{{$mekano->id}}" value="{{$mekano->id}}"  onclick="makeWinner(this.value)" class="btn btn-primary">Make a Winner</button>
                                    <img width="44px" src="" style="display:none;" id="img_{{$mekano->id}}">
                                    @else
                                    <img width="44px" src="{{URL::asset('uploads/categories/winner.png')}}">
                                    @endif
                                    </h6>
                                    <p>
                                    {{$mekano->user->full_name}} - {{$mekano->user->phone}} 
                                    @if(!is_null($mekano->user->email) && $mekano->user->email != "")
                                        - {{$mekano->user->email}}
                                    @endif
                                    </p>
                                    <p>
                                    <b>Sticks: {{$mekano->stick->range}}</b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <!-- </a> -->
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12" style="margin-top: 20px;">
                {{$mekanos->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
        </div>
        </div>
    </div>
</div>
               
            </div>  
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable({
        'iDisplayLength': 50

        });});

 function makeWinner(id) {

    
     $.get("{{url('admin/make/mekanowinner')}}",{mekano_id:id},function(msg){
        location.reload();
        console.log(msg)
        $('#btn_'+id+'').hide();
         $('#img_'+id).attr('src',"{{URL::asset('uploads/categories/winner.png')}}");
         $('#img_'+id).show();

     });
 }

  function printTble() {
  
    var divToPrint = document.getElementById('dataTableBuilder');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table td,th {' +
        'border:0.25px solid silver;' +
        'padding:0.5em;' +
        'text-align:left;' +
        '}' +
        'table td,th {' +
        'text-align:left;' +
        'font-size:11px;'+
        '}'+  
       
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("","","width=900,height=710");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
    
 }
</script>

@endsection
 

