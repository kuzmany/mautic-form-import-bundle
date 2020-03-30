<?php

return [
    'name'        => 'MauticFormImportBundle',
    'description' => 'Form Import for Mautic',
    'version'     => '1.0',
    'author'      => 'MTCExtendee',

    'routes' => [
        'main'=>[
        ]
    ],

    'services'   => [
        'events'       => [
            'mautic.formimport.button.subscriber' => [
                'class'     => \MauticPlugin\MauticFormImportBundle\EventListener\ButtonSubscriber::class,
                'arguments' => [
                    'mautic.formimport.integration.settings'
                ],
            ],
            'mautic.formimport.subscriber.forms.import' => [
                'class'     => \MauticPlugin\MauticFormImportBundle\EventListener\ImportFormsSubscriber::class,
                'arguments' => [
                    'mautic.form.model.field',
                    'mautic.form.model.form',
                    'mautic.formimport.model.import.results',
                ],
            ],

        ],
        'forms'        => [
        ],
        'models'       => [
            'mautic.formimport.model.import.results' => [
                'class'     => \MauticPlugin\MauticFormImportBundle\Model\ImportResultsModel::class,
                'arguments' => [
                    'mautic.form.model.form',
                    'mautic.form.model.submission',
                    'mautic.lead.import.dispatcher',
                ],
            ],
        ],
        'integrations' => [
            'mautic.integration.formimport' => [
                'class'     => \MauticPlugin\MauticFormImportBundle\Integration\FormImportIntegration::class,
                'arguments' => [
                ],
            ],
        ],
        'others'       => [
            'mautic.formimport.integration.settings' => [
                'class'     => \MauticPlugin\MauticFormImportBundle\Integration\FormImportSettings::class,
                'arguments' => [
                    'mautic.helper.integration',
                ],
            ],
        ],
        'controllers'  => [
        ],
        'commands'     => [

        ],
    ],
    'parameters' => [
    ],
];
