/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/*import $ from 'jquery';*/
window.$ = window.jQuery = $;
import 'jquery-ui/ui/widgets/sortable.js';
window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('admin-example-component', require('./components/ExampleComponent.vue').default);

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#sortable").sortable(
        {
            update: function () {
                var order = [];
                $("#sortable").find('[data-id]').each(function () {
                        order.push($(this).data('id'));
                })
                console.log(order);
                let shoppinglist_id = $(this).data('id');
                // POST to server using $.post or $.ajax
                $.ajax({
                    data: {
                        order: order,
                    },
                    type: 'POST',
                    dataType: 'json',
                    url: '/admin/shoppinglist/' + shoppinglist_id + '/update-order'
                });
            }
        }
    );


});

