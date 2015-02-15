<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Models\IDecoratedModel;

interface IAttachmentImage extends IDecoratedModel
{

    public function getDescription();

    public function getCaption();

    public function getSrc( $image_size );

}