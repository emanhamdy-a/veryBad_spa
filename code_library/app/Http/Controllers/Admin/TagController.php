<?php
namespace App\Http\Controllers\Admin;

use App\DataTables\CodeDatatable;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Storage;

class TagController extends Controller
{

   public function index()
   {
      return view('tags.index',['title'=>'']);
   }

   public function store()
   {
      $data = $this->validate(request(),
         [
            'name' => 'required',
            'parent' => 'nullable',
         ]);

     Tag::create($data);
      session()->flash('success', 'gololol');
      return redirect(url('tags'))->withStatus(__('Tag Created Successsfully.'));
   }

   public function edit($id)
   {
      $tag = Tag::findOrFail($id);
      $title   = trans('admin.edit');
      return view('tags.edit', compact('tag', 'title'));
   }

   public function update(Request $r, $id)
   {
    $data = $this->validate(request(),
    [
       'name' => 'required',
       'parent' => 'nullable',
    ]);

    Tag::where('id', $id)->update($data);
    return redirect(url('tags'))->withStatus(__('Tag Updated Successsfully.'));
   }


   public function destroy($id)
   {
      $tag = Tag::findOrFail($id);
      $tag->delete();
      session()->flash('success', trans('admin.deleted_record'));
      return redirect(url('tags'))->withStatus(__('Tag Deleted Successsfully.'));
    }

}
