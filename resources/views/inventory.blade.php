@extends('main-layout')
@section('title', 'Inventory')
@section('content')
  <form action='/vbdb/inventory' method='post' id='filterRules'>
    {{csrf_field()}}
    <input type='hidden' id='numberRuleTracker' name='numberRuleTracker' value='0'>
    <input type='hidden' id='textRuleTracker' name='textRuleTracker' value='0'>
    <button type='submit'>Submit</button>
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
  var numberRuleTracker = 0;
  var textRuleTracker = 0;
  function addNumberRule() {
    var fieldTag = document.createElement('select');
    fieldTag.name = 'numberField' + numberRuleTracker;
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
    operatorTag.name = 'numberOperator' + numberRuleTracker;
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
    valueTag.name = 'numberValue' + numberRuleTracker;
    valueTag.type = 'number';
    valueTag.value = 0;

    var divTag = document.createElement('div');
    divTag.classList.add('form-group');

    divTag.appendChild(fieldTag);
    divTag.appendChild(operatorTag);
    divTag.appendChild(valueTag);
    document.getElementById('filterRules').appendChild(divTag);
    numberRuleTracker++;
    document.getElementById('numberRuleTracker').value = numberRuleTracker;
  }

  function addTextRule() {
    var fieldTag = document.createElement('select');
    fieldTag.name = 'textField' + textRuleTracker;
    var categoryTag = document.createElement('option');
    categoryTag.innerHTML = 'Category';
    categoryTag.value = 'category';
    var brandTag = document.createElement('option');
    brandTag.innerHTML = 'Brand';
    brandTag.value = 'brand';
    var nameTag = document.createElement('option');
    nameTag.innerHTML = 'Name';
    nameTag.value = 'name';
    var paymentTag = document.createElement('option');
    paymentTag.innerHTML = 'Payment';
    paymentTag.value = 'payment';
    var colourTag = document.createElement('option');
    colourTag.innerHTML = 'Colour';
    colourTag.value = 'colour';
    var usSizeTag = document.createElement('option');
    usSizeTag.innerHTML = 'US Size';
    usSizeTag.value = 'usSize';
    var sourceTag = document.createElement('option');
    sourceTag.innerHTML = 'Source';
    sourceTag.value = 'source';
    var buyerTag = document.createElement('option');
    buyerTag.innerHTML = 'Buyer';
    buyerTag.value = 'buyer';
    var locationTag = document.createElement('option');
    locationTag.innerHTML = 'Location';
    locationTag.value = 'location';
    var notesTag = document.createElement('option');
    notesTag.innerHTML = 'Notes';
    notesTag.value = 'notes';
    var statusTag = document.createElement('option');
    statusTag.innerHTML = 'Status';
    statusTag.value = 'status';
    fieldTag.appendChild(categoryTag);
    fieldTag.appendChild(brandTag);
    fieldTag.appendChild(nameTag);
    fieldTag.appendChild(paymentTag);
    fieldTag.appendChild(colourTag);
    fieldTag.appendChild(usSizeTag);
    fieldTag.appendChild(sourceTag);
    fieldTag.appendChild(buyerTag);
    fieldTag.appendChild(locationTag);
    fieldTag.appendChild(notesTag);
    fieldTag.appendChild(statusTag);

    var operatorTag = document.createElement('select');
    operatorTag.name = 'textOperator' + textRuleTracker;
    var equalsTag = document.createElement('option');
    equalsTag.value = '=';
    equalsTag.innerHTML = '=';
    var containsTag = document.createElement('option');
    containsTag.value = 'contains';
    containsTag.innerHTML = 'Contains';
    operatorTag.appendChild(equalsTag);
    operatorTag.appendChild(containsTag);

    var valueTag = document.createElement('input');
    valueTag.name = 'textValue' + textRuleTracker;
    valueTag.type = 'text';

    var divTag = document.createElement('div');
    divTag.classList.add('form-group');

    divTag.appendChild(fieldTag);
    divTag.appendChild(operatorTag);
    divTag.appendChild(valueTag);
    document.getElementById('filterRules').appendChild(divTag);
    textRuleTracker++
    document.getElementById('textRuleTracker').value = textRuleTracker;
  }
</script>
