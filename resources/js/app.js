
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

