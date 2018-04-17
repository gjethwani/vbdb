<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use DB;

class InventoryController extends Controller
{
    public function showInventory() {
      $allInventory = Inventory::all();
      return view('inventory', [
        'inventory' => $allInventory
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
      $results = DB::select(DB::raw($query));
      return view('inventory', [
        'inventory' => $results
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
}
