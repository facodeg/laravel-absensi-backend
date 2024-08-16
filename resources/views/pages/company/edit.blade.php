@extends('layouts.app')

@section('title', 'Users')


@section('main')

    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <form action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data" method="POST"
                    class="dropzone needsclick" id="dropzone-basic">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        <h5 class="mb-3">Users</h5>
                        <div class="row mb-3">
                            <label for="input49" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $company->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input51" class="col-sm-3 col-form-label">Email Address</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ $company->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input51" class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map'></i></span>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" value="{{ $company->address }}">
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input51" class="col-sm-3 col-form-label">Latitude</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map-pin'></i></span>
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                        name="latitude" value="{{ $company->latitude }}">
                                    @error('latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input51" class="col-sm-3 col-form-label">Longitude</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map-pin'></i></span>
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        name="longitude" value="{{ $company->longitude }}">
                                    @error('longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input51" class="col-sm-3 col-form-label">Radius (in km)</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map-pin'></i></span>
                                    <input type="number" step="0.01" class="form-control @error('radius_km') is-invalid @enderror"
                                        name="radius_km" value="{{ $company->radius_km }}">
                                    @error('radius_km')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input51" class="col-sm-3 col-form-label">Time In</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-time'></i></span>
                                    <input type="time" class="form-control @error('time_in') is-invalid @enderror"
                                        name="time_in" value="{{ $company->time_in }}">
                                    @error('time_in')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input51" class="col-sm-3 col-form-label">Time Out</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-time'></i></span>
                                    <input type="time" class="form-control @error('time_out') is-invalid @enderror"
                                        name="time_out" value="{{ $company->time_out }}">
                                    @error('time_out')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Map</label>
                            <div class="col-sm-9">
                                <div id="map" style="height: 300px;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button class="btn btn-primary px-4">Submit</button>
                                    <button type="button" class="btn btn-light px-4">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Menyertakan Leaflet.js dan CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    // Inisialisasi peta menggunakan OpenStreetMap
    var map = L.map('map').setView([{{ $company->latitude }}, {{ $company->longitude }}], 16);

    // Tambahkan tile layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Menambahkan popup yang muncul saat peta diklik
    var popup = L.popup();

    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
    }

    map.on('click', onMapClick);

    // Tambahkan marker dan lingkaran radius
    var marker = L.marker([{{ $company->latitude }}, {{ $company->longitude }}], {
        draggable: true
    }).addTo(map);

    var circle = L.circle([{{ $company->latitude }}, {{ $company->longitude }}], {
        color: 'red',
        radius: {{ $company->radius_km }} * 1000 // Mengubah km ke meter
    }).addTo(map);

    // Event handler untuk marker drag
    marker.on('dragend', function (e) {
        var position = marker.getLatLng();
        marker.setLatLng(position, {draggable: 'true'}).bindPopup(position).update();
        $('input[name="latitude"]').val(position.lat).trigger('change');
        $('input[name="longitude"]').val(position.lng).trigger('change');
        circle.setLatLng(position);
    });

    // Event handler untuk perubahan radius
    $('input[name="radius_km"]').on('input', function () {
        var radius = $(this).val() * 1000; // Mengubah km ke meter
        circle.setRadius(radius);
    });

    // Event handler untuk perubahan latitude/longitude
    $('input[name="latitude"], input[name="longitude"]').on('input', function () {
        var lat = $('input[name="latitude"]').val();
        var lng = $('input[name="longitude"]').val();
        var latlng = L.latLng(lat, lng);
        marker.setLatLng(latlng).update();
        map.setView(latlng, map.getZoom()); // Memperbarui tampilan peta
        circle.setLatLng(latlng);
    });

    // Event handler untuk klik pada peta
    map.on('click', function (e) {
        var latlng = e.latlng;
        marker.setLatLng(latlng).update();
        circle.setLatLng(latlng);
        $('input[name="latitude"]').val(latlng.lat).trigger('change');
        $('input[name="longitude"]').val(latlng.lng).trigger('change');
    });


</script>


@endsection
