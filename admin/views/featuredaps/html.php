<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsFeaturedapsHtml extends JViewHtml
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
		//$this->form = $form;
		//$this->item = $item;
	
		parent::display($tpl);
	}
  function render()
  {
    $app = JFactory::getApplication();
    $layout = $this->getLayout('layout');
    $featuredapsModel = new DdcbookitModelsFeaturedaps();
    $featuredapModel = new DdcbookitModelsFeaturedap();
 
    switch($layout) {

     	case "default":
     		default:
			$this->items = $featuredapsModel->listItems();
			$this->addToolbar();
			// Set the submenu
			DdcbookitHelpersDdcbookit::addSubmenu('featured apartments');
    	break;

    	case "edit":
    		$this->form = $featuredapModel->getForm();
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

        JToolBarHelper::title(JText::_('COM_DDCBOOKIT_FEATURED_APARTMENTS_MANAGE'));
        JToolBarHelper::addNew('featured.add');
               
        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_ddcbookit');
        }
    }
    protected function addUpdToolBar()
    {
    	$input = JFactory::getApplication()->input;
    	$input->set('hidemainmenu', true);
    	$isNew = (isset($this->items->ddcbookit_featuredapartment_id));
    	JToolBarHelper::title($isNew ? JText::_('COM_DDCBOOKIT_MANAGER_FEATURED_APARTMENT_NEW'): JText::_('COM_DDCBOOKIT_MANAGER_FEATURED_APARTMENT_EDIT'));
    	JToolBarHelper::save('featured.save');
    	JToolBarHelper::cancel('featured.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
    }
}