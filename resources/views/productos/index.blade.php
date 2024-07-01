@extends('layouts.Layout')

@section('title', 'Lista de Productos')

@section('style')
<link rel="stylesheet" href="/css/products.css">
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = this.getAttribute('data-price');

                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: productId,
                        name: productName,
                        price: productPrice
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert('Error al agregar el producto al carrito');
                    }
                });
            });
        });
    });
</script>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Lista de Productos</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div class="border border-gray-300 rounded-md p-4">
            <h2 class="text-xl font-bold">Producto 1</h2>
            <p class="text-gray-700">100 Bs</p>
            <button class="add-to-cart mt-4 bg-blue-600 text-white px-4 py-2 rounded-md"
                    data-id="1" data-name="Producto 1" data-price="100">
                Agregar al Carrito
            </button>
        </div>
        <div class="border border-gray-300 rounded-md p-4">
            <h2 class="text-xl font-bold">Producto 2</h2>
            <p class="text-gray-700">200 Bs</p>
            <button class="add-to-cart mt-4 bg-blue-600 text-white px-4 py-2 rounded-md"
                    data-id="2" data-name="Producto 2" data-price="200">
                Agregar al Carrito
            </button>
        </div>
        <div class="border border-gray-300 rounded-md p-4">
            <h2 class="text-xl font-bold">Producto 3</h2>
            <p class="text-gray-700">300 Bs</p>
            <button class="add-to-cart mt-4 bg-blue-600 text-white px-4 py-2 rounded-md"
                    data-id="3" data-name="Producto 3" data-price="300">
                Agregar al Carrito
            </button>
        </div>
        <div class="border border-gray-300 rounded-md p-4">
            <h2 class="text-xl font-bold">Producto 4</h2>
            <p class="text-gray-700">400 Bs</p>
            <button class="add-to-cart mt-4 bg-blue-600 text-white px-4 py-2 rounded-md"
                    data-id="4" data-name="Producto 4" data-price="400">
                Agregar al Carrito
            </button>
        </div>
    </div>
</div>
@endsection
