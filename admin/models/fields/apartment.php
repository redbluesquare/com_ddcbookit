<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldApartment extends JFormFieldList
{
        /**
         * The field type.
         *
         * @var         string
         */
        protected $type = 'HelloWorld';
 
        /**
         * Method to get a list of options for a list input.
         *
         * @return      array           An array of JHtml options.
         */
        protected function getOptions() 
        {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
 
                $query->select('#__ddcbookit_apartments.ddcbookit_apartment_id as ddcbookit_apartment_id,apartment_name,alias,proptype_title,#__ddcbookit_residences.residence_name as residence,residence_id');
                $query->from('#__ddcbookit_apartments');
                $query->leftJoin('#__ddcbookit_residences on residence_id=#__ddcbookit_residences.ddcbookit_residence_id');
                $messages = $db->loadObjectList();
                $options = array();
                if ($messages)
                {
                        foreach($messages as $message) 
                        {
                                $options[] = JHtml::_('select.option', $message->ddcbookit_apartment_id, $message->apartment_name .
                                                      ($message->residence_id ? ' (' . $message->apartment . ')' : ''));
                        }
                }
                $options = array_merge(parent::getOptions(), $options);
                return $options;
        }
}
