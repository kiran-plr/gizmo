@push('styles')
    <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>
@endpush
<div>
    <form wire:submit.prevent='submit'>
        @csrf
        <div class="track-form">
            <h1>Track your shipment</h1>
            <p>Every mailer has a unique tracking number and barcode so you can track your package(s) online
                throughout the entire process. To track your shipment, simply enter your personal seven
                digit
                tracking code below:</p>
            <input @keyup.enter="$emit('submit')" type="text" wire:model.lazy='trackingNumber' name="tracking_number" autocomplete="off"
                class="dgwt-wcas-search-input">
            @error('trackingNumber')
                <div class="invalid-feedback" style="justify-content: center;">{{ $message }}</div>
            @enderror
        </div>
        <div class="tracking-form-loader" >
            <div class="spinner-border text-primary" role="status" wire:loading>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        @if ($trackingNumber && $this->html)
            <div id="tracking_results">
                {!! $this->html !!}
            </div>
        @endif
    </form>
</div>
