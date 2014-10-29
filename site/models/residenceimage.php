<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsResidenceimage extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_residence_id		= null;
  var $_cat_id		    	= null;
  var $_pagination  		= null;
  var $_published   		= 1;
  var $_user_id     		= null;
  var $_formdata			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$app = JFactory::getApplication();
  	$this->_residence_id = $app->input->get('residence_id', null);
  	$this->_cat_id = $app->input->get('id', null);
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

    $query->select('residence.*');
    $query->from('#__ddcbookit_residences as residence');
    //$query->select('ri.ddcbookit_residence_id as res_image_id');
    //$query->select('ri.ddcbookit_residence_image_id');
    //$query->select('ri.image');
    //$query->leftJoin('#__ddcbookit_residence_images as ri on residence.ddcbookit_residence_id = ri.ddcbookit_residence_id');
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


  	if($this->_residence_id!=null)
  	{
  		$query->where('residence.ddcbookit_residence_id = "'.$this->_residence_id.'"');
  	}
   return $query;
  }
}