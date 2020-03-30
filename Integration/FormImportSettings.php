<?php

/*
 * @copyright   2020 MTCExtendee. All rights reserved
 * @author      MTCExtendee
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticFormImportBundle\Integration;

use Mautic\CoreBundle\Helper\ArrayHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;

class FormImportSettings
{

    /**
     * @var bool|\Mautic\PluginBundle\Integration\AbstractIntegration
     */
    private $integration;

    private $enabled = false;

    /**
     * @var array
     */
    private $settings = [];

    /**
     * DolistSettings constructor.
     *
     * @param IntegrationHelper $integrationHelper
     */
    public function __construct(IntegrationHelper $integrationHelper)
    {
        $this->integration = $integrationHelper->getIntegrationObject('FormImport');
        if ($this->integration instanceof FormImportIntegration && $this->integration->getIntegrationSettings(
            )->getIsPublished()) {
            $this->settings = $this->integration->mergeConfigToFeatureSettings();
            $this->enabled = true;
        }
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
