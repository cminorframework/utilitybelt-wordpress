<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Attachment;

use\InvalidArgumentException;

use CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post\TPostResolver;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post\TAttachmentResolver;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IAttachmentHelper;

/**
 * Helper class to retrieve attachments from posts
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class AttachmentHelper implements IAttachmentHelper
{

    use TPostResolver;
    use TAttachmentResolver;

    const  TYPE_ATTACHMENT = 'image';
    const TYPE_AUDIO = 'audio';


    protected $decorated_image_definition;

    public function __construct(IDecoratedImage $decorated_image_definition)
    {
        $this->decorated_image_definition = $decorated_image_definition;
    }

    /**
     * Returns a decorated image instance associated with the provided $post
     * @see \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IAttachmentHelper::getDecoratedImage()
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
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage
     */
    public function getDecoratedImage($post, $fetch_meta_data = false)
    {
        /*
         * If no image post is provided return null
         */
        if(!$post){
            return null;
        }

        /*
         * If $post is not instance of Wp_Post but is integer containing the post id, retrieve the Wp_post object from db using this id
         */
        if($post instanceof \WP_Post === false){
            if(!is_numeric($post)){
                throw new \InvalidArgumentException($this->_getClassName().'->'.__FUNCTION__.'() at line '.__LINE__.': the $post is not integer or \Wp_Post');
            }
            $post = $this->_getPostById($post);
        }

        $meta_data = [];
        if($fetch_meta_data){
            $meta_data = $this->_getAttachmentMetaData($post->ID);
        }

        return $this->createDecoratedImage($post, $meta_data, []);

    }

	/**
	 * Creates a new decorated post instance and populates it with the provided data
	 * @param \Wp_Post $post
	 * @param array $meta_data_array
	 * @param array $extra_data_array
	 * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage
	 */
	public function createDecoratedImage(\Wp_Post $post = null, array $meta_data_array = [], array $extra_data_array = [])
	{

	    //create a new instance of decorated post by cloning the definition
	    //in this way you can bind a custom decorated post class to be returned
	    $decorated_post = clone $this->decorated_image_definition;

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

	    return $decorated_post;

	}

}