<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Filters;

/**
 * Defines the functions for a class that registers wordpress filters
 *
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IFilterRegister
{

	/**
	 * Adds a wordpress filter class to the register
	 *
	 * @param IFilterRegisterable $action
	 */
	public function addFilter(IFilterRegisterable $filter);

	/**
	 * Registers all the filter classes
	 */
	public function registerFilters();

}