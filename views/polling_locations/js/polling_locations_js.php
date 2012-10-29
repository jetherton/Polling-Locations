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

var polling_place_settings = <?=$settings?>;

$.fn.equalHeights = function(px) {
	$(this).each(function(){
		var currentTallest = 0;
		$(this).children().each(function(i){
			if ($(this).height() > currentTallest) { currentTallest = $(this).height(); }
		});
		if (!px || !Number.prototype.pxToEm) currentTallest = currentTallest.pxToEm(); //use ems unless px is specified
		// for ie6, set height since min-height isn't supported
		if ($.browser.msie && $.browser.version == 6.0) { $(this).children().css({'height': currentTallest}); }
		$(this).children().css({'min-height': currentTallest}); 
	});
	return this;
};


jQuery(document).ready(function($) {

			$(polling_place_settings.button_placement).append('<?=$button?>');

			$(polling_place_settings.button_selector).on('click',function(){

					var address_value = $(polling_place_settings.address_selector).val(),
						city_value = $(polling_place_settings.city_selector).val(),
						state_value = $(polling_place_settings.state_selector).val(),
						zip_value = $(polling_place_settings.zip_selector).val(),
						full_address = address_value + " " + city_value + ", " + state_value + " " + zip_value,
						url = "https://www.googleapis.com/civicinfo/us_v1/voterinfo/"+polling_place_settings.election_id+"/lookup?officialOnly=false&fields=pollingLocations(address%2CendDate%2Cname%2Cnotes%2CpollingHours%2CstartDate%2CvoterServices)&key="+polling_place_settings.api_key;
						


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
								
					   			var address = "";

					   			var html = "<div id='pollingLocation"+index+"' class='location'>\n";
					   			//if there's more than one polling place then give the user the option to pick one
					   			if(location.address.locationName != undefined) {
					   				html += "<div class='locationName'>" +location.address.locationName + "</div>\n";	
					   			}
					   			if(location.address.line1 != undefined) {
					   				html += "<div class='line1'>" + location.address.line1 + "</div>\n"; 
									address += location.address.line1;
					   			}
					   			if(location.address.line2 != undefined) {
						   			html += "<div class='line2'>" + location.address.line2 + "</div>\n";
									address += location.address.line2;
						   		}
					   			if(location.address.line3 != undefined) {
						   			html += "<div class='line3'>" + location.address.line3 + "</div>\n";
									address += location.address.line3;
						   		}
					   			
					   			html += "<div class='cityStateZip'>" + location.address.city + ", " + location.address.state +" " + location.address.zip +"</div>\n";
								address += ", " + location.address.city + ", " + location.address.state +" " + location.address.zip;


					   			if(location.pollingHours != undefined) {
					   				html += "<div class='hours'>Hours: "+location.pollingHours + "</div>\n";
					   			}
								//if there's just one polling place automatically geolocate it
					   			if(data.pollingLocations.length == 1)
					   			{
					   				$("#location_find").val(address);
					   				geoCode(true);
					   			}
					   			// if not create radio buttons
					   			else {
					   				html += "<div class='geo_radio_buttons'><p>Use Polling Place</p><input type='radio' id='geo_yes_"+index+"' name='geo_on_"+index+"' data-address='"+address+"' data-index="+index+" class='geo_yes' /><label for='geo_yes'>Yes</label><input name='geo_on_"+index+"' type='radio' id='geo_no_"+index+"' checked='checked' class='geo_no' /><label for='geo_no'>No</label></div>";
					   			}

					   			html += "</div> \n";
					   			locations += html;
					   		});

	
					   		$(polling_place_settings.info_box_selector).show();
					   		$(polling_place_settings.info_box_selector).html(locations);

					   		$(".locations").equalHeights();
					   		if(data.pollingLocations.length > 1) {

								$(".geo_radio_buttons input[type='radio']").on('change',function(e){
										
									var radio = $(this);
									var locations = $('.location');

									if(radio.attr('class') === 'geo_yes') {
										
										var location = radio.parent().parent();

										locations.hide();
										location.show();

										geoCodePollingPlace(radio.data('address'),radio.data('index'));
									
									}
									else {
									
										locations.show();	
										$("#location_find").val("");
									}
									

								});
							

							}
						}
					   	
						   	

					   	else 
					   	{
					   		$(polling_place_settings.info_box_selector).show();
					   		$(polling_place_settings.info_box_selector).html("<div class='locationError'>Sorry, but no polling places where found for that address<br/>Use the map and search box below to manually locate the polling place as best you can.</div>");
					   		$("#location_name_div").show();
							$(".form-map").show();
							if(map == null)
							{
								initMap();
							
							}		

					   	}
					  },
					  error: function(xhr, textStatus, errorThrown) {
						  $(polling_place_settings.info_box_selector).show();
					    $(polling_place_settings.info_box_selector).html("<div class='locationError'>"+polling_place_settings.error_message+"</div>");

					  }
					});
					
			});

		});


		function geoCodePollingPlace(address, index)
		{
			$("#location_find").val(address);
			geoCode(true);
			return false;
		}

</script>