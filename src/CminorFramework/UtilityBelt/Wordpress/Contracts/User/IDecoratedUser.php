<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\User;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost;

interface IDecoratedUser extends IDecoratedPost
{

    public function getDisplayName();

}