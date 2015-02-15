<?php
namespace CminorFramework\UtilityBelt\Wordpress\Extendables\Components\Controllers;
use CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Controllers\Controller;
use CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Views\View;

class Controller implements Controller
{

    protected $_views = [];

    /**
     *
     * @param string $view_name
     * @return \CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Views\View
     */
    public function getView($view_name)
    {

        if(isset($this->_views[$view_name])){
            return $this->_views[$view_name];
        }

        return $this->_views[$view_name];
    }

    /**
     * Sets the view to the controller
     * @param View $view
     * @return \CminorFramework\UtilityBelt\Wordpress\Extendables\Components\Controllers\Controller
     */
    public function setView(View $view)
    {
        $view_name = $view->getViewName();
        $this->_views[$view_name] = $view;
        return $this;
    }

}