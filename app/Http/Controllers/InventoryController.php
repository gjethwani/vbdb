<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;

class InventoryController extends Controller
{
    public function showInventory() {
      $allInventory = Inventory::all();
      //dd($allInventory->itemName);
      return view('inventory', [
        'inventory' => $allInventory
      ]);
    }
}
