<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Purchase;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();

       return view('ADMIN.adminHomepage')->with('products', $products);
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
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'productname' => 'required',
            'productdescription' => 'required',
            'productcount' => 'required',
            'productprice' => 'required',

        ]);
 
        if ($files = $request->file('image')) {

            $imageName = time().'.'.$request->image->getClientOriginalExtension(); //----> CHANGE IMAGE FILE NAME
            $request->file('image')->move(public_path('images'), $imageName); //----> MOVE IMAGE TO PUBLI FOLDER

            $products = new Product();

            $products->product_name = $request->productname; //-----------> TO SAVE PRODUCT ITEM AND IMAGE FILE NAME
            $products->product_image = $imageName;
            $products->product_code = 0;
            $products->product_description = $request->productdescription;
            $products->product_count = $request->productcount;
            $products->product_price = $request->productprice;
            $products->save();

            $id = $products->id;      //----------------> TO GENERATE PRODUCT CODE
            $created = preg_replace("/[\s-:]/", "", $products->created_at);
            $products->product_code = 'ITEM' . $created . $products->products_image . $id;
            $products->save();
             
            return Response()->json([
                "success" => true,
                "image" => $imageName
            ]);
 
        }
 
        return Response()->json([
                "success" => false,
                "image" => ''
            ]);
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::find($id);

        return view('ADMIN.adminViewpage')->with('products', $products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $id)
    {
        $products = Product::find($request->id);

        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        request()->validate([
            'productname' => 'required',
            'productdescription' => 'required',
            'productcount' => 'required|numeric|min:1',
            'productprice' => 'required',

        ]);

        $products = Product::find($request->id);  //-------------> EDIT/SAVE PRODUCT
        
        if ($request->file('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension(); //----> CHANGE IMAGE FILE NAME
            $request->file('image')->move(public_path('images'), $imageName); //----> MOVE IMAGE TO PUBLI FOLDER
            $products->product_image = $imageName;
        }

        $products->product_name = $request->productname;
        $products->product_description = $request->productdescription;
        $products->product_count = $request->productcount;
        $products->product_price = $request->productprice;
        $products->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $products = Product::find($request->id);
        $products->delete();

    }
}
