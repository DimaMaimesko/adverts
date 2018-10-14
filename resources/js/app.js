
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


$('#flash-overlay-modal').modal();

$('#adminTab a').on('click', function (e) {
    $(this).tab('show')
});

$("[data-confirm]").click(function() {
    return confirm($(this).attr('data-confirm'));
});


$(document).on('click', '.location-button', function () {
    var button = $(this);
    var target = $(button.data('target'));

    window.geocode_callback = function (response) {
        if (response.response.GeoObjectCollection.metaDataProperty.GeocoderResponseMetaData.found > 0) {
            target.val(response.response.GeoObjectCollection.featureMember['0'].GeoObject.metaDataProperty.GeocoderMetaData.Address.formatted);
        } else {
            alert('Unable to detect your address.');
        }
    };

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var location = position.coords.longitude + ',' + position.coords.latitude;
            var url = 'https://geocode-maps.yandex.ru/1.x/?format=json&callback=geocode_callback&geocode=' + location;
            var script = $('<script>').appendTo($('body'));
            script.attr('src', url);
        }, function (error) {
            console.warn(error.message);
        });
    } else {
        alert('Unable to detect your location.');
    }
});



