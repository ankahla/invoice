<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\Image;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image as UploadImage;

class UploadController extends Controller
{
    protected $layout = 'index';

    /* === C.R.U.D. === */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $path = public_path('upload/'.$filename);
                $img = UploadImage::make($image->getRealPath());
                $img->resize(null, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($path);

                $store = new Image();
                $store->user_id = Auth::id();
                $store->name = $filename;
                $store->save();
            } catch (\Exception $e) {
                return Redirect::to('setting')->with('message', $e->getMessage());
            }
        } else {
            return Redirect::to('setting')->with('message', trans('invoice.file_is_empty'));
        }

        return Redirect::to('setting')->with('message', trans('invoice.data_was_saved'));
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $path = public_path('upload/'.$filename);

                $img = UploadImage::make($image->getRealPath());
                $img->resize(null, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($path);
                $update = Image::where('id', $id)->where('user_id', Auth::id())->first();
                $update->name = $filename;
                $update->save();
            } catch (\Exception $e) {
                return Redirect::to('setting')->with('message', $e->getMessage());
            }
        } else {
            return Redirect::to('setting')->with('message', trans('invoice.file_is_empty'));
        }

        return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
    }

    public function destroy($id)
    {
        $delete = Image::where('id', $id)->where('user_id', Auth::id());
        $delete->delete();

        return Redirect::to('setting')->with('message', trans('invoice.data_was_deleted'));
    }

    /* === END C.R.U.D. === */
}
