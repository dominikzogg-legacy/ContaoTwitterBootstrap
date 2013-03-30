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
 * MERCHANslideILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
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

class ContentBootstrapSlider extends ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_bootstrap_slider';

    const TYPE = 'bootstrapSlider';

    const SLIDER_WRAPPER_START = 'ce_bootstrap_slider_wrapper_start';
    const SLIDER_ELEMENT_START = 'ce_bootstrap_slider_element_start';
    const SLIDER_ELEMENT_STOP = 'ce_bootstrap_slider_element_stop';
    const SLIDER_WRAPPER_STOP = 'ce_bootstrap_slider_wrapper_stop';

    /**
     * Generate the content element
     */
    protected function compile()
    {
        // wrapper start
        if($this->bootstrapSliderType == self::SLIDER_WRAPPER_START)
        {
            $this->prepareWrapperStart();
        }

        // frontend
        if(TL_MODE == 'FE')
        {
            $this->assignFrontendTemplate($this->bootstrapSliderType);
        }
        // backend
        else
        {
            $this->assignBackendTemplate($this->bootstrapSliderType);
        }
    }

    protected function prepareWrapperStart()
    {
        // get slides
        $this->bootstrapSlideElements = $this->getSlideElements();

        // backend
        if(TL_MODE == 'BE')
        {
            // set slide title
            $this->backendTitle = 'slides: ' . implode(', ', $this->bootstrapSlideElements);

            // replace it with the error
            if(!empty($this->strError))
            {
                $this->backendTitle = "Error: {$this->strError}";
            }
        }
    }

    /**
     * @param string $strTemplate
     */
    protected function assignFrontendTemplate($strTemplate)
    {
        $this->strTemplate = $strTemplate;
        $this->Template = new FrontendTemplate($this->strTemplate);
        $this->Template->setData($this->arrData);
    }

    /**
     * @param string $strWildcard
     */
    protected function assignBackendTemplate($strWildcard)
    {
        $this->strTemplate = 'be_wildcard';
        $this->Template = new BackendTemplate($this->strTemplate);
        $this->Template->wildcard = "### {$strWildcard} ###";
        if(!empty($this->backendTitle))
        {
            $this->Template->title = $this->backendTitle;
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getSlideElements()
    {
        // prepare slide elements
        $arrReturn = array();

        // get all content elements in this article which are type slide and the sorting value is bigger or equal the wrapper start
        $objContentElement = $this->Database->prepare("
            SELECT
                id,
                bootstrapSliderType,
                bootstrapSliderTitle
            FROM
                tl_content
            WHERE
                type = ? AND
                pid = ? AND
                sorting >= ? AND
                invisible != 1
            ORDER BY
                sorting
        ")->execute(self::TYPE, $this->pid, $this->sorting);

        $boolOpenWrapper = false;
        $boolOpenElement = false;

        while($objContentElement->next())
        {
            switch($objContentElement->bootstrapSliderType)
            {
                case self::SLIDER_WRAPPER_START:
                    if($boolOpenWrapper)
                    {
                        $this->strError = 'There is a slide wrapper start within another wrapper!';
                    }
                    $boolOpenWrapper = true;
                    break;
                case self::SLIDER_ELEMENT_START:
                    if($boolOpenElement)
                    {
                        $this->strError = 'There is a slide element start within another element!';
                    }
                    $boolOpenElement = true;
                    $arrReturn[$objContentElement->id] = $objContentElement->bootstrapSliderTitle;
                    break;
                case self::SLIDER_ELEMENT_STOP:
                    if(!$boolOpenElement)
                    {
                        $this->strError = 'There is a slide element stop without a start element!';
                    }
                    $boolOpenElement = false;
                    break;
                case self::SLIDER_WRAPPER_STOP:
                    if($boolOpenElement)
                    {
                        $this->strError = 'There is a slide wrapper stop without a stop element!';
                    }
                    if(!$boolOpenWrapper)
                    {
                        $this->strError = 'There is a slide wrapper stop without a start wrapper!';
                    }
                    $boolOpenWrapper = false;
                    break 2;
                default:
                    throw new Exception("Unknown type, please contact the programmer!");
                    break;
            }
        }

        if(empty($arrReturn))
        {
            $this->strError = 'There are no elements!';
        }

        if($boolOpenWrapper)
        {
            $this->strError = 'There is no stop wrapper!';
        }

        return $arrReturn;
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        // prepare the types
        $arrReturn = array();

        // create new reflection class
        $objReflectionClass = new ReflectionClass(__CLASS__);

        // get class constants
        $arrConstants = $objReflectionClass->getConstants();

        // foreach constant in class
        foreach($arrConstants as $strConstantKey => $strConstantValue)
        {
            // only add constants begin with SLIDER_
            if(strpos($strConstantKey, 'SLIDER_') === 0)
            {
                $arrReturn[$strConstantValue] = $strConstantValue;
            }
        }

        // return the types
        return $arrReturn;
    }
}