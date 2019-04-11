<thead>
<tr>
    @foreach($attributes as $attribute)
        <th>{{$attribute->name}}</th>
    @endforeach
    <th>Stock</th>
    <th>Price</th>
</tr>
</thead>
<tbody>
@foreach($combinations as $combination)
    <tr>
        @foreach($combination as $item)
            <td data-attribute-value-id="{{$item['id']}}">{{$item['value']}}</td>
        @endforeach
        <td><input type="number" class="product-stock" value="0"/></td>
        <td><input type="number" class="product-price" value="0"/> &euro;</td>
    </tr>
@endforeach
</tbody>