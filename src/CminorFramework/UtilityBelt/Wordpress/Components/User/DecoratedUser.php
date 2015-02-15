<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\User;

use CminorFramework\UtilityBelt\Wordpress\Contracts\User\IDecoratedUser;
use CminorFramework\UtilityBelt\Wordpress\Components\Models\DecoratedModel;

class DecoratedUser extends DecoratedModel implements IDecoratedUser
{

    public function getDisplayName()
    {

        return $this->raw_object->get('display_name');

    }

}