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

        //check if $post is int or Wp_post or IdecoratedPost and return Wp_post
        $post = $this->_postAdapter($post);

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
     * Returns the posts (or custom post types) associated with the provided meta data
     * @param string $meta_key
     * @param mixed $meta_value
     * @param string $compare_operator
     * @param string $post_type
     * @return multitype:\WP_Post returns an array of post objects, or empty array if nothing found
     */
    public function getPostByMetaData($meta_key, $meta_value, $compare_operator = '=', $post_type = 'post')
    {
        $arguments = [
            'post_type'  => $post_type,
            'meta_key'   => $metakey,
            'meta_query' => [
                [
                    'key'     => $meta_key,
                    'value'   => $meta_value,
                    'compare' => $compare_operator,
                ]
            ],
        ];

        $search_query = new \WP_Query( $arguments );

        if(!$search_query->found_posts){
            return [];
        }
        return $search_query->posts;
    }

    /**
     * Retrieves a post (or a custom post type) by a post field (ie post_title, post_author, etc)
     * @param string $field_name
     * @param mixed $field_value
     * @param string $post_type
     * @throws \InvalidArgumentException
     * @return multitype:\WP_Post returns an array of post objects, or empty array if nothing found
     */
    public function getPostByField($field_name, $field_value, $post_type = 'post')
    {

        if(!$field_name){
            throw new \InvalidArgumentException(get_class($this).'->'.__FUNCTION__.'(): Invalid field name');
        }

        if(empty($field_value)){
            throw new \InvalidArgumentException(get_class($this).'->'.__FUNCTION__.'(): Invalid field value');
        }

        $query_arguments = [
            'post_type' => $post_type,
            $field_name => $field_value
        ];

        $search_query = new \WP_Query( $query_arguments );

        if(!$search_query->found_posts){
            return [];
        }

        return  $search_query->posts;
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
        $decorated_post = $this->_decoratedPostAdapter($post, true);

        $decorated_image = null;

        //find the image id by the post meta and get the decorated image object
        if($image_id = $decorated_post->getMetaData($image_type_meta_key)){
            $decorated_image = $this->attachment_helper->getDecoratedImage($image_id, true);
        }

        return $decorated_image;

    }

    /**
     * Returns the image src of the image file associated with the provided post by the post meta
     * @param int|WP_Post $post
     * @param string $image_type_meta_key
     * @param string $image_size
     * @return string|NULL
     */
    public function getAttachmentImageSrcByPostMeta($post, $image_type_meta_key, $image_size)
    {

        try
                {
            if($decorated_image = $this->getAttachmentImageByPostMeta($post, $image_type_meta_key)){
                if($src = $decorated_image->getSrc($image_size)){
                    return $src;
                }
            }
        }
        catch(\InvalidArgumentException $e){
            return null;
        }

        return null;

    }


    /**
     * Accepts INT(post_id), WP_Post, IDecoratedPost and returns WP_Post
     *
     * Throws exception if $post is not one of the above
     *
     * @param mixed $post
     * @throws \InvalidArgumentException
     * @return \WP_Post|NULL
     */
    protected function _postAdapter($post)
    {

        switch(true){
            case $post instanceof \WP_Post:
                return $post;
            case $post instanceof IDecoratedPost:
                return $post->getRawObject();
            case is_numeric($post):
                return $this->_getPostById($post);
            default:
                $message = get_class($this).'->'.__FUNCTION__.'() at line '.__LINE__.': the $post is not INT or \Wp_Post or IDecoratedPost';
                throw new \InvalidArgumentException($message);
        }

    }

    /**
     * Accepts INT(post_id), WP_Post, IDecoratedPost and returns IDecoratedPost
     *
     * Throws exception if $post is not one of the above
     *
     * @param mixed $post
     * @param bool $with_meta if true fetches the posts meta information
     * @throws \InvalidArgumentException
     * @return IDecoratedPost|NULL
     */
    protected function _decoratedPostAdapter($post, $with_meta = true)
    {

        switch(true){
            case $post instanceof \WP_Post:
                return $this->getDecoratedPost($post, $with_meta);
            case $post instanceof IDecoratedPost:
                return $post;
            case is_numeric($post):
                return $this->getDecoratedPost($post, $with_meta);
            default:
                $message = get_class($this).'->'.__FUNCTION__.'() at line '.__LINE__.': the $post is not INT or \Wp_Post or IDecoratedPost';
                throw new \InvalidArgumentException($message);
        }

    }

}