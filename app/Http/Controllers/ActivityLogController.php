<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;

use Illuminate\Http\Request;
use Carbon\Carbon;
class ActivityLogController extends Controller
{
    public function index(){
        $logs = ActivityLog::orderBy('waktu', 'DESC')->paginate(25);
        return view('admin.log_aktivitas.index', compact('logs'));
    }
}
