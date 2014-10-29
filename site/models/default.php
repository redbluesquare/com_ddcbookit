<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsDefault extends JModelBase
{
  protected $__state_set  = null;
  protected $_total       = null;
  protected $_pagination  = null;
  protected $_db          = null;
  protected $id           = null;
  protected $catid        = null;
  protected $limitstart   = 0;
  protected $limit        = 100;
 
  function __construct()
  {
  	parent::__construct();
  	$this->_db = JFactory::getDBO();
  	
  	$app = JFactory::getApplication();
  	$ids = $app->input->get("cids",null,'array');
  	
  	$id = $app->input->get("apartment_id");
  	if ( $id && $id > 0 ){
  		$this->id = $id;
  	}else if ( count($ids) == 1 ){
  		$this->id = $ids[0];
  	}else{
  		$this->id = $ids;
  	}
  
  }
  public function store($data=null)
  {
  	$data = $data ? $data : JRequest::getVar('jform', array(), 'post', 'array');
  	$row = JTable::getInstance($data['table'],'Table');
  
  	$date = date("Y-m-d H:i:s");
  
  	// Bind the form fields to the table
  	if (!$row->bind($data))
  	{
  		return false;
  	}
  
  	$row->modified = $date;
  	if ( !$row->created )
  	{
  		$row->created = $date;
  	}
  
  	// Make sure the record is valid
  	if (!$row->check())
  	{
  		return false;
  	}
  
  	if (!$row->store())
  	{
  		return false;
  	}
  
  	return $row;
  
  }
  
  /**
   * Modifies a property of the object, creating it if it does not already exist.
   *
   * @param   string  $property  The name of the property.
   * @param   mixed   $value     The value of the property to set.
   *
   * @return  mixed  Previous value of the property.
   *
   * @since   11.1
   */
  public function set($property, $value = null)
  {
  	$previous = isset($this->$property) ? $this->$property : null;
  	$this->$property = $value;
  
  	return $previous;
  }
  
  public function get($property, $default = null)
  {
  	return isset($this->$property) ? $this->$property : $default;
  }
  
  /**
   * Build a query, where clause and return an object
   *
   */
  public function getItem($apartment_id=null, $checkin=null, $checkout=null)
  {
  	$db = JFactory::getDBO();
  
  	$query = $this->_buildQuery($apartment_id=null, $checkin=null, $checkout=null);
  	$this->_buildWhere($query, $apartment_id=null, $checkin=null, $checkout=null);
  	$db->setQuery($query);
  
  	$item = $db->loadObject();
  	return $item;
  }
  
  /**
   * Build query and where for protected _getList function and return a list
   *
   * @return array An array of results.
   */
  public function listItems($apartment_id=null, $checkin=null, $checkout=null)
  {
  	$query = $this->_buildQuery();
  	$this->_buildWhere($query, $apartment_id, $checkin, $checkout);
  
  	$list = $this->_getList($query, $this->limitstart, $this->limit);
  	return $list;
  }
  
  /**
   * Gets an array of objects from the results of database query.
   *
   * @param   string   $query       The query.
   * @param   integer  $limitstart  Offset.
   * @param   integer  $limit       The number of records.
   *
   * @return  array  An array of results.
   *
   * @since   11.1
   */
  protected function _getList($query, $limitstart = 0, $limit = 0)
  {
  	$db = JFactory::getDBO();
  	$db->setQuery($query, $limitstart, $limit);
  	$result = $db->loadObjectList();
  
  	return $result;
  }
  
  /**
   * Returns a record count for the query
   *
   * @param   string  $query  The query.
   *
   * @return  integer  Number of rows for query
   *
   * @since   11.1
   */
  protected function _getListCount($query)
  {
  	$db = JFactory::getDBO();
  	$db->setQuery($query);
  	$db->query();
  
  	return $db->getNumRows();
  }
  
  /* Method to get model state variables
   *
  * @param   string  $property  Optional parameter name
  * @param   mixed   $default   Optional default value
  *
  * @return  object  The property where specified, the state object where omitted
  *
  * @since   11.1
  */
  public function getState($property = null, $default = null)
  {
  	if (!$this->__state_set)
  	{
  		// Protected method to auto-populate the model state.
  		$this->populateState();
  
  		// Set the model state set flag to true.
  		$this->__state_set = true;
  	}
  
  	return $property === null ? $this->state : $this->state->get($property, $default);
  }
  
  /**
   * Get total number of rows for pagination
   */
  function getTotal()
  {
  	if ( empty ( $this->_total ) )
  	{
  		$query = $this->_buildQuery();
  		$this->_total = $this->_getListCount($query);
  	}
  
  	return $this->_total;
  }
  
  /**
   * Generate pagination
   */
  function getPagination()
  {
  	// Lets load the content if it doesn't already exist
  	if (empty($this->_pagination))
  	{
  		$this->_pagination = new JPagination( $this->getTotal(), $this->getState($this->_view.'_limitstart'), $this->getState($this->_view.'_limit'),null,JRoute::_('index.php?view='.$this->_view.'&layout='.$this->_layout));
  	}
  
  	return $this->_pagination;
  }
  function dateDiff($start, $end) {
  	$start_ts = strtotime($start);
  	$end_ts = strtotime($end);
  	$diff = $end_ts - $start_ts;
  	return round($diff / 86400);
  }
  /**
   * Method to auto-populate the model state.
   *
   * This method should only be called once per instantiation and is designed
   * to be called on the first call to the getState() method unless the model
   * configuration flag to ignore the request is set.
   *
   * @return  void
   *
   * @note    Calling getState in this method will result in recursion.
   * @since   12.2
   */
  protected function populateState()
  {
  }
  
  	/**
  	 * A function to check an apartment and return the price
  	 * @creator Darryl Usher
  	 * @param apartment_id $apartment_id
  	 * @param checkin $checkin
  	 * @param checkout $checkout
  	 * @return price
  	 */
static function apartmentprice($apartment_id, $checkin, $checkout)
  {
  	$checkinA = date_create($checkin);
  	$checkoutA = date_create($checkout);
  	$interval = date_diff($checkinA, $checkoutA);
  	$stayindays = $interval->format('%a');
  	$checkprices = new DdcbookitModelsApartments();
  	
  	$aparts = $checkprices->listItems();
  	$c=0;
  	while($aparts[$c]->ddcbookit_apartments_id!=$apartment_id)
  	{
  		$c++;
  	}
  	$residence = $aparts[$c]->res_id;
  	$proptype = $aparts[$c]->ddcbookit_proptype_id;
  	$category = (int)$aparts[$c]->catid;
  	
  	$check = false;
  	$getprice = $checkprices->getPrices();
  	$numprices=count($getprice);
  	$i=0;
  	while($check==false){
  		if($getprice[$i]->residence_id==$residence){
  			if($getprice[$i]->proptype_id==$proptype){
  				if((int)$getprice[$i]->catid==$category){
  					if($stayindays<=$getprice[$i]->max_days){
  						if(JHtml::date($checkin,"Y-m-d")<JHtml::date($getprice[$i]->enddate,"Y-m-d")){
 	 						$price=$getprice[$i]->price;
  							$check=true;
  						}
  					}
  				}
  			}
  		}
  		$i++;
  		if($i>$numprices){
  			//$price=1;
  			$check=true;
  		}
  	}
  	return $price;
  }

	/****************************************
	 * Function for checking each apartment whether
	 * it is available between two dates.
	 ****************************************/
	
static function checkmybooking($apartment_id, $checkin, $checkout)
	{
		$booking = new DdcbookitModelsBooking();
		$booking = $booking->listItems();
		foreach($booking as $item){
			if($checkin!=null || $checkout!=null){
			if($apartment_id == $item->apart_id){
				if($item->checkin!=null){
					if( (($checkin >= $item->checkin) And ($checkin < $item->checkout))
							Or (($checkin < $item->checkin) And ($checkout > $item->checkin))
							Or (($checkin < $item->checkin) And ($checkout > $item->checkin) And ($checkout <= $item->checkout))
							Or (($checkout > $item->checkin) And ($checkout <= $item->checkout))
					){
						return $apartment_id;
					}
				}
			}
			}
		}
	
	}

	

	
}