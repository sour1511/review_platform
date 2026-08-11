async function initialize() {
    $('form').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    try {
        await google.maps.importLibrary('places');
        await google.maps.importLibrary('maps');
        await google.maps.importLibrary('marker');
    } catch (err) {
        console.error('Google Maps libraries failed to load', err);
        return;
    }

    bindMapInputs(document);
}

async function bindMapInputs(root) {
    if (typeof google === 'undefined' || !google.maps) {
        return;
    }

    const scope = root || document;
    const locationInputs = scope.querySelectorAll('.map-input');

    for (let i = 0; i < locationInputs.length; i++) {
        const input = locationInputs[i];
        if (input.dataset.placesBound === '1') {
            continue;
        }

        const fieldKey = input.id.replace(/-input$/, '');
        const latEl = document.getElementById(fieldKey + '-latitude');
        const lngEl = document.getElementById(fieldKey + '-longitude');
        const mapEl = document.getElementById(fieldKey + '-map');

        const isEdit = latEl && lngEl && latEl.value !== '' && lngEl.value !== '' &&
            latEl.value !== '0' && lngEl.value !== '0';
        const latitude = (latEl && parseFloat(latEl.value)) || -33.8688;
        const longitude = (lngEl && parseFloat(lngEl.value)) || 151.2195;
        const position = { lat: latitude, lng: longitude };

        let map = null;
        let marker = null;

        if (mapEl) {
            // mapId is required for AdvancedMarkerElement
            map = new google.maps.Map(mapEl, {
                center: position,
                zoom: 13,
                mapId: 'DEMO_MAP_ID'
            });

            marker = new google.maps.marker.AdvancedMarkerElement({
                map: isEdit ? map : null,
                position: position
            });
        }

        if (google.maps.places && google.maps.places.PlaceAutocompleteElement) {
            await attachPlaceAutocompleteElement(input, fieldKey, map, marker);
        } else if (google.maps.places && google.maps.places.Autocomplete) {
            attachLegacyAutocomplete(input, fieldKey, map, marker);
        } else {
            console.error('No Places Autocomplete API available. Enable Places API (New) in Google Cloud.');
        }

        input.dataset.placesBound = '1';
    }
}

function setMarkerPosition(marker, map, location) {
    if (!marker || !map || !location) {
        return;
    }
    marker.position = location;
    marker.map = map;
}

function fitMapToPlace(map, marker, place) {
    if (!map || !place || !place.location) {
        return;
    }
    if (place.viewport) {
        map.fitBounds(place.viewport);
    } else {
        map.setCenter(place.location);
        map.setZoom(17);
    }
    setMarkerPosition(marker, map, place.location);
}

async function attachPlaceAutocompleteElement(input, fieldKey, map, marker) {
    const options = {
        requestedLanguage: document.documentElement.lang || 'en',
    };

    // Bias suggestions toward the map viewport so results appear reliably
    if (map && typeof map.getBounds === 'function' && map.getBounds()) {
        options.locationBias = map.getBounds();
    } else if (map && typeof map.getCenter === 'function' && map.getCenter()) {
        options.locationBias = map.getCenter();
    }

    const placeAutocomplete = new google.maps.places.PlaceAutocompleteElement(options);

    placeAutocomplete.classList.add('map-place-autocomplete');
    placeAutocomplete.setAttribute('placeholder', input.getAttribute('placeholder') || 'Enter a location');

    // Prefer dedicated wrapper so layout stays stable next to the map
    let wrap = input.closest('.places-autocomplete-wrap');
    if (!wrap) {
        wrap = document.createElement('div');
        wrap.className = 'places-autocomplete-wrap';
        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);
    }

    // Keep original input for form posts / validation, hide visually
    input.type = 'hidden';
    input.removeAttribute('required');
    wrap.insertBefore(placeAutocomplete, input);

    if (input.value) {
        try {
            placeAutocomplete.value = input.value;
        } catch (e) { /* ignore */ }
    }

    async function handlePlaceSelect(event) {
        try {
            const placePrediction = event.placePrediction || (event.detail && event.detail.placePrediction);
            if (!placePrediction) {
                return;
            }

            const place = placePrediction.toPlace();
            await place.fetchFields({
                fields: ['displayName', 'formattedAddress', 'location', 'viewport', 'id']
            });

            const label = place.formattedAddress || place.displayName || '';
            input.value = label;
            try {
                placeAutocomplete.value = label;
            } catch (e) { /* ignore */ }

            if (place.location) {
                const lat = typeof place.location.lat === 'function' ? place.location.lat() : place.location.lat;
                const lng = typeof place.location.lng === 'function' ? place.location.lng() : place.location.lng;
                setLocationCoordinates(fieldKey, lat, lng);
                fitMapToPlace(map, marker, place);
            }
        } catch (err) {
            console.error('Place selection failed', err);
        }
    }

    placeAutocomplete.addEventListener('gmp-select', handlePlaceSelect);
    placeAutocomplete.addEventListener('gmp-placeselect', handlePlaceSelect);

    placeAutocomplete.addEventListener('input', function () {
        const raw = placeAutocomplete.value || placeAutocomplete.inputValue || '';
        if (typeof raw === 'string') {
            input.value = raw;
        }
    });
}

function attachLegacyAutocomplete(input, fieldKey, map, marker) {
    const geocoder = new google.maps.Geocoder();
    const autocomplete = new google.maps.places.Autocomplete(input, {
        fields: ['place_id', 'geometry', 'name', 'formatted_address']
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        const place = autocomplete.getPlace();
        if (!place || !place.geometry) {
            window.alert("No details available for input: '" + (place && place.name ? place.name : '') + "'");
            input.value = '';
            return;
        }

        if (place.formatted_address) {
            input.value = place.formatted_address;
        }

        if (place.place_id) {
            geocoder.geocode({ placeId: place.place_id }, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK && results[0]) {
                    setLocationCoordinates(
                        fieldKey,
                        results[0].geometry.location.lat(),
                        results[0].geometry.location.lng()
                    );
                }
            });
        } else {
            setLocationCoordinates(
                fieldKey,
                place.geometry.location.lat(),
                place.geometry.location.lng()
            );
        }

        if (map && marker && place.geometry) {
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            setMarkerPosition(marker, map, place.geometry.location);
        }
    });
}

function setLocationCoordinates(key, lat, lng) {
    const latitudeField = document.getElementById(key + '-latitude');
    const longitudeField = document.getElementById(key + '-longitude');
    if (latitudeField) {
        latitudeField.value = lat;
    }
    if (longitudeField) {
        longitudeField.value = lng;
    }
}

window.initialize = initialize;
window.bindMapInputs = bindMapInputs;
