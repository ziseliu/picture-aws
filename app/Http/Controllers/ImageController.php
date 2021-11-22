<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image as ImageModel;
use Image;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    protected $aws_prefix = 'https://image-for-test.s3.ap-northeast-1.amazonaws.com/';
    /**
     * upload image
     *
     * @return void
     */
    public function upload(Request $request)
    {
        $images = [];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $ext = $file->getClientOriginalExtension(); //文件拓展名
                $path = $file->getRealPath(); //绝对路径

                $name_prefix = time() . uniqid();

                $origin_name = "{$name_prefix}.$ext";
                $medium_name = "{$name_prefix}_500x500.$ext";
                $small_name = "{$name_prefix}_200x200.$ext";

                $res_origin = Storage::disk('s3')->put($origin_name, file_get_contents($path));
                // 500*500
                $res_medium = Storage::disk('s3')->put($medium_name, Image::make($path)->resize(500, 500)->encode()->encoded);
                // 200x200
                $res_small = Storage::disk('s3')->put($small_name, Image::make($path)->resize(200, 200)->encode()->encoded);

                $images = [
                    'large' => $this->aws_prefix . $origin_name,
                    'medium' => $this->aws_prefix . $medium_name,
                    'small' => $this->aws_prefix . $small_name
                ];
                try {
                    $res = ImageModel::create($images);
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            }
        }

        return view('welcome', ['images' => $images]);
    }
}
