<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavouriteController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->favouriting($id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfavourite($id);
        return redirect()->back();
    }
}
