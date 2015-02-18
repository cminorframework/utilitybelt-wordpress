<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\User;

use CminorFramework\UtilityBelt\Wordpress\Components\Traits\User\TUserResolver;
use CminorFramework\UtilityBelt\Wordpress\Components\Traits\User\TUserMetaResolver;
use CminorFramework\UtilityBelt\Wordpress\Contracts\User\IDecoratedUser;
use CminorFramework\UtilityBelt\Wordpress\Contracts\User\IUserHelper;
/**
 * Helper class to retrieve user data
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class UserHelper implements IUserHelper
{

   use TUserResolver;

   use TUserMetaResolver;

   /**
    * Holds the concrete implementation of the IDecoratedUser interface
    * This is the class that will be used to clone from when creating new objects of this type
    *
    * @var \CminorFramework\UtilityBelt\Wordpress\Contracts\User\IDecoratedUser
    */
   protected $decorated_user_definition;

   /**
    * The class dependencies
    *
    * @param \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost $decorated_post_definition
    */
   public function __construct(IDecoratedUser $decorated_user_definition)
   {
       $this->decorated_user_definition = $decorated_user_definition;
   }

   /**
    * Returns a decorated user instance associated with the provided $user
    * @see \CminorFramework\UtilityBelt\Wordpress\Contracts\User\IUserHelper::getDecoratedPost()
    *
    * Throws WordpressFunctionNotFoundException exception if $post is not instance of \WP_User AND wordpress get_user method is not found to retrieve it
    * Throws InvalidArgumentException exception if $user is not instance of \WP_User AND $user is not int
    *
    * @uses Wordpress method : get_user_by
    * @uses Wordpress method : get_user_meta
    * @throws \CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressFunctionNotFoundException
    * @throws \InvalidArgumentException
    *
    * @param mixed:int|\WP_User $user The user id OR the \Wp_User object to be decorated
    * @param bool $fetch_meta_data if set to true, will also retrieve the user's metadata
    * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\User\IDecoratedUser
    */
   public function getDecoratedUser($user, $fetch_meta_data = false)
   {
       /*
        * If no post is provided return null
        */
       if(!$user){
           return null;
       }

       /*
        * If $post is not instance of WP_User but is integer containing the user id, retrieve from db using this id
        */
       if($user instanceof \WP_User === false){
           if(!is_numeric($user)){
               throw new \InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'() at line '.__LINE__.': the $user is not instance of integer or \WP_User');
           }
           $user = $this->_getUserById($user);
       }

       if(!$user){
           return null;
       }

       $meta_data = [];

       if($fetch_meta_data){
           $meta_data = $this->_getUserMetaData($user->ID);
       }

       return $this->createDecoratedUser($user, $meta_data, []);

   }

   /**
    * Creates a new decorated user instance and populates it with the provided data
    * @param \WP_User $user
    * @param array $meta_data_array
    * @param array $extra_data_array
    * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\User\IDecoratedUser
    */
   public function createDecoratedUser(\WP_User $user = null, array $meta_data_array = [], array $extra_data_array = [])
   {

       //create a new instance of decorated post by cloning the definition
       //in this way you can bind a custom decorated post class to be returned
       $decorated_user = clone $this->decorated_user_definition;

       //Set the decorated post's properties and data
       if($user){
           $decorated_user->_setRawObject($user);
       }

       if($meta_data_array){
           $decorated_user->_setMetaDataArray($meta_data_array);
       }

       if($extra_data_array){
           $decorated_user->_setExtraDataArray($extra_data_array);
       }

       return $decorated_user;

   }

}