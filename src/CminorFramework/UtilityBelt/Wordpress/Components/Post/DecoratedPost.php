<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Post;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost;
use CminorFramework\UtilityBelt\Wordpress\Components\Models\DecoratedModel;

class DecoratedPost extends DecoratedModel implements IDecoratedPost
{

    protected $_image_attachments = [];

    public function _setImageAttachmentsArray(array $image_attachments)
    {
        $this->_image_attachments = $image_attachments;
    }

    public function getImageAttachmentsArray()
    {
        return $this->_image_attachments;
    }

    public function getImageAttachmentById($image_id)
    {
        if(isset($this->_image_attachments[$image_id])){
            return $this->_image_attachments[$image_id];
        }
        return null;
    }


}