<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Attachment;

use CminorFramework\UtilityBelt\Wordpress\Components\Models\DecoratedModel;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage;
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
class DecoratedImage extends DecoratedModel implements IDecoratedImage
{

    public function getDescription()
    {
        return $this->getRawObject()->post_content;
    }

    public function getCaption()
    {
        return $this->getRawObject()->post_excerpt;
    }

    /**
     * Returns the src of this image
     * @param array|string $size
     * @uses wp_get_attachmet_image_src
     * @return string
     */
    public function getSrc( $size = array(150,150) )
    {

        //get the src of the image id
        if( $img_src = wp_get_attachment_image_src($this->getRawObject()->ID, $size) ) {

            //its an array, get the first element
            $img_src = $img_src[0];

            return $img_src;

        }

        return null;
    }



}