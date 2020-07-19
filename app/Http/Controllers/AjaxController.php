<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function productPrice(Request $request)
    {
        $product = Product::where('id', $request->get('product'))
            ->where('user_id', Auth::id())
            ->first();

        return json_encode($product);
    }
}
