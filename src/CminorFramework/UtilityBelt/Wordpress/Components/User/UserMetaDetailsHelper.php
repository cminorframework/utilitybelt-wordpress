<?php
namespace CminorFramework\UtilityBelt\Wordpress\Helpers\User;

/**
 * Helper class to retrieve user meta details data
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class UserMetaDetailsHelper
{

    protected $user_meta_details;

    public function _setUserMetaDetails($user_meta_details)
    {

        $this->user_meta_details = $user_meta_details;

        return $this;

    }

    /**
     * Returns a custom field from the user meta details
     * @param string $field_name
     * @return string
     */
    public function getCustomField($field_name)
    {
        $string = null;

        if ( isset($this->user_meta_details[$field_name]) ){

            if ( isset($this->user_meta_details[$field_name][0]) ){
                $string = $this->user_meta_details[$field_name][0];
            }
            else{
                $string = $this->user_meta_details[$field_name];
            }

        }

        return $string;
    }

   /**
    * Returns the function/job title
    * @return string
    */
    public function getJobTitle()
    {
        $string =  isset($this->user_meta_details['employee_jobtitle']) ? $this->user_meta_details['employee_jobtitle'][0] : null;
        return $string;
    }

    /**
     * Returns the user description meta field
     * @return string
     */
    public function getDescription()
    {
        $string =  isset($this->user_meta_details['description']) ? $this->user_meta_details['description'][0] : null;
        return $string;
    }

    /**
     * Returns the phone number
     * @return string
     */
    public function getPhone()
    {
        $string =   isset($this->user_meta_details['phone']) ? $this->user_meta_details['phone'][0] : null;
        return $string;
    }

    /**
     * Returns the facebook url
     * @return string
     */
    public function getFacebook()
    {
        $string =   isset($this->user_meta_details['facebook']) ? $this->user_meta_details['facebook'][0] : null;
        return $string;
    }

    /**
     * Returns the linked in url
     * @return string
     */
    public function getLinkedIn()
    {
        $string =   isset($this->user_meta_details['linkedin']) ? $this->user_meta_details['linkedin'][0] : null;
        return $string;
    }

    /**
     * Returns the twitter url
     * @return string
     */
    public function getTwitter()
    {
        $string =   isset($this->user_meta_details['twitter']) ? $this->user_meta_details['twitter'][0] : null;
        return $string;
    }


}