<?php

namespace App\http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use Session;

class ProdukController extends Controller
{
    //buat index
    public function index()
    {
    	$Produk = Produk::all();
    	return view('produk.index'); 
    }

    public function store(Request $request)
    {
    	try {
    		DB::beginTransaction();
    		$Produk = new Produk;
    		$Produk->nama = $request-> nama;
    		$Produk->save();
    		DB::commit();
    		Session::flash('message', 'Data berhasil disimpan'); //toast
    		return redirect()-> back();
    	} catch (Exception $e) {
    		DB::rollback();
    		Session::flash('message', 'data tidak berhasil disimpan');
    		return redirect()->back();
    	}
    }
}
