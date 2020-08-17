@extends('layouts.app')

@section('content')
@include('users.partials.header', [
        'class' => 'col-lg-7'
    ])
@push('js')
<!-- Trigger the modal with a button -->
<style type="text/css">
 .hidden{display:none;}
</style>

<script type="text/javascript">
$(document).ready(function(){
  $('.mn_tg').on('click',function () {
    $('.parent_id').val('');
    $("#jstree").jstree().deselect_all(true);
  })

  $('#jstree').jstree({
    "core" : {
      'data' :{!! get_dep() !!},
      "themes" : {
        "variant" : "large"
      }
    },
    'checkbox' : {
    		'three_state' : false,
        'visible' : true,
        "keep_selected_style" : false
    },
    "plugins" : [ "wholerow","checkbox"]
  });

});

$('#jstree').on('changed.jstree',function(e,data){
    var i , j , r = [];
    var  name = [];
    for(i=0,j = data.selected.length;i < j;i++)
    {
        r.push(data.instance.get_node(data.selected[i]).id);
        name.push(data.instance.get_node(data.selected[i]).text);
    }
    $('.parent_id').val(r.join(', '));
    if(r.join(', ') != '')
    {
      $('#form_Delete_department').attr('action','{{ url('tags') }}/'+r.join(', '));
      $('#dep_name').text(name.join(', '));
      $('.showbtn_control').removeClass('hidden');
      $('.edit_dep').attr('href','{{ url('tags') }}/'+r.join(', ')+'/edit');
    }else{
      $('.showbtn_control').addClass('hidden');
    }
});
</script>
@endpush

  <div class="container-fluid mt--7">
    <form id='searchform' class="navbar-search navbar-search-dark"
        style='position:relative;left:0px;top:-35px;'method="post" action="/search"autocomplete="off">
        @csrf
        @method('get')
        <div class="form-group mb-0">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
          <input type="hidden" name="parent" id="parent" class='parent_id'>
          <input type="hidden" name="paginate" id="paginate" class='paginate'>
          <input class="form-control" placeholder="Search" name='search' id='search' type="text">
          <button type='submit' class='btn btn-info' style=position:absolute;top:-55px;right:0px;>Search</button>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col-xl-5 order-xl-2 mb-5 mb-xl-0">
        <div class="card card-profile shadow">
          <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <button type="button" class="btn btn-primary mn_tg showbtn_control mb-5 mt-4" style='margin:auto;' >Deselect</button>
                <div id="jstree" class='col-12'></div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-xl-7 order-xl-1">
        <div class="card bg-secondary shadow">
          @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('status') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif
          <div class="card-body searchdata m-0 p-0" style='min-height:650px;'>
            <?php $id=[];?>
            @if(count($codes))
             <div id="accordion" class="one p-0 m-0">
             @foreach($codes as $code)
             @if(!in_array($code->id,$id))
              <div class="card two">
                <!-- secondary lighter light neutral --white-->
                <div class="card-header three" id="heading{{$code->id}}">
                  <h5 class="mb-0 four">
                    <button class="btn btn-link  collapsed" data-toggle="collapse" data-target="#collapse{{$code->id}}" aria-expanded="false" aria-controls="collapse{{$code->id}}">
                      {{ $code->name }}
                      @if($code->file || $code->bigfile)
                        <i class="fa fa-download text-orange ml-2" aria-hidden="true"></i>
                      @endif
                    </button>
                    <span style='float:right;'>
                      <a class='opnv' dataCode='{{$code->code}}'dataEx='{{$code->explaine}}' style='cursor:pointer;'><i class='fa fa-code fa-lg text-primary mx-2'></i></a>
                      <!-- {!! Form::open(['url'=>url('')]) !!}
                      {!! Form::close() !!} -->
                      <a href="/delete/{{$code->id}}"><i class='fa fa-trash fa-lg text-danger mx-2 deletBtn'></i></a>
                      <a href="/addcode/{{$code->id}}/edit"><i class='fa fa-edit fa-lg text-info mx-2'></i></a>
                    </span>
                  </h5>
                </div>
                <div id="collapse{{$code->id}}" class="collapse" aria-labelledby="heading{{$code->id}}" data-parent="#accordion">
                  <div class="card-body">
                      @if($code->file || $code->bigfile)
                      <h3>Download files</h3>
                      @else
                      <h3>There is no files to dwonload it.</h3>
                      @endif
                    <a class="btn btn-link" href="{{ Storage::url($code->file) }}" download="{{str_replace('files/','',preg_replace('/\d+/u', '', $code->file)) }}">
                      {{str_replace('files/','',preg_replace('/\d+/u', '', $code->file)) }}</a></br>
                    <a class="btn btn-link" href="{{ Storage::url($code->bigfile) }}" download="{{str_replace('bigfiles/','',preg_replace('/\d+/u', '', $code->bigfile)) }}">
                      {{str_replace('bigfiles/','',preg_replace('/\d+/u', '', $code->bigfile)) }}</a>
                  </div>
                </div>
              </div>
              @endif
              <?php $id[]=$code->id;?>
              @endforeach
              @else
              <div class='alert alert-danger m-5'>There is no results for this search try with another word or tag.</div>
             </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@push('js')
  <div class='m-5 border'>
    {{$codes->links()}}
  </div>
@endpush
<script>
$(document).ready(function(){
	$('.pagination a').removeClass('disabled');
});
</script>
@endsection
  <!-- /.box -->
  <?php
    function get_dep($select = null,$dep_hide = null) {
      $tags=App\Tag::selectRaw('name as text')
      ->selectRaw('id as id')
      ->selectRaw('parent as parent')->orderBy('name','asc')
      ->get(['text', 'parent', 'id']);
      $data=[];
      $obj=[];
      foreach ($tags as $key => $tag) {
        // $obj['icon']     = Storage::url($tag->icon);
        // $obj['icon']     = "'<i class='fa fa-tags'></i>'";
        // $obj['icon']     = "glyphicon glyphicon-plus";
        if($select !== null && $select==$tag->id){
          $obj['state']=[
            'opend'   =>true,
            'selected'=>true,
            'disabled' => false,
          ];
        }else{
          $obj['state']=[
          'opend'   =>false,
          'selected'=>false,
          // 'disabled' => true,
          ];
        }
        if ($dep_hide !== null and $dep_hide == $tag->id) {

          $obj['state'] = [
            'opened'   => false,
            'selected' => false,
            'disabled' => true,
            'hidden'   => true,
          ];
        }
        $tag->parent = $tag->parent ? $tag->parent :'#';
        $obj['id']=$tag->id;
        $obj['text']=$tag->text;
        $obj['parent']=$tag->parent;
        array_push($data,$obj);
      }
      return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
  ?>
