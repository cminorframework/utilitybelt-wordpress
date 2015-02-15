<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Traits\User;

/**
 * Trait that provides methods to fetch a Wp_User metadata
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
trait TUserMetaResolver
{

    /**
     * Returns the meta data associated with the provided user id
     * @param int $user_id
     * @return array
     */
    protected function _getUserMetaData($user_id)
    {
        return  get_user_meta( (int) $user_id);
    }

}