<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Traits\General;

/**
 * Provides base methods for runtime resolving a class name
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
trait TClassNameResolver
{

    protected function _getClassName()
    {
        return get_class($this);
    }

}