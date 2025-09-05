<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class BooksReportExport implements FromView
{
    protected $data;

    public function __construct()
    {
        $this->data = DB::table('vw_books_report')->get();
    }

    public function view(): View
    {
        return view('exports.books_report', [
            'books' => $this->data
        ]);
    }
}
