@extends('layouts.Layout')

@section('title', 'Pago Exitoso')

@section('style')
<link rel="stylesheet" href="/css/stripe.css">

@endsection

@section('content')
<style>
    .success-message {
        background-color: #e7f9e7;
        border: 1px solid #4caf50;
        color: #4caf50;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
        margin-top: 50px;
    }
    .success-icon {
        font-size: 50px;
        margin-bottom: 20px;
    }
    .btn-home {
        background-color: #4caf50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px;
        display: inline-block;
        margin-top: 20px;
    }
    .btn-home:hover {
        background-color: #45a049;
    }
</style>
<div class="container mx-auto">
    <div class="success-message">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="text-2xl font-bold">Pago Realizado con Éxito</h1>
        <p class="mt-2">¡Gracias por tu compra! Tu pago ha sido procesado correctamente.</p>
        <a href="/cart" class="btn-home">Volver al Inicio</a>
    </div>
</div>
@endsection
