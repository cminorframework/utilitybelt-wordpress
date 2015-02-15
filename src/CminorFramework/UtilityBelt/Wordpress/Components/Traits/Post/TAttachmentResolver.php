<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post;

use CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\General\TClassNameResolver;
/**
 * Provides the methods to resolve an attachment and its related data from wordpress database
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
trait TAttachmentResolver
{

    use TClassNameResolver;

    /**
     * Returns the meta data associated with the provided post id
     * @param int $post_id
     * @throws \CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException
     * @return array
     */
    protected function _getAttachmentMetaData($post_id)
    {

        if(!function_exists('wp_get_attachment_metadata')){
            throw  new WordpressFunctionNotFoundException($this->_getClassName().'->'.__FUNCTION__.'() at line '.__LINE__.': wordpress method wp_get_attachment_metadata not found');
        }

        return wp_get_attachment_metadata( $post_id );

    }

}