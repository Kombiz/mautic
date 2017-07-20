<?php

namespace MauticPlugin\MauticCrmBundle\Integration\Pipedrive\Export;

use Mautic\LeadBundle\Entity\CompanyLead;
use Mautic\LeadBundle\Entity\Lead;
use MauticPlugin\MauticCrmBundle\Entity\PipedriveDeal;
use MauticPlugin\MauticCrmBundle\Entity\PipedriveOwner;
use MauticPlugin\MauticCrmBundle\Integration\Pipedrive\AbstractPipedrive;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DealExport extends AbstractPipedrive
{
    public function create(PipedriveDeal $deal, Lead $lead)
    {
        $leadId                = $lead->getId();
        $leadIntegrationEntity = $this->getLeadIntegrationEntity(['internalEntityId' => $leadId]);



        $params = [
            'title'     => $deal->getTitle(),
            'stage_id'  => $deal->getStage()->getStageId(),
            'person_id' => $leadIntegrationEntity->getIntegrationEntityId(),
        ];

        try {
            $this->getIntegration()->getApiHelper()->createDeal($params);

            return true;
        }
        catch (\Exception $e) {
            $this->getIntegration()->logIntegrationError($e);
        }

        return false;
    }
}
