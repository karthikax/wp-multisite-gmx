<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'iU;L#2d98O_m4)8@ELVg3-/lyDGZ!bm7>aIf(%4,&*r}pwYn?[O`fy(u#jGtaY_V');
define('SECURE_AUTH_KEY',  'u^h|h@}GTM$jLMsu?)J2e_}|8}a7|f[5VJTNqD.eu-V*rbr- 16po:Zem|A^;&t ');
define('LOGGED_IN_KEY',    'J.:/qi.qh&y[fHe5Bc+v9:#!b,Qn12|[PZyU-71^ht>w#-pnzJHC7D(RqUHto=!4');
define('NONCE_KEY',        'HAO?yd]Xp(>(]v*A<f>j6_sscmvze1rT|&zZ5tF+|uU$$e1fX0~[%?|iOop&Q|z8');
define('AUTH_SALT',        'KOCS.}/k2`VD,C4!$6pA@>PJT]1~|k0lB<e_b)c ^6VH+s2:v-FHtC|NYf$Qg5dl');
define('SECURE_AUTH_SALT', '}7}:?+[ cvfU?n+-B84!]#4F+|-@V|.(v-y/@Vwcc0j9u+DP9+ZjZaf&a0gJRzXy');
define('LOGGED_IN_SALT',   'X}{U:#+kkt/XWa4<|V5a,+{d1]Ln7=TAh>, 9*Pbo7+V@ld7^~C.Q]1?LOIQMpB;');
define('NONCE_SALT',       '&qHYLcCPC;MH<|QBCda2+&-Az/D^q,Xn~~}04`O<Z0{nP1CaG2`CF8JPhu`J6|x}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'gmx_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
