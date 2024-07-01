@extends('layouts.Layout')

@section('title', 'Carrito de Compras')

@section('style')
<link rel="stylesheet" href="/css/cart.css">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Carrito de Compras</h1>
    @if (count($cart) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($cart as $item)
                <div class="border border-gray-300 rounded-md p-4">
                    <h2 class="text-xl font-bold">{{ $item['name'] }}</h2>
                    <p class="text-gray-700">{{ $item['price'] }} Bs</p>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            <button class="bg-green-600 text-white px-4 py-2 rounded-md" id="checkout-button">Pagar</button>
        </div>
    @else
        <p>No hay productos en el carrito.</p>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('checkout-button').addEventListener('click', function () {
        window.location.href = '/payments/1';
    });
</script>
@endsection
