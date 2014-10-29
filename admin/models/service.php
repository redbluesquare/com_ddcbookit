<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class DdcbookitModelsService extends JModelForm
{
	var $form    		= null;
	var $_user_id 		= null;

	function __construct()
	{

		parent::__construct();
	}
	
	public function getData()
	{
		if ($this->data === null)
		{
			$this->data = new stdClass;
			$app = JFactory::getApplication();
			$params = JComponentHelper::getParams('com_ddcbookit');
	
			// Override the base user data with any data in the session.
			$temp = (array) $app->getUserState('com_ddcbookit.service.data', array());
			foreach ($temp as $k => $v)
			{
				$this->data->$k = $v;
			}
	
		}
		return $this->data;
	}
	
	/**
	 * Method to get the package form.
	 *
	 * The base form is loaded from XML and then an event is fired
	 * for users plugins to extend the form with extra fields.
	 *
	 * @param   array    $data      An optional array of data for the form to interogate.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  JForm  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_ddcbookit.service', 'service', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
	
		return $form;
	}
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_ddcbookit.service.data', array());
		if (empty($data))
		{
			$jinput = JFactory::getApplication()->input;
			$task = $jinput->get('task', "", 'STR' );
			if($task != 'service.add')
			{
				$serviceModel = new DdcbookitModelsServices();
				$data = $serviceModel->getItem();
				return $data;
			}
		}
	}

	public function getInput()
	{
		parent::__construct();
	}

}
