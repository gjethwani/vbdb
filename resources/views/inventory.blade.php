@extends('main-layout')
@section('title', 'Inventory')
@section('content')
  <style>
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }
    .show {
      display:block;
    }
    .dropdown-content p:hover {
      background-color: #ddd;
    }
  </style>
  @if ($showAllInventoryButton)
    <div>
      <button style='float: right' class='btn btn-primary'><a href='/vbdb/inventory' style='color:white;text-decoration: none;'>Show All Inventory</a></button>
    </div>
  @endif
  <button class='btn btn-primary' onclick='return scrollToBottom();' style='position: fixed'>Scroll To Top</button>
  <button class='btn btn-primary' onclick='return scrollToTop();' style='position: fixed; margin-left: 127px;'>Scroll To Bottom</button>
  <form action='/vbdb/inventory' method='post' id='filterForm' style='display: inline-block; margin-top: 50px;'>
    {{csrf_field()}}
    <input type='hidden' id='numberRuleTracker' name='numberRuleTracker' value='0'>
    <input type='hidden' id='textRuleTracker' name='textRuleTracker' value='0'>
    <div id='filterRules'>
    </div>
    <button type='submit'>Submit</button>
    <button class='btn btn-primary' onclick='return addNumberRule();'type='button'>Add Number rule</button>
    <button class='btn btn-primary' onclick='return addTextRule();' type='button'>Add Text rule</button>
  </form>
  <table class='table'>
    <tr>
      <th id='category'>Category</th>
      <th id='brand'>Brand</th>
      <th id='itemName'>Name</th>
      <th id='payment'>Payment</th>
      <th id='colour'>Colour</th>
      <th id='usSize'>US Size</th>
      <th id='cost'>Cost</th>
      <th id='source'>Source</th>
      <th id='sellingPrice'>Selling Price</th>
      <th id='profit'>Profit</th>
      <th id='unrealisedSalesProfit'>Unrealised Sales Value</th>
      <th id='realisedProfit'>Realised Profit</th>
      <th id='buyer'>Buyer</th>
      <th id='location'>Location</th>
      <th id='notes'>Notes</th>
      <th id='distributed'>Distributed</th>
      <th id='status'>Status</th>
      <th id='updated_at'>Updated At</th>
      <th id='created_at'>Created At</th>
      <th>Action</th>
    </tr>
    @foreach ($inventory as $product)
      <tr id='{{$product->id}}'>
        <!--<form id='editForm'>-->
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
          <td>
            @if (isset($product->distributed))
              {{$product->distributed}}
            @endif
          </td>
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
          <td>
          <button class='btn btn-primary' type='button' onclick='return submitEdit({{$product->id}})' style='display: none;'>Save</button>
        <!--</form>-->
          <button class='btn btn-primary' onclick='return editRow({{$product->id}})'>Edit</button>
          <button class='btn btn-primary' onclick='return deleteRow({{$product->id}})'>Delete</button>
        </td>
      </tr>
    @endforeach
    <tr>
      <form action='/vbdb/insert' method='post' autocomplete='off'>
        {{csrf_field()}}
        <td> <!-- category -->
          <input type='text' name='category' id='category' class='input'>
          <div id='categoryAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- brand -->
          <input type='text' name='brand' id='brand' class='input'>
          <div id='brandAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- name -->
          <input type='text' name='itemName' id='itemName' class='input'>
          <div id='itemNameAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- payment -->
          <input type='text' name='payment' id='payment' class='input'>
          <div id='paymentAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- colour -->
          <input type='text' name='colour' id='colour' class='input'>
          <div id='colourAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- US Size -->
          <input type='text' name='usSize'>
        </td>
        <td> <!-- cost -->
          <input type='number' name='cost'>
        </td>
        <td> <!-- source -->
          <input type='text' name='source' id='source' class='input'>
          <div id='sourceAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- selling price -->
          <input type='number' name='sellingPrice'>
        </td>
        <td> <!-- profit -->
          <input type='number' name='profit'>
        </td>
        <td> <!-- unrealised sales value -->
          <input type='number' name='unrealisedSalesValue'>
        </td>
        <td> <!-- realised profit -->
          <input type='number' name='realisedProfit'>
        </td>
        <td> <!-- buyer -->
          <input type='text' name='buyer' id='buyer' class='input'>
          <div id='buyerAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- location -->
          <input type='text' name='location' id='location' class='input'>
          <div id='locationAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- notes -->
          <input type='text' name='notes' id='notes' class='input'>
          <div id='notesAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- distributed -->
          <input type='text' name='distributed'>
        </td>
        <td> <!-- status -->
          <input type='text' name='status' id='status' class='input'>
          <div id='statusAutoComplete' class='dropdown-content'></div>
        </td>
        <td> <!-- updated at -->
          <input type='text' name='updatedAt'>
        </td>
        <td> <!-- created at -->
          <input type='text' name='createdAt'>
        </td>
        <td> <!-- action -->
          <input type='number' name='quantity'>
          <button class='btn btn-primary'>Insert</button>
        </td>
      </form>
    </tr>
  </table>
  <script> <!-- deleting code -->
    function deleteRow(id) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Typical action to be performed when the document is ready:
          document.getElementById(id).style.display = 'none';
        }
      };
      xhttp.open('GET', '/vbdb/delete/' + id, true);
      xhttp.send();
    }
  </script>
  <script> <!-- editing code -->
    var currentlyEditing = false;
    function editRow(id) {
        if (currentlyEditing) {
          return;
        }
        currentlyEditing = true;
        var tr = document.getElementById(id);
        for (var j = 0, col; col = tr.cells[j]; j++) {
          //iterate through columns
          //columns would be accessed using the "col" variable assigned in the for loop
          var children = col.children;
          if (children.length != 3) {
            var value = col.innerHTML.trim();
            if (j == 6 || j == 8 || j == 9 || j == 10 || j == 11) {
              col.innerHTML = '<input type="number" value="' + value + '" id="edit' + col.parentElement.parentElement.children[0].children[j].id  + '" onchange="return fieldChanged(`' + col.parentElement.parentElement.children[0].children[j].id + '`)">'; //big name statement access column headers
            } else {
              col.innerHTML = '<input type="text" value="' + value + '" id="edit' + col.parentElement.parentElement.children[0].children[j].id  + '" onchange="return fieldChanged(`' + col.parentElement.parentElement.children[0].children[j].id + '`)">';
            }
        } else {
          children[0].style.display = 'inline-block';
          children[1].style.display = 'none';
        }
      }
    }

    var changedFields = new Set();

    function fieldChanged(field) {
      changedFields.add(field);
    }

    function submitEdit(id) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            currentlyEditing = false;
             // Typical action to be performed when the document is ready:
             var response = JSON.parse(xhttp.responseText);
             var tr = document.getElementById(id);
             for (var j = 0, col; col = tr.cells[j]; j++) { //iterate through cells
               if (col.children.length === 3) {
                 col.children[0].style.display = 'none';
                 col.children[1].style.display = 'inline-block';
               } else {
                 var tdId = col.children[0].id;
                 col.innerHTML = response[tdId.substring(4)];
               }

               //iterate through columns
               //columns would be accessed using the "col" variable assigned in the for loop
               /*var children = col.children
               var i = 1;
               for (var key in response) { //iterate through json response
                 //console.log('here');
                 if (children.length == 3) {
                   children[0].style.display = 'none';
                   children[1].style.display = 'block';
                 }
                 if (response.hasOwnProperty(key)) {
                   if (key === 'id' || key === 'toWhack') {
                     continue;
                   } else {
                     children[i].innerHTML = response[key];
                   }
                   i++;
                   //console.log(key + " -> " + newObject[key]);
                 }
               }*/
            /*   if (children.length != 3) {
                 col.innerHTML = response[i];
               }*/
             }
          }
      };
      /*var category = form.elements.namedItem('category');
      var brand = form.elements.namedItem('brand');
      var itemName = form.elements.namedItem('itemName');
      var payment = form.elements.namedItem('payment');
      var colour = form.elements.namedItem('colour');
      var usSize = form.elements.namedItem('usSize');
      var cost = form.elements.namedItem('cost');
      var source = form.elements.namedItem('source');
      var sellingPrice = form.elements.namedItem('sellingPrice');
      var profit = form.elements.namedItem('profit');
      var unrealisedSalesValue = form.elements.namedItem('unrealisedSalesValue');
      var realisedProfit = form.elements.namedItem('realisedProfit');
      var buyer = form.elements.namedItem('buyer');
      var location = form.elements.namedItem('location');
      var notes = form.elements.namedItem('notes');
      var distributed = form.elements.namedItem('distributed');*/
      var url = '/vbdb/edit/' + id + '?';
      var changedFieldsIterator = changedFields.values();
      if (changedFields.size > 0) {
        for (var i = 0; i < changedFields.size; i++) {
          var currValue = changedFieldsIterator.next().value;
          var fieldId = 'edit' + currValue;
          url += currValue
          url += '=';
          if (document.getElementById(fieldId).value == null) {
            url += '%20';
          } else {
            url += document.getElementById(fieldId).value;
          }
          url += '&';
        }
      }
      url += '_token='
      url += '{{csrf_token()}}';
      xhttp.open('GET', url, true);
      xhttp.send();
    }
  </script>
  <script> <!-- drop down code -->
    var allData = JSON.parse('{!! json_encode($inventory) !!}');
    function autocomplete(column, query) {
      var toReturn = [];
      for (var i = 0; i < allData.length; i++) {
      //  console.log(allData[i][column]);
        if (allData[i][column] != null && (allData[i][column].toLowerCase()).indexOf(query.toLowerCase()) !== -1) {
          if (!toReturn.includes(allData[i][column])) {
            toReturn.push(allData[i][column]);
          }
        }
      }
    //  console.log(toReturn);
      var dropDown = document.getElementById(column + 'AutoComplete');
      dropDown.innerHTML = '';
      for (var i = 0; i < toReturn.length; i++) {
        var dropDownOption = document.createElement('p');
        dropDownOption.innerHTML = toReturn[i];
        var temp = toReturn[i];
        dropDownOption.onclick = (event) => {
          if (document.getElementById(column + 'AutoComplete').classList.contains('show')) {
            document.getElementById(column).value = event.path[0].innerHTML;
          }
        };
        dropDown.appendChild(dropDownOption);
      }
      showAutocompleteDropdown(column);
      return toReturn;
    }
    document.getElementById('category').oninput = function() {
      return autocomplete('category',document.getElementById('category').value);
    };
    document.getElementById('brand').oninput = function() {
      return autocomplete('brand',document.getElementById('brand').value);
    };
    document.getElementById('itemName').oninput = function() {
      return autocomplete('itemName',document.getElementById('itemName').value);
    };
    document.getElementById('payment').oninput = function() {
      return autocomplete('payment',document.getElementById('payment').value);
    };
    document.getElementById('colour').oninput = function() {
      return autocomplete('colour',document.getElementById('colour').value);
    };
    document.getElementById('source').oninput = function() {
      return autocomplete('source',document.getElementById('source').value);
    };
    document.getElementById('buyer').oninput = function() {
      return autocomplete('buyer',document.getElementById('buyer').value);
    };
    document.getElementById('location').oninput = function() {
      return autocomplete('location',document.getElementById('location').value);
    };
    document.getElementById('notes').oninput = function() {
      return autocomplete('notes',document.getElementById('notes').value);
    };
    document.getElementById('status').oninput = function() {
      return autocomplete('status',document.getElementById('status').value);
    };
    function showAutocompleteDropdown(column) {
      if (!document.getElementById(column + 'AutoComplete').classList.contains('show')) {
        document.getElementById(column + 'AutoComplete').classList.add('show');
      }

    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.input')) {

        var dropdowns = document.getElementsByClassName('dropdown-content');
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    };


    /* DELETE */
  </script>
@endsection
<script> <!-- Code for filter rules -->
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

    var deleteButton = document.createElement('button');
    deleteButton.innerHTML = 'Delete';
    deleteButton.onclick = function(event) {
      event.preventDefault();
      this.parentElement.style.display = 'none';
      numberRuleTracker--;
      document.getElementById('numberRuleTracker').value = numberRuleTracker;
    };

    var divTag = document.createElement('div');
    divTag.classList.add('form-group');

    divTag.appendChild(fieldTag);
    divTag.appendChild(operatorTag);
    divTag.appendChild(valueTag);
    divTag.appendChild(deleteButton);
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
    nameTag.value = 'itemName';
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

    var deleteButton = document.createElement('button');
    deleteButton.innerHTML = 'Delete';
    deleteButton.onclick = function(event) {
      event.preventDefault();
      this.parentElement.style.display = 'none';
      textRuleTracker--;
      document.getElementById('textRuleTracker').value = textRuleTracker;
      var parent = document.getElementById('filterRules');
      parent.removeChild(this.parentNode);
      //var field =
    };

    var divTag = document.createElement('div');
    divTag.classList.add('form-group');

    divTag.appendChild(fieldTag);
    divTag.appendChild(operatorTag);
    divTag.appendChild(valueTag);
    divTag.appendChild(deleteButton);
    document.getElementById('filterRules').appendChild(divTag);
    textRuleTracker++
    document.getElementById('textRuleTracker').value = textRuleTracker;
  }

  function scrollToBottom() {
    window.scrollTo(0, 0);
  }

  function scrollToTop() {
    window.scrollTo(0,document.body.scrollHeight);
  }
</script>
