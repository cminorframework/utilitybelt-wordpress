<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\User;

interface IUserHelper
{
    /**
     * Returns a decorated user instance associated with the provided $user
     *
     * @param mixed:int|\WP_User $user The user id OR the \Wp_User object to be decorated
     * @param bool $fetch_meta_data if set to true, will also retrieve the user's metadata
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\User\IDecoratedUser
     */
    public function getDecoratedUser($user, $fetch_meta_data = false);

    /**
     * Creates a new decorated user instance and populates it with the provided data
     * @param \WP_User $user
     * @param array $meta_data_array
     * @param array $extra_data_array
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\User\IDecoratedUser
     */
    public function createDecoratedUser(\WP_User $user = null, array $meta_data_array = [], array $extra_data_array = []);

}