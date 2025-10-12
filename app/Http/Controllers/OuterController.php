<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSet;
use Illuminate\Http\Request;

class OuterController extends Controller
{
    public function index()
    {
        $appset = ApplicationSet::first();

        return view('pages.outer.index', [
            "title" => "Test"
        ]);
    }
}
