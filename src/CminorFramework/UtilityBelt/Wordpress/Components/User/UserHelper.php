<?php
namespace CminorFramework\UtilityBelt\Wordpress\Helpers\User;

/**
 * Helper class to retrieve user data
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class UserHelper
{

    /**
     * Returns a Wp_User object if it exists in the system, null otherwise
     * @param int $user_id
     * @throws \InvalidArgumentException
     * @return Ambigous <NULL, WP_User>
     */
    public function getUserById($user_id)
    {

        if(!$user_id){
            throw new \InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid user id!');
        }

        $wp_user = null;

        if ( $user =  get_user_by('id', (int) $user_id ) ){

            $wp_user = $user;

        }

        return $wp_user;

    }

    /**
     * Returns the display name associated with this user id
     * @param unknown $user_id
     * @throws InvalidArgumentException
     * @return Ambigous <number, mixed>
     */
    public function getDisplayNameByUserId($user_id)
    {

        if(!$user_id){
			throw new \InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid user id!');
		}

		$display_name = null;

		//get the user object
		if( $user = $this->getUserById($user_id) ){
		    $display_name = $this->getDisplayNameByUser($user);
		}

		return $display_name;

    }

    /**
     * Returns the display name associated with this user object
     * @param \WP_User $user
     * @return Ambigous <number, mixed>
     */
    public function getDisplayNameByUser(\WP_User $user)
    {

        if(!$user){
            throw new \InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid user object!');
        }


        return $user->get('display_name');

    }

    /**
     * Returns the user avatar image by providing the user id
     * @param int $user_id
     * @param number $width
     * @throws \RuntimeException
     * @return string
     */
    public function getUserAvatarByUserId($user_id, $width = 200)
    {

        $user_avatar = null;

        if(!function_exists('user_avatar_get_avatar')){
            throw new \RuntimeException(__CLASS__.'->'.__FUNCTION__.'(): '.'Missing function user_avatar_get_avatar!');
        }

        $user_avatar = user_avatar_get_avatar( $user_id , $width);

        return $user_avatar;

    }

    /**
     * Returns the user avatar image by providing the user object
     * @uses user_avatar_get_avatar
     * @param \WP_User $user
     * @param number $width
     * @return \CminorFramework\UtilityBelt\Wordpress\Helpers\User\Ambigous
     */
    public function getUserAvatarByUser(\WP_User $user, $width = 200)
    {

        $user_id = $user->ID;

        return $this->getUserAvatarByUserId($user_id, $width);

    }

    /**
     * Returns a UserMetaDetailsHelper object if the user has meta details, null otherwise
     * @param int $user_id
     * @throws \InvalidArgumentException
     * @return \CminorFramework\UtilityBelt\Wordpress\Helpers\User\UserMetaDetailsHelper
     */
    public function getUserMetaDetails($user_id)
    {

        if(!$user_id){
            throw new \InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid user id!');
        }

        $user_meta_helper = null;

        //get the meta details from wordpress
        if ($user_meta_details = get_user_meta( (int) $user_id) ){

            //create an instance of the user meta details helper
            $user_meta_helper = $this->createUserMetaDetailsHelper($user_meta_details);

        }

        return $user_meta_helper;

    }

    /**
     * Create an instance of the UserMetaDetailsHelper
     * @param array $user_meta_details
     * @return \CminorFramework\UtilityBelt\Wordpress\Helpers\User\UserMetaDetailsHelper
     */
    public function createUserMetaDetailsHelper($user_meta_details)
    {

        $user_meta_helper = new UserMetaDetailsHelper();

        $user_meta_helper->_setUserMetaDetails($user_meta_details);

        return $user_meta_helper;

    }


}