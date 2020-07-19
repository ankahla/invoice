<?php

/*
 * This file is part of the Invoice project.
 * (c) Kahla Anouar <kahla.anoir@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Language as LanguageRequest;
use App\Model\Language;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    protected $layout = 'index';

    /* === VIEW === */
    public function index()
    {
        $data = [
            'languages' => Language::all(),
        ];

        return view('admin.languages.index', $data);
    }

    public function create()
    {
        return view('admin.languages.create', []);
    }

    public function show($id)
    {
        $data = [
            'original' => File::getRequire(base_path().'/resources/lang/_default/default.php'),
            'translated' => File::getRequire(base_path().'/resources/lang/'.Language::where('id', $id)->first()->short.'/invoice.php'),
        ];

        return view('admin.languages.show', $data);
    }

    public function edit($id)
    {
        $data = [
            'language' => Language::where('id', $id)->first(),
        ];

        return view('admin.languages.edit', $data);
    }

    /* === END VIEW === */

    /* === C.R.U.D. === */
    public function store(LanguageRequest $request)
    {
        $rules = [
            'name' => 'required',
            'short_name' => 'required',
        ];

        //$validator = Validator::make(Input::all(), $rules);
        $validated = $request->validated();
        var_dump($validated);
        die;

        if ($validator->passes()) {
            $dir = strtolower(Input::get('short_name'));

            if (!File::exists(resource_path('lang/'.$dir))) {
                $store = new Language();
                $store->name = Input::get('name');
                $store->short = $dir;
                $store->save();

                File::copyDirectory(resource_path('lang/_original'), resource_path('lang/'.$dir), 0777);
            } else {
                Session::flash('validationMessage', trans('invoice.directory_exist'));

                return Redirect::to('language/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
            }
        } else {
            return Redirect::to('language/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
        }

        return Redirect::to('language')->with('message', trans('invoice.data_was_saved'));
    }

    public function update(Request $request, $îd)
    {
        $data = $request->validate(['name' => 'required']);
        $update = Language::where('id', $îd)->first();
        $update->name = $data['name'];
        $update->save();

        return Redirect::to('language')->with('message', trans('invoice.data_was_saved'));
    }

    public function destroy($id)
    {
        $delete = Language::where('id', $id)->first();
        $delete->delete();

        return Redirect::to('language')->with('message', trans('invoice.data_was_deleted'));
    }

    /* === END C.R.U.D. === */

    /* === OTHERS === */
    public function translate(Request $request)
    {
        $locale = $request->get('languageID');
        $words = $request->get('words');

        $dir = Language::where('id', $locale)->first()->short;

        $contents = '
		<?php
		return array(';
        foreach ($words as $k => $v) {
            $contents .= '"'.$k.'" => "'.$v.'", ';
        }

        $contents .= ');';

        File::put(resource_path('lang/'.$dir.'/invoice.php'), $contents);

        return Redirect::to('language')->with('message', trans('invoice.data_was_saved'));
    }

    /* === END OTHERS === */
}
