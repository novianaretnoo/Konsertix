<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Ticket;

class TransaksiController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Ticket = Transaksi::all();
        return $Ticket;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Ticket = Transaksi::find($id);
        if ($Ticket) {
            return response()->json([
                'status' => 200,
                'data' => $Ticket
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'id atas ' .$id . ' tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $list = Ticket::where('nama_konser', $request['nama_konser'])->first();
        $Ticket = Transaksi::find($id);
        if($Ticket){
            $Ticket->nama_konser = $request->nama_konser ? $request->nama_konser : $Ticket->nama_konser;
            $Ticket->email = $request->email ? $request->email : $Ticket->email;
            $Ticket->total_tiket = $request->total_tiket ? $request->total_tiket : $Ticket->total_tiket;
            $Ticket->total_harga = $list->harga * $request->total_tiket;
            $Ticket->metode_pembayaran = $request->metode_pembayaran ? $request->metode_pembayaran : $Ticket->metode_pembayaran;
            $Ticket->status_pembayaran = $request->status_pembayaran ? $request->status_pembayaran : $Ticket->status_pembayaran;
            $Ticket->save();
            return response()->json([
                'status' => 200,
                'data' => $Ticket
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => $id . ' tidak ditemukan'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $list = Ticket::where('nama_konser', $request['nama_konser'])->first();
        if($list){
            $list->stok = $list->stok - $request->total_tiket;
            $list->save();

            $table = Transaksi::create([
                "nama_konser" => $request->nama_konser,
                "email" => $request->email,
                "total_tiket" => $request->total_tiket,
                "total_harga" => $list->harga * $request->total_tiket,
                "metode_pembayaran" => $request->metode_pembayaran,
                "status_pembayaran" => $request->status_pembayaran
            ]);

            return response()->json([
                'status' => 200,
                'data' => $table
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Gagal Booking'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Ticket = Transaksi::where('id', $id)->first();
        if($Ticket){
            $Ticket->delete();
            return response()->json([
                'status' => 200,
                'data' => $Ticket
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => $id . ' tidak ditemukan'
            ], 404);
        }
    }
}
