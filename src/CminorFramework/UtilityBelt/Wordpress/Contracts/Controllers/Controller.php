<?php
namespace CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Controllers;
use CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Views\View;

interface Controller
{

    /**
     * @return \CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Views\View
     * @param unknown $view_name
     */
    public function getView($view_name);

    public function setView(View $view);


}