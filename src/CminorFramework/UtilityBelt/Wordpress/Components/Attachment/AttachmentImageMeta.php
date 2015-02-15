<?php
namespace CminorFramework\UtilityBelt\Wordpress\Helpers\Attachment;

/**
 * Container to hold the image meta information data
 *
 * @package UtilityBelt\Wordpress\Helpers
 * @subpackage Attachment
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class AttachmentImageMeta
{

    /**
     * Holds an array with the image meta information
     * @var array
     */
    protected $image_meta;

    public function __construct($image_meta_data)
    {
        $this->image_meta = $image_meta_data;
    }

    /**
     * Returns the filename of the image
     * @return string
     */
    public function getFile()
    {
        return isset($this->image_meta['file']) ? $this->image_meta['file'] : null;
    }

    /**
     * Returns the caption of the image
     * @return string
     */
    public function getCaption()
    {
        return  isset($this->image_meta['image_meta']['caption']) ? $this->image_meta['caption'] : null;
    }

    /**
     * Returns the title of the image
     * @return string
     */
    public function getTitle()
    {
        return  isset($this->image_meta['image_meta']['title']) ? $this->image_meta['title'] : null;
    }

    /**
     * Returns the credit of the image
     * @return string
     */
    public function getCredit()
    {
        return  isset($this->image_meta['image_meta']['credit']) ? $this->image_meta['credit'] : null;
    }

    /**
     * Returns the meta data array
     * @return array
     */
    public function getMetaArray()
    {
        return $this->image_meta;
    }

}