<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Traits\User;
/**
 *
 * Provides the methods to resolve a user from wordpress database
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
trait TUserResolver
{

    /**
     * Retrieves a Wp_User Object associated with the provided user id
     * @param int $user_id
     * @return \WP_User|NULL
     */
    protected function _getUserById($user_id)
    {
        if($user = get_user_by('id', (int) $user_id )){
            return $user;
        }
        return null;
    }

}