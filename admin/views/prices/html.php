<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsPricesHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    $modelPrices = new DdcbookitModelsPrices();
    $pricesFormModel = new DdcbookitModelsPrice();

 
    switch($layout) {

     	case "default":
     		default:
			$this->items = $modelPrices->listItems();
			$this->addToolbar();
			
			// Set the submenu
			DdcbookitHelpersDdcbookit::addSubmenu('prices');
    	break;

    	case "edit":
    		$this->form = $pricesFormModel->getForm();
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

        JToolBarHelper::title(JText::_('COM_DDCBOOKIT_MANAGER_APARTMENT_PRICES'));
        JToolBarHelper::addNew('price.add');
               
        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_ddcbookit');
        }
    }
    protected function addUpdToolBar()
    {
    	$input = JFactory::getApplication()->input;
    	$input->set('hidemainmenu', true);
    	$isNew = (isset($this->items->ddcbookit_price_id));
    	JToolBarHelper::title($isNew ? JText::_('COM_DDCBOOKIT_MANAGER_PRICE_NEW'): JText::_('COM_DDCBOOKIT_MANAGER_PRICE_EDIT'));
    	JToolBarHelper::save('price.save');
    	JToolBarHelper::cancel('price.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
    	JToolBarHelper::custom('price.delete','','','Delete',false);
    }
}