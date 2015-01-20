<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsBookingsHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $app = JFactory::getApplication();
    $layout = $this->getLayout();
    $formBooking = new DdcbookitModelsBooking();
    $modelBookings = new DdcbookitModelsBookings();
    $modelPayments = new DdcbookitModelsPayments();
 
    switch($layout) {

     	case "default":
     		default:
			$this->items = $modelPayments->listItems();
			$this->addToolbar();
			// Set the submenu
			DdcbookitHelpersDdcbookit::addSubmenu('bookings');
    	break;

    	case "edit":
    		$this->item = $modelBookings->getItem();
    		$this->form = $formBooking->getForm();
    		$this->addUpdToolbar();
    	break;
    	
    	case "payments":
    		$this->payment = $modelPayments->getItem();
    		$this->addUpdToolbar1();
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

        JToolBarHelper::title(JText::_('COM_DDCBOOKIT_MANAGER_BOOKING_EDIT'));
        JToolBarHelper::addNew('booking.add');
               
        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_ddcbookit');
        }
    }
    protected function addUpdToolBar()
    {
    	$modelBookings = new DdcbookitModelsBookings();
    	$this->items = $modelBookings->listItems();
    	$input = JFactory::getApplication()->input;
    	$input->set('hidemainmenu', true);
    	$isNew = (isset($this->items->ddcbookit_bookings_id));
    	JToolBarHelper::title($isNew ? JText::_('COM_DDCBOOKIT_MANAGER_BOOKING_NEW'): JText::_('COM_DDCBOOKIT_MANAGER_BOOKING_EDIT'));
    	JToolBarHelper::save('booking.save');
    	JToolBarHelper::cancel('booking.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
    }
    protected function addUpdToolBar1()
    {
    	$input = JFactory::getApplication()->input;
    	$input->set('hidemainmenu', true);
    	$isNew = (isset($this->items->ddcbookit_bookings_id));
    	JToolBarHelper::title($isNew ? JText::_('COM_DDCBOOKIT_MANAGER_BOOKING_NEW'): JText::_('COM_DDCBOOKIT_VIEW_PAYMENT_DETAILS'));
    	JToolBarHelper::cancel('booking.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
    }
}