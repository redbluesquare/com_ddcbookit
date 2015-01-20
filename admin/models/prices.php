<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsPrices extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_prices_id    		= null;
  var $_cat_id			    = null;
  var $_search_text	    	= null;
  var $_startdate	    	= null;
  var $_enddate		    	= null;
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
  	$this->_prices_id = $app->input->get('prices_id', null);
	$this->_formdata    = $app->input->get('jform', array(),'array');
	$this->session = JFactory::getSession();
	if($app->input->get('search_text', null)==null)
	{
		$this->_search_text = $this->session->get('searchtext');
	}
	else
	{
		$this->_search_text = $app->input->get('search_text', null);
		$this->session->set('searchtext',$app->input->get('search_text', null));
	}
	if($app->input->get('startdate', null)==null)
	{
		$this->_startdate = $this->session->get('startdate');
	}
	else
	{
		$this->_startdate = JHtml::date($app->input->get('startdate', null),"Y-m-d");
		$this->session->set('startdate',JHtml::date($app->input->get('startdate', null),"Y-m-d"));
	}
	if($app->input->get('enddate', null)==null)
	{
		$this->_enddate = $this->session->get('enddate');
	}
	else
	{
		$this->_enddate = JHtml::date($app->input->get('enddate', null),"Y-m-d");
		$this->session->set('enddate',JHtml::date($app->input->get('enddate', null),"Y-m-d"));
	}
	$this->task = $app->input->get('task', "", 'STR' );
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

    $query->select('prices.ddcbookit_apartment_price_id');
    $query->select('prices.residence_id');
    $query->select('prices.proptype_id');
    $query->select('prices.apartment_id');
    $query->select('prices.catid');
    $query->select('prices.min_days');
    $query->select('prices.max_days');
    $query->select('prices.days_before_discount');
    $query->select('prices.discount_price');
    $query->select('prices.price');
    $query->select('prices.startdate');
    $query->select('prices.enddate');
    $query->select('c.title as category_title');
    $query->select('res.ddcbookit_residence_id as id, res.residence_name as residence');
    $query->select('pt.proptype_title');
    $query->from('#__ddcbookit_apartment_prices as prices');
    $query->from('#__ddcbookit_proptypes as pt');
    $query->from('#__ddcbookit_apartments as apartment');
    $query->from('#__ddcbookit_residences as res');
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
  	if($this->_search_text!=null)
  	{
  		$query->where('CONCAT(res.residence_name,", ",pt.proptype_title,", ",c.title) LIKE "%'.$this->_search_text.'%"');
  	}
  	if($this->_startdate!=null)
  	{
  		$query->where('prices.startdate >= "'.$this->_startdate.'"');
  	}
  	if($this->_enddate!=null)
  	{
  		$query->where('prices.enddate <= "'.$this->_enddate.'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('res.state = "'.$this->_published.'"');
  	}
   return $query;
  }
  
  public function uploadPrices(){
  	$file = fopen(JRoute::_(JPATH_COMPONENT.'/assets/uploads/apartment_prices.csv'),'r');
  	$header = trim(fgets($file));
  	$header = explode(',', $header);
  	$colcount = count($header);
  	
  	$vals = fgets($file);
  	$vals = explode(',', $vals);
  	
  	while(!feof($file)):
  	// Get a db connection.
  	$db = JFactory::getDbo();
  	
  	// Create a new query object.
  	$query = $db->getQuery(true);
  	
  	// Insert columns.
  	$columns = $header;
  	
  	// Insert values.
  	$values = trim(fgets($file));
  	$values = explode(',', $values);
  	
  	if(count($values)==8):
  	// Prepare the insert query.
  	$query
  	->insert($db->quoteName('#__ddcbookit_apartment_prices'))
  	->columns($db->quoteName($columns))
  	->values(implode(',', $db->quote($values)));
  	
  	// Set the query using our newly populated query object and execute it.
  	$db->setQuery($query);
  	$db->query();
  	endif;
  	endwhile;
  	$rows = true;
  	return $rows;
  }
  
}