<?php
/* Glory to Ukraine! Glory to the heros! */

namespace Codelegacy\Customjs\Controller\Test;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Simple extends Action
{
    /**
     * Execute view action
     * @url domain/customjs/test/simple
     * @return ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}