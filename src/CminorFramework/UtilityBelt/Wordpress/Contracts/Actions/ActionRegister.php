<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Actions;

/**
 * Defines the functions for a class that registers wordpress actions
 *
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IActionRegister
{

	/**
	 * Adds a wordpress action class to the register
	 *
	 * @param IActionRegisterable $action
	 */
	public function addAction(IActionRegisterable $action);

	/**
	 * Adds a worpdress action class to the admin actions register
	 * @param IActionRegisterable $action
	 */
	public function addAdminAction(IActionRegisterable $action);

	/**
	 * Registers all the action classes
	 */
	public function registerActions();

}