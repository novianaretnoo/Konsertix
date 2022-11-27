<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Ticket;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemesanan = Pemesanan::all();
        return $pemesanan;
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
        $list = Ticket::where('nama_konser', $request['nama_konser'])->first();
        if($list){
            $list->stok = $list->stok * 1;
            $list->save();

                $table = Pemesanan::create([
                "nama_konser" => $request->nama_konser,
                "nama_lengkap" => $request->nama_lengkap,
                "email" => $request->email,
                "no_hp" => $request->no_hp,
                "no_ktp" => $request->no_ktp,
                "total_tiket" => $request->total_tiket,
                "total_harga" => $list->harga * $request->total_tiket,
            ]);

            return response()->json([
                'status' => 200,
                'data' => $table
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Gagal melakukan pemesanan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pemesanan = pemesanan::find($id);
        if ($pemesanan) {
            return response()->json([
                'status' => 200,
                'data' => $pemesanan
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
        $list = Ticket::where('nama_konser', $request['nama_konser'])->first();
        if($list){
            $list->stok = $list->stok * 1;
            $list->save();
            $pemesanan = Pemesanan::find($id);
            if($pemesanan){
                $pemesanan->nama_konser = $request->nama_konser ? $request->nama_konser : $pemesanan->nama_konser;
                $pemesanan->nama_lengkap = $request->nama_lengkap ? $request->nama_lengkap : $pemesanan->nama_lengkap;
                $pemesanan->email = $request->email ? $request->email : $pemesanan->email;
                $pemesanan->no_ktp = $request->no_ktp ? $request->no_ktp : $pemesanan->no_ktp;
                $pemesanan->total_tiket = $request->total_tiket ? $request->total_tiket : $pemesanan->total_tiket;
                $pemesanan->total_harga = $request->total_harga ? $request->total_harga : $list->harga * $request->total_tiket;
                $pemesanan->save();
                return response()->json([
                    'status' => 200,
                    'data' => $pemesanan
                ],200);
    
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => $id . ' tidak ditemukan'
                ], 404);
            }
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
        $pemesanan = Pemesanan::where('id', $id)->first();
        if($pemesanan){
            $pemesanan->delete();
            return response()->json([
                'status' => 200,
                'data' => $pemesanan,
                'message' => $id . ' terhapus'
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => $id . ' tidak ditemukan'
            ], 404);
        }
    }
}
