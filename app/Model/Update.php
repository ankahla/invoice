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

class Update extends Model
{
    const SOLSO_VERSION = '1.1';

    public function runUpdate()
    {
        $generals = DB::table('generals')->first();

        if (self::SOLSO_VERSION !== $generals->version) {
            DB::unprepared(file_get_contents(app_path().'/database/sql/update-'.self::SOLSO_VERSION.'.sql'));

            DB::table('generals')
                    ->where('id', 1)
                    ->update(['version' => self::SOLSO_VERSION]);
        }
    }
}
