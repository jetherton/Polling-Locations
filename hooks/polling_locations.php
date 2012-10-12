<?php defined('SYSPATH') or die('No direct script access.');

 /**
 * Polling Locations
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

class polling_locations {
 
    // on construction of the plugin
    public function __construct()
    {
        // Hook into routing before all controllers
        Event::add('system.pre_controller', array($this, 'add'));
    }
 
 
    public function add()
    {   
            // if it is the reports submit page
            if ((Router::$controller == 'reports' AND Router::$method == 'submit')) {    

                // Hook into the scripts
                Event::add('ushahidi_action.header_scripts', array('Polling_Locations_Controller', 'create'));

        
                
            }
    }

 
}
 
//instatiation of hook
new polling_locations;
