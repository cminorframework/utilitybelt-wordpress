<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment;

/**
 * Defines the required methods to be implemented by PostHelper classes
 * Creates a decorated post, or retrieves a decorated wp post
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IAttachmentHelper
{

    /**
     * Returns a decorated image instance associated with the provided $post
     * @param mixed:int|\WP_Post $post The post id OR the \Wp_Post object to be decorated
     * @param bool $fetch_meta_data if set to true, will also retrieve the post's metadata
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage
     */
    public function getDecoratedImage($post, $fetch_meta_data = false);

    /**
	 * Creates a new decorated image post instance and populates it with the provided data
	 * @param \Wp_Post $post
	 * @param array $meta_data_array
	 * @param array $extra_data_array
	 * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage
	 */
	public function createDecoratedImage(\Wp_Post $post = null, array $meta_data_array = [], array $extra_data_array = []);

}