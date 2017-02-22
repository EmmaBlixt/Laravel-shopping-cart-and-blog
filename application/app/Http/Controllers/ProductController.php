<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use App\ProductLog;
use DB;
use Session;

class ProductController extends Controller 
{


/*
|--------------------------------------------------------------------------
| Get routes
|--------------------------------------------------------------------------
|
| Redirects to index, new product & shopping cart pages
| 
*/

	public function get_index() {
		$products = Product::all();
		return view('product.index', ['products' => $products]);
	}


	public function get_edit_product($id) {	
		$product = Product::find($id);
		return view('product.edit-product',['product' => $product]);
	} 

	public function get_insert_product(){
		return view('product.insert-product');
	}

	public function get_cart() {	
		if (!Session::has('cart')) {
		return view('product.shopping-cart');
			}

		$old_cart = Session::get('cart');
		$cart = new Cart($old_cart);
		return view('product.shopping-cart', [
			'products' => $cart->items, 
			'total_price' => $cart->total_price]);
	}


/*
|--------------------------------------------------------------------------
| Cart functions
|--------------------------------------------------------------------------
|
| Allows user to add/remove, empty and check out the shopping cart
| 
*/

	public function add_to_cart(Request $request, $id) {
		
		$product = Product::find($id);
			// checks if a cart is in session, otherwise cart is null
		$old_cart = Session::has('cart') ? Session::get('cart') : null;
		$cart = new Cart($old_cart);
		$cart->add($product, $product->id);

		$request->session()->put('cart', $cart);
		return redirect()->route('shopping-cart');
	}


	public function remove_from_cart(Request $request, $id) {
		
		$product = Product::find($id);
			// checks if a cart is in session, otherwise cart is null
		$old_cart = Session::has('cart') ? Session::get('cart') : null;
		$cart = new Cart($old_cart);
		$cart->remove($product, $product->id);

		$request->session()->put('cart', $cart);
		return redirect()->route('shopping-cart');
	}


	public function clear_cart() {
        Session::flush();
        return redirect()->back();
	}

	public function get_checkout() {
		if (!Session::has('cart')) {
			return view('product.shopping-cart');
			}
		$old_cart = Session::get('cart');
		$cart = new Cart($old_cart);
		$total = $cart->total_price;
	return view('product.checkout', ['total' => $total]);
}


/*
|--------------------------------------------------------------------------
| Insert Products
|--------------------------------------------------------------------------
| A function to add new products to the database.
| It provides validation for the user input
|
*/
	public function add_new_product(Request $request) {
		
		$this->validate($request, [
			'name' => 'required|alpha',
			'description' => 'required|regex:/^[\pL\s\-]+$/u',
			'price' => 'required|numeric'
			]);

		  $product = new Product([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            ]);

     $file = array('image' => Input::file('image'));

// check if image was uploaded
if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
    $product->save();
    return redirect()->route('index');
}
else

  	// getting all of the post data
      $destinationPath = 'uploads/products'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = $product->name . $product->id . '.' . $extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
      // sending back with message
     $product->image = $fileName;
     $product->save();

		return redirect()->route('index');
	}

/*
|--------------------------------------------------------------------------
| Delete Products
|--------------------------------------------------------------------------
| A function to delete products in the database.
|
*/
	public function delete_product(Request $request, $id) {
		
		$product = Product::find($id);

		Product::where('id', $id)->delete();

		return redirect()->route('index');
	}


/*
|--------------------------------------------------------------------------
| Update Products
|--------------------------------------------------------------------------
| A function update existing products in the database.
| It provides validation for the user input
|
*/

	public function post_edit_product(Request $request) {

		 $id = $request->input('id');
		 $product = Product::find($id);

		$this->validate($request, [
			'name' => 'required|alpha',
			'description' => 'required|regex:/^[\pL\s\-]+$/u',
			'price' => 'required|numeric'
			]);

		  $product->name = $request->input('name');
          $product->description = $request->input('description');
          $product->price =$request->input('price');
          

     $file = array('image' => Input::file('image'));

     if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
    $product->update();
    return redirect()->route('index');
}
else

      $destinationPath = 'uploads/products'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = $product->name . $product->id . '.' . $extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
      // sending back with message
     $product->image = $fileName;
     $product->update();

		return redirect()->route('index');
	}

}