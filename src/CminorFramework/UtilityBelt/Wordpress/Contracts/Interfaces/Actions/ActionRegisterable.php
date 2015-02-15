<?php
namespace CminorFramework\UtilityBelt\Wordpress\Interfaces\Actions;

/**
 * Defines the required functions for the wordpress action classes
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface ActionRegisterable
{

	/**
	 * Includes all the wordpress action hooks for the class that implements this interface
	 */
	public function register();


}