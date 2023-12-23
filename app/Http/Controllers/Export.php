<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Exporter;
use Illuminate\Http\Request;

use App\Exports\NewsExport;
use App\Exports\ImportantNewsExport;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Controller
{
    public function exportAll()
    {
        return Excel::download(new NewsExport, 'news.xlsx');
    }
    public function exportImportant()
    {
        return Excel::download(new ImportantNewsExport, 'news.xlsx');
    }
}
