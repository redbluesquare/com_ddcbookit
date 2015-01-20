<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

class DdcbookitViewsApartmentsHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;
 
  function render()
  {
    $app = JFactory::getApplication();
    $layout = $this->getLayout();
    $params = JComponentHelper::getParams('com_ddcbookit');
    //retrieve task list from model
    $apartmentsModel = new DdcbookitModelsApartments();
    $servicesModel = new DdcbookitModelsServices();
    $residenceModel = new DdcbookitModelsResidence();
    $bookModel = new DdcbookitModelsBooking();
    
 
    switch($layout) {
     	case "apartments":
     		default:
     		$pathway = $app->getPathway();
     		$pathway->addItem('apartments', '');
     		$this->services = $servicesModel->listItems();
        	$this->residence = $residenceModel->getItem();
     		$this->apartments = $apartmentsModel->listItems();
     		$document = JFactory::getDocument();
     		$document->addScript('https://maps.googleapis.com/maps/api/js?key='.$params->get('google_api_key'));
     		$document->addScriptDeclaration('
    			function initialize() {
  					geocoder = new google.maps.Geocoder();
  					var latlng = new google.maps.LatLng(0.397, 50.644);
  					var mapOptions = {
    					zoom: 14,
    					center: latlng
  					}
  					map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
     				google.maps.event.trigger(map, \'resize\');
					jQuery(\'a[href="#location"]\').on(\'shown\', function(e) {
            			google.maps.event.trigger(map, \'resize\');
        			});
     			}
     			function codeAddress() {
     				var address = "'.$this->residence->post_code.', UK";
  					geocoder.geocode( { "address": address}, function(results, status) {
    					if (status == google.maps.GeocoderStatus.OK) {
      						map.setCenter(results[0].geometry.location);
      						var marker = new google.maps.Marker({
          						map: map,
          						position: results[0].geometry.location
      						});
     					}
  					});
     			}
     				google.maps.event.addDomListener(window, "load", initialize);
			');
      	break;
    	case "apartmentbook":
    		$pathway = $app->getPathway();
    		$pathway->addItem('book apartment', '');
    		$this->residence = $residenceModel->getItem();
    		$this->apartments = $apartmentsModel->getItem();
    		$this->services = $servicesModel->listItems();
    		$apartmentsModel->hit();
    	break;
    	case "booksummary":
    		$this->booking = $bookModel->getItem();

    		break;
    }
 
    //display
    return parent::render();
  } 
}