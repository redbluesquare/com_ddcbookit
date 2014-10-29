<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsProptypes extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_proptypes_id    		= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_published   	= 1;
  var $_user_id     	= null;
  var $_formdata		= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$this->_proptypes_id = $app->input->get('proptypes_id', null);
  	$app = JFactory::getApplication();
  	$jinput = JFactory::getApplication()->input;
	$this->_formdata    = $jinput->get('jform', array(),'array');
  	  	
    parent::__construct();       
  }
    
	
  /**
  * Builds the query to be used by the product model
  * @return   object  Query object
  *
  *
  */
  protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('proptypes.ddcbookit_proptype_id');
    $query->select('proptypes.proptype_title');
    $query->select('proptypes.state');
    $query->select('proptypes.proptype_description');
    $query->from('#__ddcbookit_proptypes as proptypes');
    $query->group('proptypes.ddcbookit_proptype_id');
    return $query;
    
  }

  /**
  * Builds the filter for the query
  * @param    object  Query object
  * @return   object  Query object
  *
  */
  protected function _buildWhere(&$query)
  {


  	if($this->_proptypes_id!=null)
  	{
  		$query->where('proptypes.ddcbookit_proptype_id = "'.(int)$this->_proptypes_id.'"');
  	}
   return $query;
  }
}