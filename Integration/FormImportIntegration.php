<?php

/*
 * @copyright   2020 MTCExtendee. All rights reserved
 * @author      MTCExtendee
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticFormImportBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;
use Mautic\UserBundle\Form\Type\UserListType;
use Symfony\Component\Form\FormBuilder;


class FormImportIntegration extends AbstractIntegration
{
    const INTEGRATION_NAME = 'FormImport';

    public function getName()
    {
        return self::INTEGRATION_NAME;
    }

    public function getDisplayName()
    {
        return 'Form Import';
    }

    public function getAuthenticationType()
    {
        return 'none';
    }

    public function getRequiredKeyFields()
    {
        return [
        ];
    }

    public function getIcon()
    {
        return 'plugins/MauticFormImportBundle/Assets/img/icon.png';
    }
}
