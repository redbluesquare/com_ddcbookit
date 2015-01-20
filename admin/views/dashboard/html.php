<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsDashboardHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

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
  	JToolBarHelper::help('JHELP_DDCBOOKIT',true,'http://redbluesquare.co.uk/custom-joomla-components/24-apartment-manager.html');
  
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcbookit');
  	}
  }
}