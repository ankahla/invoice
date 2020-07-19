<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Model\Report;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{
    public function index()
    {
        $reports = new Report();

        $data = [
            'invoices' => $reports->invoices(),
            'amounts' => $reports->amounts(),
            'clients' => $reports->clients(),
        ];

        return view('reports.index', $data);
    }
}
