<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsPrices extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_prices_id    		= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_published   	= 1;
  var $_user_id     	= null;
  var $_formdata		= null;
  protected $messages;

  public function __construct($config = array())
  {
  	if (empty($config['filter_fields']))
  	{
  		$config['filter_fields'] = array(
  				'ddcbookit_apartment_price_id', 'prices.ddcbookit_apartment_price_id',
  		);
  		$app = JFactory::getApplication();
  		//If no User ID is set to current logged in user
  		$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  		$this->_prices_id = $app->input->get('prices_id', null);
  		$app = JFactory::getApplication();
  		$jinput = JFactory::getApplication()->input;
  		$this->_formdata    = $jinput->get('jform', array(),'array');
  		$this->task = $jinput->get('task', "", 'STR' );
  	}
  
  	parent::__construct($config);
  }
  
//   function __construct()
//   {
//   	$app = JFactory::getApplication();
//   	//If no User ID is set to current logged in user
//   	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
//   	$this->_prices_id = $app->input->get('prices_id', null);
//   	$app = JFactory::getApplication();
//   	$jinput = JFactory::getApplication()->input;
// 	$this->_formdata    = $jinput->get('jform', array(),'array');
// 	$this->task = $jinput->get('task', "", 'STR' );
//     parent::__construct();       
//   }
    
	
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

    $query->select('prices.ddcbookit_apartment_price_id');
    $query->select('prices.residence_id');
    $query->select('prices.proptype_id');
    $query->select('prices.apartment_id');
    $query->select('prices.catid');
    $query->select('prices.min_days');
    $query->select('prices.max_days');
    $query->select('prices.price');
    $query->select('prices.startdate');
    $query->select('prices.enddate');
    $query->select('c.title as category_title');
    $query->select('res.ddcbookit_residence_id as id, res.residence_name as residence');
    $query->select('pt.proptype_title');
    $query->from('#__ddcbookit_proptypes as pt');
    $query->from('#__ddcbookit_apartments as apartment');
    $query->from('#__ddcbookit_residences as res');
    $query->from('#__ddcbookit_apartment_prices as prices');
    $query->from('#__categories as c');
    $query->where('prices.apartment_id = apartment.ddcbookit_apartments_id');
    $query->where('pt.ddcbookit_proptype_id = apartment.proptype_id');
    $query->where('apartment.residence_name = res.ddcbookit_residence_id');
    $query->where('apartment.catid = c.id');
    $query->order('prices.apartment_id ASC');
    $query->order('prices.min_days ASC');
    $query->order('prices.startdate ASC');
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


  	if($this->_prices_id!=null)
  	{
  			$query->where('prices.ddcbookit_apartment_price_id = "'.(int)$this->_prices_id.'"');
  	}
   return $query;
  }
}
