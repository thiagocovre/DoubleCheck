<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'DigitalHub_DoubleCheck',
    __DIR__
);

// Classe Uninstall para mover o módulo por completo
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'DigitalHub_DoubleCheck',
    __DIR__,
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'DigitalHub_DoubleCheck\Setup\Uninstall'
);

