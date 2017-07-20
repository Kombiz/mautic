<?php

namespace MauticPlugin\MauticCrmBundle\Integration\Pipedrive\Import;

use MauticPlugin\MauticCrmBundle\Entity\PipedriveProduct;

class ProductImport extends AbstractImport
{
    public function create(array $data = [])
    {
        $product = $this->em->getRepository(PipedriveProduct::class)->findOneByProductId($data['id']);
        if (!$product) {
            $product = new PipedriveProduct();
        }

        $product->setProductId($data['id']);
        $product->setName($data['name']);
        $product->setActive($data['active_flag']);
        $product->setSelectable($data['selectable']);

        $this->em->persist($product);
        $this->em->flush();

        return true;
    }

    public function update(array $data = [])
    {
        /**
         * @todo
         */
        // if (!$this->getIntegration()->isPipelineSupportEnabled()) {
        //     return; //feature disabled
        // }

        $product = $this->em->getRepository(PipedriveProduct::class)->findOneByProductId($data['id']);

        if (!$product) {
            return $this->create($data);
        }

        $update = false;
        foreach ($data as $field => $value) {
            switch($field) {
                case 'name':
                    if ($value != $product->getName()) {
                        $product->setName($value);
                        $update = true;

                    }
                    break;
                case 'active':
                    if ($value != $product->getActive()) {
                        $product->setActive($value);
                        $update = true;
                    }
                    break;
                case 'selectable':
                    if ($value != $product->getSelectable()) {
                        $product->setSelectable($value);
                        $update = true;
                    }
                    break;
            }
        }

        //$product->setDateModified(new \DateTime());

        if ($update) {
            $this->em->persist($product);
            $this->em->flush();
        }
    }

    public function delete(array $data = [])
    {
        /**
         * @todo
         */
        // if (!$this->getIntegration()->isPipelineSupportEnabled()) {
        //     return; //feature disabled
        // }

        $product = $this->em->getRepository(PipedriveProduct::class)->findOneByProductId($data['id']);

        if (!$product) {
            throw new \Exception('Product doesn\'t exist', Response::HTTP_NOT_FOUND);
        }

        $this->em->transactional(function ($em) use ($product) {
            $em->remove($product);
        });
    }
}
