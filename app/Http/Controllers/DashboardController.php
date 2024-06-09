<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('dashboard');
    }
}
