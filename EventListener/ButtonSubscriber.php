<?php

/*
 * @copyright   2020 Mautic Contributors. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticFormImportBundle\EventListener;

use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomButtonEvent;
use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CoreBundle\Templating\Helper\ButtonHelper;
use Mautic\LeadBundle\Entity\Lead;
use Mautic\LeadBundle\Model\LeadModel;
use MauticPlugin\MauticCustomSmsBundle\Integration\CustomSmsSettings;
use MauticPlugin\MauticFormImportBundle\Integration\FormImportSettings;

class ButtonSubscriber extends CommonSubscriber
{
    private $event;

    private $objectId;

    /**
     * @var FormImportSettings
     */
    private $formImportSettings;


    /**
     * ButtonSubscriber constructor.
     *
     * @param FormImportSettings $formImportSettings
     */
    public function __construct(FormImportSettings $formImportSettings)
    {
        $this->formImportSettings = $formImportSettings;
    }


    public static function getSubscribedEvents()
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS => ['injectViewButtons', 0],
        ];
    }

    /**
     * @param CustomButtonEvent $event
     */
    public function injectViewButtons(CustomButtonEvent $event)
    {
        if (!$this->formImportSettings->isEnabled()) {
            return;
        }
        if (false === strpos($event->getRoute(), 'mautic_form_')) {
            return;
        }
        if (null === $event->getItem()) {
            return;
        }
        $this->setEvent($event);

        /** @var Lead $object */
        $object = $event->getItem();
        if (method_exists($object, 'getId')) {
            $this->setObjectId($event->getItem()->getId());
        }
        $this->addButtonGenerator(
            null,
            $this->translator->trans('mautic.formimport.import.results'),
            'fa fa-upload',
            'form',
            2,
            '',
            $this->translator->trans('mautic.formimport.import.results')
        );
    }

    /**
     * @param        $objectId
     * @param        $btnText
     * @param        $icon
     * @param        $context
     * @param int    $priority
     * @param null   $target
     * @param string $header
     */
    private function addButtonGenerator(
        $objectId,
        $btnText,
        $icon,
        $context,
        $priority = -10,
        $target = null,
        $header = ''
    ) {
        $event = $this->getEvent();
        $route = $this->router->generate(
            'mautic_import_action',
            ['object' => 'form-'.$this->getObjectId(), 'objectAction' => 'new']
        );

        $attr = [
            'href'        => $route,
            'data-toggle' => 'ajax',
            'data-method' => 'POST',
        ];

        switch ($target) {
            case '_blank':
                $attr['data-toggle'] = '';
                $attr['data-method'] = '';
                $attr['target']      = $target;
                break;
            case '#MauticSharedModal':
                $attr['data-toggle'] = 'ajaxmodal';
                $attr['data-method'] = '';
                $attr['data-target'] = $target;
                $attr['data-header'] = $header;
                break;
        }

        $button =
            [
                'attr'      => $attr,
                'btnText'   => $this->translator->trans($btnText),
                'iconClass' => $icon,
                'priority'  => $priority,
                'primary'   => false,
            ];

        // detail button
        $event
            ->addButton(
                $button,
                ButtonHelper::LOCATION_PAGE_ACTIONS,
                ['mautic_'.$context.'_action', ['objectAction' => 'view']]
            );

        $event
            ->addButton(
                $button,
                ButtonHelper::LOCATION_PAGE_ACTIONS,
                ['mautic_'.$context.'_action', ['objectAction' => 'view']]
            );

        $route                  = $this->router->generate(
            'mautic_import_index',
            ['object' => 'form-'.$this->getObjectId()]
        );
        $button['attr']['href'] = $route;
        $button['btnText']      = $this->translator->trans('mautic.formimport.import.history');
        $button['priority']     = 1;
        $button['iconClass']    = 'fa fa-history';
        $event
            ->addButton(
                $button,
                ButtonHelper::LOCATION_PAGE_ACTIONS,
                ['mautic_'.$context.'_action', ['objectAction' => 'view']]
            );


    }

    /**
     * @return CustomButtonEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed CustomButtonEvent
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return mixed
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * @param mixed $objectId
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;
    }
}
