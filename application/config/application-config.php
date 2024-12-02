<?php
defined('BASEPATH') OR exit('No direct script access allowed');  // Prevent direct script access

/**
 * @file config.php
 * @brief This file contains configuration settings for the FoodieGo application.
 * It includes settings related to site URLs, session handling, file uploads, error reporting, and security.
 */

/**
 * @def SITEURL
 * @brief Defines the base URL of the site.
 *
 * This constant is used throughout the application to generate full URLs.
 * It is important to ensure that this value matches the actual base URL of the site.
 */
define('SITEURL', 'http://localhost/FoodieGo/');

/**
 * @var $config['base_url']
 * @brief Set the base URL for the application.
 *
 * This value is used to generate links throughout the application.
 * It typically contains the protocol (http or https) and domain.
 */
$config['base_url'] = SITEURL;

/**
 * @var $config['index_page']
 * @brief Specifies the index file.
 *
 * This setting is left empty for clean URLs, meaning no index.php will appear in the URL.
 */
$config['index_page'] = '';

/**
 * @var $config['sess_driver']
 * @brief Defines the session storage driver.
 *
 * In this case, the session data is stored using files. Other possible options include 'database' or 'redis'.
 */
$config['sess_driver'] = 'files';

/**
 * @var $config['sess_cookie_name']
 * @brief Specifies the name of the session cookie.
 *
 * This is the name of the cookie that stores the session ID.
 */
$config['sess_cookie_name'] = 'foodiego_session';

/**
 * @var $config['sess_expiration']
 * @brief Session expiration time (in seconds).
 *
 * The session will expire after this period, which is set to 7200 seconds (2 hours) here.
 */
$config['sess_expiration'] = 7200;

/**
 * @var $config['upload_path']
 * @brief Specifies the path where uploaded images will be stored.
 *
 * This directory is used for storing uploaded files, such as images.
 * Ensure that the directory is writable by the web server.
 */
$config['upload_path'] = './assets/images/food/';

/**
 * @var $config['allowed_types']
 * @brief Specifies the allowed file types for uploads.
 *
 * The application will only accept files with the specified extensions, e.g., 'gif', 'jpg', or 'png'.
 */
$config['allowed_types'] = 'gif|jpg|png';

/**
 * @var $config['max_size']
 * @brief Defines the maximum allowed file size for uploads.
 *
 * The size is specified in kilobytes (KB). Here, the maximum file size is set to 2048 KB (2 MB).
 */
$config['max_size'] = 2048;

/**
 * @var $config['log_threshold']
 * @brief Sets the log level.
 *
 * This determines the level of logging, where 1 means only error messages will be logged.
 * Other levels include 2 (debug), 3 (info), and 4 (all messages).
 */
$config['log_threshold'] = 1;

/**
 * @var $config['log_path']
 * @brief Path to the log files.
 *
 * If left empty, the default log path will be used. You can specify a custom directory here if needed.
 */
$config['log_path'] = '';

/**
 * @var $config['log_file_extension']
 * @brief Specifies the file extension for log files.
 *
 * If left empty, the default file extension will be used for log files (typically .php or .log).
 */
$config['log_file_extension'] = '';

/**
 * @var $config['encryption_key']
 * @brief Secret key used for data encryption.
 *
 * This key is used for encrypting sensitive data. It should be kept secret and not shared publicly.
 */
$config['encryption_key'] = 'your-secret-key';

/**
 * @var $config['csrf_protection']
 * @brief Enables or disables Cross-Site Request Forgery (CSRF) protection.
 *
 * When set to TRUE, the application will protect against CSRF attacks by requiring a valid CSRF token for form submissions.
 */
$config['csrf_protection'] = TRUE;

/**
 * @var $config['csrf_token_name']
 * @brief Name for the CSRF token field.
 *
 * This is the name of the hidden input field that holds the CSRF token in forms.
 */
$config['csrf_token_name'] = 'csrf_token';

/**
 * @var $config['csrf_cookie_name']
 * @brief Name for the CSRF cookie.
 *
 * This cookie holds the CSRF token that is used for validating the form submissions.
 */
$config['csrf_cookie_name'] = 'csrf_cookie';

?>