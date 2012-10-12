<?php defined('SYSPATH') or die('No direct script access.');

 /**
 * Polling Locations Settings Controller
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

class Polling_Locations_Settings_Controller extends Admin_Controller {

    // default action
	public function index()
	{
        // the template for this page
		$this->template->this_page = 'addons';
		
		// Standard Settings View
		$this->template->content = new View("admin/addons/plugin_settings");
		$this->template->content->title = "Polling Locations Settings";
		
		// Settings Form View
		$this->template->content->settings_form = new View("polling_locations/admin/polling_locations_settings");

        // create the form
		$form = array
        (
            'election_id' => '',
            'api_key' => '',
            'address_selector' => '',
            'city_selector' => '',
            'state_selector' => '',
            'zip_selector' => '',
            'button_placement' => '',
            'button_selector' => '',
            'info_box_selector' => '',
            'error_message' => '',
        );

        // create version for errors
        $errors = $form;

        // there isn't any form error
        $form_error = FALSE;

        // the form hasn't been saved
        $form_saved = FALSE;

        // if there is post data
        if ($_POST)
        {
            // Instantiate Validation, use $post, so we don't overwrite $_POST
            $post = new Validation($_POST);

            // Add some filters
            $post->pre_filter('trim', TRUE);

            // Add some rules, the input field, followed by a list of checks, carried out in order
            $post->add_rules('election_id','required');
            $post->add_rules('api_key', 'required');
            $post->add_rules('address_selector', 'required');
            $post->add_rules('city_selector', 'required');
            $post->add_rules('state_selector', 'required');
            $post->add_rules('zip_selector', 'required');
            $post->add_rules('button_placement', 'required');
            $post->add_rules('button_selector', 'required');
            $post->add_rules('info_box_selector', 'required');
            $post->add_rules('error_message', 'required');

            // Test to see if things passed the rule checks
            if ($post->validate())
            {
                // save the value of the election id
                $polling_locations_model = new Polling_Locations_Model(1);
                $polling_locations_model->value = $post->election_id;
                $polling_locations_model->save();

                // save the value of the api key
                $polling_locations_model = new Polling_Locations_Model(2);
                $polling_locations_model->value = $post->api_key;
                $polling_locations_model->save();

                     // save the value of the address selector
                $polling_locations_model = new Polling_Locations_Model(3);
                $polling_locations_model->value = $post->address_selector;
                $polling_locations_model->save();

               // save the value of the city selector
                $polling_locations_model = new Polling_Locations_Model(4);
                $polling_locations_model->value = $post->city_selector;
                $polling_locations_model->save();

               // save the value of the state selector
                $polling_locations_model = new Polling_Locations_Model(5);
                $polling_locations_model->value = $post->state_selector;
                $polling_locations_model->save();

               // save the value of the zip selector
                $polling_locations_model = new Polling_Locations_Model(6);
                $polling_locations_model->value = $post->zip_selector;
                $polling_locations_model->save();

               // save the value of the button placement
                $polling_locations_model = new Polling_Locations_Model(7);
                $polling_locations_model->value = $post->button_placement;
                $polling_locations_model->save();

               // save the value of the button selector
                $polling_locations_model = new Polling_Locations_Model(8);
                $polling_locations_model->value = $post->button_selector;
                $polling_locations_model->save();

                // save the value of the info box selector
                $polling_locations_model = new Polling_Locations_Model(9);
                $polling_locations_model->value = $post->info_box_selector;
                $polling_locations_model->save();

                // save the value of the error message
                $polling_locations_model = new Polling_Locations_Model(10);
                $polling_locations_model->value = $post->error_message;
                $polling_locations_model->save();

                // we saved everything
                $form_saved = TRUE;

                // repopulate the form fields
                $form = arr::overwrite($form, $post->as_array());

            }

            // No! We have validation errors, we need to show the form again,
            else
            {
                // repopulate the form fields
                $form = arr::overwrite($form, $post->as_array());

                // populate the error fields, if any
                $errors = arr::overwrite($errors, $post->errors('pollinglocation'));

                // there was a form error
                $form_error = TRUE;
            }
        }
        else
        {
            // Retrieve Current Settings
            $polling_locations_settings = ORM::factory('polling_locations')->find_all();
            
            // set the current settings to the form
            foreach($polling_locations_settings as $setting) {

            	$form[$setting->key] = $setting->value;

            }
          
        }

       
        // set all the variables for the content
        $this->template->content->settings_form->form = $form;
	    $this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
	}


}

