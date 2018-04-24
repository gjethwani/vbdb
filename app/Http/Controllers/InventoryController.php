<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\User;
use Auth;
use DB;

class InventoryController extends Controller
{
    public function showInventory() {
      $allInventory = Inventory::all();
      return view('inventory', [
        'inventory' => $allInventory,
        'showAllInventoryButton' => false
      ]);
    }

    public function filterInventory(Request $request) {
      $numberRuleTracker = (int) $request->input('numberRuleTracker');
      $textRuleTracker = (int) $request->input('textRuleTracker');
      $query = 'SELECT * FROM inventory ';
      //numbers
      if ($numberRuleTracker != 0 || $textRuleTracker != 0) {
        $query = $query . ' WHERE ';
      }
      for ($i = 0; $i < $numberRuleTracker; $i++) {
        $fieldName = 'numberField' . $i;
        $operatorName = 'numberOperator' . $i;
        $valueName = 'numberValue' . $i;
        $query = $query . ' ' . $request->input($fieldName) . ' ' . $request->input($operatorName) . ' ' . $request->input($valueName);
        if ($i != $numberRuleTracker - 1) {
          $query = $query . ' AND ';
        }
      }
      if ($numberRuleTracker != 0 && $textRuleTracker != 0) {
        $query = $query . ' AND ';
      }
      //text
      for ($i = 0; $i < $textRuleTracker; $i++) {
        $fieldName = 'textField' . $i;
        $operatorName = 'textOperator' . $i;
        $valueName = 'textValue' . $i;
        $operator = $request->input($operatorName);
        if ($operator == '=') {
          $query = $query . $request->input($fieldName) . ' ' . $request->input($operatorName) . ' "' . $request->input($valueName) . '"';
        } else {
          $query = $query . $request->input($fieldName) . ' LIKE  "%' . $request->input($valueName) . '%"';
        }
        if ($i != $textRuleTracker - 1) {
          $query = $query . ' AND ';
        }
      }
      //dd($query);
      $results = DB::select(DB::raw($query));
      return view('inventory', [
        'inventory' => $results,
        'showAllInventoryButton' => true
      ]);
    }

    public function autocomplete(Request $request) {
      $column = $request->input('column');
      $term = $request->input('query');

      $results = array();

      $queries = DB::table('inventory')
        ->select($column)
        ->where($column, 'LIKE', '%'.$term.'%')
        ->take(5)->get();

      foreach ($queries as $query)
      {
          $results[] = [ 'suggestion' => $query];
      }
      return json_encode($results);
    }

    public function insert(Request $request) {
      $quantity = $request->input('quantity');
      for ($i = 0; $i < $quantity; $i++) {
          $newProduct = new Inventory;
          $newProduct->category = $request->input('category');
          $newProduct->brand = $request->input('brand');
          $newProduct->itemName = $request->input('itemName');
          $newProduct->payment = $request->input('payment');
          $newProduct->colour = $request->input('colour');
          $newProduct->usSize = $request->input('usSize');
          $newProduct->cost = $request->input('cost');
          $newProduct->source = $request->input('source');
          $newProduct->sellingPrice = $request->input('sellingPrice');
          $newProduct->profit = $request->input('profit');
          $newProduct->unrealisedSalesValue = $request->input('unrealisedSalesValue');
          $newProduct->realisedProfit = $request->input('realisedProfit');
          $newProduct->buyer = $request->input('buyer');
          $newProduct->location = $request->input('location');
          $newProduct->notes = $request->input('notes');
          $newProduct->distributed = $request->input('distributed');
          $newProduct->status = $request->input('status');
          $newProduct->updated_at = $request->input('updatedAt');
          $newProduct->created_at = $request->input('createdAt');
          //dd(Auth::user());
          //dd(Auth::id() . ' ' . User::find(Auth::id()));
          $newProduct->save();
      }
      return redirect('/vbdb/inventory');
    }

    public function delete($id) {
      DB::table('inventory')->where('id', '=', $id)->delete();
    }

    public function edit(Request $request, $id) {
      $toEdit = Inventory::find($id);
      if ($request->input('category') != null) {
        $toEdit->category = $request->input('category');
      }
      if ($request->input('brand') != null) {
        $toEdit->brand = $request->input('brand');
      }
      if ($request->input('itemName') != null) {
        $toEdit->itemName = $request->input('itemName');
      }
      if ($request->input('payment') != null) {
        //dd('here payment');
        $toEdit->payment = $request->input('payment');
      }
      if ($request->input('colour') != null) {
        $toEdit->colour = $request->input('colour');
      }
      if ($request->input('usSize') != null) {
        $toEdit->usSize = $request->input('usSize');
      }
      if ($request->input('cost') != null) {
        $toEdit->cost = $request->input('cost');
      }
      if ($request->input('source') != null) {
        $toEdit->source = $request->input('source');
      }
      if ($request->input('sellingPrice') != null) {
        $toEdit->sellingPrice = $request->input('sellingPrice');
      }
      if ($request->input('profit') != null) {
        $toEdit->profit = $request->input('profit');
      }
      if ($request->input('unrealisedSalesValue') != null) {
        $toEdit->unrealisedSalesValue = $request->input('unrealisedSalesValue');
      }
      if ($request->input('realisedProfit') != null) {
        $toEdit->realisedProfit = $request->input('realisedProfit');
      }
      if ($request->input('buyer') != null) {
        $toEdit->buyer = $request->input('buyer');
      }
      if ($request->input('location') != null) {
        $toEdit->location = $request->input('location');
      }
      if ($request->input('notes') != null) {
        $toEdit->notes = $request->input('notes');
      }
      if ($request->input('distributed') != null) {
        $toEdit->notes = $request->input('distributed');
      }
      if ($request->input('status') != null) {
        $toEdit->status = $request->input('status');
      }
      if ($request->input('updated_at') != null) {
        $toEdit->updated_at = $request->input('updated_at');
      }
      if ($request->input('created_at') != null) {
        $toEdit->created_at = $request->input('created_at');
      }
      $toEdit->save();
      //dd($toEdit->toArray());
      return json_encode(($toEdit->toArray()));
    }
}
