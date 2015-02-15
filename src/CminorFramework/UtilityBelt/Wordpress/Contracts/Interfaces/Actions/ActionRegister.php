<?php
namespace CminorFramework\UtilityBelt\Wordpress\Interfaces\Actions;

/**
 * Defines the functions for a class that registers wordpress actions
 *
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface ActionRegister
{

	/**
	 * Adds a wordpress action class to the register
	 *
	 * @param ActionRegisterable $action
	 */
	public function addAction(ActionRegisterable $action);

	/**
	 * Adds a worpdress action class to the admin actions register
	 * @param ActionRegisterable $action
	 */
	public function addAdminAction(ActionRegisterable $action);

	/**
	 * Registers all the action classes
	 */
	public function registerActions();

}