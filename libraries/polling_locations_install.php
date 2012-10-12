<?php  defined('SYSPATH') or die('No direct script access.');

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
class polling_locations_install {
 
    /**
     * Constructor to load the shared database library
     */
    public function __construct()
    {
        $this->db =  new Database();
    }
 
    /**
     * Creates the required database tables for polling_locations
     */
    public function run_install()
    {

        //drop the tables if they already exist
        $this->db->query("
            DROP TABLE IF EXISTS `".Kohana::config('database.default.table_prefix')."polling_locations`;
          ");
        // create the table for the settings
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."polling_locations`
            (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `key` varchar(100) NOT NULL DEFAULT '',
                `value` text,
                PRIMARY KEY (`id`)

            );");
        // put the defaults into the table
        $this->db->query("
            INSERT INTO `polling_locations` (`id`, `key`, `value`)
            VALUES
                (1,'election_id','2000'),
                (2,'api_key',NULL),
                (3,'address_selector',NULL),
                (4,'city_selector',NULL),
                (5,'state_selector',NULL),
                (6,'zip_selector',NULL),
                (7,'button_placement',NULL),
                (8,'button_selector','".'#locationLookUp'."'),
                (9,'info_box_selector',NULL),
                (10,'error_message','No Location Found');
        ");
        
    }
 
    /**
     * Deletes the database tables for polling_locations
     */
    public function uninstall()
    {
        $this->db->query("
            DROP TABLE ".Kohana::config('database.default.table_prefix')."polling_locations;
           
            ");
    }
}