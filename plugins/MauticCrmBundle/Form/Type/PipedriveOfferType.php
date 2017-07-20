<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCrmBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use MauticPlugin\MauticCrmBundle\Entity\PipedriveStage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotEqualTo;

class PipedriveOfferType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $stages = $this->em->getRepository(PipedriveStage::class)
            ->createQueryBuilder('st')
            ->join('st.pipeline', 'p')
            ->addOrderBy('p.name', 'ASC')
            ->addOrderBy('st.order', 'ASC')
            ->getQuery()
            ->getResult();
        // $products = $this->em->getRepository(PipedriveProduct::class)->findBy([], ['name' => 'ASC']);

        $stageChoices = [];
        foreach ($stages as $stage) {
            $stageChoices[$stage->getPipeline()->getName()][$stage->getId()] =  $stage->getName();
        }

        // $productChoices = [];
        // foreach ($products as $product) {
        //     $productChoices[$product->getId()] = $product->getId();
        // }

        // $builder->add('product', 'choice', [
        //     'label'   => 'mautic.pipedrive.stage.label',
        //     'choices' => $productChoices,
        // ]);

        $builder->add(
            'title',
            'text',
            [
                'label' => 'mautic.pipedrive.offer_name.label',
                //'data'  => (isset($data['offer_name'])) ? $data['offer_name'] : '',
                'attr'  => [
                    'tooltip' => 'mautic.pipedrive.offer_name.tooltip',
                ],
            ]
        );
        $builder->add('stage', 'choice', [
            'label'   => 'mautic.pipedrive.stage.label',
            'choices' => $stageChoices,
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'label' => false,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pipedrive_offer_action';
    }

}
