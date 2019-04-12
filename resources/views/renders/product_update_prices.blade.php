<thead>
<tr>
    @foreach($attributes as $attribute)
        <th>{{$attribute->name}}</th>
    @endforeach
    <th>{{ trans('product.stock') }}</th>
        <th>{{ trans('product.price') }}</th>
</tr>
</thead>
<tbody>
@foreach($combinations as $combination)
    <tr>
        @foreach($combination->combinations as $item)
            <td data-attribute-value-id="{{$item['id']}}">{{$item['value']}}</td>
        @endforeach
        <td><input type="number" class="product-stock" value="{{$combination->stock}}"/></td>
        <td><input type="number" class="product-price" value="{{$combination->price}}"/> &euro;</td>
    </tr>
@endforeach
</tbody>