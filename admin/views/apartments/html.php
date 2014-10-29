<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsApartmentsHtml extends JViewHtml
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
    $apartmentsModel = new DdcbookitModelsApartments();
    $apartmentModel = new DdcbookitModelsApartment();
 
    switch($layout) {

     	case "default":
     		default:
			$this->items = $apartmentsModel->listItems();
			$this->addToolbar();
			// Set the submenu
			DdcbookitHelpersDdcbookit::addSubmenu('apartments');
    	break;

    	case "edit":
    		$this->form = $apartmentModel->getForm();
    		$this->addUpdToolbar();
    	break;

    		
    }
    
    //$this->sidebar = JHtmlSidebar::render();
    //display
    return parent::render();
  }
   protected function addToolbar()
    {
        $canDo  = DdcbookitHelpersDdcbookit::getActions();

        // Get the toolbar object instance
        $bar = JToolBar::getInstance('toolbar');

        JToolBarHelper::title(JText::_('COM_DDCBOOKIT_APARTMENTS_MANAGE'));
        JToolBarHelper::addNew('apartment.add');
               
        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_ddcbookit');
        }
    }
    protected function addUpdToolBar()
    {
    	$input = JFactory::getApplication()->input;
    	$input->set('hidemainmenu', true);
    	$isNew = (isset($this->items->ddcbookit_apartments_id));
    	JToolBarHelper::title($isNew ? JText::_('COM_DDCBOOKIT_MANAGER_APARTMENT_NEW'): JText::_('COM_DDCBOOKIT_MANAGER_APARTMENT_EDIT'));
    	JToolBarHelper::save('apartment.save');
    	JToolBarHelper::cancel('apartment.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
    }
}