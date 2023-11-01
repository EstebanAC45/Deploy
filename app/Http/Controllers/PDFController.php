<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Carrito;
use PDF;


class PDFController extends Controller
{
    public function index()
    {
        $filenane = 'factura.pdf';

        $data = [
            'title' => 'Prueba de PDF'
            
        ];

        $html = view() -> make('venta.factura', $data) -> render();

        $pdf = new PDF();

        $pdf::setTitle('Factura');
        $pdf::addPage();
        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output(public_path($filenane), 'F');

         return response()->download(public_path($filenane));
    }

    public function show($id)
    {
        $venta = Venta::find($id);
        $carrito_venta = Carrito::where('numero_venta', $id)->get();
        $pdf = PDF::loadView('venta.factura', compact('venta', 'carrito_venta'));
        return $pdf->stream('factura.pdf');
        
    }
}
