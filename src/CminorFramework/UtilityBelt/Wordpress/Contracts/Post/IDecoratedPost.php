<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Post;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Models\IDecoratedModel;

/**
 * Defines the methods for the DecoratedPost model
 * This model will be used to decorate the WP_Post object
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IDecoratedPost extends IDecoratedModel
{

    /**
     * Sets an array of Wp_Posts that are the attachments to the raw/original Wp_post
     *
     * @param array $image_attachments
     *            The array should have the format of [Post_ID => Wp_Post]
     */
    public function _setImageAttachmentsArray(array $image_attachments);

    /**
     * Returns the array that holds the image attachments
     */
    public function getImageAttachmentsArray();

    /**
     * Returns an image attachment associated with this id
     *
     * @param int $image_id
     *            The Wp_Post ID
     */
    public function getImageAttachmentById($image_id);

}
