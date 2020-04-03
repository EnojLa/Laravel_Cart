<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Session;
use App\Purchase;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

       return view('USER.userHomepage')->with('products', $products);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       
        $products = Product::find($request->id);

        return response()->json($products);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        
    }

    public function addtocart(Request $request)
    {
        $item = ['id' => $request->id,
                'prodName' => $request->prodName,
                'prodDesc' => $request->prodDesc,
                'prodQuantity' => $request->prodQuantity,
                'total' => $request->total
             ];
             
        Session::push('cart', $item);

     
    } 

    public function showCart() {


        return view('USER.addtocart');

    }

    public function checkOut(Request $request) 
    {
        $purchase = new Purchase;
        foreach (Session::get('cart') as $carts){

           $cart = Product::find($carts['id']);

           $stock = $carts['prodQuantity'];
           $quantity = $cart->product_count - $stock;
           $cart->product_count = $quantity;
           if ($cart->product_count < 0){
                return false;
           }else{
           $cart->save();
           }
           $purchase->product_name = $carts['prodName'];
           $purchase->product_description = $carts['prodDesc'];
           $purchase->product_quantity = $carts['prodQuantity'];
           $purchase->product_total = $carts['total'];
           $purchase->save();
        }
         $request->session()->forget('cart');
    }
    
}
