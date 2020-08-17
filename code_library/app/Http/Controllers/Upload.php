<?php
namespace App\Http\Controllers;
use Storage;

class Upload extends Controller {

	public static function upload($data = []) {
    if (in_array('new_name', $data)) {
      $new_name = $data['new_name'] === null?time():$data['new_name'];
    }
    if (request()->hasFile($data['file']) && $data['upload_type'] == 'single') {
      Storage::has('public/' . $data['delete_file'])?Storage::delete('public/' . $data['delete_file']):'';
      $string = random_int(000000000,999999999);
      $name = request()->file($data['file'])->getClientOriginalName();
      $path = request()->file($data['file'])
      ->storeAs('public/' . $data['path'], $string .$name);
      return str_replace('public/' , '' , $path);
      // $extension = request()->file($data['file'])->extension();
      // return str_replace('public/' , '' , request()->file($data['file'])->store('public/' . $data['path']));
    }
  }
}
