<?php
namespace CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Views;

interface View
{

    public function toHtml();

    /**
     * @param unknown $parameter_name
     * @param unknown $parameter_value
     * @return \CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Views\View
     */
    public function setViewParameters(array $view_parameters);

    public function getViewName();

}