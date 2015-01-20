<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsResidencesHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

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
    		$this->addUpdToolbar();
    	break;
    	
    	case "updater":

    		$this->items = $modelResidence->listItems();
    		$this->UpdToolbar();
    		// Set the submenu
    		DdcbookitHelpersDdcbookit::addSubmenu('residences');
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
    protected function UpdToolBar()
    {
    	$input = JFactory::getApplication()->input;
    	JToolBarHelper::title(JText::_('COM_DDCBOOKIT_MANAGER_RESIDENCE_EDIT'));
    	JToolbarHelper::apply('residence.apply');
    }
}