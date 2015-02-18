<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Filters;

/**
 * Defines the required functions for the wordpress filter classes
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IFilterRegisterable
{

	/**
	 * registers the filter hooks in wordpress
	 */
	public function register();


}