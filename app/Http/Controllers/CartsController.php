<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use Session;
use App\Purchase;
use App\User;

class CartsController extends Controller
{
    public function index()
    {
        $products = Product::all();

       return view('USER.userHomepage')->with('products', $products);
    }

    public function show(Request $request)
    {
       
        $products = Product::find($request->id);

        return response()->json($products);
    }

    public function destroy(Request $request)
    {   
        $item = $this->removeElementWithValue(Session::get('cart'), "id", $request->id);

        $request->session()->forget('cart');
        Session::put('cart', $item);

        return 'Success';
    }

    public function addtocart(Request $request)
    {

        $item = ['id' => $request->id,
                'prodName' => $request->prodName,
                'prodDesc' => $request->prodDesc,
                'prodQuantity' => $request->prodQuantity,
                'total' => $request->total
             ];

        $items = Session::get('cart');
        if ($items == null){
          
          Session::push('cart', $item);
        }else{
          foreach ($items as $key => $value) {
            if ($items[$key]['id'] == $request->id ){
                $items[$key]['prodQuantity'] = $request->prodQuantity + $items[$key]['prodQuantity'];
                $items[$key]['total'] = $request->total + $items[$key]['total'];
                $request->session()->forget('cart');
                Session::put('cart', $items);
            }else{
              Session::push('cart', $item);
            }
            
          }
        }
    } 

    public function showCart() 
    {
        return view('USER.addtocart');
    }

    public function checkOut(Request $request) 
    {
        foreach (Session::get('cart') as $carts){

           $cart = Product::find($carts['id']);

           $stock = $carts['prodQuantity'];
           $quantity = $cart->product_count - $stock;
           $cart->product_count = $quantity; 
           if ($cart->product_count < 0) {
             return false;
           }else{
           $cart->save();

           $purchase = new Purchase();
           
           $purchase->product_name = $carts['prodName'];
           $purchase->product_id = Auth::user()->id;
           $purchase->product_description = $carts['prodDesc'];
           $purchase->product_quantity = $carts['prodQuantity'];
           $purchase->product_total = $carts['total'];
           $purchase->save();
           }
           $request->session()->forget('cart');
        }
         
    }

    public function removeElementWithValue($array, $key, $value){
         foreach($array as $subKey => $subArray){
              if($subArray[$key] == $value){
                   unset($array[$subKey]);
              }
         }
         return $array;
    }

    public function purchase()
    {
      $user = Auth::user()->id;

      $purchase = Purchase::where('product_id', $user)->latest()->get();

      return view('USER.purchase')->with('purchase', $purchase);
    }
    
}
