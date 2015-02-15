<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Attachment;

use CminorFramework\UtilityBelt\Wordpress\Components\Post\DecoratedPost;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IAttachmentImage;
/**
 *
 * Represents the attachment image as object
 * Features useful methods to retrieve an image source according to predefined sizes, get image meta data etc
 *
 * @package UtilityBelt\Wordpress\Helpers
 * @subpackage Attachment
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class AttachmentImage extends DecoratedPost implements IAttachmentImage
{

    public function getDescription()
    {
        return $this->image_post->post_content;
    }

    public function getCaption()
    {
        return $this->image_post->post_excerpt;
    }

    /**
     * Returns the src of this image
     * @param array|string $size
     * @uses wp_get_attachmet_image_src
     * @return Ambigous <unknown, multitype:, string, boolean, mixed, multitype:int , multitype:Ambigous <mixed, int> >
     */
    public function getSrc( $size = array(150,150) )
    {

        //get the src of the image id
        if( $img_src = wp_get_attachment_image_src($this->image_post->ID, $size) ) {

            //its an array, get the first element
            $img_src = $img_src[0];

        }

        return $img_src;

    }



}