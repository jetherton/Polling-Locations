<?php defined('SYSPATH') or die('No direct script access.');
 /**
 * Polling Locations Model
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Rachel Higley <me@rachelhigley.com>
 * @package    Polling Locations, Ushahidi Plugin 
 * @copyright  Rachel Higley rachelhigley.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
* 
*/
?>

<script type="text/javascript">

var polling_locations_settings = <?=$settings?>;



jQuery(document).ready(function($) {
			
			$(polling_locations_settings.button_placement).append('<?=$button?>');

			$(polling_locations_settings.button_selector).on('click',function(){

					var address_value = $(polling_locations_settings.address_selector).val(),
						city_value = $(polling_locations_settings.city_selector).val(),
						state_value = $(polling_locations_settings.state_selector).val(),
						zip_value = $(polling_locations_settings.zip_selector).val(),
						full_address = address_value + " " + city_value + ", " + state_value + " " + zip_value,
						url = "https://www.googleapis.com/civicinfo/us_v1/voterinfo/"+polling_locations_settings.election_id+"/lookup?officialOnly=false&fields=pollingLocations(address%2CendDate%2Cname%2Cnotes%2CpollingHours%2CstartDate%2CvoterServices)&key="+polling_locations_settings.api_key;
						


					$.ajax({
					  url: url,
					  type: 'POST',		
					  dataType: 'json',
					  contentType: 'application/json; charset=utf-8',
					  data: JSON.stringify({address: full_address}),
					  processData: false,
					  success: function(data, textStatus, xhr) {
					  
					   	if(!$.isEmptyObject(data))
					   	{
					   		var locations = "";
					   		$(data.pollingLocations).each(function(index,location){

					   			var html = "<div class='polling_locations'>\n";
					   			html += "<div class='locationName'>" +location.address.locationName + "</div>\n";
					   			html += "<div class='line1'>" + location.address.line1 + "</div>\n"; 
					   			html += "<div class='line2'>" + location.address.line2 + "</div>\n";
					   			html += "<div class='line3'>" + location.address.line3 + "</div>\n";
					   			html += "<div class='cityStateZip'>" + location.address.city + ", " + location.address.state +" " + location.address.zip +"</div>\n";
					   			html += "<div class='hours'>Hours: "+location.pollingHours + "</div>\n";
					   			html += "</div> \n";
					   			locations += html;
					   		});

					   		$(polling_locations_settings.info_box_selector).html(locations);

					   	}

					   	else 
					   	{

					   		$(polling_locations_settings.info_box_selector).html("<div class='locationError'>"+polling_locations_settings.errorMessage+"</div>");

					   	}
					  },
					  error: function(xhr, textStatus, errorThrown) {

					    $(polling_locations_settings.info_box_selector).html("<div class='locationError'>"+polling_locations_settings.errorMessage+"</div>");

					  }
					});
					
			});

		});

</script>