
<div id="promoCarousel" class="carousel slide mb-4 shadow-sm rounded" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach($featuredProducts as $index => $product)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="d-flex align-items-center justify-content-center bg-dark text-white" style="height: 300px;">
                    <div class="text-center">
                        <h2>АКЦІЯ: {{ $product->name }}</h2>
                        <a href="#" class="btn btn-warning">Купити</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>