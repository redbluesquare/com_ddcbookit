<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitViewsProptypesRaw extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $type = $app->input->get('proptype');
    $id = $app->input->get('id');
    $view = $app->input->get('view');
 
    //retrieve task list from model
    $model = new DdcbookitModelsProptypes();
    
    $this->proptypes = $model->getProptype($id,$view,FALSE);
    
    //display
    echo $this->proptypes;
  } 
}
