<?php
namespace App\Http\Controllers\Admin;

use App\DataTables\CodeDatatable;
use App\Http\Controllers\Controller;
use App\Code;
use App\Tag;
use Illuminate\Http\Request;
use Storage;
use App\Http\Controllers\Upload;
use Str;
use DB;
class CodeController extends Controller
{
   public function index()
   {

   }
   public function create()
   {
    return view('codes.create',['title'=>'']);
   }

   public function store(Request $request)
   {
     $data = $this->validate(request(),
      [
       'name'     => 'required',
       'code'     => 'required',
       'explaine' => 'nullable',
       'file'     => 'nullable',
       'bigfile'  => 'nullable',
      ]);

      if (request()->hasFile('file')) {
         $data['file'] = Upload::upload([
            'file'        => 'file',
            'path'        => 'files',
            'upload_type' => 'single',
            'delete_file' => '',
         ]);
      }
      if (request()->hasFile('bigfile')) {
         $data['bigfile'] = Upload::upload([
            'file'        => 'bigfile',
            'path'        => 'bigfiles',
            'upload_type' => 'single',
            'delete_file' => '',
         ]);
      }
      $code=Code::create($data);
      if($request->parent){
        $parents=explode(', ',$request->parent);
        foreach ($parents as $parent) {
          if($parent!=''){
            DB::table('code_tag')->insert([
              ['code_id' => $code->id, 'tag_id' => $parent]
            ]);
          }
        }
      }
      return redirect(url('addcode/create'))->withStatus(__('New Code Added Successsfully.'));
   }

   public function show($id)
   {
      //
   }

   public function edit($id)
   {
      $code = Code::find($id);
      $tags = DB::table('tags')
      ->join('code_tag', 'code_tag.tag_id', '=', 'tags.id')
      ->where(function($query)use ($id)      {
        $query->where('code_tag.code_id',$id);
      })->select('tags.id')
      ->get();
      $title   = trans('Edit');
      return view('codes.edit', compact('code', 'title','tags'));
   }
   public function update(Request $r, $id)
   {
      //  "remember" => "on"
     $data = $this->validate(request(),
     [
      'name'     => 'required',
      'code'     => 'required',
      'explaine' => 'nullable',
      'file'     => 'nullable',
      'bigfile'  => 'nullable',
     ]);

     if (request()->hasFile('file')) {
        $data['file'] = Upload::upload([
           'file'        => 'file',
           'path'        => 'files',
           'upload_type' => 'single',
           'delete_file' => Code::findOrFail($id)->file,
        ]);
     }
     if (request()->hasFile('bigfile')) {
        $data['bigfile'] = Upload::upload([
           'file'        => 'bigfile',
           'path'        => 'bigfiles',
           'upload_type' => 'single',
           'delete_file' => Code::findOrFail($id)->bigfile,
        ]);
     }

     $code=Code::where('id', $id)->update($data);
     DB::table('code_tag')->where('code_id',$id)->delete();

     if($r->parent){
      $parents=explode(', ',$r->parent);
      foreach ($parents as $parent) {
        if($parent!=''){
          DB::table('code_tag')->insert([
            ['code_id' => $id, 'tag_id' => $parent]
          ]);
        }
      }
    }
     return redirect(url('search'))->withStatus(__('Code Updated Successsfully.'));
   }
}
