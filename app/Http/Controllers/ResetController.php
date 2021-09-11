<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResetController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function reset(){

        Artisan::call('migrate:fresh --seed');

        foreach (['categories', 'products'] as $folder) {
            Storage::deleteDirectory($folder);
            Storage::makeDirectory($folder);

            $files = Storage::disk('reset')->files($folder);

            foreach ($files as $file) {
                Storage::put($file, Storage::disk('reset')->get($file));
            }
        }

        session()->flash('success', 'Project was reset by default');
        return redirect()->route('index');
    }
}
