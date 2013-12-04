<?php
/**
 * Create a new post-type for the plugin.
 *
 * @package   Post_Type_Contactos
 * @author    Matias Esteban <estebanmatias92@gmail.com>
 * @license   MIT License
 * @link      http://example.com
 * @copyright 2013 Matias Esteban
 */

if (!class_exists('Contactos_Set_Post_Type')) :

    /**
     * Contactos_Set_Post_Type description.
     */
    class Contactos_Set_Post_Type extends Post_Type_Contactos
    {

        function __construct()
        {

            if ( ! class_exists( 'Super_Custom_Post_Type' ) )
                return;

            // Add post type
            $post_type_labels =  array(
                'supports' => array( 'title', 'editor', 'thumbnail' ),
                );
            $post_type = new Super_Custom_Post_Type( self::$post_type, self::$type_singular, self::$type_name, $post_type_labels );

            // Add meta boxes
            $post_type->add_meta_box( array(
                'id'       => self::$post_type . '_meta_box',
                'title'    => __( 'Properties', self::$plugin_slug . '-locale' ),
                'context'  => 'normal',
                'priority' => 'high',
                'fields'   => array(

                    '_entity' => array(
                        'label'   => __( 'Entity', self::$plugin_slug . '-locale' ),
                        'type'    => 'radio',
                        'options' => array_keys( self::$entities ),
                        'default' => array( 'Mujer' )
                    ),

                    '_telephone' => array(
                        'label'       => __( 'Telephone', self::$plugin_slug . '-locale' ),
                        'type'        => 'tel',
                        'placeholder' => '4005252',
                        'default'     => ''
                    ),

                    '_email' => array(
                        'label'       => __( 'Email', self::$plugin_slug . '-locale' ),
                        'type'        => 'email',
                        'placeholder' => 'usuario@entidad.com',
                        'default'     => ''
                    ),

                    '_social_facebook' => array(
                        'label'       => __( 'ID Facebook', self::$plugin_slug . '-locale' ),
                        'type'        => 'text',
                        'placeholder' => 'user_apellido',
                        'url'         => 'https://www.facebook.com/',
                        'default'     => ''
                    ),

                    '_social_twitter' => array(
                        'label'       => __( 'ID Twitter', self::$plugin_slug . '-locale' ),
                        'type'        => 'text',
                        'placeholder' => '@usuario',
                        'url'         => 'https://www.twitter.com/',
                        'default'     => ''
                    ),

                    '_social_google_plus' => array(
                        'label'       => __( 'ID Google+', self::$plugin_slug . '-locale' ),
                        'type'        => 'text',
                        'placeholder' => '109801415806419677156',
                        'url'         => 'https://plus.google.com/',
                        'default'     => ''
                    )

                )
            ) );

            // Add meta to admin columns
            $post_type->add_to_columns( array(
                '_thumbnail_id' => '',
                '_email'        => 'Email',
            ) );

            // Add taxonomy
            $taxonomy_labels = array(
                'show_admin_column' => true,
            );
            $taxonomy = new Super_Custom_Taxonomy( self::$taxonomy, self::$tax_singular, self::$tax_name, 'cat', $taxonomy_labels );

            // Connect post type and taxes
            connect_types_and_taxes( $post_type, array( $taxonomy ) );

        }
    }

endif;
