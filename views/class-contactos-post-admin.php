<?php
/**
 * Post Type Contactos.
 *
 * @package   Post_Type_Contactos
 * @author    Matias Esteban <estebanmatias92@gmail.com>
 * @license   MIT License
 * @link      http://example.com
 * @copyright 2013 Matias Esteban
 */

if ( ! class_exists( 'Contactos_Post_Admin' ) ) :

    /**
     * This class contains the administration panel view of the posts.
     */
    class Contactos_Post_Admin extends Post_Type_Contactos {

        /**
         * Instance of this class.
         *
         * @since    0.1.0
         *
         * @var      object
         */
        protected static $instance = null;

        /**
         * Initialize the admin post view.
         *
         * @since 0.1.0
         */
        protected function __construct() {

            add_action( 'manage_' . self::$post_type . '_posts_custom_column', array( $this, 'custom_columns', ) );

            add_filter( 'manage_edit-' . self::$post_type . '_columns', array( $this, 'columns' ) );

        }

        /**
         * Return an instance of this class.
         *
         * @since     0.1.0
         *
         * @return    object    A single instance of this class.
         */
        public static function get_instance() {

            // If the single instance hasn't been set, set it now.
            if ( null == self::$instance ) {
                self::$instance = new self;
            }

            return self::$instance;

        }

        /**
         * Declare custom columns.
         *
         * @since  0.1.0
         *
         * @param  array    $columns      Admin post table columns.
         *
         * @return array    Columns modified.
         */
        public function columns( $columns ) {

            $columns['title']     = __( 'Name' );

            $new = array();
            foreach( $columns as $key => $title ) {

                // Put the Thumbnail column before the Author column
                if ( $key == 'title' ) {
                    $new['_thumbnail_id'] = '';
                }

                if ( $key == 'taxonomy-' . self::$taxonomy ) {
                    $new['_social_facebook'] = 'FB';
                    $new['_social_twitter'] = 't';
                    $new['_social_google_plus'] = 'G+';
                }

                $new[$key] = $title;

            }

            return $new;

        }

        /**
         * Define once custom column.
         *
         * @since  0.1.0
         *
         * @param  string    $column_name  Culumn name to return.
         *
         * @return null      Returns the correct column when the wp hook call him.
         */
        public function custom_columns( $column_name ) {

            global $post;

            $prefix = '_social';

            if ( ! stristr( $column_name, $prefix ) ) {
                return;
            }

            $meta_id     = $column_name;
            $meta_value  = get_post_meta( $post->ID, $column_name )[0];
            $social_icon = new Contactos_Post_Public();

            echo $social_icon->get_social_icon( $meta_value,  $column_name );

        }

    }

endif;
