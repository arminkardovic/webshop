@component('mail::message')
# You have created a new order

Order total price is {{ $order->total() }}

@component('mail::button', ['url' => url('/profile#orders')])
Check your orders
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
