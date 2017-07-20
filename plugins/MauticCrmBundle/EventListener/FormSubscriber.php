<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCrmBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\FormBundle\Event\FormBuilderEvent;
use Mautic\FormBundle\FormEvents;

/**
 * Class FormSubscriber.
 * inspired from EmailBundle/FormSubscriber
 */
class FormSubscriber extends CommonSubscriber
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::FORM_ON_BUILD => ['onFormBuilder', 0],
        ];
    }

    /**
     * Add a send email actions to available form submit actions.
     *
     * @param FormBuilderEvent $event
     */
    public function onFormBuilder(FormBuilderEvent $event)
    {
        // Add form submit actions
        $action = [
            'group'             => 'mautic.pipedrive.actions',
            'label'             => 'mautic.pipedrive.actions.push_offer',
            'description'       => 'mautic.pipedrive.actions.tooltip',
            'formType'          => 'pipedrive_offer_action',
            //'formTheme'   => 'MauticPluginBundle:FormTheme\Integration',
            'callback'          => ['\\MauticPlugin\\MauticCrmBundle\\Helper\\EventHelper', 'pushOffer'],
            //            'allowCampaignForm' => true,
        ];

        $event->addSubmitAction('pipedrive.push_offer', $action);
    }
}
