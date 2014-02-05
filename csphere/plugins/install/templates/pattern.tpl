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

$config = [];

$config['cache']['driver']      = '{* raw cache.driver *}';
$config['cache']['host']        = '{* raw cache.host *}';
$config['cache']['password']    = '{* raw cache.password *}';
$config['cache']['port']        = '{* raw cache.port *}';
$config['cache']['timeout']     = '{* raw cache.timeout *}';

$config['database']['driver']   = '{* raw db.driver *}';
$config['database']['host']     = '{* raw db.host *}';
$config['database']['username'] = '{* raw db.username *}';
$config['database']['password'] = '{* raw db.password *}';
$config['database']['prefix']   = '{* raw db.prefix *}';
$config['database']['schema']   = '{* raw db.schema *}';
$config['database']['file']     = '{* raw db.file *}';

$config['logs']['driver']       = '{* raw logs *}';
$config['logs']['save']         = ['errors' => true];
$config['logs']['mail']         = ['errors' => true];
$config['logs']['mail_to']      = '';

$config['mail']['driver']       = '{* raw mail.driver *}';
$config['mail']['newline']      = '{* raw mail.newline *}';
$config['mail']['from']         = '{* raw mail.from *}';
$config['mail']['subject']      = '{* raw mail.subject *}';
$config['mail']['timeout']      = '{* raw mail.timeout *}';
$config['mail']['host']         = '{* raw mail.host *}';
$config['mail']['username']     = '{* raw mail.username *}';
$config['mail']['password']     = '{* raw mail.password *}';
$config['mail']['port']         = '{* raw mail.port *}';

$config['view']['driver']       = 'html';
$config['view']['theme']        = 'default';
$config['view']['debug']        = {* raw config.debug *};
$config['view']['zlib']         = {* raw config.zlib *};
$config['view']['links_ajax']   = {* raw config.ajax *};
$config['view']['links_pretty'] = {* raw config.rewrite *};