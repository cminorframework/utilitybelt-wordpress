<?php
namespace CminorFramework\UtilityBelt\Wordpress\Interfaces\Filters;

/**
 * Defines the functions for a class that registers wordpress filters
 *
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface FilterRegister
{

	/**
	 * Adds a wordpress action class to the register
	 *
	 * @param ActionRegisterable $action
	 */
	public function addFilter(FilterRegisterable $filter);

	/**
	 * Registers all the action classes
	 */
	public function registerFilters();

}