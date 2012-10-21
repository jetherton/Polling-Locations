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

var settings = <?=$settings?>;



jQuery(document).ready(function($) {
			
			$(settings.button_placement).append('<?=$button?>');

			$(settings.button_selector).on('click',function(){

					var address_value = $(settings.address_selector).val(),
						city_value = $(settings.city_selector).val(),
						state_value = $(settings.state_selector).val(),
						zip_value = $(settings.zip_selector).val(),
						full_address = address_value + " " + city_value + ", " + state_value + " " + zip_value,
						url = "https://www.googleapis.com/civicinfo/us_v1/voterinfo/"+settings.election_id+"/lookup?officialOnly=false&fields=pollingLocations(address%2CendDate%2Cname%2Cnotes%2CpollingHours%2CstartDate%2CvoterServices)&key="+settings.api_key;
						


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

					   			lastAddress = location.address.line1 + " " + location.address.line2 + " " + location.address.line3 + " " + location.address.city + ", " + location.address.state +" " + location.address.zip;
					   			var html = "<div id='pollingLocation"+index+"' class='location'>\n";
					   			//if there's more than one polling place then give the user the option to pick one
					   			if(data.pollingLocations.length > 1)
					   			{
						   			html += "<div class='usePollingPlace'><a href=\"#\" onclick='geoCodePollingPlace(\"" + location.address.line1 + " " + location.address.line2 + " " + location.address.line3 + " " + location.address.city + ", " + location.address.state +" " + location.address.zip + "\", "+index+"); return false;'>Use Polling Place</a></div>";
					   			}  
					   			if(location.address.locationName != undefined) {
					   				html += "<div class='locationName'>" +location.address.locationName + "</div>\n";	
					   			}
					   			if(location.address.line1 != undefined) {
					   				html += "<div class='line1'>" + location.address.line1 + "</div>\n"; 
					   			}
					   			if(location.address.line2 != undefined) {
						   			html += "<div class='line2'>" + location.address.line2 + "</div>\n";
						   		}
					   			if(location.address.line3 != undefined) {
						   			html += "<div class='line3'>" + location.address.line3 + "</div>\n";
						   		}
					   			html += "<div class='cityStateZip'>" + location.address.city + ", " + location.address.state +" " + location.address.zip +"</div>\n";
					   			if(location.pollingHours != undefined) {
					   				html += "<div class='hours'>Hours: "+location.pollingHours + "</div>\n";
					   			}
					   			html += "</div> \n";
					   			locations += html;
								//if there's just one polling place automatically geolocate it
					   			if(data.pollingLocations.length == 1)
					   			{
						   			var address = location.address.line1 + " " + location.address.line2 + " " + location.address.line3 + " " + location.address.city + ", " + location.address.state +" " + location.address.zip;
					   				$("#location_find").val(address);
					   				geoCode(true);
					   			}
					   		});

					   		$(settings.info_box_selector).show();
					   		$(settings.info_box_selector).html(locations);
						}
					   	
						   	

					   	else 
					   	{
					   		$(settings.info_box_selector).show();
					   		$(settings.info_box_selector).html("<div class='locationError'>Sorry, but no polling places where found for that address<br/>Use the map and search box below to manually locate the polling place as best you can.</div>");
					   		$("#location_name_div").show();
							$(".form-map").show();
							if(map == null)
							{
								initMap();
							
							}		

					   	}
					  },
					  error: function(xhr, textStatus, errorThrown) {
						  $(settings.info_box_selector).show();
					    $(settings.info_box_selector).html("<div class='locationError'>"+settings.error_message+"</div>");

					  }
					});
					
			});

		});


		function geoCodePollingPlace(address, index)
		{
			$("#location_find").val(address);
			geoCode(true);
			$("#pollingLocation" + index + " div.usePollingPlace").text('Selected');
			$("#pollingLocation" + index + " div.usePollingPlace").addClass('alert-info');
			$("#pollingLocation" + index + " div.usePollingPlace").removeClass('usePollingPlace');
			return false;
		}

</script>