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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#sortable").sortable({
        update: function update() {
            var order = [];
            $("#sortable").find('[data-id]').each(function () {
                order.push($(this).data('id'));
            });
            console.log(order);
            var shoppinglist_id = $(this).data('id');

            $.ajax({
                data: {
                    order: order
                },
                type: 'POST',
                dataType: 'json',
                url: '/shoppinglist/' + shoppinglist_id + '/update-order'
            });
        }
    });
    $('.add_recipe').click(function (e) {
        var shoppinglist_id = $(this).data('id');

        $.ajax({
            method: "GET",
            url: "/shoppinglist/" + shoppinglist_id + "/ajax-add-recipe",
            data: {
                shoppinglist_id: $(this).data('id'),
                'message': 'Hello there',
                'error': 'ERROR!',
            },
            success: function (data) {
                ajaxStatus(data);
                $('.ajax-alert').removeClass('d-none').text(data['message']);

            },
            error: function (response) {
                console.log('Error:', response);
            }

        });
    });
    function ajaxStatus(data) {
        $('.ajax-status').removeClass('d-none').append(data['message'] + "<br>");
        console.log('Kuckuck!');

    }

});
/*
 * A bridge between iPad and iPhone touch events and jquery draggable, sortable etc. mouse interactions.
 * @author Oleg Slobodskoi
 */
/iPad|iPhone/.test( navigator.userAgent ) && (function( $ ) {

    var proto =  $.ui.mouse.prototype,
        _mouseInit = proto._mouseInit;

    $.extend( proto, {
        _mouseInit: function() {
            this.element
                .bind( "touchstart." + this.widgetName, $.proxy( this, "_touchStart" ) );

            _mouseInit.apply( this, arguments );
        },

        _touchStart: function( event ) {
            if ( event.originalEvent.targetTouches.length != 1 ) {
                return false;
            }

            this.element
                .bind( "touchmove." + this.widgetName, $.proxy( this, "_touchMove" ) )
                .bind( "touchend." + this.widgetName, $.proxy( this, "_touchEnd" ) );

            this._modifyEvent( event );

            this._mouseDown( event );

            return false;
        },

        _touchMove: function( event ) {
            this._modifyEvent( event );
            this._mouseMove( event );
        },

        _touchEnd: function( event ) {
            this.element
                .unbind( "touchmove." + this.widgetName )
                .unbind( "touchend." + this.widgetName );
            this._mouseUp( event );
        },

        _modifyEvent: function( event ) {
            event.which = 1;
            var target = event.originalEvent.targetTouches[0];
            event.pageX = target.clientX;
            event.pageY = target.clientY;
        }

    });

})( jQuery );




