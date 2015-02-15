<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Actions;

/**
 * Defines the required functions for the wordpress action classes
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IActionRegisterable
{

	/**
	 * Includes all the wordpress action hooks for the class that implements this interface
	 */
	public function register();


}