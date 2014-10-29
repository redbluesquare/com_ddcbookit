<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbookitModelsProfile extends DdcbookitModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);

    parent::__construct();       
  }
 
function getItem()
  {

    $profile = JFactory::getUser($this->_user_id);
    $userDetails = JUserHelper::getProfile($this->_user_id);
    $profile->details =  isset($userDetails->profile) ? $userDetails->profile : array();

    $profile->isMine = JFactory::getUser()->id == $profile->id ? TRUE : FALSE;

    return $profile;
  }

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('u.id, u.username, u.email, u.registerDate');
    $query->from('#__users as u');

    $query->select('cd.name, cd.address, cd.telephone, cd.suburb, cd.postcode, cd.id as contact_id');
    $query->leftjoin('#__contact_details as cd on cd.user_id = u.id');

    return $query;
  }

  protected function _buildWhere($query)
  {
    $query->group("u.id");
        
    return $query;
  }

}