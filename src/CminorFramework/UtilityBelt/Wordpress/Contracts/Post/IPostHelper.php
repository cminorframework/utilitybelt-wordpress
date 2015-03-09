<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Post;

/**
 * Defines the required methods to be implemented by PostHelper classes
 * A PostHelper is the implementation of the helper that will create IDecoratedPosts objects
 * and provide additional methods to remove boilerplate code.
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IPostHelper
{

    /**
     * Returns a Decorated post instance associated with the Wp_post
     *
     * @param mixed $post
     *            Provide the \Wp_Post or the id of the post and it will be automatically resolved
     * @param bool $fetch_meta_data
     *            if set to true, will also retrieve the post's metadata
     * @param bool $fetch_image_attachments
     *            if set to true, will also retrieve the post's image attachments
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function getDecoratedPost($post, $fetch_meta_data = false, $fetch_image_attachments = false);

    /**
     * Returns array with the decorated posts instances associated with the provided $posts
     *
     * @param array $posts
     *            an array of \WP_Post
     * @param bool $fetch_meta_data
     *            if set to true, will also retrieve the post's metadata
     * @return mixed:\CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function getDecoratedPosts(array $posts, $fetch_meta_data = false, $fetch_image_attachments = false);

    /**
     * Low level method
     * Creates a new decorated post instance and populates it with the provided data
     *
     * @param \Wp_Post $post
     * @param array $meta_data_array
     *            an array of meta data information
     * @param array $extra_data_array
     *            an array of extra data information
     * @param array $image_attachments
     *            an array of Wp_Posts holding the image attachments of this post
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function createDecoratedPost(\Wp_Post $post = null, array $meta_data_array = [], array $extra_data_array = [], array $image_attachments = []);

    /**
     * Returns the $post_type post that is connected to the provided post by taxonomy and meta key
     * Returns null if no post found
     *
     * @param int $post_id
     *            the original post that will be searched for connections
     * @param string $post_type
     *            the connected post type that we will search for
     * @param string $taxonomy
     *            the taxonomy that is connecting the two posts
     * @param string $connection_meta_key
     *            the meta key that is connecting the two posts
     * @return \WP_Post|NULL
     */
    public function getConnectedPostByTaxonomyAndMetaKey($post_id, $post_type, $taxonomy, $connection_meta_key);

    /**
     * Returns the posts (or custom post types) associated with the provided meta data
     *
     * @param string $meta_key
     *            the meta key to search for
     * @param mixed $meta_value
     *            the value of the meta key to be matched
     * @param string $compare_operator
     *            the operator to be used (ie '=')
     * @param string $post_type
     *            the type of the post
     * @return multitype:\WP_Post returns an array of post objects, or empty array if nothing found
     */
    public function getPostByMetaData($meta_key, $meta_value, $compare_operator, $post_type);

    /**
     * Retrieves a post (or a custom post type) by a post field (ie post_title, post_author, etc)
     *
     * @param string $field_name
     *            the field name (or table column name)
     * @param mixed $field_value
     *            the field value
     * @param string $post_type
     *            the type of the post
     * @return multitype:\WP_Post returns an array of post objects, or empty array if nothing found
     */
    public function getPostByField($field_name, $field_value, $post_type);

    /**
     * Returns the decorated image object associated with this post and meta key
     * Returns null if no image found
     *
     * @param int|WP_Post $post
     * @param string $image_type_meta_key
     *            the meta key that connects the wp_post with an image attachment
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage|NULL
     */
    public function getAttachmentImageByPostMeta($post, $image_type_meta_key);

    /**
     * Returns the image src of the image file associated with the provided post by the post meta
     *
     * @param int|WP_Post $post
     * @param string $image_type_meta_key
     *            the meta key that connects the wp_post with an image attachment
     * @param array|String $image_size
     *            an array or string for image size as defined in wordpress
     * @return string|NULL
     */
    public function getAttachmentImageSrcByPostMeta($post, $image_type_meta_key, $image_size);
}
