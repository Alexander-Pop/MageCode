<?php
/* Glory to Ukraine! Glory to the heros! */

namespace Codelegacy\Crud\Controller\Adminhtml\Post;

use Codelegacy\Crud\Api\Data\PostInterface;
use Codelegacy\Crud\Api\PostRepositoryInterface;
use Codelegacy\Crud\Controller\Adminhtml\AbstractIndex;
use Codelegacy\Crud\Helper\AclResources;

class Index extends AbstractIndex
{
    /**
     * @return string
     */
    protected function _getAclResource()
    {
        return AclResources::POST;
    }

    /**
     * @return string
     */
    protected function _getEntityTitle()
    {
        return __(PostInterface::ENTITY_TITLE);
    }

    /**
     * @return string
     */
    protected function _getRepositoryInterface()
    {
        return PostRepositoryInterface::class;
    }
}