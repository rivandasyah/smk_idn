<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Product;
use Exception;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //index buat nampilin semua produk yg udh di-list
        try {
        	$Produk = Product::all();

        	$response = $Produk;
        	$code = 200;
        } catch (Exception $e) {
        	$code = 500;
        	$response= $e -> getMessage();
        }

        return apiResponseBuilder($code, $response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //buat create produ/data baru
        $this-> validate($request, [
        		'name' => 'required', 
        		'description' => 'required',
        		// 'price' => 'required | numeric' buat nambahin price kalo misalkan di app nya ada price
        		'image' => 'required'
        	]);

       try {
       		$Produk = new Product(); 

       		//buat auto-create folder iamge di laravel 
       		$imageName = time().'.'.request()->image->getClientOriginalExtension();
       		request()->image->move(public_path('images'), $imageName);

       		$Produk -> name = $request-> name;
       		$Produk -> description= $request-> description;
       		$Produk -> image = $imageName;

       		$Produk->save();
       		$code=200;
       		$response=$Produk;

       } catch (Exception $e) {
       		if ($e instanceof ValidationException) {
       			$code = 400;
       			$response = 'tidak ada data';
       		} else {
       			$code = 500;
       			$response = $e -> getMessage();
       		}
       }

       return apiResponseBuilder($code, $response); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //untuk menampilkan data berdasarkan id dia
        try {
        	$Produk = Product::findOrFail($id);

        	$code = 200;
        	$response = $Produk;
        } catch (Exception $e) {
        	if ($e instanceof ModelNotFoundException) {
        		$code = 404;
        		$response = 'inputkan sesuai id';
        	} else {
        		$code = 500;
        		$response = $e -> getMessage();
        	}
        	
        }

        return apiResponseBuilder($code, $response);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //untuk menghapus produk
        try {
        	$Produk = Product::find($id);
        	$Produk->delete();
        	$code = 200;
        	$response = $Produk;
        } catch (Exception $e) {
        	$code = 500;
        	$response=$e->getMessage();
        }

    	return apiResponseBuilder($code, $response);
    }

}
