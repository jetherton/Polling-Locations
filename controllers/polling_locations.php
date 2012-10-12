<?php defined('SYSPATH') OR die('No direct access allowed.');

 /**
 * Polling Locations Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Rachel Higley <me@rachelhigley.com>
 * @package    Polling Locations, Ushahidi Plugin 
 * @copyright  Rachel Higley rachelhigley.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
* 
*/


class Polling_Locations_Controller extends Controller
{

	// render the view for the login form
	public function create() {

		// get the js view
		$js = View::factory('polling_locations/js/polling_locations_js');

		// create a new Polling Locations
		$polling_locations = new Polling_Locations_Model();

		// get all the polling locations settings
		$polling_locations_settings = ORM::factory('polling_locations')->find_all();

		// loop through the db results for all the settings
		foreach($polling_locations_settings as $setting) {

			// set the settings into the array
			$settings[$setting->key] = $setting->value;

		}

		// set the settings
		$js->settings = json_encode($settings);

		// get the button code
		$button = View::factory('polling_locations/button');

		// set the button
		$js->button = $button;

		// render the js
		$js->render(TRUE);
	}

	
}
