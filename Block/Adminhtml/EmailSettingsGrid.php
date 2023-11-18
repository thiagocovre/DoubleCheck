<?php
// app/code/DigitalHub/DoubleCheck/Block/Adminhtml/EmailSettingsGrid.php
namespace DigitalHub\DoubleCheck\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class EmailSettingsGrid extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_email_settings_grid';
        $this->_blockGroup = 'DigitalHub_DoubleCheck';
        $this->_headerText = __('Email Settings Grid');
        parent::_construct();
    }
}
