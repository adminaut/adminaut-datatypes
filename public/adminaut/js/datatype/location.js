jQuery.fn.locationDatatype = function() {
    var $datatype = $(this);
    this.data = $datatype.data();

    this.useHiddenElement = this.data.useHiddenElement;
    this.saveAs = this.data.saveAs;
    this.separator = this.data.separator;
    this.engine = this.data.engine;
    this.$mainInput = $('input[name="'+ this.data.mainInput +'"]');
    this.$searchInput = $datatype.find('.search-input');
    this.readOnly = this.data.readonly;
    this.value = this.data.value;

    if(this.data.longitudeElement) {
        this.$longitudeElement = $('input[name="'+ this.data.longitudeElementName +'"]');
    }

    if(this.engine === 'google') {
        this.googleMode = this.data.googleMode;
        this.googlePlaceFilter = this.data.googlePlaceFilter;

        console.log(this.data, this.data.$googlePlaceIdElementName);
        if(this.data.googlePlaceIdElementName) {
            this.$googlePlaceIdElement = $('input[name="'+ this.data.googlePlaceIdElementName +'"]');
        }
    }

    this.map = null;
    this.marker = null;
    this.useGeoLocation = false;

    this.init = function() {
        var $datatype = $(this);
        this.prepareContainer();
        this.map = new google.maps.Map($(this).find('.datatype-location-map-container')[0]);
        var value = this.getValue();
        if(typeof(value.latitude) === 'number' && typeof(value.longitude) === 'number' ) {
            this.placeMarker(value);
            this.setCenter(value);
            this.setZoom(18);
        } else {
            // TODO: default center by config
            this.setCenter({latitude: 0, longitude: 0});
            this.setZoom(4);
        }

        if(!this.readOnly) {
            this.initSearch();
            this.initClickListener();
        }
    };

    this.prepareContainer = function() {

        var $renderInput = $('<div class="row"></div>');
        console.log(this);
        if(!this.readonly) {
            $renderInput.append($('<div class="col-xs-6"></div>').append(this.$mainInput.addClass('form-control')));
            if (this.$longitudeElement) {
                $renderInput.append($('<div class="col-xs-6"></div>').append(this.$longitudeElement.addClass('form-control')));
            }
        }

        var $renderMap = $('<div class="row"></div>');
        var $mapContainer = $('<div class="datatype-location-map-container" style="margin-top: 15px; min-height: 300px;"></div>').appendTo($renderMap);
        if(!this.readOnly) {
            $mapContainer.append(this.$searchInput);
        }
        // var $renderMap = $('<div class="row"><div class="col-xs-12"><div class="datatype-location-map-container" style="margin-top: 15px; min-height: 300px;">' +  + '</div></div></div>')
        $(this).html($renderInput).append($renderMap);
    };

    this.setCenter = function(location) {
        if(this.engine === 'google') {
            this.map.setCenter({lat: location.latitude, lng: location.longitude});
        }
    };

    this.placeMarker = function(location) {
        if(this.engine === 'google') {
            if (this.marker === null) {
                this.marker = new google.maps.Marker({
                    position: {lat: location.latitude, lng: location.longitude},
                    map: this.map
                });
            } else {
                this.marker.setPosition({lat: location.latitude, lng: location.longitude});
            }
        }

    };

    this.getGooglePlaceInfo = function(placeid, callback) {
        var $datatype = $(this);

        if(this.place) {
            if (this.place.place_id === placeid) {
                return this.place;
            }
        } else {
            var placeidService = new google.maps.places.PlacesService(this.map);
            var request = {
                placeId: placeid
            };

            var self = this;
            placeidService.getDetails(request, function (place, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    self.place = place;
                }
            });
        }

        return this.place;
    };

    this.setZoom = function(level) {
        this.map.setZoom(level);
    };

    this.getValue = function() {
        if(typeof(this.value) === 'object' && this.value.latitude !== undefined) {
            if(typeof(this.value.latitude) !== 'number') {
                this.value.latitude = parseFloat(this.value.latitude);
                this.value.longitude = parseFloat(this.value.longitude);
            }
            return this.value;
        } else {
            if(this.engine === 'google') {
                if(this.value.googlePlaceId !== undefined) {
                    var place = this.getGooglePlaceInfo(this.value.googlePlaceId);

                    this.value.latitude = place.geometry.location.lat;
                    this.value.longitude = place.geometry.location.lng;
                }
            }
        }

        return this.value;
    };

    this.initSearch = function() {
        $datatype = $(this);
        var self = this;

        if(this.engine === 'google') {
            this.autocomplete = new google.maps.places.Autocomplete(this.$searchInput[0]);
            this.autocomplete.bindTo('bounds', this.map);
            this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(this.$searchInput[0]);

            this.autocomplete.addListener('place_changed', function() {
                var place = self.autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                self.value.googlePlaceId = place.place_id;
                self.value.latitude = place.geometry.location.lat();
                self.value.longitude = place.geometry.location.lng();
                self.placeMarker(self.value);
                self.setCenter(self.value);
                self.setZoom(18);
                self.updateInputsValue();
            });
        }
    };

    this.initClickListener = function() {
        var self = this;

        if(this.engine === 'google') {
            google.maps.event.addListener(this.map, 'click', function (event) {
                self.getGooglePlaceInfo(event.placeId);
                if(self.googleMode === 'coordinates') {
                    self.value.latitude = event.latLng.lat();
                    self.value.longitude = event.latLng.lng();

                    if(event.placeId) {
                        self.value.googlePlaceId = event.placeId;
                    }
                } else if(self.googleMode === 'places') {
                    if(event.placeId) {
                        self.value.latitude = event.latLng.lat();
                        self.value.longitude = event.latLng.lng();
                        self.value.googlePlaceId = event.placeId;
                    }
                }

                if(event.placeId === undefined) {
                    self.value.googlePlaceId = "";
                }

                self.placeMarker(self.value);
                self.updateInputsValue();
            });
        }
    };

    this.updateInputsValue = function() {
        if(this.saveAs === 'elements') {

            if(this.engine === 'google') {
                this.$mainInput.val(this.value.latitude.toFixed(6));
                if(this.$longitudeElement) {
                    this.$longitudeElement.val(this.value.longitude.toFixed(6));
                }

                if(this.$googlePlaceIdElement) {
                    this.$googlePlaceIdElement.val(this.value.googlePlaceId);
                }
            } else {
                this.$mainInput.val(this.value.latitude.toFixed(6));
                if(this.$longitudeElement) {
                    this.$longitudeElement.val(this.value.longitude.toFixed(6));
                }
            }

        } else if(this.saveAs === 'json') {
            var jsonValue = {};

            if(this.engine === 'google') {
                if(this.googleMode !== 'places') {
                    jsonValue.latitude = this.value.latitude.toFixed(6);
                    jsonValue.longitude = this.value.longitude.toFixed(6);
                }

                if(this.googleMode !== 'coordinates') {
                    jsonValue.googlePlaceId = this.value.googlePlaceId;
                }
            } else {
                jsonValue.latitude = this.value.latitude.toFixed(6);
                jsonValue.longitude = this.value.longitude.toFixed(6);
            }

            this.$mainInput.val(JSON.stringify(jsonValue));
        } else if(this.saveAs === 'string') {
            var value = "";

            if(this.engine === 'google') {
                if(this.googleMode !== 'places') {
                    value = this.value.latitude.toFixed(6) + this.separator + this.value.longitude.toFixed(6);
                }

                if(this.googleMode !== 'coordinates') {
                    value += (value.length > 0 ? this.separator : '') + this.value.googlePlaceId;
                }
            } else {
                value = this.value.latitude.toFixed(6) + this.separator + this.value.longitude.toFixed(6);
            }
        }
    };

    return this.init();
};

(function($) {
    appendScript('https://maps.googleapis.com/maps/api/js?libraries=places&key=' + google_api);
    var style = '<style>'
        + '.datatype-location-map-container { margin-top: 15px; min-height: 300px; }'
        + '.controls { display: none; }'
        + '.gm-style .controls { display: block; }'
        + '.controls {background-color: #fff;border-radius: 2px;border: 1px solid transparent;box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);box-sizing: border-box;font-family: Roboto;font-size: 15px;font-weight: 300;height: 29px;margin-left: 17px;margin-top: 10px;outline: none;padding: 0 11px 0 13px;text-overflow: ellipsis;width: 400px;}'
        + '.controls:focus {border-color: #4d90fe;}'
        + '</style>';

    $('head').append(style);

    $(window).load(function(){
        $('.datatype-location').each(function(){
            $(this).locationDatatype();
        });
    });
})(jQuery);