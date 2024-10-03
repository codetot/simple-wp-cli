<?php
/**
 * Plugin Name: Simple WP CLI
 * Plugin URI:  https://github.com/codetot/simple-wp-cli
 * Description: A simple extra WP CLI
 * Version:     0.0.1
 * Author:      Code Tot JSC
 * Author URI:  https://codetot.com
 * License:     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( defined('WP_CLI') && class_exists( 'WP_CLI' ) ) {
    WP_CLI::add_command( 'tag', function($args, $assoc_args) {
        if (!empty( $args[0] ) && 'delete' === $args[0]) {
            $count = isset($assoc_args['count']) ? intval($assoc_args['count']) : 1;
            $number = isset($assoc_args['number']) ? intval($assoc_args['number']) : 100;

            $success = 0;
            $failure = 0;

            $terms = get_terms([
                'taxonomy' => 'post_tag',
                'count' => $count,
                'fields' => 'ids',
                'number' => $number
            ]);

            foreach ($terms as $term_id) {
                $result = wp_delete_term($term_id, 'post_tag');

                if ($result) {
                    $success++;
                } else {
                    $failure++;

                    WP_CLI::error( $result );
                }
            }

            WP_CLI::success( 'Result: ' . $success . ' success, ' . $failure . ' failure' );
        } else {
            WP_CLI::error( 'Incorrect param.' );
        }
    });
}