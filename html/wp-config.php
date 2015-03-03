<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
//uncomment these when large file upload ability is needed
//remember to also update upload_max_filesize in php.ini
//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//define( 'WP_MAX_MEMORY_LIMIT' , '512M' );
//ini_set('max_execution_time', 300);

//remove prompt for ftp
define('FS_METHOD', 'direct');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'thehvac.net');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'fr1ck0ffMang');

/** MySQL hostname */
define('DB_HOST', 'db-int.doap.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+Y=4P<u$$v3c5>vDR~Am4T{(Ch`1<x]pbRzpog+*L]n}00<|RYM~~HR625cQ{5:+');
define('SECURE_AUTH_KEY',  'j(=Hk_6L+%;vfc-Io:u&kAw_:rO,AjuBJ_O/SZZ?hGZgoULZtD>tZlxPiRnW[_3 ');
define('LOGGED_IN_KEY',    ')Iq%]}i;4o %|,O)J$q{_l4.)1a^oQ^k?.(;-` 171}IyT~>+7V<;Fn%tia3@rY<');
define('NONCE_KEY',        '45uj<n81SWS@%> EM*^$o:1bYZ?H|-? Y<9[i+c?|Z)Qyh`R(*o@h&GlGY8<+!1m');
define('AUTH_SALT',        'jVHJLM:YYs&y&8A%5rV`)R9pgDg{^/K%LS3Xzi}h:>xXuTr<+895IOD%&$|wb9OT');
define('SECURE_AUTH_SALT', 'iY*+NLIIP@!ke^>M64l|}u!~g!)c]TK1Vv{G/Nlm2@~.fvjH#Ar6TjtilUiH. )`');
define('LOGGED_IN_SALT',   '+gcoTi|K/i9s;oMZ@_A*54U>9At0+?(]t!p,}QGFr4n,(Ye%rC3YWTLII(-tGC&~');
define('NONCE_SALT',       'yK:;&:j+1|D% Rf=2B:.|XY4xzmd-*rfce*O)!IjQPPQlgNciODLj|-v,V(Vyt;7');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

