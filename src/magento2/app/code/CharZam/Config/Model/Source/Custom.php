<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace CharZam\Config\Model\Source;

/**
 * @api
 * @since 100.0.2
 */
class Custom implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('First option')],
            ['value' => 2, 'label' => __('Second option')],
            ['value' => 3, 'label' => __('Third option')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            1 => __('First option'),
            2 => __('Second option'),
            3 => __('Third option')
        ];
    }
}
