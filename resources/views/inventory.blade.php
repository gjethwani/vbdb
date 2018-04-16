@extends('main-layout')
@section('title', 'Inventory')
@section('content')
  <form id='filterRules'>
  </form>
  <button class='btn btn-primary' onclick='return addNumberRule();'>Add Number rule</button>
  <button class='btn btn-primary' onclick='return addTextRule();'>Add Text rule</button>
  <table class='table'>
    <tr>
      <th>Category</th>
      <th>Brand</th>
      <th>Name</th>
      <th>Payment</th>
      <th>Colour</th>
      <th>US Size</th>
      <th>Cost</th>
      <th>Source</th>
      <th>Selling Price</th>
      <th>Profit</th>
      <th>Unrealised Sales Value</th>
      <th>Realised Profit</th>
      <th>Buyer</th>
      <th>Location</th>
      <th>Notes</th>
      <th>Distributed</th>
      <th>Status</th>
      <th>Updated At</th>
      <th>Created At</th>
    </tr>
    @foreach ($inventory as $product)
      <tr>
        <td>
          @if (isset($product->category))
            {{$product->category}}
          @endif
        </td>
        <td>
          @if (isset($product->brand))
            {{$product->brand}}
          @endif
        </td>
        <td>{{$product->itemName}}</td>
        <td>{{$product->payment}}</td>
        <td>
          @if (isset($product->colour))
            {{$product->colour}}
          @endif
        </td>
        <td>{{$product->usSize}}</td>
        <td>{{$product->cost}}</td>
        <td>{{$product->source}}</td>
        <td>{{$product->sellingPrice}}</td>
        <td>{{$product->profit}}</td>
        <td>{{$product->unrealisedSalesValue}}</td>
        <td>{{$product->realisedProfit}}</td>
        <td>
          @if (isset($product->buyer))
            {{$product->buyer}}
          @endif
        </td>
        <td>
          @if (isset($product->location))
            {{$product->location}}
          @endif
        </td>
        <td>
          @if (isset($product->notes))
            {{$product->notes}}
          @endif
        </td>
        <td>{{$product->distributed}}</td>
        <td>{{$product->status}}</td>
        <td>
          @if (isset($product->updated_at))
            {{$product->updated_at}}
          @endif
        </td>
        <td>
          @if (isset($product->created_at))
            {{$product->created_at}}
          @endif
        </td>
      </tr>
    @endforeach
  </table>
@endsection
<script>
  function addNumberRule() {
    var fieldTag = document.createElement('select');
    var costTag = document.createElement('option');
    costTag.innerHTML = 'Cost';
    costTag.value = 'cost';
    var sellingPriceTag = document.createElement('option');
    sellingPriceTag.innerHTML = 'Selling Price';
    sellingPriceTag.value = 'sellingPrice';
    var profitTag = document.createElement('option');
    profitTag.innerHTML = 'Profit';
    profitTag.value = 'profit';
    var unrealisedTag = document.createElement('option');
    unrealisedTag.innerHTML = 'Unrealised Sales Value';
    unrealisedTag.value = 'unrealisedSalesValue';
    var realisedTag = document.createElement('option');
    realisedTag.innerHTML = 'Realised Profit';
    unrealisedTag.value = 'realisedProfit';
    fieldTag.appendChild(costTag);
    fieldTag.appendChild(sellingPriceTag);
    fieldTag.appendChild(profitTag);
    fieldTag.appendChild(unrealisedTag);
    fieldTag.appendChild(realisedTag);

    var operatorTag = document.createElement('select');
    var equalsTag = document.createElement('option');
    equalsTag.value = '=';
    equalsTag.innerHTML = '=';
    var smallerTag = document.createElement('option');
    smallerTag.value = '<';
    smallerTag.innerHTML = '<';
    var biggerTag = document.createElement('option');
    biggerTag.value = '>';
    biggerTag.innerHTML = '>';
    var smallerEqualsTag = document.createElement('option');
    smallerEqualsTag.value = '<=';
    smallerEqualsTag.innerHTML = '<=';
    var biggerEqualsTag = document.createElement('option');
    biggerEqualsTag.value = '>=';
    biggerEqualsTag.innerHTML = '>=';
    operatorTag.appendChild(equalsTag);
    operatorTag.appendChild(smallerTag);
    operatorTag.appendChild(biggerTag);
    operatorTag.appendChild(smallerEqualsTag);
    operatorTag.appendChild(biggerEqualsTag);

    var valueTag = document.createElement('input');
    valueTag.type = 'number';
    valueTag.name = 'value';
    valueTag.value = 0;

    var divTag = document.createElement('div');
    divTag.classList.add('form-group');

    divTag.appendChild(fieldTag);
    divTag.appendChild(operatorTag);
    divTag.appendChild(valueTag);
    document.getElementById('filterRules').appendChild(divTag);
  }
</script>
