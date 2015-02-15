<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Metabox;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Actions\IActionRegisterable;
/**
 * Implements cool metaboxes
 *
 * USAGE:
 * override display($post) function for your html output
 * override save($post_id) function for your save actions
 * NOTE:
 * nonce addition and verification is handled automatically!
 *
 *
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
abstract class Metabox implements IActionRegisterable
{

    /**
     * User provided
     * The metabox title
     * @var string
     */
    protected $metabox_title;

    /**
     * User provided
     * Limit the post types that this metabox will be shown
     * @var array
     */
    protected $post_types_to_appear = array();

    /**
     * Automatically created from the class name
     * The metabox name
     * @var string
    */
    protected $metabox_name;

    /**
     * Automatically created
     * The name of the save action
     * @var string
     */
    protected $metabox_save_action;

    /**
     * Automatically created
     * The name of the nonce field
     * @var string
     */
    protected $metabox_nonce_name;

    protected $metabox_position = 'normal';
    protected $metabox_priority = 'default';

    public function __construct($metabox_title, $post_types_to_appear)
    {

        //dynamically create
        $this->metabox_name = get_class($this).'_metabox';
        $this->metabox_title = $metabox_title;
        $this->metabox_save_action = $this->metabox_name.'_save_action';
        $this->metabox_nonce_name = $this->metabox_save_action.'_nonce';

        if(is_array($post_types_to_appear)){
            $this->post_types_to_appear = $post_types_to_appear;
        }
        else{
            $this->post_types_to_appear[] = $post_types_to_appear;
        }

    }


    /**
     * Render Meta Box content.
     * Override this
     *
     * @param WP_Post $post
     */
    protected function display( $post )
    {

    }

    /**
     * Save the meta when the post is saved.
     * Override this
     *
     * @param int $post_id
     *            The ID of the post being saved.
     */
    public function save( $post_id )
    {


    }

    /**
     * Register the actions required for the metabox
     * @see \CminorFramework\UtilityBelt\Wordpress\Interfaces\Actions\ActionRegisterable::register()
     */
    public function register()
    {

        add_action( 'add_meta_boxes', array( &$this, '_register_meta_box' ) );
        add_action( 'save_post', array( &$this, '_saveMetaboxData' ) );

    }

    /**
     * Registers the metabox
     * @param string $post_type
     */
    public function _register_meta_box( $post_type )
    {

        //if the post type is not on our list, return
        if ( !in_array( $post_type, $this->post_types_to_appear ) ) {
            return false;
        }

        add_meta_box( $this->metabox_name, $this->metabox_title, array( $this, 'renderMetaboxHtml' ), $post_type, $this->metabox_position, $this->metabox_priority );

    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post
     */
    public function renderMetaboxHtml($post)
    {

        //adds a nonce to the metabox
        $this->_addSaveActionNonce();

        //display the html output
        $this->display($post);

    }

    /**
     * Adds a nonce
     */
    protected function _addSaveActionNonce()
    {

        // Add an nonce field so we can check for it later.
        wp_nonce_field( $this->metabox_save_action, $this->metabox_nonce_name );

    }

    /**
     * This is the main function that is automatically called to handle the save metabox data procedure
     * @param int $post_id
     * @return unknown
     */
    public function _saveMetaboxData($post_id)
    {

        if( ! $this->_validateNonce($post_id)){
            return $post_id;
        }

        //do the save actions
        $this->save($post_id);

    }

    /**
     * Validates the metabox nonce. Returns false if it fails
     * @param int $post_id
     * @return boolean
     */
    protected function _validateNonce($post_id)
    {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if ( ! isset( $_POST[$this->metabox_nonce_name] ) ){
            return false;
        }

        $nonce = $_POST[$this->metabox_nonce_name];

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, $this->metabox_save_action ) ){
            return false;
        }

        // If this is an autosave, our form has not been submitted,
        // so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return false;
        }


        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ){
            return false;
        }

        return true;

    }

}