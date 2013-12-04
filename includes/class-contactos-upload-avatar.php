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

if ( ! class_exists( 'Contactos_Upload_Avatar' ) ) :

	/**
     * This class contains the functions to upload media image (in this case an avatar).
     */
	class Contactos_Upload_Avatar extends Post_Type_Contactos {

		/**
		 * ID of the done current post.
		 *
		 * @var string
		 */
		private static $post_id = null;

		/**
		 * Function set the entities values, set url and ID of entity.
		 *
		 * @since  0.1.0
		 */
		public static function upload() {

			// Update the IDs values for the entities array
			self::entities_update_IDs();

			// Set de entities URLs and IDs
			foreach ( self::$entities as $entity => $value ) {

				// Set de entities URLs
				if ( empty( $value['url'] ) ) {

					// Replace this with above code
					switch ( $entity ) {

						case 'hombre':
							// Test
							$value['url'] = 'http://static.freepik.com/foto-gratis/avatar-hombre-con-el-pelo-y-las-orejas_318-1022.jpg';

							break;

						case 'mujer':
							// Test
							$value['url'] = 'http://www.disfracesydespedidas.es/485-571-large/avatar-mujer.jpg';

							break;

						case 'entidad':
							# code...
							break;

						default:
							return;
							break;

					}
					self::$entities[$entity]['url'] = $value['url'];

					//$image_root = 'assets/images/';
					//self::$entities[$entity]['url'] = PTC_PLUGIN_URL . $image_root . 'avatar_' . $entity . 'jpg';

				}

				if ( empty( $value['ID'] ) ) {

					self::create_post( $entity );

					$avatar_id = self::upload_attachment( $value['url'] );

	                if ( $avatar_id ) {
	                	self::$entities[$entity]['ID'] = $avatar_id;
	                }

				}

			}

		}

		/**
		 * Update the entities array with the last changes.
		 *
		 * @since  0.1.0
		 */
		private static function entities_update_IDs() {

			// Get the current attachments IDs and update the array
			$attachments = get_posts( array(
				'post_type' => 'attachment',
				'nopaging'  => true
	        ) );

			$attachs_id = array();

			// Search by IDs in current attachments ID, and delete if don't find this
			foreach ( $attachments as $attach ) {

				array_push( $attachs_id, $attach->ID );

			}

			foreach ( self::$entities as $entity => $value ) {

				if ( ! in_array( $value['ID'], $attachs_id  ) ) {

					self::$entities[$entity]['ID'] = '';

				}

			}
		}

		/**
		 * Create an attachment post.
		 *
		 * @since  0.1.0
		 */
		public static function create_post( $title ){

			// Prepare post
			$post                = array();
			$post['post_type']   = 'attachment';
			$post['post_title']  = 'Contactos Avatar ' . ucwords( $title );
			$post['post_author'] = 1;

		    // Save to DB
		    self::$post_id = wp_insert_post( $post );

		}

	    /**
		 * This funcion upload an attachment to media library and returns his ID
		 *
		 * @since  0.1.0
		 *
		 * @param  string    $file_url     Hosted url from attachment.
		 *
		 * @return integer   Returns the attachment ID.
		 */
	    public static function upload_attachment( $file_url ) {

	        require_once( ABSPATH . 'wp-admin' . '/includes/image.php' );
	        require_once( ABSPATH . 'wp-admin' . '/includes/file.php' );
	        require_once( ABSPATH . 'wp-admin' . '/includes/media.php' );

	        // Upload image to server
	        $result = media_sideload_image( $file_url, self::$post_id );

	        if ( is_wp_error( $result ) ) {
	            return false;
	        }

	        // get the newly uploaded image
	        $attachments = get_posts( array(
	            'post_type'    => 'attachment',
	            'number_posts' => 1,
	            'post_status'  => null,
	            'post_parent'  => self::$post_id,
	            'orderby'      => 'post_date',
	            'order'        => 'DESC'
	        ) );

	        // Returns the id of the image
	        return $attachments[0]->ID;
	    }

	}

endif;
