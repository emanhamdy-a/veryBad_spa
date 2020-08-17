<span>
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
            <a href="/delete/{{$code->id}}"><i class='deletBtn fa fa-trash fa-lg text-danger mx-2'></i></a>
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
</span>
