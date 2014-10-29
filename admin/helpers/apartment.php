<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * Residence component helper.
 */
abstract class ApartmentHelper
{
        /**
         * Configure the Linkbar.
         */
        public static function addSubmenu($submenu) 
        {
                JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_SUBMENU_MESSAGES'),
                                         'index.php?option=com_ddcbookit', $submenu == 'messages');
                JSubMenuHelper::addEntry(JText::_('COM_DDCBOOKIT_SUBMENU_CATEGORIES'),
                                         'index.php?option=com_categories&view=categories&extension=com_ddcbookit',
                                         $submenu == 'categories');
                // set some global property
                //$document = JFactory::getDocument();
                //$document->addStyleDeclaration('.icon-48-helloworld ' .
                //                               '{background-image: url(../media/com_helloworld/images/tux-48x48.png);}');
                if ($submenu == 'apartment') 
                {
                        $document->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION_CATEGORIES'));
                }
        }
}