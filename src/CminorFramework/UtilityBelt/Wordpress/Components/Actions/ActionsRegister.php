<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Actions;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Actions\IActionRegisterable;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Actions\IActionRegister;

/**
 *
 * This class will handle the registration of wordpress actions
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class ActionsRegister implements IActionRegister
{

    /**
     * Holds the action classes that need to be registered in wordpress
     * @var array
     */
    protected $_action_classes = [];

    /**
     * Holds the admin action classes that need to be registered in wordpress
     * @var array
     */
    protected $_admin_action_classes = [];

    /**
     * Adds an action class to the register
     *
     * @param IActionRegisterable $action
     * @see \CminorFramework\UtilityBelt\Wordpress\Contracts\Actions\IActionRegister::addAction()
     */
    public function addAction(IActionRegisterable $action){

        if($action){
            $this->_action_classes[] = $action;
        }
        return $this;
    }

    /**
     * Adds an admin action class to the register
     * @see \CminorFramework\UtilityBelt\Wordpress\Contracts\Actions\IActionRegister::addAdminAction()
     */
    public function addAdminAction(IActionRegisterable $action)
    {
        if($action){
            $this->_admin_action_classes[] = $action;
        }
        return $this;
    }

    /**
     * Register all the actions classes found at the register
     * @see \CminorFramework\UtilityBelt\Wordpress\Contracts\Actions\IActionRegister::registerActions()
     */
    public function registerActions()
    {

        $this->_registerActionClasses();

        $this->_registerAdminActionClasses();

    }
    /**
     * Internal method that registers the regular action classes
     * Returns false if no action classes are found on the register
     * @return boolean
     */
    protected function _registerActionClasses()
    {

        if( !$this->_action_classes ){
            return false;
        }

        foreach($this->_action_classes as $action){
            $action->register();
        }

        return true;

    }

    /**
     * Internal method that registers the admin action classes
     * Returns false if not in admin
     * Returns false if no admin action classes are found on the admin register
     *
     * @return boolean
     */
    protected function _registerAdminActionClasses()
    {
        if(!is_admin()){
            return false;
        }

        if( !$this->_admin_action_classes ){
            return false;
        }

        //foreach class call the register method
        foreach($this->_admin_action_classes as $action){
            $action->register();
        }

        return true;

    }

}