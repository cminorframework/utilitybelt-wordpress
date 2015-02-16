<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Post;

/**
 * Defines the required methods to be implemented by PostHelper classes
 * Creates a decorated post, or retrieves a decorated wp post
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IPostHelper
{

    /**
     * Returns a Decorated post instance containting the Wp_post and its metadata if fetch_meta_data is true
     *
     * @param mixed $post Provide the \Wp_Post or the id of the post and it will be automatically resolved
     * @param bool $fetch_meta_data if set to true, will also retrieve the post's metadata
     * @param bool $fetch_image_attachments if set to true, will also retrieve the post's image attachments
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function getDecoratedPost($post, $fetch_meta_data = false, $fetch_image_attachments = false);

    /**
     * Returns array with the decorated posts instances associated with the provided $posts
     * @param array $posts an array of \WP_Post
     * @param bool $fetch_meta_data if set to true, will also retrieve the post's metadata
     * @return mixed:\CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function getDecoratedPosts(array $posts, $fetch_meta_data = false, $fetch_image_attachments = false);

    /**
     * Creates a new decorated post instance and populates it with the provided data
     * @param \Wp_Post $post
     * @param array $meta_data_array
     * @param array $extra_data_array
     * @param array $image_attachments
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function createDecoratedPost(\Wp_Post $post = null, array $meta_data_array = [], array $extra_data_array = [], array $image_attachments = []);

    /**
     * Returns the $post_type post that is connected to the provided post by taxonomy and meta key
     * Returns null if no post found
     * @param int $post_id
     * @param string $post_type
     * @param string $taxonomy
     * @param string $connection_meta_key
     * @return \WP_Post|NULL
     */
    public function getConnectedPostByTaxonomyAndMetaKey($post_id, $post_type, $taxonomy, $connection_meta_key);

    /**
     * Returns the decorated image object associated with this post and meta key
     * Returns null if no image found
     * @param int|WP_Post $post
     * @param string $image_type_meta_key
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage|NULL
     */
    public function getAttachmentImageByPostMeta($post, $image_type_meta_key);

}