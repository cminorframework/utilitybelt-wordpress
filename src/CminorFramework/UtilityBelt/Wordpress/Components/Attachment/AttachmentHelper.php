<?php
namespace CminorFramework\UtilityBelt\Wordpress\Helpers\Attachment;

use\InvalidArgumentException;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IAttachmentImage;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post\TPostResolver;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post\TPostMetaResolver;

/**
 * Helper class to retrieve attachments from posts
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class AttachmentHelper
{

    use TPostResolver;
    use TPostMetaResolver;

    const  TYPE_ATTACHMENT = 'image';
    const TYPE_AUDIO = 'audio';


    protected $attachment_image_definition;

    public function __construct(IAttachmentImage $attachment_image_definition)
    {
        $this->attachment_image_definition = $attachment_image_definition;
    }


	/**
	 *
	 * Returns the image id associated with the post meta key
	 *
	 * @param int $post_id
	 * @param string $meta_key_image_type see constants of this class
	 *
	 * @uses get_post_meta
	 * @throws InvalidArgumentException
	 *
	 * @return Ambigous <NULL, number, mixed>
	 */
	public function getImageIdFromPostMeta($post_id, $meta_key_image_type)
	{

	    if(!$post_id){
	        throw new InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid post id!');
	    }

	    if(!$meta_key_image_type){
	        throw new InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid meta key for image type!');
	    }

	    $image_id = null;

	    //get the image id for this image type
	    if($image_id = get_post_meta((int) $post_id, $meta_key_image_type)){

	        //its an array, get the first element
	        $image_id = (int) $image_id[0];

	    }

	    return $image_id;


	}


    /**
     * Returns the image ids of the attachments of this post
     * @param int $post_id
     * @throws InvalidArgumentException
     * @return Ambigous <multitype:, array>
     */
	public function getAttachmentImageIds($post_id)
	{

	    if(!$post_id){
	        throw new InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid post id!');
	    }

	    $image_ids = array();

	    if($image_ids = get_attached_media(AttachmentHelper::IMAGE_TYPE_ATTACHMENT, (int) $post_id)){
            $image_ids = array_keys($image_ids);
	    }

	    return $image_ids;

	}


	public function getAttachmentImageById($image, $fetch_meta_data = false)
	{

	    if(!$image){
	        return null;
	    }

	    if($image instanceof \WP_Post === false){
	        if(!$image = $this->_getPostById($image)){
	            throw new \RuntimeException(__CLASS__.'->'.__FUNCTION__.'(): '.'Image attachment does not exist');
	        }
	    }

	    if($fetch_meta_data){
	        $image_meta_data = wp_get_attachment_metadata( $image->ID );
	    }

        return $this->createAttachmentImage($image, $image_meta_data, []);

	}


	public function createAttachmentImage($image, $meta_data_array, $extra_data_array)
	{

        $attachment_image = clone $this->attachment_image_definition;

        if($image){

            $attachment_image->_setPost($image);

        }

        if($meta_data_array){
            $attachment_image->_setMetaData($meta_data_array);
        }

        if($extra_data_array){
            $attachment_image->_setExtraData($extra_data_array);
        }

        return $attachment_image;
	}

}