<?php
/* Glory to Ukraine! Glory to the heros! */

namespace Codelegacy\Crud\Model;

use Codelegacy\Crud\Api\Data\TagInterface;
use Magento\Framework\Model\AbstractModel;
use Codelegacy\Crud\Model\ResourceModel\Tag as ResourceModel;

class Tag extends AbstractModel implements TagInterface
{
    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->setData(self::TITLE, $title);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}