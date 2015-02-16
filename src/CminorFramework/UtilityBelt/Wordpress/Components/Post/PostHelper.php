<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Post;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IPostHelper;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post\TPostResolver;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post\TPostMetaResolver;
/**
 * Helper class to provide helpful methods for a post
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class PostHelper implements IPostHelper
{

    /**
     * use the trait TPostResolver to include methods to retrieve a post from database
     */
    use TPostResolver;


    /**
     * Holds the concrete implementation of the IDecoratedPost interface
     * This is the class that will be used to clone from when creating new objects of this type
     *
     * @var \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    protected $decorated_post_definition;

    /**
     * The class dependencies
     *
     * @param \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost $decorated_post_definition
     */
    public function __construct(IDecoratedPost $decorated_post_definition)
    {
        $this->decorated_post_definition = $decorated_post_definition;
    }

    /**
     * Returns a decorated post instance associated with the provided $post
     * @see \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IPostHelper::getDecoratedPost()
     *
     * Throws WordpressFunctionNotFoundException exception if $post is not instance of \WP_Post AND wordpress get_post method is not found to retrieve it
     * Throws InvalidArgumentException exception if $post is not instance of \Wp_Post AND $post is not int
     *
     * @uses Wordpress method : get_post
     * @uses Wordpress method : get_post_meta
     * @throws \CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException
     * @throws \InvalidArgumentException
     *
     * @param mixed:int|\WP_Post $post The post id OR the \Wp_Post object to be decorated
     * @param bool $fetch_meta_data if set to true, will also retrieve the post's metadata
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function getDecoratedPost($post, $fetch_meta_data = false, $fetch_image_attachments = false)
    {
        /*
         * If no post is provided return null
         */
        if(!$post){
            return null;
        }

        /*
         * If $post is not instance of Wp_Post but is integer containing the post id,
         * retrieve the Wp_post object from db using this id
         */
        if($post instanceof \WP_Post === false){
            if(!is_numeric($post)){
               throw new \InvalidArgumentException($this->_getClassName().'->'.__FUNCTION__.'() at line '.__LINE__.': the $post is not integer or \Wp_Post');
            }
            $post = $this->_getPostById($post);
        }

        $meta_data = [];
        if($fetch_meta_data){
            $meta_data = $this->_getPostMetaData($post->ID);
        }

        if($fetch_image_attachments){
            $attachments = $this->_getPostImageAttachments($post->ID);
        }

        return $this->createDecoratedPost($post, $meta_data, [], $attachments);

    }

    public function getDecoratedPosts(array $posts, $fetch_meta_data = false, $fetch_image_attachments = false)
    {
        if(!$posts){
            return [];
        }
        $decorated_posts = [];
        foreach($posts as $raw_post){
            $decorated_post = $this->getDecoratedPost($post, $fetch_meta_data, $fetch_image_attachments);
            $decorated_posts[$raw_post->ID] = $decorated_post;
        }

        return $decorated_posts;

    }

    /**
     * Creates a new decorated post instance and populates it with the provided data
     * @param \Wp_Post $post
     * @param array $meta_data_array
     * @param array $extra_data_array
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     */
    public function createDecoratedPost(\Wp_Post $post = null, array $meta_data_array = [], array $extra_data_array = [], array $image_attachments = [])
    {

        //create a new instance of decorated post by cloning the definition
        //in this way you can bind a custom decorated post class to be returned
        $decorated_post = clone $this->decorated_post_definition;

        //Set the decorated post's properties and data
        if($post){
            $decorated_post->_setRawObject($post);
        }

        if($meta_data_array){
            $decorated_post->_setMetaDataArray($meta_data_array);
        }

        if($extra_data_array){
            $decorated_post->_setExtraDataArray($extra_data_array);
        }

        if($image_attachments){
            $decorated_post->_setImageAttachmentsArray($image_attachments);
        }

        return $decorated_post;

    }

}