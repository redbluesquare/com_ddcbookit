<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsFeaturedaps extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_featured_id    	= null;
  var $_booking_id			= null;
  var $_cat_id		    	= null;
  var $_pagination  		= null;
  var $_published   		= 1;
  var $_user_id     		= null;
  var $_bookdate			= null;
  var $_checkin				= null;
  var $_checkout			= null;
  var $_formdata			= null;
  var $_ppl					= null;
  var $_proptype			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$app = JFactory::getApplication();
  	$this->_featured_id = $app->input->get('featured_id', null);

  	  	
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

    $query->select('f.*');
    $query->select('f.min_stay as minstay');
    $query->from('#__ddcbookit_featuredapartments as f');
    $query->select('residence.*');
    $query->leftjoin('#__ddcbookit_residences as residence on residence.ddcbookit_residence_id = f.residence_id');
    $query->select('apartment.residence_name as resi_id');
    $query->select('apartment.house_num');
    $query->select('apartment.min_stay');
    $query->select('apartment.ddcbookit_apartments_id as apart_id');
    $query->leftJoin('#__ddcbookit_apartments as apartment on residence.ddcbookit_residence_id = apartment.residence_name');
    $query->select('proptype.proptype_title');
    $query->leftJoin('#__ddcbookit_proptypes as proptype on f.proptype_id = proptype.ddcbookit_proptype_id');
    $query->group('ddcbookit_featuredapartment_id');
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
  	if($this->_featured_id!=null)
  	{
  		$query->where('f.ddcbookit_featuredapartment_id = "'.$this->_featured_id.'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('residence.state = "'.$this->_published.'"');
  	}
   return $query;
  }
  
}