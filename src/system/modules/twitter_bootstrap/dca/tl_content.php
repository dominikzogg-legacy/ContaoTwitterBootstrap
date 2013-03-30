<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Dominik Zogg
 * @author     Dominik Zogg <dominik.zogg@gmail.com>
 * @package    twitter_bootstrap
 * @license    LGPLv3
 */

$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentBootstrapSlider::TYPE] = '{type_legend},type,bootstrapSliderType';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'bootstrapSliderType';
$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentBootstrapSlider::SLIDER_WRAPPER_START] = '{type_legend},type,bootstrapSliderType;{bootstrapSlider_legend},bootstrapSliderInterval,bootstrapSliderPause;{protected_legend:hide},protected;{expert_legend:hide},guests,invisible,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentBootstrapSlider::SLIDER_ELEMENT_START] = '{type_legend},type,bootstrapSliderType;{bootstrapSlider_legend},bootstrapSliderTitle';
$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentBootstrapSlider::SLIDER_ELEMENT_STOP] = '{type_legend},type,bootstrapSliderType';
$GLOBALS['TL_DCA']['tl_content']['palettes'][ContentBootstrapSlider::SLIDER_WRAPPER_STOP] = '{type_legend},type,bootstrapSliderType';

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrapSliderType'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_content']['bootstrapSliderType'],
    'inputType'             => 'radio',
    'options'               => ContentBootstrapSlider::getTypes(),
    'reference'             => &$GLOBALS['TL_LANG']['tl_content'],
    'eval'                  => array
    (
        'helpwizard'        => true,
        'submitOnChange'    => true,
        'mandatory'         => true,
    )
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrapSliderInterval'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_content']['bootstrapSliderInterval'],
    'inputType'             => 'text',
    'default'               => 5000,
    'eval'                  => array
    (
        'maxlength'         => 5,
        'mandatory'         => true,
        'rgxp'              => 'digit',
        'nospace'           => true,
        'tl_class'          => 'w50'
    )
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrapSliderPause'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_content']['bootstrapSliderPause'],
    'inputType'             => 'text',
    'default'               => 'hover',
    'eval'                  => array
    (
        'mandatory'         => true,
        'rgxp'              => 'alpha',
        'nospace'           => true,
        'tl_class'          => 'w50'
    )
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrapSliderTitle'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_content']['bootstrapSliderTitle'],
    'inputType'             => 'text',
    'default'               => '',
    'eval'                  => array
    (
        'tl_class'          => 'w50'
    )
);