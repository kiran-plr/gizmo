<section class="search-location-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="location-title">
                    @if (!$type)
                        <h2>Locations</h2>
                        <p>Search for city or Postal code, or <a href="javascript:;">browse the list of Locations</a></p>
                    @else
                        <h2>Retail Partners</h2>
                        <p>Search our list of retail partners by city or zip code.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="searchbar-location-row">
            <div class="row">
                <div class="col-md-4">
                    <div class="left-searchbar-wrapper">
                        <div class="">
                            <form>
                                <div class="p-1 bg-light rounded mt-3">
                                    <div class="input-group">
                                        <input type="search" id="searchLocation" placeholder="Search location"
                                            aria-describedby="button-addon1" class="form-control border-0 bg-light"
                                            wire:model='searchLoaction' onkeydown="return event.key != 'Enter';">
                                        <div class="input-group-append">
                                            <button id="button-addon1" type="button"
                                                class="btn btn-link text-primary"><i
                                                    class='bx bx-search-alt-2'></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <ul class="searched-add">
                            @foreach ($locationsArr as $key => $location)
                                <li @if (!$type) wire:click='selectLocation({{ $location['id'] }})' @endif
                                    class="{{ $locationId == $location['id'] ? 'active' : '' }}">
                                    <strong>{{ $location['name'] }}</strong>
                                    <span>{{ $location['address'] }}</span>
                                    <span>{{ $location['city'] . ', ' . $location['state'] . ' ' . $location['zip'] }}</span>
                                    <span>{{ $location['phone'] }}</span>
                                    <strong>{{ number_format($location['distance'], 2) }} miles away</strong>
                                </li>
                            @endforeach
                            @if (!$type && count($locationsArr) == 0 && $searchLoaction)
                                <div>
                                    <h5>
                                        Sorry, there are no locations in your area. Please click here to ship your item
                                    </h5>
                                    <a role="button" href="{{ route('cart') }}"
                                        class="btn btn-primary mt-2">Ship Your Item</a>
                                </div>
                            @elseif(count($locationsArr) == 0 && $searchLoaction)
                                <div>
                                    <h5>
                                        Sorry, there are no locations in your area.
                                    </h5>
                                </div>
                            @endif
                        </ul>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="map-wrapper">
                        <div class="mapouter">
                            <div class="gmap_canvas" wire:ignore id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6oocLsENVVTWHKooR4xHVVS-ILXsA274&language=en&libraries=places&z=9">
    </script>
    <script>
        var locations = [{
            active: "1",
            address: "398-376 Los Angeles St",
            address2: null,
            city: "Los Angeles",
            created_at: null,
            distance: 1.1137984642567578,
            email: "vendor@dev-team.net",
            geo_lat: "34.047486",
            geo_lng: "-118.245815",
            hours_of_opration: null,
            id: 546,
            name: "uBreakiFix",
            phone: "2122079292",
            state: "CA",
            updated_at: null,
            zip: "90013",
        }];

        var map;
        var marker;
        var markers = [];

        function retailerMapSetup() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(locations[0].geo_lat, locations[0].geo_lng),
                zoom: @this.zoom,
            });

            displayMarker();
        }

        function displayMarker() {
            var infoWindow = new google.maps.InfoWindow();
            if (locations) {
                for (var i = 0; i < locations.length; i++) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i].geo_lat, locations[i].geo_lng),
                        map: map
                    });
                    markers.push(marker);
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infoWindow.setContent(locations[i].name);
                            infoWindow.open(map, marker);
                        }
                    })(marker, i));
                }
            }
        }

        window.addEventListener('livewire:load', function() {
            var locationArr = @this.locationsArr;
            if (locationArr != undefined && locationArr.length > 0) {
                locations = locationArr;
            }
            retailerMapSetup();
        });

        window.addEventListener('locationFind', function() {
            var data = @this.locationsArr;
            locations = data;
            if (data != undefined && data.length > 0) {
                retailerMapSetup();
            }
        });

        // $('.searched-add').animate({
        //     scrollTop: $(".searched-add li.active").offset().top
        // }, 1000);
    </script>
@endpush
