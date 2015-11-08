<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Log;

class AdminController extends Controller
{
    public function show()
    {
        $logs = Log::newest()->take(10)->get();
        $downloadCount = Log::where('type', '=', 'download')->count();
        return view('admin.dashboard', [
            'active' => 'dashboard',
            'logs' => $logs,
            'downloadCount' => $downloadCount,
        ]);
    }
}
