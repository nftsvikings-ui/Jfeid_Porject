<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;

class PolicyController extends Controller
{

    public function show($slug)
    {
        $policy = Policy::where('slug', $slug)->firstOrFail();

        return view('policies.show', compact('policy'));
    }
}
