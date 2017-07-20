<?php

namespace  MauticPlugin\MauticCrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\LeadBundle\Entity\Lead;

class PipedriveDeal
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $dealId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var Lead
     */
    private $lead;

    /**
     * @var PipedriveStage
     */
    private $stage;


    /**
     * @param ORM\ClassMetadata $metadata
     */
    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('plugin_crm_pipedrive_deals')
            ->addUniqueConstraint(['deal_id'], 'unique_stage');

        $builder->addId();
        $builder->addNamedField('dealId', 'integer', 'deal_id', false);
        $builder->addNamedField('title', 'string', 'title', false);
        $builder->addLead();

        $stage = $builder->createManyToOne('stage', 'MauticPlugin\MauticCrmBundle\Entity\PipedriveStage');
        $stage->addJoinColumn('stage_id', 'id', $nullable = false, $unique = false, $onDelete = 'CASCADE')
            ->build();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getDealId()
    {
        return $this->dealId;
    }

    /**
     * @param integer $dealId
     *
     * @return PipedriveDeal
     */
    public function setDealId($dealId)
    {
        $this->dealId = $dealId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return PipedriveDeal
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Lead
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param Lead $lead
     *
     * @return PipedriveStage
     */
    public function setLead(Lead $lead)
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * @return PipedriveStage
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param PipedriveStage $stage
     *
     * @return PipedriveStage
     */
    public function setStage($stage)
    {
        $this->stage = $stage;

        return $this;
    }
}
