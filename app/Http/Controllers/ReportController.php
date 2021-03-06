<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\ProductCameOut;
use App\Helpers\ResponseFormatter;

class ReportController extends Controller
{
    //
    public function index()
    {
        return view('report.index');
    }

    public function search(Request $request)
    {
        $start = date($request->start . " 00:00:00");
        $end = date($request->end . " 23:59:59");
        if($request->status == "semua")
        {
            $report = ProductCameOut::whereBetween('updated_at',[$start, $end])->with('product')->get();
        }
        else{
            $report = ProductCameOut::whereBetween('updated_at',[$start, $end])->where('status', $request->status)->with('product')->get();
        }
        return ResponseFormatter::success($report, "Pencarian Berhasil.");
    }

    public function pdf(Request $request)
    {

        $bulan = [
            "01" => "JANUARI",
            "02" => "FEBRUARI",
            "03" => "MARET",
            "04" => "APRIL",
            "05" => "MEI",
            "06" => "JUNI",
            "07" => "JULI",
            "08" => "AGUSTUS",
            "09" => "SEPTEMBER",
            "10" => "OKTOBER",
            "11" => "NOVEMBER",
            "12" => "DESEMBER"
        ];

        $date_range = explode('-', $request->date_range);
        $date_range[0] = str_replace(" ", "", $date_range[0]);
        $date_range[1] = str_replace(" ", "", $date_range[1]);
        $start = explode('/', $date_range[0]);
        $end = explode('/', $date_range[1]);
        $start_datetime = date( "{$start[2]}-{$start[0]}-{$start[1]} 00:00:00");
        $end_datetime = date("{$end[2]}-{$end[0]}-{$end[1]} 23:59:59");

        $data['start'] = $start[1] . " ".$bulan[$start[0]] . " ". $start[2];
        $data['end'] = $end[1] ." ".$bulan[$end[0]] . " ". $end[2];
        
        if($request->status == "semua")
        {
            $data['reports'] = ProductCameOut::whereBetween('updated_at',[$start_datetime, $end_datetime])->with('product')->get();
        }
        else{
            $data['reports'] = ProductCameOut::whereBetween('updated_at',[$start_datetime, $end_datetime])->where('status', $request->status)->with('product')->get();
        }
        PDF::setOptions(['dpi' => 300, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true]);
        $pdf = PDF::loadView('report.pdf', $data);
        return $pdf->stream('report.pdf');
    }
}