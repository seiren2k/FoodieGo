<?php
defined('BASEPATH') OR exit('No direct script access allowed');  // Prevent direct script access

// Site URL - Defines the base URL of the site
define('SITEURL', 'http://localhost/FoodieGo/');

// Base URL - Set the base URL for the application (used for generating links)
$config['base_url'] = SITEURL;

// Index File - Specifies the index file (empty in this case for clean URLs)
$config['index_page'] = '';

// Session Variables - Configure session handling parameters
$config['sess_driver'] = 'files';  // Session storage driver (uses files for session data)
$config['sess_cookie_name'] = 'foodiego_session';  // Name of the session cookie
$config['sess_expiration'] = 7200;  // Session expiration time (in seconds, 7200 = 2 hours)

// Upload Paths - Configure settings for file uploads
$config['upload_path'] = './assets/images/food/';  // Path where uploaded images will be stored
$config['allowed_types'] = 'gif|jpg|png';  // Allowed file types for uploads
$config['max_size'] = 2048;  // Maximum allowed file size for uploads (in KB)

// Error Reporting - Configuring logging options
$config['log_threshold'] = 1;  // Log level (1 = Error messages only)
$config['log_path'] = '';  // Path to log files (empty means default path will be used)
$config['log_file_extension'] = '';  // File extension for log files (empty means default extension will be used)

// Security - Set security-related configuration options
$config['encryption_key'] = 'your-secret-key';  // Secret key used for data encryption
$config['csrf_protection'] = TRUE;  // Enable Cross-Site Request Forgery (CSRF) protection
$config['csrf_token_name'] = 'csrf_token';  // Name for the CSRF token field
$config['csrf_cookie_name'] = 'csrf_cookie';  // Name for the CSRF cookie
?>