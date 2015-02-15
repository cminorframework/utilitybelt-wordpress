<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost;

interface IAttachmentImage extends IDecoratedPost
{

    public function getDescription();

    public function getCaption();

    public function getSrc( $image_size );

}