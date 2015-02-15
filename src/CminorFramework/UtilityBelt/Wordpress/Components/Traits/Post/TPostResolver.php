<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Traits\Post;

use CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\General\TClassNameResolver;
/**
 * Provides the methods to resolve a post from wordpress database
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
trait TPostResolver
{

    use TClassNameResolver;

    /**
     * Returns a \WP_Post associated with this id or NULL if not found
     * Throws exception if wordpress get_post method is not found
     *
     * @uses Wordpress method : get_post( $id, $output, $filter )
     *
     * @param int $id
     * @param string $output
     * @param string $filter
     * @throws \CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException
     * @return \WP_Post|NULL
     */
    protected function _getPostById($id, $output = null, $filter = null)
    {
        if(!function_exists('get_post')){
            throw  new WordpressFunctionNotFoundException($this->_getClassName().'->'.__FUNCTION__.'() at line '.__LINE__.': wordpress method get_post not found');
        }

        if($post = get_post( (int) $id, $output, $filter )){
            return $post;
        }
        return null;
    }

}