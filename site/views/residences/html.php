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
    $layout = $this->getLayout();
    
    //retrieve task list from model
    $apartmentsModel = new DdcbookitModelsApartments();
    $residenceModel = new DdcbookitModelsResidence();
    $bookModel = new DdcbookitModelsBooking();
 
    switch($layout) {
    	case "residence":
    		default:
    		$this->booking = $bookModel->listItems();
    		$this->apartments = $apartmentsModel->listItems();
    		$this->residence = $residenceModel->listItems();
    	break;
    }
 
    //display
    return parent::render();
  } 
}