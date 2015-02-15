<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post;

use CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException;
/**
 * Provides the methods to resolve a post and its related data from wordpress database
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
trait TPostResolver
{

    /**
     * Returns a \WP_Post associated with this id or NULL if not found
     * Throws exception if wordpress get_post method is not found
     *
     * @uses Wordpress method : get_post( $id, $output, $filter )
     *
     * @param int $id
     * @param string $output
     * @param string $filter
     * @throws \CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException
     * @return \WP_Post|NULL
     */
    protected function _getPostById($id, $output = null, $filter = null)
    {
        if(!function_exists('get_post')){
            throw  new WordpressFunctionNotFoundException(__CLASS__.'->'.__FUNCTION__.'() at line '.__LINE__.': wordpress method get_post not found');
        }

        if($post = get_post( (int) $id, $output, $filter )){
            return $post;
        }
        return null;
    }

    /**
     * Returns the meta data associated with the provided post id
     * @param int $post_id
     * @throws \CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException
     * @return array
     */
    protected function _getPostMetaData($post_id)
    {

        if(!function_exists('get_post_meta')){
            throw  new WordpressFunctionNotFoundException(__CLASS__.'->'.__FUNCTION__.'() at line '.__LINE__.': wordpress method get_post_meta not found');
        }

        return  get_post_meta( (int) $post_id, null, false );

    }

    /**
     * Returns the image attachments of this post
     * @param int $post_id
     * @throws WordpressFunctionNotFoundException
     * @return array of \WP_Post objects
     */
    protected function _getPostImageAttachments($post_id)
    {
        if(!function_exists('get_attached_media')){
            throw  new WordpressFunctionNotFoundException(__CLASS__.'->'.__FUNCTION__.'() at line '.__LINE__.': wordpress method get_attached_media not found');
        }

        $post_attachments = [];
        if($attachments =  get_attached_media( 'image', (int) $post_id)){
            $post_attachments = $attachments;
        }

        return $post_attachments;
    }

}