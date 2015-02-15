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
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function getDecoratedPost($post, $fetch_meta_data = false);

    /**
     * Creates a new decorated post instance and populates it with the provided data
     * @param \Wp_Post $post
     * @param array $meta_data_array
     * @param array $extra_data_array
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function createDecoratedPost(\Wp_Post $post = null, array $meta_data_array = [], array $extra_data_array = []);

}