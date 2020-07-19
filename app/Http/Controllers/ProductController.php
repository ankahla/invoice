<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\Currency;
use App\Model\Product;
use App\Model\ProductsImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as UploadImage;

class ProductController extends Controller
{
    protected $layout = 'index';

    public function index()
    {
        $currency = new Currency();

        $data = [
            'products' => Product::where('user_id', Auth::id())->where('status', 1)->get(),
            'currency' => $currency->defaultCurrency(),
        ];

        return view('products.index', $data);
    }

    public function create()
    {
        return view('products.create');
    }

    public function show($id)
    {
        return json_encode(Product::where('id', $id)->where('user_id', Auth::id())->first());
    }

    public function edit($id)
    {
        $data = [
            'product' => Product::where('id', $id)->where('user_id', Auth::id())->first(),
            'product_image' => ProductsImage::where('product_id', $id)->first(),
        ];

        return view('products.edit', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'price' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $store = new Product();
            $store->user_id = Auth::id();
            $store->name = $request->get('name');
            $store->code = $request->get('code');
            $store->price = $request->get('price');
            $store->description = $request->get('description');
            $store->status = 1;
            $store->save();
            if ($request->hasFile('image')) {
                $this->storeImage($request, $store->id);
            }
        } else {
            return Redirect::to('product/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('product')->with('message', trans('invoice.data_was_saved'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'price' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $update = Product::where('id', $id)->where('user_id', Auth::id())->first();
            $update->name = $request->get('name');
            $update->code = $request->get('code');
            $update->price = $request->get('price');
            $update->description = $request->get('description');
            $update->save();

            if ($request->hasFile('image')) {
                $this->storeImage($request, $id);
            } elseif ($request->has('delete_image')) {
                $this->deleteImage($id);
            }
        } else {
            return Redirect::to('product/'.$id.'/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('product')->with('message', trans('invoice.data_was_updated'));
    }

    public function destroy($id)
    {
        $update = Product::where('id', $id)->where('user_id', Auth::id())->first();
        $update->status = 0;
        $update->save();

        return Redirect::to('product')->with('message', trans('invoice.data_was_deleted'));
    }

    private function storeImage(Request $request, $productId)
    {
        try {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('upload/products/'.$filename);
            $img = UploadImage::make($image->getRealPath());
            $img->resize(null, 100, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($path);
            $store = ProductsImage::where('product_id', $productId)->first();
            if (!$store) {
                $store = new ProductsImage();
            }
            $store->product_id = $productId;
            $store->name = $filename;
            $store->save();
        } catch (\Exception $e) {
            return Redirect::to('product')->with('message', $e->getMessage());
        }
    }

    private function deleteImage($productId)
    {
        $img = ProductsImage::where('product_id', $productId)->first();
        if ($img) {
            $path = public_path('upload/products/'.$img->name);
            if (file_exists($path)) {
                unlink($path);
            }
            $img->delete();
        }
    }
}
