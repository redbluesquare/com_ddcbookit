<?php
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
//Display partial views
class DdcbookitViewsResidencesPhtml extends JViewHTML
{
  function render()
  {
  	$this->params = JComponentHelper::getParams('com_ddcbookit');
    return parent::render();
  }
}
