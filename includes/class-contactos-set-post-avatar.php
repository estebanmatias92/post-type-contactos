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

if ( ! class_exists( 'Contactos_Set_Post_Avatar' ) ) :

	/**
     * This class contains the functions to set the image thumbnail by default in the posts.
     */
	class Contactos_Set_Post_Avatar extends Post_Type_Contactos {

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
	        	$this->set_post_thumbnail( $post->ID );
	        }

		}

		/**
		 * Set the default thumbnail for the contacts.
		 *
		 * @since  0.1.0
		 */
		private function set_post_thumbnail( $post_id ) {

			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}

	        // Get current thumbnail
			$post_thumbnail = get_post_meta( $post_id, '_thumbnail_id', true );

			// Search post thumbnail in current entities array
			$in_array = false;
			foreach ( self::$entities as $entity ) {

				if ( $post_thumbnail == $entity['ID'] ) {
					$in_array = true;
				}

			}

			// Get current entity
			$entity = strtolower( get_post_meta( $post_id , '_entity', true ) );

            // Check for the current thumbnail, and update
            if ( empty( $post_thumbnail ) || ( $in_array && $post_thumbnail != self::$entities[$entity]['ID'] ) ) {

				update_post_meta( $post_id, '_thumbnail_id', self::$entities[$entity]['ID'], $post_thumbnail );

            }

		}

	}

endif;
