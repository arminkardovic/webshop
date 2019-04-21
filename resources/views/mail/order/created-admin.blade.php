@component('mail::message')
# A new order has been created

Order total price is {{ $order->total() }}

@component('mail::button', ['url' => url('/admin/orders/' . $order->id)])
Check it
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
