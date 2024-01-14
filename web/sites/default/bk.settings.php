<?php

// phpcs:ignoreFile

/**
 * @file
 * Drupal site-specific configuration file.
 *
 * IMPORTANT NOTE:
 * This file may have been set to read-only by the Drupal installation program.
 * If you make changes to this file, be sure to protect it again after making
 * your modifications. Failure to remove write permissions to this file is a
 * security risk.
 *
 * In order to use the selection rules below the multisite aliasing file named
 * sites/sites.php must be present. Its optional settings will be loaded, and
 * the aliases in the array $sites will override the default directory rules
 * below. See sites/example.sites.php for more information about aliases.
 *
 * The configuration directory will be discovered by stripping the website's
 * hostname from left to right and pathname from right to left. The first
 * configuration file found will be used and any others will be ignored. If no
 * other configuration file is found then the default configuration file at
 * 'sites/default' will be used.
 *
 * For example, for a fictitious site installed at
 * https://www.drupal.org:8080/mysite/test/, the 'settings.php' file is searched
 * for in the following directories:
 *
 * - sites/8080.www.drupal.org.mysite.test
 * - sites/www.drupal.org.mysite.test
 * - sites/drupal.org.mysite.test
 * - sites/org.mysite.test
 *
 * - sites/8080.www.drupal.org.mysite
 * - sites/www.drupal.org.mysite
 * - sites/drupal.org.mysite
 * - sites/org.mysite
 *
 * - sites/8080.www.drupal.org
 * - sites/www.drupal.org
 * - sites/drupal.org
 * - sites/org
 *
 * - sites/default
 *
 * Note that if you are installing on a non-standard port number, prefix the
 * hostname with that number. For example,
 * https://www.drupal.org:8080/mysite/test/ could be loaded from
 * sites/8080.www.drupal.org.mysite.test/.
 *
 * @see example.sites.php
 * @see \Drupal\Core\DrupalKernel::getSitePath()
 *
 * In addition to customizing application settings through variables in
 * settings.php, you can create a services.yml file in the same directory to
 * register custom, site-specific service definitions and/or swap out default
 * implementations with custom ones.
 */

/**
 * Database settings:
 *
 * The $databases array specifies the database connection or
 * connections that Drupal may use.  Drupal is able to connect
 * to multiple databases, including multiple types of databases,
 * during the same request.
 *
 * One example of the simplest connection array is shown below. To use the
 * sample settings, copy and uncomment the code below between the @code and
 * @endcode lines and paste it after the $databases declaration. You will need
 * to replace the database username and password and possibly the host and port
 * with the appropriate credentials for your database system.
 *
 * The next section describes how to customize the $databases array for more
 * specific needs.
 *
 * @code
 * $databases['default']['default'] = [
 *   'database' => 'databasename',
 *   'username' => 'sqlusername',
 *   'password' => 'sqlpassword',
 *   'host' => 'localhost',
 *   'port' => '3306',
 *   'driver' => 'mysql',
 *   'prefix' => '',
 *   'collation' => 'utf8mb4_general_ci',
 * ];
 * @endcode
 */
$databases = [];

/**
 * Customizing database settings.
 *
 * Many of the values of the $databases array can be customized for your
 * particular database system. Refer to the sample in the section above as a
 * starting point.
 *
 * The "driver" property indicates what Drupal database driver the
 * connection should use.  This is usually the same as the name of the
 * database type, such as mysql or sqlite, but not always.  The other
 * properties will vary depending on the driver.  For SQLite, you must
 * specify a database file name in a directory that is writable by the
 * webserver.  For most other drivers, you must specify a
 * username, password, host, and database name.
 *
 * Drupal core implements drivers for mysql, pgsql, and sqlite. Other drivers
 * can be provided by contributed or custom modules. To use a contributed or
 * custom driver, the "namespace" property must be set to the namespace of the
 * driver. The code in this namespace must be autoloadable prior to connecting
 * to the database, and therefore, prior to when module root namespaces are
 * added to the autoloader. To add the driver's namespace to the autoloader,
 * set the "autoload" property to the PSR-4 base directory of the driver's
 * namespace. This is optional for projects managed with Composer if the
 * driver's namespace is in Composer's autoloader.
 *
 * For each database, you may optionally specify multiple "target" databases.
 * A target database allows Drupal to try to send certain queries to a
 * different database if it can but fall back to the default connection if not.
 * That is useful for primary/replica replication, as Drupal may try to connect
 * to a replica server when appropriate and if one is not available will simply
 * fall back to the single primary server (The terms primary/replica are
 * traditionally referred to as master/slave in database server documentation).
 *
 * The general format for the $databases array is as follows:
 * @code
 * $databases['default']['default'] = $info_array;
 * $databases['default']['replica'][] = $info_array;
 * $databases['default']['replica'][] = $info_array;
 * $databases['extra']['default'] = $info_array;
 * @endcode
 *
 * In the above example, $info_array is an array of settings described above.
 * The first line sets a "default" database that has one primary database
 * (the second level default).  The second and third lines create an array
 * of potential replica databases.  Drupal will select one at random for a given
 * request as needed.  The fourth line creates a new database with a name of
 * "extra".
 *
 * You can optionally set a prefix for all database table names by using the
 * 'prefix' setting. If a prefix is specified, the table name will be prepended
 * with its value. Be sure to use valid database characters only, usually
 * alphanumeric and underscore. If no prefix is desired, do not set the 'prefix'
 * key or set its value to an empty string ''.
 *
 * For example, to have all database table prefixed with 'main_', set:
 * @code
 *   'prefix' => 'main_',
 * @endcode
 *
 * Advanced users can add or override initial commands to execute when
 * connecting to the database server, as well as PDO connection settings. For
 * example, to enable MySQL SELECT queries to exceed the max_join_size system
 * variable, and to reduce the database connection timeout to 5 seconds:
 * @code
 * $databases['default']['default'] = [
 *   'init_commands' => [
 *     'big_selects' => 'SET SQL_BIG_SELECTS=1',
 *   ],
 *   'pdo' => [
 *     PDO::ATTR_TIMEOUT => 5,
 *   ],
 * ];
 * @endcode
 *
 * WARNING: The above defaults are designed for database portability. Changing
 * them may cause unexpected behavior, including potential data loss. See
 * https://www.drupal.org/developing/api/database/configuration for more
 * information on these defaults and the potential issues.
 *
 * More details can be found in the constructor methods for each driver:
 * - \Drupal\mysql\Driver\Database\mysql\Connection::__construct()
 * - \Drupal\pgsql\Driver\Database\pgsql\Connection::__construct()
 * - \Drupal\sqlite\Driver\Database\sqlite\Connection::__construct()
 *
 * Sample Database configuration format for PostgreSQL (pgsql):
 * @code
 *   $databases['default']['default'] = [
 *     'driver' => 'pgsql',
 *     'database' => 'databasename',
 *     'username' => 'sqlusername',
 *     'password' => 'sqlpassword',
 *     'host' => 'localhost',
 *     'prefix' => '',
 *   ];
 * @endcode
 *
 * Sample Database configuration format for SQLite (sqlite):
 * @code
 *   $databases['default']['default'] = [
 *     'driver' => 'sqlite',
 *     'database' => '/path/to/databasefilename',
 *   ];
 * @endcode
 *
 * Sample Database configuration format for a driver in a contributed module:
 * @code
 *   $databases['default']['default'] = [
 *     'driver' => 'my_driver',
 *     'namespace' => 'Drupal\my_module\Driver\Database\my_driver',
 *     'autoload' => 'modules/my_module/src/Driver/Database/my_driver/',
 *     'database' => 'databasename',
 *     'username' => 'sqlusername',
 *     'password' => 'sqlpassword',
 *     'host' => 'localhost',
 *     'prefix' => '',
 *   ];
 * @endcode
 */

/**
 * Location of the site configuration files.
 *
 * The $settings['config_sync_directory'] specifies the location of file system
 * directory used for syncing configuration data. On install, the directory is
 * created. This is used for configuration imports.
 *
 * The default location for this directory is inside a randomly-named
 * directory in the public files path. The setting below allows you to set
 * its location.
 */
# $settings['config_sync_directory'] = '/directory/outside/webroot';

/**
 * Settings:
 *
 * $settings contains environment-specific configuration, such as the files
 * directory and reverse proxy address, and temporary configuration, such as
 * security overrides.
 *
 * @see \Drupal\Core\Site\Settings::get()
 */

/**
 * Salt for one-time login links, cancel links, form tokens, etc.
 *
 * This variable will be set to a random value by the installer. All one-time
 * login links will be invalidated if the value is changed. Note that if your
 * site is deployed on a cluster of web servers, you must ensure that this
 * variable has the same value on each server.
 *
 * For enhanced security, you may set this variable to the contents of a file
 * outside your document root; you should also ensure that this file is not
 * stored with backups of your database.
 *
 * Example:
 * @code
 *   $settings['hash_salt'] = file_get_contents('/home/example/salt.txt');
 * @endcode
 */
$settings['hash_salt'] = '7yL-O6XskEJ9Ln8m6r_-PG82111IkVbLHNS4QENSUTD4JtEYqkZVSJ_p7dVb1cOL27_bQQeJdw';

/**
 * Deployment identifier.
 *
 * Drupal's dependency injection container will be automatically invalidated and
 * rebuilt when the Drupal core version changes. When updating contributed or
 * custom code that changes the container, changing this identifier will also
 * allow the container to be invalidated as soon as code is deployed.
 */
# $settings['deployment_identifier'] = \Drupal::VERSION;

/**
 * Access control for update.php script.
 *
 * If you are updating your Drupal installation using the update.php script but
 * are not logged in using either an account with the "Administer software
 * updates" permission or the site maintenance account (the account that was
 * created during installation), you will need to modify the access check
 * statement below. Change the FALSE to a TRUE to disable the access check.
 * After finishing the upgrade, be sure to open this file again and change the
 * TRUE back to a FALSE!
 */
$settings['update_free_access'] = FALSE;

/**
 * Fallback to HTTP for Update Manager and for fetching security advisories.
 *
 * If your site fails to connect to updates.drupal.org over HTTPS (either when
 * fetching data on available updates, or when fetching the feed of critical
 * security announcements), you may uncomment this setting and set it to TRUE to
 * allow an insecure fallback to HTTP. Note that doing so will open your site up
 * to a potential man-in-the-middle attack. You should instead attempt to
 * resolve the issues before enabling this option.
 * @see https://www.drupal.org/docs/system-requirements/php-requirements#openssl
 * @see https://en.wikipedia.org/wiki/Man-in-the-middle_attack
 * @see \Drupal\update\UpdateFetcher
 * @see \Drupal\system\SecurityAdvisories\SecurityAdvisoriesFetcher
 */
# $settings['update_fetch_with_http_fallback'] = TRUE;

/**
 * External access proxy settings:
 *
 * If your site must access the Internet via a web proxy then you can enter the
 * proxy settings here. Set the full URL of the proxy, including the port, in
 * variables:
 * - $settings['http_client_config']['proxy']['http']: The proxy URL for HTTP
 *   requests.
 * - $settings['http_client_config']['proxy']['https']: The proxy URL for HTTPS
 *   requests.
 * You can pass in the user name and password for basic authentication in the
 * URLs in these settings.
 *
 * You can also define an array of host names that can be accessed directly,
 * bypassing the proxy, in $settings['http_client_config']['proxy']['no'].
 */
# $settings['http_client_config']['proxy']['http'] = 'http://proxy_user:proxy_pass@example.com:8080';
# $settings['http_client_config']['proxy']['https'] = 'http://proxy_user:proxy_pass@example.com:8080';
# $settings['http_client_config']['proxy']['no'] = ['127.0.0.1', 'localhost'];

/**
 * Reverse Proxy Configuration:
 *
 * Reverse proxy servers are often used to enhance the performance
 * of heavily visited sites and may also provide other site caching,
 * security, or encryption benefits. In an environment where Drupal
 * is behind a reverse proxy, the real IP address of the client should
 * be determined such that the correct client IP address is available
 * to Drupal's logging, statistics, and access management systems. In
 * the most simple scenario, the proxy server will add an
 * X-Forwarded-For header to the request that contains the client IP
 * address. However, HTTP headers are vulnerable to spoofing, where a
 * malicious client could bypass restrictions by setting the
 * X-Forwarded-For header directly. Therefore, Drupal's proxy
 * configuration requires the IP addresses of all remote proxies to be
 * specified in $settings['reverse_proxy_addresses'] to work correctly.
 *
 * Enable this setting to get Drupal to determine the client IP from the
 * X-Forwarded-For header. If you are unsure about this setting, do not have a
 * reverse proxy, or Drupal operates in a shared hosting environment, this
 * setting should remain commented out.
 *
 * In order for this setting to be used you must specify every possible
 * reverse proxy IP address in $settings['reverse_proxy_addresses'].
 * If a complete list of reverse proxies is not available in your
 * environment (for example, if you use a CDN) you may set the
 * $_SERVER['REMOTE_ADDR'] variable directly in settings.php.
 * Be aware, however, that it is likely that this would allow IP
 * address spoofing unless more advanced precautions are taken.
 */
# $settings['reverse_proxy'] = TRUE;

/**
 * Specify every reverse proxy IP address in your environment.
 * This setting is required if $settings['reverse_proxy'] is TRUE.
 */
# $settings['reverse_proxy_addresses'] = ['a.b.c.d', ...];

/**
 * Reverse proxy trusted headers.
 *
 * Sets which headers to trust from your reverse proxy.
 *
 * Common values are:
 * - \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_FOR
 * - \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_HOST
 * - \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PORT
 * - \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PROTO
 * - \Symfony\Component\HttpFoundation\Request::HEADER_FORWARDED
 *
 * Note the default value of
 * @code
 * \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_FOR | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_HOST | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PORT | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PROTO | \Symfony\Component\HttpFoundation\Request::HEADER_FORWARDED
 * @endcode
 * is not secure by default. The value should be set to only the specific
 * headers the reverse proxy uses. For example:
 * @code
 * \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_FOR | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_HOST | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PORT | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PROTO
 * @endcode
 * This would trust the following headers:
 * - X_FORWARDED_FOR
 * - X_FORWARDED_HOST
 * - X_FORWARDED_PROTO
 * - X_FORWARDED_PORT
 *
 * @see \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_FOR
 * @see \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_HOST
 * @see \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PORT
 * @see \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PROTO
 * @see \Symfony\Component\HttpFoundation\Request::HEADER_FORWARDED
 * @see \Symfony\Component\HttpFoundation\Request::setTrustedProxies
 */
# $settings['reverse_proxy_trusted_headers'] = \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_FOR | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_HOST | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PORT | \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PROTO | \Symfony\Component\HttpFoundation\Request::HEADER_FORWARDED;


/**
 * Page caching:
 *
 * By default, Drupal sends a "Vary: Cookie" HTTP header for anonymous page
 * views. This tells a HTTP proxy that it may return a page from its local
 * cache without contacting the web server, if the user sends the same Cookie
 * header as the user who originally requested the cached page. Without "Vary:
 * Cookie", authenticated users would also be served the anonymous page from
 * the cache. If the site has mostly anonymous users except a few known
 * editors/administrators, the Vary header can be omitted. This allows for
 * better caching in HTTP proxies (including reverse proxies), i.e. even if
 * clients send different cookies, they still get content served from the cache.
 * However, authenticated users should access the site directly (i.e. not use an
 * HTTP proxy, and bypass the reverse proxy if one is used) in order to avoid
 * getting cached pages from the proxy.
 */
# $settings['omit_vary_cookie'] = TRUE;


/**
 * Cache TTL for client error (4xx) responses.
 *
 * Items cached per-URL tend to result in a large number of cache items, and
 * this can be problematic on 404 pages which by their nature are unbounded. A
 * fixed TTL can be set for these items, defaulting to one hour, so that cache
 * backends which do not support LRU can purge older entries. To disable caching
 * of client error responses set the value to 0. Currently applies only to
 * page_cache module.
 */
# $settings['cache_ttl_4xx'] = 3600;

/**
 * Expiration of cached forms.
 *
 * Drupal's Form API stores details of forms in a cache and these entries are
 * kept for at least 6 hours by default. Expired entries are cleared by cron.
 *
 * @see \Drupal\Core\Form\FormCache::setCache()
 */
# $settings['form_cache_expiration'] = 21600;

/**
 * Class Loader.
 *
 * If the APCu extension is detected, the classloader will be optimized to use
 * it. Set to FALSE to disable this.
 *
 * @see https://getcomposer.org/doc/articles/autoloader-optimization.md
 */
# $settings['class_loader_auto_detect'] = FALSE;

/**
 * Authorized file system operations:
 *
 * The Update Manager module included with Drupal provides a mechanism for
 * site administrators to securely install missing updates for the site
 * directly through the web user interface. On securely-configured servers,
 * the Update manager will require the administrator to provide SSH or FTP
 * credentials before allowing the installation to proceed; this allows the
 * site to update the new files as the user who owns all the Drupal files,
 * instead of as the user the webserver is running as. On servers where the
 * webserver user is itself the owner of the Drupal files, the administrator
 * will not be prompted for SSH or FTP credentials (note that these server
 * setups are common on shared hosting, but are inherently insecure).
 *
 * Some sites might wish to disable the above functionality, and only update
 * the code directly via SSH or FTP themselves. This setting completely
 * disables all functionality related to these authorized file operations.
 *
 * @see https://www.drupal.org/node/244924
 *
 * Remove the leading hash signs to disable.
 */
# $settings['allow_authorize_operations'] = FALSE;

/**
 * Default mode for directories and files written by Drupal.
 *
 * Value should be in PHP Octal Notation, with leading zero.
 */
# $settings['file_chmod_directory'] = 0775;
# $settings['file_chmod_file'] = 0664;

/**
 * Public file base URL:
 *
 * An alternative base URL to be used for serving public files. This must
 * include any leading directory path.
 *
 * A different value from the domain used by Drupal to be used for accessing
 * public files. This can be used for a simple CDN integration, or to improve
 * security by serving user-uploaded files from a different domain or subdomain
 * pointing to the same server. Do not include a trailing slash.
 */
# $settings['file_public_base_url'] = 'http://downloads.example.com/files';

/**
 * Public file path:
 *
 * A local file system path where public files will be stored. This directory
 * must exist and be writable by Drupal. This directory must be relative to
 * the Drupal installation directory and be accessible over the web.
 */
# $settings['file_public_path'] = 'sites/default/files';

/**
 * Additional public file schemes:
 *
 * Public schemes are URI schemes that allow download access to all users for
 * all files within that scheme.
 *
 * The "public" scheme is always public, and the "private" scheme is always
 * private, but other schemes, such as "https", "s3", "example", or others,
 * can be either public or private depending on the site. By default, they're
 * private, and access to individual files is controlled via
 * hook_file_download().
 *
 * Typically, if a scheme should be public, a module makes it public by
 * implementing hook_file_download(), and granting access to all users for all
 * files. This could be either the same module that provides the stream wrapper
 * for the scheme, or a different module that decides to make the scheme
 * public. However, in cases where a site needs to make a scheme public, but
 * is unable to add code in a module to do so, the scheme may be added to this
 * variable, the result of which is that system_file_download() grants public
 * access to all files within that scheme.
 */
# $settings['file_additional_public_schemes'] = ['example'];

/**
 * Private file path:
 *
 * A local file system path where private files will be stored. This directory
 * must be absolute, outside of the Drupal installation directory and not
 * accessible over the web.
 *
 * Note: Caches need to be cleared when this value is changed to make the
 * private:// stream wrapper available to the system.
 *
 * See https://www.drupal.org/documentation/modules/file for more information
 * about securing private files.
 */
# $settings['file_private_path'] = '';

/**
 * Temporary file path:
 *
 * A local file system path where temporary files will be stored. This directory
 * must be absolute, outside of the Drupal installation directory and not
 * accessible over the web.
 *
 * If this is not set, the default for the operating system will be used.
 *
 * @see \Drupal\Component\FileSystem\FileSystem::getOsTemporaryDirectory()
 */
# $settings['file_temp_path'] = '/tmp';

/**
 * Session write interval:
 *
 * Set the minimum interval between each session write to database.
 * For performance reasons it defaults to 180.
 */
# $settings['session_write_interval'] = 180;

/**
 * String overrides:
 *
 * To override specific strings on your site with or without enabling the Locale
 * module, add an entry to this list. This functionality allows you to change
 * a small number of your site's default English language interface strings.
 *
 * Remove the leading hash signs to enable.
 *
 * The "en" part of the variable name, is dynamic and can be any langcode of
 * any added language. (eg locale_custom_strings_de for german).
 */
# $settings['locale_custom_strings_en'][''] = [
#   'forum'      => 'Discussion board',
#   '@count min' => '@count minutes',
# ];

/**
 * A custom theme for the offline page:
 *
 * This applies when the site is explicitly set to maintenance mode through the
 * administration page or when the database is inactive due to an error.
 * The template file should also be copied into the theme. It is located inside
 * 'core/modules/system/templates/maintenance-page.html.twig'.
 *
 * Note: This setting does not apply to installation and update pages.
 */
# $settings['maintenance_theme'] = 'bartik';

/**
 * PHP settings:
 *
 * To see what PHP settings are possible, including whether they can be set at
 * runtime (by using ini_set()), read the PHP documentation:
 * http://php.net/manual/ini.list.php
 * See \Drupal\Core\DrupalKernel::bootEnvironment() for required runtime
 * settings and the .htaccess file for non-runtime settings.
 * Settings defined there should not be duplicated here so as to avoid conflict
 * issues.
 */

/**
 * If you encounter a situation where users post a large amount of text, and
 * the result is stripped out upon viewing but can still be edited, Drupal's
 * output filter may not have sufficient memory to process it.  If you
 * experience this issue, you may wish to uncomment the following two lines
 * and increase the limits of these variables.  For more information, see
 * http://php.net/manual/pcre.configuration.php.
 */
# ini_set('pcre.backtrack_limit', 200000);
# ini_set('pcre.recursion_limit', 200000);

/**
 * Add Permissions-Policy header to disable Google FLoC.
 *
 * By default, Drupal sends the 'Permissions-Policy: interest-cohort=()' header
 * to disable Google's Federated Learning of Cohorts feature, introduced in
 * Chrome 89.
 *
 * See https://en.wikipedia.org/wiki/Federated_Learning_of_Cohorts for more
 * information about FLoC.
 *
 * If you don't wish to disable FLoC in Chrome, you can set this value
 * to FALSE.
 */
# $settings['block_interest_cohort'] = TRUE;

/**
 * Configuration overrides.
 *
 * To globally override specific configuration values for this site,
 * set them here. You usually don't need to use this feature. This is
 * useful in a configuration file for a vhost or directory, rather than
 * the default settings.php.
 *
 * Note that any values you provide in these variable overrides will not be
 * viewable from the Drupal administration interface. The administration
 * interface displays the values stored in configuration so that you can stage
 * changes to other environments that don't have the overrides.
 *
 * There are particular configuration values that are risky to override. For
 * example, overriding the list of installed modules in 'core.extension' is not
 * supported as module install or uninstall has not occurred. Other examples
 * include field storage configuration, because it has effects on database
 * structure, and 'core.menu.static_menu_link_overrides' since this is cached in
 * a way that is not config override aware. Also, note that changing
 * configuration values in settings.php will not fire any of the configuration
 * change events.
 */
# $config['system.site']['name'] = 'My Drupal site';
# $config['user.settings']['anonymous'] = 'Visitor';

/**
 * Fast 404 pages:
 *
 * Drupal can generate fully themed 404 pages. However, some of these responses
 * are for images or other resource files that are not displayed to the user.
 * This can waste bandwidth, and also generate server load.
 *
 * The options below return a simple, fast 404 page for URLs matching a
 * specific pattern:
 * - $config['system.performance']['fast_404']['exclude_paths']: A regular
 *   expression to match paths to exclude, such as images generated by image
 *   styles, or dynamically-resized images. The default pattern provided below
 *   also excludes the private file system. If you need to add more paths, you
 *   can add '|path' to the expression.
 * - $config['system.performance']['fast_404']['paths']: A regular expression to
 *   match paths that should return a simple 404 page, rather than the fully
 *   themed 404 page. If you don't have any aliases ending in htm or html you
 *   can add '|s?html?' to the expression.
 * - $config['system.performance']['fast_404']['html']: The html to return for
 *   simple 404 pages.
 *
 * Remove the leading hash signs if you would like to alter this functionality.
 */
# $config['system.performance']['fast_404']['exclude_paths'] = '/\/(?:styles)|(?:system\/files)\//';
# $config['system.performance']['fast_404']['paths'] = '/\.(?:txt|png|gif|jpe?g|css|js|ico|swf|flv|cgi|bat|pl|dll|exe|asp)$/i';
# $config['system.performance']['fast_404']['html'] = '<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>';

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

/**
 * Override the default service container class.
 *
 * This is useful for example to trace the service container for performance
 * tracking purposes, for testing a service container with an error condition or
 * to test a service container that throws an exception.
 */
# $settings['container_base_class'] = '\Drupal\Core\DependencyInjection\Container';

/**
 * Override the default yaml parser class.
 *
 * Provide a fully qualified class name here if you would like to provide an
 * alternate implementation YAML parser. The class must implement the
 * \Drupal\Component\Serialization\SerializationInterface interface.
 */
# $settings['yaml_parser_class'] = NULL;

/**
 * Trusted host configuration.
 *
 * Drupal core can use the Symfony trusted host mechanism to prevent HTTP Host
 * header spoofing.
 *
 * To enable the trusted host mechanism, you enable your allowable hosts
 * in $settings['trusted_host_patterns']. This should be an array of regular
 * expression patterns, without delimiters, representing the hosts you would
 * like to allow.
 *
 * For example:
 * @code
 * $settings['trusted_host_patterns'] = [
 *   '^www\.example\.com$',
 * ];
 * @endcode
 * will allow the site to only run from www.example.com.
 *
 * If you are running multisite, or if you are running your site from
 * different domain names (eg, you don't redirect http://www.example.com to
 * http://example.com), you should specify all of the host patterns that are
 * allowed by your site.
 *
 * For example:
 * @code
 * $settings['trusted_host_patterns'] = [
 *   '^example\.com$',
 *   '^.+\.example\.com$',
 *   '^example\.org$',
 *   '^.+\.example\.org$',
 * ];
 * @endcode
 * will allow the site to run off of all variants of example.com and
 * example.org, with all subdomains included.
 *
 * @see https://www.drupal.org/docs/installing-drupal/trusted-host-settings
 */

/**
 * The default list of directories that will be ignored by Drupal's file API.
 *
 * By default ignore node_modules and bower_components folders to avoid issues
 * with common frontend tools and recursive scanning of directories looking for
 * extensions.
 *
 * @see \Drupal\Core\File\FileSystemInterface::scanDirectory()
 * @see \Drupal\Core\Extension\ExtensionDiscovery::scanDirectory()
 */
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

/**
 * The default number of entities to update in a batch process.
 *
 * This is used by update and post-update functions that need to go through and
 * change all the entities on a site, so it is useful to increase this number
 * if your hosting configuration (i.e. RAM allocation, CPU speed) allows for a
 * larger number of entities to be processed in a single batch run.
 */
$settings['entity_update_batch_size'] = 50;

/**
 * Entity update backup.
 *
 * This is used to inform the entity storage handler that the backup tables as
 * well as the original entity type and field storage definitions should be
 * retained after a successful entity update process.
 */
$settings['entity_update_backup'] = TRUE;

/**
 * Node migration type.
 *
 * This is used to force the migration system to use the classic node migrations
 * instead of the default complete node migrations. The migration system will
 * use the classic node migration only if there are existing migrate_map tables
 * for the classic node migrations and they contain data. These tables may not
 * exist if you are developing custom migrations and do not want to use the
 * complete node migrations. Set this to TRUE to force the use of the classic
 * node migrations.
 */
$settings['migrate_node_migrate_type_classic'] = FALSE;


$config['image.settings']['suppress_itok_output'] = TRUE;
$config['image.settings']['allow_insecure_derivatives'] = TRUE;


/**
 * Load local development override configuration, if available.
 *
 * Create a settings.local.php file to override variables on secondary (staging,
 * development, etc.) installations of this site.
 *
 * Typical uses of settings.local.php include:
 * - Disabling caching.
 * - Disabling JavaScript/CSS compression.
 * - Rerouting outgoing emails.
 *
 * Keep this code block at the end of this file to take full effect.
 */

if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
$databases['default']['default'] = array (
  'database' => 'motultech',
  'username' => 'motultech',
  'password' => 'POc4BTnXqBOjQA8',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '3306',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'driver' => 'mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
);
$settings['config_sync_directory'] = 'sites/default/files/config_xHL5UENYznUMGBPvuZlbYiQEZwww3tzC_WBxaH8HLKHtFJr_VEEDOlHTi8eXO9OT74ALKwmFDQ/sync';




const LOCALIZATION_MATRIX = array(
  'GLOBAL' => array(
    'global' => array('label'=>'', 'country_url'=>'global', 'langs'=>array('en')),
  ),
  'AMERICA' => array(
    'ai'=>array('label'=>'ANGUILLA', 'country_url'=>'ai', 'langs'=>array('en')),
    'ag'=>array('label'=>'ANTIGUA AND BARBUDA', 'country_url'=>'ag', 'langs'=>array('en')),
    'ar'=>array('label'=>'ARGENTINA', 'country_url'=>'ar', 'langs'=>array('en')),
    'aw'=>array('label'=>'ARUBA', 'country_url'=>'aw', 'langs'=>array('en')),
    'bs'=>array('label'=>'BAHAMAS', 'country_url'=>'bs', 'langs'=>array('en')),
    'bb'=>array('label'=>'BARBADOS', 'country_url'=>'bb', 'langs'=>array('en')),
    'bz'=>array('label'=>'BELIZE', 'country_url'=>'bz', 'langs'=>array('en')),
    'bm'=>array('label'=>'BERMUDA', 'country_url'=>'bm', 'langs'=>array('en')),
    'bo'=>array('label'=>'BOLIVIA', 'country_url'=>'bo', 'langs'=>array('en')),
    'br'=>array('label'=>'BRAZIL', 'country_url'=>'br', 'langs'=>array('en')),
    'vg'=>array('label'=>'BRITISH VIRGIN ISLANDS', 'country_url'=>'vg', 'langs'=>array('en')),
    'ca'=>array('label'=>'CANADA', 'country_url'=>'ca', 'langs'=>array('en')),
    'ky'=>array('label'=>'CAYMAN ISLANDS', 'country_url'=>'ky', 'langs'=>array('en')),
    'cl'=>array('label'=>'CHILE', 'country_url'=>'cl', 'langs'=>array('en')),
    'co'=>array('label'=>'COLOMBIA', 'country_url'=>'co', 'langs'=>array('en')),
    'cr'=>array('label'=>'COSTA RICA', 'country_url'=>'cr', 'langs'=>array('en')),
    'cu'=>array('label'=>'CUBA', 'country_url'=>'cu', 'langs'=>array('en')),
    'cw'=>array('label'=>'CURACAO', 'country_url'=>'cw', 'langs'=>array('en')),
    'dm'=>array('label'=>'DOMINICA', 'country_url'=>'dm', 'langs'=>array('en')),
    'do'=>array('label'=>'DOMINICAN REPUBLIC', 'country_url'=>'do', 'langs'=>array('en')),
    'ec'=>array('label'=>'ECUADOR', 'country_url'=>'ec', 'langs'=>array('en')),
    'sv'=>array('label'=>'EL SALVADOR', 'country_url'=>'sv', 'langs'=>array('en')),
    'fk'=>array('label'=>'FALKLAND ISLANDS', 'country_url'=>'fk', 'langs'=>array('en')),
    'gf'=>array('label'=>'FRENCH GUIANA', 'country_url'=>'gf', 'langs'=>array('en')),
    'gl'=>array('label'=>'GREENLAND', 'country_url'=>'gl', 'langs'=>array('en')),
    'gd'=>array('label'=>'GRENADA', 'country_url'=>'gd', 'langs'=>array('en')),
    'gp'=>array('label'=>'GUADELOUPE', 'country_url'=>'gp', 'langs'=>array('en')),
    'gt'=>array('label'=>'GUATEMALA', 'country_url'=>'gt', 'langs'=>array('en')),
    'gy'=>array('label'=>'GUYANA', 'country_url'=>'gy', 'langs'=>array('en')),
    'ht'=>array('label'=>'HAITI', 'country_url'=>'ht', 'langs'=>array('en')),
    'hn'=>array('label'=>'HONDURAS', 'country_url'=>'hn', 'langs'=>array('en')),
    'jm'=>array('label'=>'JAMAICA', 'country_url'=>'jm', 'langs'=>array('en')),
    'mq'=>array('label'=>'MARTINIQUE', 'country_url'=>'mq', 'langs'=>array('en')),
    'mx'=>array('label'=>'MEXICO', 'country_url'=>'mx', 'langs'=>array('en')),
    'ms'=>array('label'=>'MONTSERRAT', 'country_url'=>'ms', 'langs'=>array('en')),
    'ni'=>array('label'=>'NICARAGUA', 'country_url'=>'ni', 'langs'=>array('en')),
    'pa'=>array('label'=>'PANAMA', 'country_url'=>'pa', 'langs'=>array('en')),
    'py'=>array('label'=>'PARAGUAY', 'country_url'=>'py', 'langs'=>array('en')),
    'pe'=>array('label'=>'PERU', 'country_url'=>'pe', 'langs'=>array('en')),
    'pr'=>array('label'=>'PUERTO RICO', 'country_url'=>'pr', 'langs'=>array('en')),
    'bl'=>array('label'=>'SAINT BARTHELEMY', 'country_url'=>'bl', 'langs'=>array('en')),
    'kn'=>array('label'=>'SAINT KITTS AND NEVIS', 'country_url'=>'kn', 'langs'=>array('en')),
    'lc'=>array('label'=>'SAINT LUCIA', 'country_url'=>'lc', 'langs'=>array('en')),
    'mf'=>array('label'=>'SAINT MARTIN', 'country_url'=>'mf', 'langs'=>array('en')),
    'pm'=>array('label'=>'SAINT PIERRE AND MIQUELON', 'country_url'=>'pm', 'langs'=>array('en')),
    'vc'=>array('label'=>'SAINT VINCENT AND THE GRENADINES', 'country_url'=>'vc', 'langs'=>array('en')),
    'sx'=>array('label'=>'SINT MAARTEN', 'country_url'=>'sx', 'langs'=>array('en')),
    'sr'=>array('label'=>'SURINAME', 'country_url'=>'sr', 'langs'=>array('en')),
    'tt'=>array('label'=>'TRINIDAD AND TOBAGO', 'country_url'=>'tt', 'langs'=>array('en')),
    'tc'=>array('label'=>'TURKS AND CAICOS ISLANDS', 'country_url'=>'tc', 'langs'=>array('en')),
    'us'=>array('label'=>'UNITED STATES', 'country_url'=>'us', 'langs'=>array('en')),
    'vi'=>array('label'=>'UNITED STATES VIRGIN ISLANDS', 'country_url'=>'vi', 'langs'=>array('en')),
    'uy'=>array('label'=>'URUGUAY', 'country_url'=>'uy', 'langs'=>array('en')),
    've'=>array('label'=>'VENEZUELA', 'country_url'=>'ve', 'langs'=>array('en')),
  ),
  'EUROPE' => array(
    'al'=>array('label'=>'ALBANIA', 'country_url'=>'al', 'langs'=>array('en')),
    'ad'=>array('label'=>'ANDORRA', 'country_url'=>'ad', 'langs'=>array('en')),
    'at'=>array('label'=>'AUSTRIA', 'country_url'=>'at', 'langs'=>array('en')),
    'by'=>array('label'=>'BELARUS', 'country_url'=>'by', 'langs'=>array('en')),
    'be'=>array('label'=>'BELGIUM', 'country_url'=>'be', 'langs'=>array('en')),
    'ba'=>array('label'=>'BOSNIA AND HERZEGOVINA', 'country_url'=>'ba', 'langs'=>array('en')),
    'bg'=>array('label'=>'BULGARIA', 'country_url'=>'bg', 'langs'=>array('en')),
    'hr'=>array('label'=>'CROATIA', 'country_url'=>'hr', 'langs'=>array('en')),
    'cy'=>array('label'=>'CYPRUS', 'country_url'=>'cy', 'langs'=>array('en')),
    'cz'=>array('label'=>'CZECH REPUBLIC', 'country_url'=>'cz', 'langs'=>array('en')),
    'dk'=>array('label'=>'DENMARK', 'country_url'=>'dk', 'langs'=>array('en')),
    'ee'=>array('label'=>'ESTONIA', 'country_url'=>'ee', 'langs'=>array('en')),
    'fo'=>array('label'=>'FAROE ISLANDS', 'country_url'=>'fo', 'langs'=>array('en')),
    'fi'=>array('label'=>'FINLAND', 'country_url'=>'fi', 'langs'=>array('en')),
    'fr'=>array('label'=>'FRANCE', 'country_url'=>'fr', 'langs'=>array('en', 'fr')),
    'de'=>array('label'=>'GERMANY', 'country_url'=>'de', 'langs'=>array('en')),
    'gi'=>array('label'=>'GIBRALTAR', 'country_url'=>'gi', 'langs'=>array('en')),
    'gr'=>array('label'=>'GREECE', 'country_url'=>'gr', 'langs'=>array('en')),
    'gg'=>array('label'=>'GUERNSEY', 'country_url'=>'gg', 'langs'=>array('en')),
    'hu'=>array('label'=>'HUNGARY', 'country_url'=>'hu', 'langs'=>array('en')),
    'is'=>array('label'=>'ICELAND', 'country_url'=>'is', 'langs'=>array('en')),
    'ie'=>array('label'=>'IRELAND', 'country_url'=>'ie', 'langs'=>array('en')),
    'im'=>array('label'=>'ISLE OF MAN', 'country_url'=>'im', 'langs'=>array('en')),
    'it'=>array('label'=>'ITALY', 'country_url'=>'it', 'langs'=>array('en')),
    'je'=>array('label'=>'JERSEY', 'country_url'=>'je', 'langs'=>array('en')),
    'lv'=>array('label'=>'LATVIA', 'country_url'=>'lv', 'langs'=>array('en')),
    'li'=>array('label'=>'LIECHTENSTEIN', 'country_url'=>'li', 'langs'=>array('en')),
    'lt'=>array('label'=>'LITHUANIA', 'country_url'=>'lt', 'langs'=>array('en')),
    'lu'=>array('label'=>'LUXEMBOURG', 'country_url'=>'lu', 'langs'=>array('en')),
    'mt'=>array('label'=>'MALTA', 'country_url'=>'mt', 'langs'=>array('en')),
    'md'=>array('label'=>'MOLDOVA', 'country_url'=>'md', 'langs'=>array('en')),
    'mc'=>array('label'=>'MONACO', 'country_url'=>'mc', 'langs'=>array('en')),
    'me'=>array('label'=>'MONTENEGRO', 'country_url'=>'me', 'langs'=>array('en')),
    'nl'=>array('label'=>'NETHERLANDS', 'country_url'=>'nl', 'langs'=>array('en')),
    'mk'=>array('label'=>'NORTH MACEDONIA', 'country_url'=>'mk', 'langs'=>array('en')),
    'no'=>array('label'=>'NORWAY', 'country_url'=>'no', 'langs'=>array('en')),
    'pl'=>array('label'=>'POLAND', 'country_url'=>'pl', 'langs'=>array('en')),
    'pt'=>array('label'=>'PORTUGAL', 'country_url'=>'pt', 'langs'=>array('en')),
    'ro'=>array('label'=>'ROMANIA', 'country_url'=>'ro', 'langs'=>array('en')),
    'ru'=>array('label'=>'RUSSIA', 'country_url'=>'ru', 'langs'=>array('en')),
    'sm'=>array('label'=>'SAN MARINO', 'country_url'=>'sm', 'langs'=>array('en')),
    'rs'=>array('label'=>'SERBIA', 'country_url'=>'rs', 'langs'=>array('en')),
    'sk'=>array('label'=>'SLOVAKIA', 'country_url'=>'sk', 'langs'=>array('en')),
    'si'=>array('label'=>'SLOVENIA', 'country_url'=>'si', 'langs'=>array('en')),
    'es'=>array('label'=>'SPAIN', 'country_url'=>'es', 'langs'=>array('en')),
    'se'=>array('label'=>'SWEDEN', 'country_url'=>'se', 'langs'=>array('en')),
    'ch'=>array('label'=>'SWITZERLAND', 'country_url'=>'ch', 'langs'=>array('en')),
    'ua'=>array('label'=>'UKRAINE', 'country_url'=>'ua', 'langs'=>array('en')),
    'gb'=>array('label'=>'UNITED KINGDOM', 'country_url'=>'gb', 'langs'=>array('en')),
    'va'=>array('label'=>'VATICAN CITY', 'country_url'=>'va', 'langs'=>array('en')),
  ),
  'AFRICA' => array(
    'dz'=>array('label'=>'ALGERIA', 'country_url'=>'dz', 'langs'=>array('en')),
    'ao'=>array('label'=>'ANGOLA', 'country_url'=>'ao', 'langs'=>array('en')),
    'bj'=>array('label'=>'BENIN', 'country_url'=>'bj', 'langs'=>array('en')),
    'bw'=>array('label'=>'BOTSWANA', 'country_url'=>'bw', 'langs'=>array('en')),
    'bf'=>array('label'=>'BURKINA FASO', 'country_url'=>'bf', 'langs'=>array('en')),
    'bi'=>array('label'=>'BURUNDI', 'country_url'=>'bi', 'langs'=>array('en')),
    'cm'=>array('label'=>'CAMEROON', 'country_url'=>'cm', 'langs'=>array('en')),
    'cv'=>array('label'=>'CAPE VERDE', 'country_url'=>'cv', 'langs'=>array('en')),
    'cf'=>array('label'=>'CENTRAL AFRICAN REPUBLIC', 'country_url'=>'cf', 'langs'=>array('en')),
    'td'=>array('label'=>'CHAD', 'country_url'=>'td', 'langs'=>array('en')),
    'km'=>array('label'=>'COMOROS', 'country_url'=>'km', 'langs'=>array('en')),
    'dj'=>array('label'=>'DJIBOUTI', 'country_url'=>'dj', 'langs'=>array('en')),
    'cd'=>array('label'=>'DR CONGO', 'country_url'=>'cd', 'langs'=>array('en')),
    'eg'=>array('label'=>'EGYPT', 'country_url'=>'eg', 'langs'=>array('en')),
    'gq'=>array('label'=>'EQUATORIAL GUINEA', 'country_url'=>'gq', 'langs'=>array('en')),
    'er'=>array('label'=>'ERITREA', 'country_url'=>'er', 'langs'=>array('en')),
    'sz'=>array('label'=>'ESWATINI', 'country_url'=>'sz', 'langs'=>array('en')),
    'et'=>array('label'=>'ETHIOPIA', 'country_url'=>'et', 'langs'=>array('en')),
    'ga'=>array('label'=>'GABON', 'country_url'=>'ga', 'langs'=>array('en')),
    'gm'=>array('label'=>'GAMBIA', 'country_url'=>'gm', 'langs'=>array('en')),
    'gh'=>array('label'=>'GHANA', 'country_url'=>'gh', 'langs'=>array('en')),
    'gn'=>array('label'=>'GUINEA', 'country_url'=>'gn', 'langs'=>array('en')),
    'gw'=>array('label'=>'GUINEA-BISSAU', 'country_url'=>'gw', 'langs'=>array('en')),
    'ci'=>array('label'=>'IVORY COAST', 'country_url'=>'ci', 'langs'=>array('en')),
    'ke'=>array('label'=>'KENYA', 'country_url'=>'ke', 'langs'=>array('en')),
    'ls'=>array('label'=>'LESOTHO', 'country_url'=>'ls', 'langs'=>array('en')),
    'lr'=>array('label'=>'LIBERIA', 'country_url'=>'lr', 'langs'=>array('en')),
    'ly'=>array('label'=>'LIBYA', 'country_url'=>'ly', 'langs'=>array('en')),
    'mg'=>array('label'=>'MADAGASCAR', 'country_url'=>'mg', 'langs'=>array('en')),
    'mw'=>array('label'=>'MALAWI', 'country_url'=>'mw', 'langs'=>array('en')),
    'ml'=>array('label'=>'MALI', 'country_url'=>'ml', 'langs'=>array('en')),
    'mr'=>array('label'=>'MAURITANIA', 'country_url'=>'mr', 'langs'=>array('en')),
    'mu'=>array('label'=>'MAURITIUS', 'country_url'=>'mu', 'langs'=>array('en')),
    'yt'=>array('label'=>'MAYOTTE', 'country_url'=>'yt', 'langs'=>array('en')),
    'ma'=>array('label'=>'MOROCCO', 'country_url'=>'ma', 'langs'=>array('en')),
    'mz'=>array('label'=>'MOZAMBIQUE', 'country_url'=>'mz', 'langs'=>array('en')),
    'na'=>array('label'=>'NAMIBIA', 'country_url'=>'na', 'langs'=>array('en')),
    'ne'=>array('label'=>'NIGER', 'country_url'=>'ne', 'langs'=>array('en')),
    'ng'=>array('label'=>'NIGERIA', 'country_url'=>'ng', 'langs'=>array('en')),
    'cg'=>array('label'=>'REPUBLIC OF THE CONGO', 'country_url'=>'cg', 'langs'=>array('en')),
    're'=>array('label'=>'REUNION', 'country_url'=>'re', 'langs'=>array('en')),
    'rw'=>array('label'=>'RWANDA', 'country_url'=>'rw', 'langs'=>array('en')),
    'st'=>array('label'=>'SAO TOME AND PRINCIPE', 'country_url'=>'st', 'langs'=>array('en')),
    'sn'=>array('label'=>'SENEGAL', 'country_url'=>'sn', 'langs'=>array('en')),
    'sc'=>array('label'=>'SEYCHELLES', 'country_url'=>'sc', 'langs'=>array('en')),
    'sl'=>array('label'=>'SIERRA LEONE', 'country_url'=>'sl', 'langs'=>array('en')),
    'so'=>array('label'=>'SOMALIA', 'country_url'=>'so', 'langs'=>array('en')),
    'za'=>array('label'=>'SOUTH AFRICA', 'country_url'=>'za', 'langs'=>array('en')),
    'ss'=>array('label'=>'SOUTH SUDAN', 'country_url'=>'ss', 'langs'=>array('en')),
    'sd'=>array('label'=>'SUDAN', 'country_url'=>'sd', 'langs'=>array('en')),
    'tz'=>array('label'=>'TANZANIA', 'country_url'=>'tz', 'langs'=>array('en')),
    'tg'=>array('label'=>'TOGO', 'country_url'=>'tg', 'langs'=>array('en')),
    'tn'=>array('label'=>'TUNISIA', 'country_url'=>'tn', 'langs'=>array('en')),
    'ug'=>array('label'=>'UGANDA', 'country_url'=>'ug', 'langs'=>array('en')),
    'eh'=>array('label'=>'WESTERN SAHARA', 'country_url'=>'eh', 'langs'=>array('en')),
    'zm'=>array('label'=>'ZAMBIA', 'country_url'=>'zm', 'langs'=>array('en')),
    'zw'=>array('label'=>'ZIMBABWE', 'country_url'=>'zw', 'langs'=>array('en')),
  ),
  'ASIA' => array(
    'af'=>array('label'=>'AFGHANISTAN', 'country_url'=>'af', 'langs'=>array('en')),
    'am'=>array('label'=>'ARMENIA', 'country_url'=>'am', 'langs'=>array('en')),
    'az'=>array('label'=>'AZERBAIJAN', 'country_url'=>'az', 'langs'=>array('en')),
    'bh'=>array('label'=>'BAHRAIN', 'country_url'=>'bh', 'langs'=>array('en')),
    'bd'=>array('label'=>'BANGLADESH', 'country_url'=>'bd', 'langs'=>array('en')),
    'bt'=>array('label'=>'BHUTAN', 'country_url'=>'bt', 'langs'=>array('en')),
    'bn'=>array('label'=>'BRUNEI', 'country_url'=>'bn', 'langs'=>array('en')),
    'kh'=>array('label'=>'CAMBODIA', 'country_url'=>'kh', 'langs'=>array('en')),
    'cn'=>array('label'=>'CHINA', 'country_url'=>'cn', 'langs'=>array('en')),
    'ge'=>array('label'=>'GEORGIA', 'country_url'=>'ge', 'langs'=>array('en')),
    'hk'=>array('label'=>'HONG KONG', 'country_url'=>'hk', 'langs'=>array('en')),
    'id'=>array('label'=>'INDONESIA', 'country_url'=>'id', 'langs'=>array('en')),
    'ir'=>array('label'=>'IRAN', 'country_url'=>'ir', 'langs'=>array('en')),
    'iq'=>array('label'=>'IRAQ', 'country_url'=>'iq', 'langs'=>array('en')),
    'il'=>array('label'=>'ISRAEL', 'country_url'=>'il', 'langs'=>array('en')),
    'jp'=>array('label'=>'JAPAN', 'country_url'=>'jp', 'langs'=>array('en')),
    'jo'=>array('label'=>'JORDAN', 'country_url'=>'jo', 'langs'=>array('en')),
    'kz'=>array('label'=>'KAZAKHSTAN', 'country_url'=>'kz', 'langs'=>array('en')),
    'kw'=>array('label'=>'KUWAIT', 'country_url'=>'kw', 'langs'=>array('en')),
    'kg'=>array('label'=>'KYRGYZSTAN', 'country_url'=>'kg', 'langs'=>array('en')),
    'la'=>array('label'=>'LAOS', 'country_url'=>'la', 'langs'=>array('en')),
    'lb'=>array('label'=>'LEBANON', 'country_url'=>'lb', 'langs'=>array('en')),
    'mo'=>array('label'=>'MACAU', 'country_url'=>'mo', 'langs'=>array('en')),
    'my'=>array('label'=>'MALAYSIA', 'country_url'=>'my', 'langs'=>array('en')),
    'mv'=>array('label'=>'MALDIVES', 'country_url'=>'mv', 'langs'=>array('en')),
    'mn'=>array('label'=>'MONGOLIA', 'country_url'=>'mn', 'langs'=>array('en')),
    'mm'=>array('label'=>'MYANMAR', 'country_url'=>'mm', 'langs'=>array('en')),
    'np'=>array('label'=>'NEPAL', 'country_url'=>'np', 'langs'=>array('en')),
    'kp'=>array('label'=>'NORTH KOREA', 'country_url'=>'kp', 'langs'=>array('en')),
    'om'=>array('label'=>'OMAN', 'country_url'=>'om', 'langs'=>array('en')),
    'pk'=>array('label'=>'PAKISTAN', 'country_url'=>'pk', 'langs'=>array('en')),
    'ps'=>array('label'=>'PALESTINE', 'country_url'=>'ps', 'langs'=>array('en')),
    'ph'=>array('label'=>'PHILIPPINES', 'country_url'=>'ph', 'langs'=>array('en')),
    'qa'=>array('label'=>'QATAR', 'country_url'=>'qa', 'langs'=>array('en')),
    'sa'=>array('label'=>'SAUDI ARABIA', 'country_url'=>'sa', 'langs'=>array('en')),
    'sg'=>array('label'=>'SINGAPORE', 'country_url'=>'sg', 'langs'=>array('en')),
    'kr'=>array('label'=>'SOUTH KOREA', 'country_url'=>'kr', 'langs'=>array('en')),
    'lk'=>array('label'=>'SRI LANKA', 'country_url'=>'lk', 'langs'=>array('en')),
    'sy'=>array('label'=>'SYRIA', 'country_url'=>'sy', 'langs'=>array('en')),
    'tw'=>array('label'=>'TAIWAN', 'country_url'=>'tw', 'langs'=>array('en')),
    'tj'=>array('label'=>'TAJIKISTAN', 'country_url'=>'tj', 'langs'=>array('en')),
    'th'=>array('label'=>'THAILAND', 'country_url'=>'th', 'langs'=>array('en')),
    'tl'=>array('label'=>'TIMOR-LESTE', 'country_url'=>'tl', 'langs'=>array('en')),
    'tr'=>array('label'=>'TURKEY', 'country_url'=>'tr', 'langs'=>array('en')),
    'tm'=>array('label'=>'TURKMENISTAN', 'country_url'=>'tm', 'langs'=>array('en')),
    'ae'=>array('label'=>'UNITED ARAB EMIRATES', 'country_url'=>'ae', 'langs'=>array('en')),
    'uz'=>array('label'=>'UZBEKISTAN', 'country_url'=>'uz', 'langs'=>array('en')),
    'vn'=>array('label'=>'VIETNAM', 'country_url'=>'vn', 'langs'=>array('en')),
    'ye'=>array('label'=>'YEMEN', 'country_url'=>'ye', 'langs'=>array('en')),
  ),
  'INDIA' => array(
    'in'=>array('label'=>'INDIA', 'country_url'=>'in', 'langs'=>array('en')),
  ),
);

const DOMAIN_LANGUAGES = array(
  'global'=>['en'],
  'america'=>['en'],
  'europe'=>['en'],
  'africa'=>['en'],
  'asia'=>['en'],
  'india'=>['en'],
);

const COUNTRY_DOMAIN = array(
  'global'=>'',
  'dz'=>'africa',
  'ao'=>'africa',
  'bj'=>'africa',
  'bw'=>'africa',
  'bf'=>'africa',
  'bi'=>'africa',
  'cm'=>'africa',
  'cv'=>'africa',
  'cf'=>'africa',
  'td'=>'africa',
  'km'=>'africa',
  'dj'=>'africa',
  'cd'=>'africa',
  'eg'=>'africa',
  'gq'=>'africa',
  'er'=>'africa',
  'sz'=>'africa',
  'et'=>'africa',
  'ga'=>'africa',
  'gm'=>'africa',
  'gh'=>'africa',
  'gn'=>'africa',
  'gw'=>'africa',
  'ci'=>'africa',
  'ke'=>'africa',
  'ls'=>'africa',
  'lr'=>'africa',
  'ly'=>'africa',
  'mg'=>'africa',
  'mw'=>'africa',
  'ml'=>'africa',
  'mr'=>'africa',
  'mu'=>'africa',
  'yt'=>'africa',
  'ma'=>'africa',
  'mz'=>'africa',
  'na'=>'africa',
  'ne'=>'africa',
  'ng'=>'africa',
  'cg'=>'africa',
  're'=>'africa',
  'rw'=>'africa',
  'st'=>'africa',
  'sn'=>'africa',
  'sc'=>'africa',
  'sl'=>'africa',
  'so'=>'africa',
  'za'=>'africa',
  'ss'=>'africa',
  'sd'=>'africa',
  'tz'=>'africa',
  'tg'=>'africa',
  'tn'=>'africa',
  'ug'=>'africa',
  'eh'=>'africa',
  'zm'=>'africa',
  'zw'=>'africa',
  'ai'=>'america',
  'ag'=>'america',
  'ar'=>'america',
  'aw'=>'america',
  'bs'=>'america',
  'bb'=>'america',
  'bz'=>'america',
  'bm'=>'america',
  'bo'=>'america',
  'br'=>'america',
  'vg'=>'america',
  'ca'=>'america',
  'ky'=>'america',
  'cl'=>'america',
  'co'=>'america',
  'cr'=>'america',
  'cu'=>'america',
  'cw'=>'america',
  'dm'=>'america',
  'do'=>'america',
  'ec'=>'america',
  'sv'=>'america',
  'fk'=>'america',
  'gf'=>'america',
  'gl'=>'america',
  'gd'=>'america',
  'gp'=>'america',
  'gt'=>'america',
  'gy'=>'america',
  'ht'=>'america',
  'hn'=>'america',
  'jm'=>'america',
  'mq'=>'america',
  'mx'=>'america',
  'ms'=>'america',
  'ni'=>'america',
  'pa'=>'america',
  'py'=>'america',
  'pe'=>'america',
  'pr'=>'america',
  'bl'=>'america',
  'kn'=>'america',
  'lc'=>'america',
  'mf'=>'america',
  'pm'=>'america',
  'vc'=>'america',
  'sx'=>'america',
  'sr'=>'america',
  'tt'=>'america',
  'tc'=>'america',
  'us'=>'america',
  'vi'=>'america',
  'uy'=>'america',
  've'=>'america',
  'af'=>'asia',
  'am'=>'asia',
  'az'=>'asia',
  'bh'=>'asia',
  'bd'=>'asia',
  'bt'=>'asia',
  'bn'=>'asia',
  'kh'=>'asia',
  'cn'=>'asia',
  'ge'=>'asia',
  'hk'=>'asia',
  'in'=>'asia',
  'id'=>'asia',
  'ir'=>'asia',
  'iq'=>'asia',
  'il'=>'asia',
  'jp'=>'asia',
  'jo'=>'asia',
  'kz'=>'asia',
  'kw'=>'asia',
  'kg'=>'asia',
  'la'=>'asia',
  'lb'=>'asia',
  'mo'=>'asia',
  'my'=>'asia',
  'mv'=>'asia',
  'mn'=>'asia',
  'mm'=>'asia',
  'np'=>'asia',
  'kp'=>'asia',
  'om'=>'asia',
  'pk'=>'asia',
  'ps'=>'asia',
  'ph'=>'asia',
  'qa'=>'asia',
  'sa'=>'asia',
  'sg'=>'asia',
  'kr'=>'asia',
  'lk'=>'asia',
  'sy'=>'asia',
  'tw'=>'asia',
  'tj'=>'asia',
  'th'=>'asia',
  'tl'=>'asia',
  'tr'=>'asia',
  'tm'=>'asia',
  'ae'=>'asia',
  'uz'=>'asia',
  'vn'=>'asia',
  'ye'=>'asia',
  'al'=>'eu',
  'ad'=>'eu',
  'at'=>'eu',
  'by'=>'eu',
  'be'=>'eu',
  'ba'=>'eu',
  'bg'=>'eu',
  'hr'=>'eu',
  'cy'=>'eu',
  'cz'=>'eu',
  'dk'=>'eu',
  'ee'=>'eu',
  'fo'=>'eu',
  'fi'=>'eu',
  'fr'=>'eu',
  'de'=>'eu',
  'gi'=>'eu',
  'gr'=>'eu',
  'gg'=>'eu',
  'hu'=>'eu',
  'is'=>'eu',
  'ie'=>'eu',
  'im'=>'eu',
  'it'=>'eu',
  'je'=>'eu',
  'lv'=>'eu',
  'li'=>'eu',
  'lt'=>'eu',
  'lu'=>'eu',
  'mt'=>'eu',
  'md'=>'eu',
  'mc'=>'eu',
  'me'=>'eu',
  'nl'=>'eu',
  'mk'=>'eu',
  'no'=>'eu',
  'pl'=>'eu',
  'pt'=>'eu',
  'ro'=>'eu',
  'ru'=>'eu',
  'sm'=>'eu',
  'rs'=>'eu',
  'sk'=>'eu',
  'si'=>'eu',
  'es'=>'eu',
  'se'=>'eu',
  'ch'=>'eu',
  'ua'=>'eu',
  'gb'=>'eu',
  'va'=>'eu',
);

const COUNTRY_LANGUAGES = array(
  'global'=>['en'],
  'dz'=>['en'],
  'ao'=>['en'],
  'bj'=>['en'],
  'bw'=>['en'],
  'bf'=>['en'],
  'bi'=>['en'],
  'cm'=>['en'],
  'cv'=>['en'],
  'cf'=>['en'],
  'td'=>['en'],
  'km'=>['en'],
  'dj'=>['en'],
  'cd'=>['en'],
  'eg'=>['en'],
  'gq'=>['en'],
  'er'=>['en'],
  'sz'=>['en'],
  'et'=>['en'],
  'ga'=>['en'],
  'gm'=>['en'],
  'gh'=>['en'],
  'gn'=>['en'],
  'gw'=>['en'],
  'ci'=>['en'],
  'ke'=>['en'],
  'ls'=>['en'],
  'lr'=>['en'],
  'ly'=>['en'],
  'mg'=>['en'],
  'mw'=>['en'],
  'ml'=>['en'],
  'mr'=>['en'],
  'mu'=>['en'],
  'yt'=>['en'],
  'ma'=>['en'],
  'mz'=>['en'],
  'na'=>['en'],
  'ne'=>['en'],
  'ng'=>['en'],
  'cg'=>['en'],
  're'=>['en'],
  'rw'=>['en'],
  'st'=>['en'],
  'sn'=>['en'],
  'sc'=>['en'],
  'sl'=>['en'],
  'so'=>['en'],
  'za'=>['en'],
  'ss'=>['en'],
  'sd'=>['en'],
  'tz'=>['en'],
  'tg'=>['en'],
  'tn'=>['en'],
  'ug'=>['en'],
  'eh'=>['en'],
  'zm'=>['en'],
  'zw'=>['en'],
  'ai'=>['en'],
  'ag'=>['en'],
  'ar'=>['en'],
  'aw'=>['en'],
  'bs'=>['en'],
  'bb'=>['en'],
  'bz'=>['en'],
  'bm'=>['en'],
  'bo'=>['en'],
  'br'=>['en'],
  'vg'=>['en'],
  'ca'=>['en'],
  'ky'=>['en'],
  'cl'=>['en'],
  'co'=>['en'],
  'cr'=>['en'],
  'cu'=>['en'],
  'cw'=>['en'],
  'dm'=>['en'],
  'do'=>['en'],
  'ec'=>['en'],
  'sv'=>['en'],
  'fk'=>['en'],
  'gf'=>['en'],
  'gl'=>['en'],
  'gd'=>['en'],
  'gp'=>['en'],
  'gt'=>['en'],
  'gy'=>['en'],
  'ht'=>['en'],
  'hn'=>['en'],
  'jm'=>['en'],
  'mq'=>['en'],
  'mx'=>['en'],
  'ms'=>['en'],
  'ni'=>['en'],
  'pa'=>['en'],
  'py'=>['en'],
  'pe'=>['en'],
  'pr'=>['en'],
  'bl'=>['en'],
  'kn'=>['en'],
  'lc'=>['en'],
  'mf'=>['en'],
  'pm'=>['en'],
  'vc'=>['en'],
  'sx'=>['en'],
  'sr'=>['en'],
  'tt'=>['en'],
  'tc'=>['en'],
  'us'=>['en'],
  'vi'=>['en'],
  'uy'=>['en'],
  've'=>['en'],
  'af'=>['en'],
  'am'=>['en'],
  'az'=>['en'],
  'bh'=>['en'],
  'bd'=>['en'],
  'bt'=>['en'],
  'bn'=>['en'],
  'kh'=>['en'],
  'cn'=>['en'],
  'ge'=>['en'],
  'hk'=>['en'],
  'in'=>['en'],
  'id'=>['en'],
  'ir'=>['en'],
  'iq'=>['en'],
  'il'=>['en'],
  'jp'=>['en'],
  'jo'=>['en'],
  'kz'=>['en'],
  'kw'=>['en'],
  'kg'=>['en'],
  'la'=>['en'],
  'lb'=>['en'],
  'mo'=>['en'],
  'my'=>['en'],
  'mv'=>['en'],
  'mn'=>['en'],
  'mm'=>['en'],
  'np'=>['en'],
  'kp'=>['en'],
  'om'=>['en'],
  'pk'=>['en'],
  'ps'=>['en'],
  'ph'=>['en'],
  'qa'=>['en'],
  'sa'=>['en'],
  'sg'=>['en'],
  'kr'=>['en'],
  'lk'=>['en'],
  'sy'=>['en'],
  'tw'=>['en'],
  'tj'=>['en'],
  'th'=>['en'],
  'tl'=>['en'],
  'tr'=>['en'],
  'tm'=>['en'],
  'ae'=>['en'],
  'uz'=>['en'],
  'vn'=>['en'],
  'ye'=>['en'],
  'al'=>['en'],
  'ad'=>['en'],
  'at'=>['en'],
  'by'=>['en'],
  'be'=>['en'],
  'ba'=>['en'],
  'bg'=>['en'],
  'hr'=>['en'],
  'cy'=>['en'],
  'cz'=>['en'],
  'dk'=>['en'],
  'ee'=>['en'],
  'fo'=>['en'],
  'fi'=>['en'],
  'fr'=>['en', 'fr'],
  'de'=>['en'],
  'gi'=>['en'],
  'gr'=>['en'],
  'gg'=>['en'],
  'hu'=>['en'],
  'is'=>['en'],
  'ie'=>['en'],
  'im'=>['en'],
  'it'=>['en'],
  'je'=>['en'],
  'lv'=>['en'],
  'li'=>['en'],
  'lt'=>['en'],
  'lu'=>['en'],
  'mt'=>['en'],
  'md'=>['en'],
  'mc'=>['en'],
  'me'=>['en'],
  'nl'=>['en'],
  'mk'=>['en'],
  'no'=>['en'],
  'pl'=>['en'],
  'pt'=>['en'],
  'ro'=>['en'],
  'ru'=>['en'],
  'sm'=>['en'],
  'rs'=>['en'],
  'sk'=>['en'],
  'si'=>['en'],
  'es'=>['en'],
  'se'=>['en'],
  'ch'=>['en'],
  'ua'=>['en'],
  'gb'=>['en'],
  'va'=>['en'],
);

const COUNTRY_LANGUAGE_DEFAULT = array(
  'global'=>'en',
  'dz'=>'en',
  'ao'=>'en',
  'bj'=>'en',
  'bw'=>'en',
  'bf'=>'en',
  'bi'=>'en',
  'cm'=>'en',
  'cv'=>'en',
  'cf'=>'en',
  'td'=>'en',
  'km'=>'en',
  'dj'=>'en',
  'cd'=>'en',
  'eg'=>'en',
  'gq'=>'en',
  'er'=>'en',
  'sz'=>'en',
  'et'=>'en',
  'ga'=>'en',
  'gm'=>'en',
  'gh'=>'en',
  'gn'=>'en',
  'gw'=>'en',
  'ci'=>'en',
  'ke'=>'en',
  'ls'=>'en',
  'lr'=>'en',
  'ly'=>'en',
  'mg'=>'en',
  'mw'=>'en',
  'ml'=>'en',
  'mr'=>'en',
  'mu'=>'en',
  'yt'=>'en',
  'ma'=>'en',
  'mz'=>'en',
  'na'=>'en',
  'ne'=>'en',
  'ng'=>'en',
  'cg'=>'en',
  're'=>'en',
  'rw'=>'en',
  'st'=>'en',
  'sn'=>'en',
  'sc'=>'en',
  'sl'=>'en',
  'so'=>'en',
  'za'=>'en',
  'ss'=>'en',
  'sd'=>'en',
  'tz'=>'en',
  'tg'=>'en',
  'tn'=>'en',
  'ug'=>'en',
  'eh'=>'en',
  'zm'=>'en',
  'zw'=>'en',
  'ai'=>'en',
  'ag'=>'en',
  'ar'=>'en',
  'aw'=>'en',
  'bs'=>'en',
  'bb'=>'en',
  'bz'=>'en',
  'bm'=>'en',
  'bo'=>'en',
  'br'=>'en',
  'vg'=>'en',
  'ca'=>'en',
  'ky'=>'en',
  'cl'=>'en',
  'co'=>'en',
  'cr'=>'en',
  'cu'=>'en',
  'cw'=>'en',
  'dm'=>'en',
  'do'=>'en',
  'ec'=>'en',
  'sv'=>'en',
  'fk'=>'en',
  'gf'=>'en',
  'gl'=>'en',
  'gd'=>'en',
  'gp'=>'en',
  'gt'=>'en',
  'gy'=>'en',
  'ht'=>'en',
  'hn'=>'en',
  'jm'=>'en',
  'mq'=>'en',
  'mx'=>'en',
  'ms'=>'en',
  'ni'=>'en',
  'pa'=>'en',
  'py'=>'en',
  'pe'=>'en',
  'pr'=>'en',
  'bl'=>'en',
  'kn'=>'en',
  'lc'=>'en',
  'mf'=>'en',
  'pm'=>'en',
  'vc'=>'en',
  'sx'=>'en',
  'sr'=>'en',
  'tt'=>'en',
  'tc'=>'en',
  'us'=>'en',
  'vi'=>'en',
  'uy'=>'en',
  've'=>'en',
  'af'=>'en',
  'am'=>'en',
  'az'=>'en',
  'bh'=>'en',
  'bd'=>'en',
  'bt'=>'en',
  'bn'=>'en',
  'kh'=>'en',
  'cn'=>'en',
  'ge'=>'en',
  'hk'=>'en',
  'in'=>'en',
  'id'=>'en',
  'ir'=>'en',
  'iq'=>'en',
  'il'=>'en',
  'jp'=>'en',
  'jo'=>'en',
  'kz'=>'en',
  'kw'=>'en',
  'kg'=>'en',
  'la'=>'en',
  'lb'=>'en',
  'mo'=>'en',
  'my'=>'en',
  'mv'=>'en',
  'mn'=>'en',
  'mm'=>'en',
  'np'=>'en',
  'kp'=>'en',
  'om'=>'en',
  'pk'=>'en',
  'ps'=>'en',
  'ph'=>'en',
  'qa'=>'en',
  'sa'=>'en',
  'sg'=>'en',
  'kr'=>'en',
  'lk'=>'en',
  'sy'=>'en',
  'tw'=>'en',
  'tj'=>'en',
  'th'=>'en',
  'tl'=>'en',
  'tr'=>'en',
  'tm'=>'en',
  'ae'=>'en',
  'uz'=>'en',
  'vn'=>'en',
  'ye'=>'en',
  'al'=>'en',
  'ad'=>'en',
  'at'=>'en',
  'by'=>'en',
  'be'=>'en',
  'ba'=>'en',
  'bg'=>'en',
  'hr'=>'en',
  'cy'=>'en',
  'cz'=>'en',
  'dk'=>'en',
  'ee'=>'en',
  'fo'=>'en',
  'fi'=>'en',
  'fr'=>'fr',
  'de'=>'en',
  'gi'=>'en',
  'gr'=>'en',
  'gg'=>'en',
  'hu'=>'en',
  'is'=>'en',
  'ie'=>'en',
  'im'=>'en',
  'it'=>'en',
  'je'=>'en',
  'lv'=>'en',
  'li'=>'en',
  'lt'=>'en',
  'lu'=>'en',
  'mt'=>'en',
  'md'=>'en',
  'mc'=>'en',
  'me'=>'en',
  'nl'=>'en',
  'mk'=>'en',
  'no'=>'en',
  'pl'=>'en',
  'pt'=>'en',
  'ro'=>'en',
  'ru'=>'en',
  'sm'=>'en',
  'rs'=>'en',
  'sk'=>'en',
  'si'=>'en',
  'es'=>'en',
  'se'=>'en',
  'ch'=>'en',
  'ua'=>'en',
  'gb'=>'en',
  'va'=>'en',
);
const MYMOTUL_LINK_DEFAULT = array(
  'default'=>'https://b2b.motul.com/INTERSHOP/web/WFS/Motul-DEU-Site/de_DE/',
);
const MYMOTUL_LINK_EXCEPTIONS = array(
  'fr'=>'https://b2b.motul.com/INTERSHOP/web/WFS/Motul-FR-Site/fr_FR/',
);