<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Post;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Models\IDecoratedModel;

interface IDecoratedPost extends IDecoratedModel
{

    public function _setImageAttachmentsArray(array $image_attachments);

    public function getImageAttachmentsArray();

    public function getImageAttachmentById($image_id);


}