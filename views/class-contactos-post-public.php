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

if ( ! class_exists( 'Contactos_Post_Public' ) ) :

    /**
     * This class contains the administration panel view of the posts.
     */
    class Contactos_Post_Public {

        /**
         * Make a link with PNG icon of the current social network
         *
         * @since  0.1.0
         *
         * @param  string    $meta_value   Profile to link.
         * @param  string    $meta_id      Social network.
         *
         * @return string    Returns the HTML markup or empty.
         */
        public function get_social_icon( $meta_value, $meta_id ) {

            // Set icons path
            $img_url = PTC_PLUGIN_URL . 'assets/images/social-icons/';

            if ( empty( $meta_value ) ) {
                return '';
            }

            // Returns the HTML markup with url and icon
            return '<a href="' . $meta_value . '" title="Go to profile"><img id="' . $meta_id . '" class="social-meta-icon" src="' . $img_url . 'icon' . $meta_id . '.png" alt=""></a>';

        }



        /**
         * [get_meta description]
         *
         * @since [version]
         *
         * @param array     $custom_meta [description]
         *
         * @return [type]    [description]
         */
        public function get_meta( $custom_meta = array() ) {

            $prefix = '_social';

            echo '<ul class="post-meta">';

            $social_in_array = false;

            // Display meta data
            foreach ( $custom_meta as $key => $label ) {

                if ( ! stristr( $key, $prefix ) ) {

                    echo '<li><span class="post-meta-key">' . $label . ': </span>' . get_post_meta( get_the_ID(), $key, true ) . '</li>';

                } else {

                    $social_in_array = true;

                }

            }

            // Loop to display social meta data
            if ( $social_in_array ) {

                echo '<li><span class="post-meta-key">Social: ';

                // Loop to display social meta data
                foreach ( $custom_meta as $key => $label ) {

                    if ( stristr( $key, $prefix ) ) {
                        echo $this->get_social_icon( get_post_meta( get_the_ID(), $key, true ), $key );
                    }

                }

                echo '</span></li>';

            }

            echo '</ul>';

        }

    }

endif;
