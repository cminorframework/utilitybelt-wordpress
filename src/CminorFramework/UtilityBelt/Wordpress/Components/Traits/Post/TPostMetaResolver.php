<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post;

use CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException;
/**
 * Trait that provides methods to fetch a Wp_post metadata
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
trait TPostMetaResolver
{

    /**
     * Returns the meta data associated with the provided post id
     * @param int $post_id
     * @throws \CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException
     * @return array
     */
    protected function _getPostMetaData($post_id)
    {

        if(!function_exists('get_post_meta')){
            throw  new WordpressFunctionNotFoundException($this->_getClassName().'->'.__FUNCTION__.'() at line '.__LINE__.': wordpress method get_post_meta not found');
        }

        return  get_post_meta( $post_id, null, false );

    }

}