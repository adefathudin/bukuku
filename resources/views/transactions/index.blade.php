@include('_layouts.header')
<script src="{{ asset('assets/js/transaction.js') }}"></script>
<div class="flex-grow flex" x-data="initApp()" x-init="onLoad()">
    @include('transactions.section.list_products')
    <div class="w-4/12 bg-blue-gray-50 bg-white pl-2">
        <div class="bg-white flex flex-col min-h-screen min-w-full max-h-screen ">
            @include('transactions.section.cart')
            @include('transactions.section.payment')
        </div>
    </div>
    @include('transactions.section.receipt')
</div>

@include('_layouts.footer')