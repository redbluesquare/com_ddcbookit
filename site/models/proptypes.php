<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsProptypes extends DdcbookitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_user_id     	= null;
  protected $messages;

  
  /**
   * 
   */
  function __construct()
  {
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

    $query->select('proptype.ddcbookit_proptype_id, proptype.proptype_title, proptype.proptype_description');
    $query->from('#__ddcbookit_proptypes as proptype');
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


  	//if($this->_checkin!=null)
  	//{
  	//	$query->where('ltap.ltap_qdatu = "'.$this->_confdate.'"');
  	//}
   return $query;
  }
  
  function storetype($data=null)
  {
  	$data = isset($data) ? $data : JRequest::get('post');
  	if ($data['check']=="typecheck")
  	{
	
		$type_title=$data['proptype_title'];
		$type_description=$data['proptype_description'];
	
		// Get a db connection.
		$db = JFactory::getDbo();
	
		// Create a new query object.
		$query = $db->getQuery(true);
	
		// Insert columns.
		$columns = array('proptype_title', 'proptype_description');
	
		// Insert values.
		$values = array($db->quote($type_title), $db->quote($type_description));
	
		// Prepare the insert query.
		$query
		->insert($db->quoteName('#__ddcbookit_proptypes'))
		->columns($db->quoteName($columns))
		->values(implode(',', $values));
	
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
	
		try {
			// Execute the query in Joomla 3.0.
			$result = $db->execute();
		} catch (Exception $e) {
			// catch any database errors.
		}
		return $result;
  	}
  }
  
}