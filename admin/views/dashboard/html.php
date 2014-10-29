<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsDashboardHtml extends JViewHtml
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
    $layout = $this->getLayout();
    
 
    switch($layout) {

     	case "default":
     		default:
			$this->addToolbar();
    	break;
    }
   
 
    //display
    return parent::render();
  }
  protected function addToolbar()
  {
  	$canDo  = DdcbookitHelpersDdcbookit::getActions();
  
  	// Get the toolbar object instance
  	$bar = JToolBar::getInstance('toolbar');
  
  	JToolBarHelper::title(JText::_('COM_DDCBOOKIT_DASHBOARD'));
  	JToolBarHelper::help('JHELP_DDCBOOKIT',true,'components/com_ddcbookit/help/en-GB/JHelp_Ddcbookit.php');
  
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcbookit');
  	}
  }
}