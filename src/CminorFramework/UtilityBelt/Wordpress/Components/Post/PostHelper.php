<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Post;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IPostHelper;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post\TPostResolver;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post\TPostMetaResolver;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IAttachmentHelper;
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
    protected $attachment_helper;

    /**
     * The class dependencies
     *
     * @param \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost $decorated_post_definition
     */
    public function __construct(IDecoratedPost $decorated_post_definition, IAttachmentHelper $attachment_helper)
    {
        $this->decorated_post_definition = $decorated_post_definition;
        $this->attachment_helper = $attachment_helper;
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

        //check if $post is int or Wp_post and return Wp_post
        $post = $this->_resolvePostVariable($post);

        $meta_data = [];
        if($fetch_meta_data){
            $meta_data = $this->_getPostMetaData($post->ID);
        }

        $attachments = [];
        if($fetch_image_attachments){
            $attachments = $this->_getPostImageAttachments($post->ID);
        }

        return $this->createDecoratedPost($post, $meta_data, [], $attachments);

    }

    /**
     * Returns the decorated posts instances associated with the provided $post
     * @param array $posts an array of \WP_Post
     * @param bool $fetch_meta_data if set to true, will also retrieve the post's metadata
     * @return mixed:\CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost
     * @see \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IPostHelper::getDecoratedPost($post, $fetch_meta_data, $fetch_image_attachments)
     */
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


    /**
     * Returns the $post_type post that is connected to the provided post by taxonomy and meta key
     * @param int $post_id
     * @param string $post_type
     * @param string $taxonomy
     * @param string $connection_meta_key
     * @throws InvalidArgumentException
     * @return \WP_Post|NULL
     */
    public function getConnectedPostByTaxonomyAndMetaKey($post_id, $post_type, $taxonomy, $connection_meta_key)
    {

        if(!$post_id){
            throw new InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid post id!');
        }


        //get the term for this field taxonomy
        if(!$terms = wp_get_post_terms( (int) $post_id, $taxonomy)){
            return null;
        }

        //its an array, get the first element
        $term = $terms[0];

        //find the post of this custom taxonomy term
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key'     => $connection_meta_key,
                    'value'   => array($term->term_id),
                    'compare' => 'IN',
                ),
            )
        );

        $post_query = new \WP_Query($args);

        if(!$post_query->posts){
            return null;
        }

        return $post_query->posts[0];

    }

    /**
     * Returns the decorated image object associated with this post and meta key
     * @param int|WP_Post $post
     * @param string $image_type_meta_key
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage|NULL
     */
    public function getAttachmentImageByPostMeta($post, $image_type_meta_key)
    {
        //get the decorated post
        try{
            $decorated_post = $this->getDecoratedPost($post, true, false);
        }
        catch(\InvalidArgumentException $e){
            return null;
        }

        $decorated_image = null;

        //find the image id by the post meta and get the decorated image object
        if($image_id = $decorated_post->getMetaData($image_type_meta_key)){
            $decorated_image = $this->attachment_helper->getDecoratedImage($image_id, true);
        }

        return $decorated_image;

    }


    /**
     * If $post is not instance of Wp_Post but is integer containing the post id,
     * retrieve the Wp_post object from db using this id.
     * Throws exception if $post is NOT int or \WP_Post
     *
     * @param mixed $post
     * @throws \InvalidArgumentException
     * @return \WP_Post|NULL
     */
    protected function _resolvePostVariable($post)
    {

        if($post instanceof \WP_Post === false){
            if(!is_numeric($post)){
                throw new \InvalidArgumentException(get_class($this).'->'.__FUNCTION__.'() at line '.__LINE__.': the $post is not integer or \Wp_Post');
            }
            $post = $this->_getPostById($post);
        }

        return $post;

    }

}