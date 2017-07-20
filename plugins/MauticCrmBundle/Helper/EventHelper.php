<?php

namespace MauticPlugin\MauticCrmBundle\Helper;

use Mautic\CoreBundle\Factory\MauticFactory;
use MauticPlugin\MauticCrmBundle\Entity\PipedriveDeal;

class EventHelper
{

    /**
     * @param               $lead
     * @param MauticFactory $factory
     */
    public static function pushOffer($config, $lead, MauticFactory $factory)
    {
        $integrationHelper = $factory->get('mautic.helper.integration');
        $myIntegration     = $integrationHelper->getIntegrationObject('Pipedrive');

        $em = $factory->getEntityManager();

        $leadExport = $factory->get('mautic_integration.pipedrive.export.lead');
        $leadExport->setIntegration($myIntegration);
        $leadExport->create($lead);

        $dealExport = $factory->get('mautic_integration.pipedrive.export.deal');
        $dealExport->setIntegration($myIntegration);

        $deal = new PipedriveDeal();
        $deal->setTitle($config['title']);
        // $deal->setProduct(
        //     $em->getReference('MauticPlugin\MauticCrmBundle\Entity\PipedriveProduct', $config['product'])
        // );
        $deal->setStage(
            $em->getReference('MauticPlugin\MauticCrmBundle\Entity\PipedriveStage', $config['stage'])
        );
        $deal->setLead($lead);

        return $dealExport->create($deal, $lead);
    }

}
