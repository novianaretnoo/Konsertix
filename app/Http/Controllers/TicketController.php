<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Ticket = Ticket::all();
        return $Ticket;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = Ticket::create([
            "nama_konser" => $request->nama_konser,
            "kategori" => $request->kategori,
            "tanggal" => $request->tanggal,
            "tempat" => $request->tempat,
            "waktu" => $request->waktu,
            "deskripsi" => $request->deskripsi,
            "stok" => $request->stok,
            "harga" => $request->harga
        ]);

        return response()->json([
            'success' => 201,
            'message' => 'Data berhasil disimpan',
            'data' => $table
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Ticket = Ticket::find($id);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Ticket = Ticket::find($id);
        if($Ticket){
            $Ticket->nama_konser = $request->nama_konser ? $request->nama_konser : $Ticket->nama_konser;
            $Ticket->kategori = $request->kategori ? $request->kategori : $Ticket->kategori;
            $Ticket->tanggal = $request->tanggal ? $request->tanggal : $Ticket->tanggal;
            $Ticket->tempat = $request->tempat ? $request->tempat : $Ticket->tempat;
            $Ticket->waktu = $request->waktu ? $request->waktu : $Ticket->waktu;
            $Ticket->deskripsi = $request->deskripsi ? $request->deskripsi : $Ticket->deskripsi;
            $Ticket->stok = $request->stok ? $request->stok : $Ticket->stok;
            $Ticket->harga = $request->harga ? $request->harga : $Ticket->harga;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Ticket = Ticket::where('id', $id)->first();
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