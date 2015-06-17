<?php

namespace Moln\ModelManager\InputFilter;
use Zend\InputFilter\InputFilter;


/**
 * Class UiConfigInputFilter
 * @package Moln\ModelManager\InputFilter
 * @author Xiemaomao
 * @version $Id$
 */
class UiConfigInputFilter extends InputFilter
{

    public function __construct()
    {
        $jsonEncodeFilter = [
            'name' => 'callback',
            'options' => [
                'callback' => function ($value) {
                    return json_encode($value);
                }
            ]
        ];

        $inputs = [
            //
            [
                'name' => 'name',
            ],
            [
                'name' => 'source',
            ],
            [
                'name' => 'source_adapter',
            ],
            //

            //
            [
                'name' => 'ui_hidden',
                'filters' => [
                    [
                        'name' => 'callback',
                        'options' => [
                            'callback' => function ($value) {
                                foreach ($value as $key => &$val) {
                                    $val = (bool) $val;
                                }

                                return json_encode($value);
                            }
                        ]
                    ]
                ],
            ],
            [
                'name' => 'ui_title',
                'filters' => [$jsonEncodeFilter],
            ],
            [
                'name' => 'ui_template',
                'filters' => [$jsonEncodeFilter],
            ],
            [
                'name' => 'ui_width',
                'filters' => [$jsonEncodeFilter],
            ],
            [
                'name' => 'ui_index',
                'filters' => [$jsonEncodeFilter],
            ],
            [
                'name' => 'ui_sortable',
                'filters' => [$jsonEncodeFilter],
            ],
            [
                'name' => 'ui_filterable',
                'filters' => [$jsonEncodeFilter],
            ],
            [
                'name' => 'ui_type',
                'filters' => [$jsonEncodeFilter],
            ],
            //
            [
                'name' => 'detail_enable',
                'fallback_value' => false,
            ],
            [
                'required' => false,
                'name' => 'detail_template',
            ],
        ];


        foreach ($inputs as $input) {
            $this->add($input);
        }
    }
}