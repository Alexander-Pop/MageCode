<?php
/* Glory to Ukraine! Glory to the heros! */

namespace Codelegacy\Crud\Controller\Adminhtml\Category;

use Codelegacy\Crud\Api\CategoryRepositoryInterface;
use Codelegacy\Crud\Api\Data\CategoryInterface;
use Codelegacy\Crud\Controller\Adminhtml\AbstractMassDelete;
use Codelegacy\Crud\Helper\AclResources;
use Codelegacy\Crud\Model\ResourceModel\Category\Collection as CategoryCollection;

class MassDelete extends AbstractMassDelete
{
    /**
     * @return string
     */
    protected function _getAclResource()
    {
        return AclResources::CATEGORY_DELETE;
    }

    /**
     * @return string
     */
    protected function _getEntityTitle()
    {
        return CategoryInterface::ENTITY_TITLE;
    }

    /**
     * @return string
     */
    protected function _getCollectionClass()
    {
        return CategoryCollection::class;
    }

    /**
     * @return string
     */
    protected function _getRepositoryInterface()
    {
        return CategoryRepositoryInterface::class;
    }
}