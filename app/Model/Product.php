<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public function getImage()
    {
        $result = DB::table('products_images')
                ->select('name')
                ->where('product_id', $this->id)
                ->first();

        return $result ? $result->name : '';
    }
}
