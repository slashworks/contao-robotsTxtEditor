<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
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
 * @copyright  Joe Ray Gregory @ borowiakziehe KG 2012
 * @author     Joe Ray Gregory <jrgregory@borowiakziehe.de>
 * @package    robotsTextEditor
 * @license    LGPL
 * @filesource
 */

class RobotsTxtEditor extends BackendModule
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'robotsTxtEditor';

    /**
     * Compile the template
     */
    protected function compile()
    {
        $this->loadLanguageFile('tl_robotsTxtEditor');

        //generate file if not exist
        $file = new File('robots.txt');

        //name of the textarea where the robots.txt will be loaded
        $_textareaName = "content";

        // Template Vars
        $this->Template->textArea = $this->_generateTextArea($file, $_textareaName);
        $this->Template->href = $this->getReferer(true);
        $this->Template->title = specialchars($GLOBALS['TL_LANG']['MSC']['backBT']);
        $this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];
        $this->Template->submitText = $GLOBALS['TL_LANG']['MSC']['save'] ;


        //if new Data exist
        if($this->Input->post('FORM_SUBMIT') == 'is_send')
        {
            $file->write($this->Input->post($_textareaName));
            $this->redirect($this->Environment->requestUri);
        }

    }

    /**
     * generates the textarea for robots.txt content
     * @param $file
     * @param $_textareaName
     * @return string
     */
    private function _generateTextArea($file, $_textareaName)
    {
        $widget = new TextArea();
        $widget->id = $_textareaName;
        $widget->name = $_textareaName;
        $widget->value = $file->getContent();
        $widget->label = $GLOBALS['TL_LANG']['tl_robotsTxtEditor']['label'];

        //define html output
        $textareaTemplate = '<div class="long m12"><h3>%s</h3>%s<p class="tl_help tl_tip">%s</p></div>';

        return sprintf($textareaTemplate, $widget->generateLabel(),  $widget->generateWithError(), $GLOBALS['TL_LANG']['tl_robotsTxtEditor']['tip']);
    }
}