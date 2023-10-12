<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-with-filter d-flex justify-content-between align-items-center mb-3">
                    <h2 class="prod-title">
                        Sell Your iPhone
                        <span>Answer a few questions to receive an instant quote.</span>
                    </h2>
                    {{-- <div class="form-group">
                        <select class="form-control">
                            <option>All devices</option>
                            <option>Old devices</option>
                            <option>New devices</option>
                            <option>Reused devices</option>
                        </select>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($this->products as $key => $product)
                <div class="col-md-4 col-sm-6 sell-iphone-product" wire:click='selectProduct({{ $product->id }})'>
                    <div class="prod-box">
                        <img class="m-auto d-block prod-img"
                            src="{{ asset('/assets/images/home/iphone-12-black-4.png') }}" alt="">
                        <div class="prod-disc-area">
                            <h4 class="mt-4">{{ $product->name }}</h4>
                            <h4 class="start-price">Starting from
                                <span>${{ number_format($product->skuMaxPrice(), 2) }}</span>
                            </h4>
                            <p>Get it in 2 days</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- <div class="row">
            <div class="col-md-12 col-sm-6 text-center">
                <button type="button" class="btn btn-primary mt-4" wire:click='loadMore' wire:loading.class='disable-button'>
                    <div wire:loading wire:target="loadMore" class="spinner-border text-light spinner-button"
                        role="status" aria-hidden="true"></div>
                    <div wire:loading.remove wire:target="loadMore">Load More</div>
                </button>
            </div>
        </div> --}}
    </div>
</div>
