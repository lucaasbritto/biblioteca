<?php

namespace App\Http\Controllers\Exports;

use App\Http\Controllers\Controller;
use App\Exports\BooksReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function books()
    {
        return Excel::download(new BooksReportExport, 'books_report.xlsx');
    }
}
