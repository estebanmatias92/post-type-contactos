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

if ( ! class_exists( 'Contactos_Set_Meta_Social' ) ) :

	/**
     * This class contains the functions to set the image thumbnail by default in the posts.
     */
	class Contactos_Set_Meta_Social extends Post_Type_Contactos {

		/**
		 * Initialize the class and walk the posts to set his default thumbnails.
		 *
		 * @since 0.1.0
		 */
		public function __construct() {

			// Get all post published
			$posts = get_posts( array(
				'post_type' => self::$post_type,
				'status'    => 'publish',
				'nopaging'  => true
	        ) );

			// Walk the post and set the default thumbnails
	        foreach ( $posts as $post ) {
	        	$this->update_meta_social( $post->ID );
	        }

		}

        /**
         * Function to update the social meta keys values with the url of social network
         *
         * @since  0.1.0
         *
         * @param  integer   $post_id      The current post ID.
         */
        private function update_meta_social( $post_id ) {

			$prefix   = '_social';
			$meta_ids = get_post_meta( $post_id );

			// Search and find the social meta keys
            foreach ( $meta_ids as $key => $value ) {

            	if ( ! stristr( $key, $prefix ) ) {
            		continue;
            	}

            	$profile = $value[0];

            	// Set the url only to the full imputs
	            if ( ! empty( $profile ) && ! stristr( $profile, '.com/' ) ) {

	            	switch ( $key ) {

	                    case $prefix . '_facebook':
	                        $url = 'https://www.facebook.com/' . $profile;
	                        break;

	                    case $prefix . '_twitter':
	                        $url = 'https://www.twitter.com/' . $profile;
	                        break;

	                    case $prefix . '_google_plus':
	                        $url = 'https://plus.google.com/' . $profile;
	                        break;

                       	default:
                       		return;
                       		break;

	                }

	                // Set the url to the social profile meta
	                update_post_meta( $post_id, $key, $url, $profile );

	            }

            }

        }

	}

endif;
