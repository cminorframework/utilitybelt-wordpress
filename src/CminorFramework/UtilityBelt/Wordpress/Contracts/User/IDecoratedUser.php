<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\User;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Models\IDecoratedModel;

interface IDecoratedUser extends IDecoratedModel
{

    public function getDisplayName();

}