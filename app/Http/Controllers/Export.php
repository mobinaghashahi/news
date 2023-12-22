<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Exporter;
use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Exports\NewsExport;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Controller
{
    public function export()
    {
        return Excel::download(new NewsExport, 'users.xlsx');
    }
}
