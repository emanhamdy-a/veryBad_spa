<?php
namespace App\Http\Controllers\Admin;

use App\DataTables\CodeDatatable;
use App\Http\Controllers\Controller;
use App\Code;
use Illuminate\Http\Request;
use Storage;
use App\Http\Controllers\Upload;
use Str;
use DB;
class SearchController extends Controller
{
   public function index()
   {
      $sr=isset($_GET['s'])   ? '%' . $_GET['s']  . '%':  null;
      $pg=isset($_GET['page'])? '%' . $_GET['page'] . '%' : null;
      $tg=isset($_GET['tg'])  ?  $_GET['tg'] : null;
      if($sr == null && $tg == null && $pg == null){
        $codes = code::orderBy('name','asc')->paginate(10);
        $title='Code';
        return view('codes.search', compact('codes','title'));
      }
      $parents=[];
      $tags=explode(',',$tg);
      foreach ($tags as $tag) {
        $parents[]=$tag;
      }

      if(strlen($tg)>0){
        $codes = DB::table('codes')
        ->join('code_tag', 'code_tag.code_id', '=', 'codes.id')
        ->where(function($query)use ($parents)      {
          $query->whereIn('code_tag.tag_id',$parents);
        })->Where(function($query)use ($sr){
          $query->where('codes.code','LIKE',$sr);
          $query->orwhere('codes.name','LIKE',$sr);
          $query->orwhere('codes.explaine','LIKE',$sr);
        })->select('codes.*')->orderBy('name','asc')
        ->paginate(10);
      }else{
        $codes = DB::table('codes')->Where('name','LIKE',$sr)
        ->orwhere('code','LIKE',$sr)->orwhere('explaine','LIKE',$sr)
        ->orderBy('name','asc')->paginate(10);
      }
      // dd($codes);
      if (request()->ajax()) {
        return view('codes.searchrslt', compact('codes'));
      }else{
        $title='Codes';
        return view('codes.search', compact('codes','title'));
      }
   }

   public function edit($id)
   {
      $code = Code::find($id);
      $title   = trans('Edit');
      return view('codes.edit', compact('code', 'title'));
   }

  public function update(Request $r, $id)
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
    DB::table('code_tag')->where('code_id',$code->id)->delete();
    $parents=explode(', ',$request->parent);
    foreach ($parents as $parent) {
    DB::table('code_tag')->insert([
      ['code_id' => $code->id, 'tag_id' => $parent]
    ]);
    }

    return redirect(url('tags'))->withStatus(__('Code Updated Successsfully.'));
  }
   public function delete($id)
   {
     $code = code::findOrFail($id);
     Storage::has('public/' . $code->file)?Storage::delete('public/' . $code->file):'';
     Storage::has('public/' . $code->bigfile)?Storage::delete('public/' . $code->bigfile):'';
     DB::table('code_tag')->where('code_id',$id)->delete();
     $code->delete();
     return redirect(url('/search'))->withStatus(__('Code Deleted Successfully.'));
   }

}
