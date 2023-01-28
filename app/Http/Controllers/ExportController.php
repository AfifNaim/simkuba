<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kategori;
use App\Models\User;
use PDF;

class ExportController extends Controller
{
    public function exportPDF(){
        $transaksis = Transaksi::where('id_user', Auth::id())->paginate(5);
  
        $pdf = PDF::loadView('exportPDF', ['transaksis' => $transaksis]);
        
        return $pdf->download('exportPDF');
    }
}
