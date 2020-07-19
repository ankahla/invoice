<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Report
{
    /* === ADMIN === */
    public function adminInvoicesReport()
    {
        $month = DB::table('invoices')
            ->select(DB::raw('COUNT(id) as number, MIN(start_date) as xdate'))
            ->where(DB::raw('month(start_date)'), '=', date('m'))
            ->groupBy(DB::raw('day(start_date)'))
            ->get();

        $year = DB::table('invoices')
            ->select(DB::raw('COUNT(id) as number, MIN(start_date) as xdate'))
            ->where(DB::raw('year(start_date)'), '=', date('Y'))
            ->groupBy(DB::raw('month(start_date)'))
            ->get();

        return [
            'month' => self::transformToDays($month, 'Invoices'),
            'year' => self::transformToMonths($year, 'Invoices'),
        ];
    }

    public function adminUsersReport()
    {
        $month = DB::table('users')
            ->select(DB::raw('COUNT(id) as number, MAX(created_at) as xdate'))
            ->where(DB::raw('month(created_at)'), '=', date('m'))
            ->groupBy(DB::raw('day(created_at)'))
            ->get();

        $year = DB::table('users')
            ->select(DB::raw('COUNT(id) as number, MAX(created_at) as xdate'))
            ->where(DB::raw('year(created_at)'), '=', date('Y'))
            ->groupBy(DB::raw('month(created_at)'))
            ->get();

        return [
            'month' => self::transformToDays($month, 'Clients'),
            'year' => self::transformToMonths($year, 'Clients'),
        ];
    }

    /* === ADMIN === */

    public function invoices()
    {
        $month = DB::table('invoices')
                ->select(DB::raw('COUNT(id) as number, MIN(start_date) as xdate'))
                ->where('user_id', Auth::id())
                ->where(DB::raw('month(start_date)'), '=', date('m'))
                ->groupBy(DB::raw('DAY(created_at)'))
                ->get();

        $year = DB::table('invoices')
                ->select(DB::raw('COUNT(id) as number, MIN(start_date) as xdate'))
                ->where('user_id', Auth::id())
                ->where(DB::raw('year(start_date)'), '=', date('Y'))
                ->groupBy(DB::raw('month(start_date)'))
                ->get();

        return [
            'month' => self::transformToDays($month, 'Invoices'),
            'year' => self::transformToMonths($year, 'Invoices'),
        ];
    }

    public function amounts()
    {
        $month = DB::table('invoices')
                ->select(DB::raw('SUM(amount) as number, MIN(start_date) as xdate'))
                ->where('user_id', Auth::id())
                ->where('status_id', 1)
                ->where(DB::raw('month(start_date)'), '=', date('m'))
                ->groupBy(DB::raw('DAY(created_at)'))
                ->get();

        $year = DB::table('invoices')
                ->select(DB::raw('SUM(amount) as number, MIN(start_date) as xdate'))
                ->where('user_id', Auth::id())
                ->where('status_id', 1)
                ->where(DB::raw('year(start_date)'), '=', date('Y'))
                ->groupBy(DB::raw('month(created_at)'))
                ->get();

        return [
            'month' => self::transformToDays($month, 'Amounts'),
            'year' => self::transformToMonths($year, 'Amounts'),
        ];
    }

    public function clients()
    {
        $month = DB::table('clients')
                ->select(DB::raw('COUNT(id) as number, MIN(created_at) as xdate'))
                ->where('user_id', Auth::id())
                ->where(DB::raw('month(created_at)'), '=', date('m'))
                ->groupBy(DB::raw('DAY(created_at)'))
                ->get();

        $year = DB::table('clients')
                ->select(DB::raw('COUNT(id) as number, MIN(created_at) as xdate'))
                ->where('user_id', Auth::id())
                ->where(DB::raw('year(created_at)'), '=', date('Y'))
                ->groupBy(DB::raw('month(created_at)'))
                ->get();

        return [
            'month' => self::transformToDays($month, 'Clients'),
            'year' => self::transformToMonths($year, 'Clients'),
        ];
    }

    private function transformToDays($info, $legend)
    {
        $daysInMonth = $this->daysInMonth((int) date('m'), (int) date('Y'));
        $days = [];
        $arrayData = [];

        foreach ($info as $v) {
            $date = explode('-', $v->xdate);
            $arrayData[ltrim($date[2], '0')] = $v->number;
        }

        for ($i = 1; $i <= $daysInMonth; ++$i) {
            $days[$i] = $i;
        }

        $last = end($days);
        $data = '[';
        $data .= "['Days', '$legend', { role: 'style' } ],";

        foreach ($days as $k => $v) {
            if (isset($arrayData[$k])) {
                $data .= "['$v', $arrayData[$k], 'color: #8e44ad']";
            } else {
                $data .= "['$v', 0, 'color: #8e44ad']";
            }

            if ($k !== $last) {
                $data .= ',';
            }
        }

        $data .= ']';

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit;

        return $data;
    }

    /**
     * calculate number of days in a month.
     */
    private function daysInMonth(int $month, int $year)
    {
        return 2 === $month ?
            ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) :
            (($month - 1) % 7 % 2 ? 30 : 31);
    }

    private function transformToMonths($info, $legend)
    {
        $arrayData = [];
        foreach ($info as $v) {
            $date = explode('-', $v->xdate);
            $arrayData[$date[1]] = $v->number;
        }

        $months = [
            '01' => 'january',
            '02' => 'february',
            '03' => 'march',
            '04' => 'april',
            '05' => 'may',
            '06' => 'june',
            '07' => 'july',
            '08' => 'august',
            '09' => 'september',
            '10' => 'october',
            '11' => 'november',
            '12' => 'december',
        ];

        $data = '[';
        $data .= "['Days', '$legend', { role: 'style' } ],";

        foreach ($months as $k => $v) {
            if (isset($arrayData[$k])) {
                $data .= "['$v', $arrayData[$k], 'color: #8e44ad']";
            } else {
                $data .= "['$v', 0, 'color: #8e44ad']";
            }

            if (12 !== $k) {
                $data .= ',';
            }
        }

        $data .= ']';

        return $data;
    }
}
