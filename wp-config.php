<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress1');

/** MySQL database username */
define('DB_USER', 'quanzhan');

/** MySQL database password */
define('DB_PASSWORD', '5jsx2qs');

/** MySQL hostname */
define('DB_HOST', '101.251.196.91:3308');

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
define('AUTH_KEY',         '2g<wn~{p>foF0{FpNl4Q,D0Fe6xx,q^arN_*=ZXs)}Dpxs(v7%axJ8F)B;,usZ6;');
define('SECURE_AUTH_KEY',  'QX02~?@&xjTx>R2W>Xuxm~3F@Kt2B!:Zj*,Z 0c,m].x9%iw:I/+FJi3*kgP1=<M');
define('LOGGED_IN_KEY',    '7O~fQg>)(^HNIY_^Q,]:_Gu?>P.bW^=;pWlYT>=o+!aLSM+;Kg()~GCI1O(k<R9A');
define('NONCE_KEY',        'tbF?C*@u0Q0>9318!Ii]ZgGp!s~F4WDcxI!7_88B;50H%P.9pQ;0NSqF7Nh-7Cz0');
define('AUTH_SALT',        'tQb:p._T:3S`EXi>oW!q<O0kds=dxjxGkf_u2v1?&D@%?76yc+k-TZMv)*mS5sX5');
define('SECURE_AUTH_SALT', 'y5)7]2i&JPl[c8 blkU^N@SC4>G4epf_-,Z3%iH$.E(j=nJGu D<?JcD0Nq5ySXC');
define('LOGGED_IN_SALT',   'a#s24wkx;BB+|R<^]<e:+mgDd/hP6f{/O0Z0Y>*UwW n&F|3> ~9bA~8]7q,MebW');
define('NONCE_SALT',       '*S81 vkd-$Y68m0LAUGiMqwc y!*rM+UfIZ8R{+<)n($nn7:UG/rw5Hn6:fC_s$H');

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
define('WP_DEBUG', false);
define('WPLANG', 'zh_CN');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

