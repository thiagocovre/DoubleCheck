<?php
// app/code/DigitalHub/DoubleCheck/Block/Adminhtml/PricingApprovalGrid.php
namespace DigitalHub\DoubleCheck\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class PricingApprovalGrid extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_pricing_approval_grid';
        $this->_blockGroup = 'DigitalHub_DoubleCheck';
        $this->_headerText = __('Pricing Approval Grid');
        parent::_construct();
    }
}
