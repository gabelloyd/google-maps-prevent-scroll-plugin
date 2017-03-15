<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
/**
 * @package gMap_PreventScroll
 * @since  1.0.0
 * @author diazemiliano
 * Ref: https://github.com/diazemiliano/googlemaps-scrollprevent
 */

// First Enqueue the plugin
function mapScrollPrevent_plugin() {
    wp_enqueue_script( 'mapScrollPrevent', 'https://cdn.rawgit.com/diazemiliano/mapScrollPrevent/master/dist/mapScrollPrevent.min.js', array( 'jquery' ) , '0.6.4', true );
}

// Second Enqueue the script
function mapScrollPrevent_script()
    {
      echo '
        <script type="text/javascript">
          $(function() {
            var googleMapSelector = "iframe[src*=\"google.com/maps\"]";
            var options = { pressDuration: 1000 };
            $(googleMapSelector).scrollprevent(options).start();
          });
        </script>
      ';
    }

// Do the hook
add_action( 'wp_enqueue_scripts', 'mapScrollPrevent_plugin' );
add_action( 'wp_head', 'mapScrollPrevent_script' );