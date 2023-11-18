<?php
namespace DigitalHub\DoubleCheck\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Change extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('digitalhub_doublecheck_changes', 'id');
    }
}
