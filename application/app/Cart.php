<?php

namespace App;

class Cart
{
	public $items = null;
	public $total_quantity = 0;
	public $total_price = 0;

	public function __construct($old_cart){

				// checks if a cart already exists
			if ($old_cart) {
				$this->items = $old_cart->items;
				$this->total_quantity = $old_cart->total_quantity;
				$this->total_price = $old_cart->total_price;
			} 
	}

	public function add($item, $id){
		$stored_item = ['quantity' => 0, 'price' => $item->price, 'item' => $item];
		
		if ($this->items) {
				//check if item already exist in cart array
			if (array_key_exists($id, $this->items)) {
				$stored_item = $this->items[$id];
			}
		}
				//increases quantity and increases price to match
			$stored_item['quantity']++; 
			$stored_item['price'] = $item->price * $stored_item['quantity'];
				//updates total price and total quantity
			$this->items[$id] = $stored_item;
			$this->total_quantity++;
			$this->total_price += $item->price;
		
	}

		public function remove($item, $id){
		$stored_item = ['quantity' => 0, 'price' => $item->price, 'item' => $item];
		
		if ($this->items) {
				//check if item already exist in cart array
			if (array_key_exists($id, $this->items)) {
				$stored_item = $this->items[$id];
			}
		}
				//increases quantity and increases price to match
			$stored_item['quantity']--; 
			$stored_item['price'] = $item->price * $stored_item['quantity'];
				//updates total price and total quantity
			$this->items[$id] = $stored_item;
			$this->total_quantity--;
			$this->total_price -= $item->price;
		
	}


  

}
