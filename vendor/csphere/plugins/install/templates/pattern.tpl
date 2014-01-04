/**
 * Configuration
 *
 * PHP Version 5
 *
 * @category  Config
 * @package   Config
 * @author    cSphere <dev@csphere.eu>
 * @copyright 2013 cSphere Team
 * @license   http://opensource.org/licenses/bsd-license Simplified BSD License
 * @link      http://www.csphere.eu
 **/

$config = array();

$config['cache']['driver'] 			= '{* raw cache *}';

$config['database']['driver']   	= '{* raw db.driver *}';
$config['database']['host']     	= '{* raw db.host *}';
$config['database']['username'] 	= '{* raw db.username *}';
$config['database']['password'] 	= '{* raw db.password *}';
$config['database']['prefix']   	= '{* raw db.prefix *}';
$config['database']['schema']   	= '{* raw db.schema *}';
$config['database']['file']     	= '{* raw db.file *}';

$config['logs']['driver']  			= '{* raw logs *}';
$config['logs']['save']    			= array('errors' => true);
$config['logs']['mail']    			= array('errors' => true);
$config['logs']['mail_to'] 			= '';

$config['mail']['driver']         	= 'none';
$config['mail']['from']           	= 'noreply@yourdomain.com';
$config['mail']['newline']        	= '';
$config['mail']['subject_prefix'] 	= 'cSphere Test';
$config['mail']['smtp_host']      	= '';
$config['mail']['smtp_username']  	= '';
$config['mail']['smtp_password']  	= '';
$config['mail']['smtp_port']      	= 25;
$config['mail']['timeout']        	= 5;

$config['view']['driver']       	= 'html';
$config['view']['theme']        	= 'default';
$config['view']['debug']        	= {* raw config.debug *};
$config['view']['zlib']         	= {* raw config.zlib *};
$config['view']['links_ajax']   	= {* raw config.ajax *};
$config['view']['links_pretty'] 	= {* raw config.rewrite *};