<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsProfileHtml extends JViewHtml
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
		$this->item = $item;
	
		parent::display($tpl);
	}
  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    
    //retrieve task list from model
    //$profileModel = new DdcreportsModelsProfile();
    //$transfersModel = new DdcreportsModelsTransfers();
 	$bookModel = new DdcbookitModelsBooking();
    
    switch($layout) {
 
      case "dashboard":
        $this->profile = $bookModel->listItems();
      break;
 
      case "profile":
      default:
        $this->profile = $bookModel->listItems();
      break;
 
    }
 
    //display
    return parent::render();
  } 
}