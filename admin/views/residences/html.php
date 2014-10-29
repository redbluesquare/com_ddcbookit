<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsResidencesHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;
	/**
	 * Method to display the view.
	 *
	 * @param   string	The template file to include
	 * @since   1.6
	 */
	public function display($tpl = null)
	{
		// Get the view data.
	
		$this->form		= $this->get('Data');
		$this->form		= $this->get('Form');
		$this->form		= $this->get('Params');
		$this->form		= $this->get('State');
	
	
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
	
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
	
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
	
		parent::display($tpl);
	}
  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    $modelResidence = new DdcbookitModelsResidences();
    $formResidence = new DdcbookitModelsResidence();
    $modelServices = new DdcbookitModelsServices();
 
    switch($layout) {

     	case "default":
     		default:
			$this->items = $modelResidence->listItems();
			$this->addToolbar();
			// Set the submenu
			DdcbookitHelpersDdcbookit::addSubmenu('residences');
    	break;

    	case "edit":
    		$this->services = $modelServices->listItems();
    		$this->form = $formResidence->getForm();
    		$this->item = $modelResidence->getItem();
    		$this->_addserviceView = DdcbookitHelpersViewadmin::load('Residences', '_addservice', 'phtml');
    		$this->_addserviceView->services = $this->services;
    		$this->_addserviceView->residence = $this->item;
    		$this->addUpdToolbar();
    	break;
    		
    }
    
    $this->sidebar = JHtmlSidebar::render();
    //display
    return parent::render();
  }
   protected function addToolbar()
    {
        $canDo  = DdcbookitHelpersDdcbookit::getActions();

        // Get the toolbar object instance
        $bar = JToolBar::getInstance('toolbar');

        JToolBarHelper::title(JText::_('COM_DDCBOOKIT_MANAGER_RESIDENCE_EDIT'));
        //JToolBarHelper::deleteList('', 'residences.delete');
        //JToolBarHelper::editList('residence.edit');
        JToolBarHelper::addNew('residence.add');
               
        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_ddcbookit');
        }
    }
    protected function addUpdToolBar()
    {
    	$input = JFactory::getApplication()->input;
    	$input->set('hidemainmenu', true);
    	$isNew = (isset($this->items->ddcbookit_residence_id));
    	JToolBarHelper::title($isNew ? JText::_('COM_DDCBOOKIT_MANAGER_RESIDENCE_NEW'): JText::_('COM_DDCBOOKIT_MANAGER_RESIDENCE_EDIT'));
    	JToolBarHelper::save('residence.save');
    	JToolBarHelper::cancel('residence.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
    }
}