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
<!-- Modal -->
<div id="delete_bootstrap_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Tag</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      {!! Form::open(['url'=>'','method'=>'delete','id'=>'form_Delete_department']) !!}
      <div class="modal-body">
        <h4 class='alert alert-danger'>
         Are you sure you want to delete  <span id="dep_name"></span> Tag.
        </h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        {!! Form::submit('Yeas',['class'=>'btn btn-danger']) !!}
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>

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
    "checkbox" : {
      "keep_selected_style" : false
    },
    "plugins" : [ "wholerow"]
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
    <div class="row">

      <div class="col-xl-10 order-xl-1">
        <div class="card bg-secondary shadow">
          <div class="card-header bg-white border-0">
            <div class="row align-items-center">
                <h3 class="col-12 mb-0">{{ __('Add Tag') }}</h3>
            </div>
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
          </div>
          <div class="card-body">
            <form method="post" action="{{ route('tags.store') }}" autocomplete="off">
                @csrf
                @method('post')
                <input type="hidden" name="parent" id="" class='parent_id'>
                <div class="pl-lg-4">
                  <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                      <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                      @if ($errors->has('name'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                  </div>
                  <div class="box-body text-center  align-items-center">
                    <a href="" class="btn btn-info edit_dep showbtn_control hidden" ><i class="fa fa-edit"></i></a>
                    <a href="" class="btn btn-danger delete_dep showbtn_control hidden"  data-toggle="modal" data-target="#delete_bootstrap_modal" ><i class="fa fa-trash"></i> </a>
                    <button type="button" class="btn btn-primary mn_tg showbtn_control hidden" >Deselect All</button>
                    <button type="submit" class="btn btn-success">{{ __('Add Tag') }}</button>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
            </form>
          </div>
          <div class="card-body">
            <div id="jstree"class='pb-5'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
@endsection
