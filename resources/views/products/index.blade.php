@include('_layouts.header')

<script src="{{ asset('assets/js/products.js') }}"></script>

<div x-data="initProducts()" x-init="init()" class="bg-white p-4">

    @include('products.section.list_product')

</div>

@include('_layouts.footer')