<?php
/**
 * PHPWord
 *
 * Copyright (c) 2013 PHPWord
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPWord
 * @package    PHPWord
 * @copyright  Copyright (c) 2013 PHPWord
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    0.7.0
 */

/** PHPWORD_BASE_PATH */
if (!defined('PHPWORD_BASE_PATH')) {
    define('PHPWORD_BASE_PATH', dirname(__FILE__) . '/');
    require PHPWORD_BASE_PATH . 'PHPWord/Autoloader.php';
    PHPWord_Autoloader::Register();
}


/**
 * PHPWord
 */
class PHPWord
{

    /**
     * Document properties
     *
     * @var PHPWord_DocumentProperties
     */
    private $_properties;

    /**
     * Default Font Name
     *
     * @var string
     */
    private $_defaultFontName;

    /**
     * Default Font Size
     *
     * @var int
     */
    private $_defaultFontSize;

    private $_sectionCollection = array();


    public function __construct()
    {
        $this->_properties = new PHPWord_DocumentProperties();
        $this->_defaultFontName = 'Arial';
        $this->_defaultFontSize = 20;
    }

    public function getProperties()
    {
        return $this->_properties;
    }

    public function setProperties(PHPWord_DocumentProperties $value)
    {
        $this->_properties = $value;
        return $this;
    }

    public function createSection($settings = null)
    {
        $sectionCount = $this->_countSections() + 1;

        $section = new PHPWord_Section($sectionCount, $settings);
        $this->_sectionCollection[] = $section;
        return $section;
    }

    public function getDefaultFontName()
    {
        return $this->_defaultFontName;
    }

    public function setDefaultFontName($pValue)
    {
        $this->_defaultFontName = $pValue;
    }

    public function getDefaultFontSize()
    {
        return $this->_defaultFontSize;
    }

    public function setDefaultFontSize($pValue)
    {
        $pValue = $pValue * 2;
        $this->_defaultFontSize = $pValue;
    }

    public function addParagraphStyle($styleName, $styles)
    {
        PHPWord_Style::addParagraphStyle($styleName, $styles);
    }

    public function addFontStyle($styleName, $styleFont, $styleParagraph = null)
    {
        PHPWord_Style::addFontStyle($styleName, $styleFont, $styleParagraph);
    }

    public function addTableStyle($styleName, $styleTable, $styleFirstRow = null)
    {
        PHPWord_Style::addTableStyle($styleName, $styleTable, $styleFirstRow);
    }

    public function addTitleStyle($titleCount, $styleFont, $styleParagraph = null)
    {
        PHPWord_Style::addTitleStyle($titleCount, $styleFont, $styleParagraph);
    }

    public function addLinkStyle($styleName, $styles)
    {
        PHPWord_Style::addLinkStyle($styleName, $styles);
    }

    public function getSections()
    {
        return $this->_sectionCollection;
    }

    private function _countSections()
    {
        return count($this->_sectionCollection);
    }

   public function loadTemplate($strFilename)
    {
        if (file_exists($strFilename)) {
            $template = new PHPWord_Template($strFilename);
            return $template;
        } else {
            trigger_error('Template file ' . $strFilename . ' not found.', E_USER_ERROR);
        }
    }
}