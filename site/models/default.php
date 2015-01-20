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
  protected $limit        = 500;
 
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
   * 
   * 
   */
  
  static public function randstring($max = 30)
  {
  	$randstring = null;
  	$chars = "abcdefghijklmnopqrstuvwxyz0123456789#&|?ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  	$arrchar = str_split($chars);
  	for($i=0;$i<$max;$i++)
  	{
  		$randomItem = array_rand($arrchar);
  		$randstring .=$arrchar[$randomItem];
  	}
  	return $randstring;
  }
  
  
  /**
   * Gets a list of all prices on an apartment and then filters to return the total price and days.
   *
   * @param		integer		$apartment_id		The apartment.
   * @param		datetime	$checkin			The checkin date in sql format Y-m-d.
   * @param		datetime	$checkout			The checkout date in sql format Y-m-d.
   * @param   	string   	$query       		The query.
   * @param		double		$total_price		The final price.
   * @param		integer		$total_days			The total nights stay.
   *
   * @return 	array		The price and days in an array result.
   */
  static public function apartment_price($apartment_id, $checkin, $checkout)
  {
  	$apartment_price 	= null;
  	$daysbeforedisc 	= null;
  	$discount_price 	= array();
  	$timeframedays 		= null;
  	$fulltf				= false;
  	
  	$modelPrices = new DdcbookitModelsPrices();
  	$prices = $modelPrices->listItems($apartment_id, $checkin, $checkout);
  	$checkinA = date_create($checkin);
  	$checkoutA = date_create($checkout);
  	$interval = date_diff($checkinA, $checkoutA);
  	$totaldays = $interval->format('%a');
  	$totaldays = (int)$totaldays;
  	for($i=0;$i<count($prices);$i++)
  	{
  		if(( $checkin >= $prices[$i]->startdate ) And ( $checkout <= $prices[$i]->enddate ))
  		{
  			if(($prices[$i]->days_before_discount!=0))
  			{
  				if($totaldays > $prices[$i]->days_before_discount)
  				{
  					$apartment_price += $prices[$i]->price*$prices[$i]->days_before_discount;
  					$apartment_price += $prices[$i]->discount_price*($totaldays-$prices[$i]->days_before_discount);
  					$daysbeforedisc = $prices[$i]->days_before_discount;
  				}
  				else
  				{
  					$apartment_price += $prices[$i]->price*$totaldays;
  				}

  			}
  			else
  			{
  				if(($prices[$i]->max_days >= "'.$totaldays.'") || ($prices[$i]->min_days <= "'.$totaldays.'"))
  				{
  					$apartment_price += $prices[$i]->price*$totaldays;
  				}
  				
  			}
			$fulltf = true;
  		}
  		if(($checkin >= $prices[$i]->startdate) And ($checkin <= $prices[$i]->enddate) And ($checkout > $prices[$i]->enddate) )
  		{
  			$intervaldays = null;
  			$c_in = date_create($checkin);
  			$c_out = date_create($prices[$i]->enddate);
  			$intervaldays = date_diff($c_in, $c_out);
  			$intervaldays = $intervaldays->format('%a');
  			$intervaldays = $intervaldays+1;
  			if( ($prices[$i]->days_before_discount!=0) )
  			{
  				if($prices[$i]->days_before_discount < $intervaldays)
  				{
  					$apartment_price += $prices[$i]->price*$prices[$i]->days_before_discount;
  					$apartment_price += $prices[$i]->discount_price*($intervaldays-$prices[$i]->days_before_discount);
  					$daysbeforedisc = $prices[$i]->days_before_discount;
  				}
  				elseif($prices[$i]->days_before_discount==$intervaldays)
  				{
  					$apartment_price += $prices[$i]->price*$prices[$i]->days_before_discount;
  					$daysbeforedisc = $prices[$i]->days_before_discount;
  				}
  				else 
  				{
  					$apartment_price += $prices[$i]->price*$intervaldays;
  					$daysbeforedisc = $intervaldays;
  				}
 			}
 			else 
 			{
 				$apartment_price += $prices[$i]->price*$intervaldays;
 			}
 			$fulltf = false;
  		}
  		if(( $checkin < $prices[$i]->startdate ) And ( $checkout > $prices[$i]->enddate ))
  		{
  			$intervaldays = null;
  			$c_in = date_create($prices[$i]->startdate);
  			$c_out = date_create($prices[$i]->enddate);
  			$intervaldays = date_diff($c_in, $c_out);
  			$intervaldays = $intervaldays->format('%a');
  			$intervaldays = $intervaldays+1;
  			
  			if(($prices[$i]->days_before_discount!=0))
  			{
  				if(($prices[$i]->days_before_discount-$daysbeforedisc)<$intervaldays)
  				{
  					$apartment_price += $prices[$i]->price*($prices[$i]->days_before_discount-$daysbeforedisc);
  					$apartment_price += $prices[$i]->discount_price*($intervaldays-($prices[$i]->days_before_discount-$daysbeforedisc));
  					$daysbeforedisc = $prices[$i]->days_before_discount;
  				}
  				elseif(($prices[$i]->days_before_discount-$daysbeforedisc)==$intervaldays)
  				{
  					$apartment_price += $prices[$i]->price*($prices[$i]->days_before_discount-$daysbeforedisc);
  					$daysbeforedisc = $prices[$i]->days_before_discount;
  				}
  				else
  				{
  					$apartment_price += $prices[$i]->price*$intervaldays;
  					$daysbeforedisc += $intervaldays;
  				}
  			}
  			else 
  			{
  				$apartment_price += $prices[$i]->price*$intervaldays;
  			}
  		}
  		
  		if(( $checkin < $prices[$i]->startdate ) And ( $checkout >= $prices[$i]->startdate ) And ( $checkout <= $prices[$i]->enddate ))
  		{
  			$intervaldays = null;
  			$c_in = date_create($prices[$i]->startdate);
  			$c_out = date_create($checkout);
  			$intervaldays = date_diff($c_in, $c_out);
  			$intervaldays = $intervaldays->format('%a');
  			
  			
  			if(($prices[$i]->days_before_discount!=0))
  			{
  				if(($prices[$i]->days_before_discount-$daysbeforedisc)<$intervaldays)
  				{
  					$apartment_price += $prices[$i]->price*($prices[$i]->days_before_discount-$daysbeforedisc);
  					$apartment_price += $prices[$i]->discount_price*($intervaldays-($prices[$i]->days_before_discount-$daysbeforedisc));
  					$daysbeforedisc = $prices[$i]->days_before_discount;
  				}
  					elseif(($prices[$i]->days_before_discount-$daysbeforedisc)==$intervaldays)
  				{
  					$apartment_price += $prices[$i]->price*($prices[$i]->days_before_discount-$daysbeforedisc);
  					$daysbeforedisc = $prices[$i]->days_before_discount;
  				}
  				else
  				{
  					$apartment_price += $prices[$i]->discount_price*$intervaldays;
  				}
  			}
  			else 
  			{
  				$apartment_price += $prices[$i]->price*$intervaldays;
  			}
  			$fulltf = true;
  		}
  	}
  	
  	$results = array($apartment_price,$totaldays,$fulltf);
  	
  	return $results;
  }
  
  public function write_to_csv($filename, $rows)
  {
  	$file = fopen($filename, 'w');
  	foreach ($rows as $row)
  	{
  		fputcsv($file, $row);
  
  	}
  	fclose($file);
  }
  
}