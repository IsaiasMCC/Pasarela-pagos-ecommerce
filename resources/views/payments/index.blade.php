@extends('layouts.Layout')

@section('title', 'Métodos de Pago')

@section('styles')
<link rel="stylesheet" href="/css/stripe.css">
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethodRadios = document.querySelectorAll('input[name="paymentMethod"]');
        const qrPartial = document.getElementById('qrPartial');
        const paymentForm = document.getElementById('paymentForm');
        const paymentButton = document.getElementById('paymentButton');
        const loadingOverlay = document.getElementById('loadingOverlay');

        paymentMethodRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'paypal') {
                    qrPartial.classList.add('hidden');
                    paymentForm.setAttribute('action', '{{ route('payment.paypal') }}');
                } else {

                    if (this.value === 'qr') {
                        qrPartial.classList.remove('hidden');
                        paymentForm.setAttribute('action', '{{ route('payment.qr') }}');
                    } else {
                        qrPartial.classList.add('hidden');
                        paymentForm.setAttribute('action', '{{ route('payment.card') }}');
                    }
                }
            });
        });

        paymentButton.addEventListener('click', function () {
            const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

            if (true) {
                loadingOverlay.style.display = 'flex';
                this.disabled = true;
                setTimeout(() => {
                    paymentForm.submit();
                }, 1000); // Simular un retraso de 2 segundos antes de enviar el formulario
            } else {
                this.disabled = true;
                paymentForm.submit();
            }
        });
    });
</script>
@endsection

@section('content')

<div class="flex m-28">
    <div class="w-1/2 px-10">
        <p class="text-2xl font-bold">Pagar</p>
        <p class="text-xl font-semibold my-3">Dirección de facturación</p>
        <select name="" id="" class="w-full border border-black/50 rounded-md p-2 mb-5">
            <option value="">Bolivia</option>
        </select>
        <p class="text-2xl font-bold">Método de pago</p>
        <div class="mt-3">
            <div class="border-2 border-black/50 rounded-md p-2 flex">
                <input type="radio" value="card" name="paymentMethod" class="mr-1" />
                <img src="https://www.udemy.com/staticx/udemy/images/v9/card-default.svg" alt="tarjeta de crédito"
                    width="40px">
                <p class="ml-2">Tarjeta de crédito</p>
            </div>
            <div class="border-2 border-black/50 rounded-md p-2 flex mt-3">
                <input type="radio" value="qr" name="paymentMethod" class="mr-3" />
                <img src="https://static.vecteezy.com/system/resources/previews/009/326/729/non_2x/qr-code-icon-on-white-background-flat-style-qr-code-icon-for-your-web-site-design-logo-app-ui-digital-code-easy-pay-symbol-digital-data-sign-for-scanners-vector.jpg"
                    alt="QR" width="20px">
                <p class="ml-4">QR</p>
            </div>
            <div id="qrPartial" class="hidden mt-5">
                @include('payments.partials.qr')
            </div>
            <div class="border-2 border-black/50 rounded-md p-2 flex mt-3">
                <input type="radio" value="paypal" name="paymentMethod" class="mr-1" />
                <img src="https://www.udemy.com/staticx/udemy/images/v9/hpp-paypal.svg" alt="paypal" width="40px">
                <p class="ml-2">PayPal</p>
            </div>
        </div>
    </div>
    <div class="w-1/2 px-10">
        <form id="paymentForm" action="{{ route('payment.card') }}" class="bg-gray-200 px-20 py-10" method="POST">
            @csrf
            @method('POST')
            <input type="number" name="total" value="{{ $total }}" hidden>
            <p class="text-2xl font-bold">Resumen</p>
            <div class="flex justify-between mt-4">
                <p>Precio original:</p>
                <p>{{ $total }} Bs.</p>
            </div>
            <hr class="my-2 border-gray-500">
            <div class="flex justify-between font-semibold text-xl text-gray-700">
                <p>Total</p>
                <p>{{ $total }} Bs.</p>
            </div>
            <p class="my-5 text-sm">Al completar la compra, aceptas estas Condiciones de uso.</p>
            <button type="button" id="paymentButton"
                class="bg-blue-700 w-full p-3 rounded-md text-white text-lg hover:bg-blue-600">Completar
                Pago</button>
        </form>
    </div>
</div>
<div id="loadingOverlay" class="loading-overlay">
    <div class="spinner"></div>
</div>
@endsection
