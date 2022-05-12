<?php
/**
 * Plugin name: V5Blocks
 * Description: Collection of feature reach `Gutenberg` blocks to extend great content composing experience for WordPress block editor.
 * Author: Virtue5,Rimon_Habib
 * Author URI: https://rimonhabib.com
 * Version: 1.0.0
 * Text Domain: v5blocks
 * Domain Path: /languages
 *
 * @package v5blocks
 */

namespace V5Blocks;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

define('V5BLOCKS_VERSION', '1.0.0');
define('V5BLOCKS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('V5BLOCKS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('V5BLOCKS_PLUGIN_FILE', __FILE__);
define('V5BLOCKS_PLUGIN_BASE', plugin_basename(__FILE__));

/**
 * Plugin Main Class
 * @since 1.0.0
 */

final class V5Blocks
{

    private static $instance;

    public static function getInstance()
    {

        if (!isset(self::$instance) && !(self::$instance instanceof V5Blocks)) {
            self::$instance = new V5Blocks();
            self::$instance->init();
            self::$instance->includes();
        }
        return self::$instance;
    }

    private function init()
    {
        add_action('plugins_loaded', [$this, 'load_textdomain'], 99);
        add_action('enqueue_block_editor_assets', [$this, 'block_localization'], 99);
    }

    private function includes()
    {

    }

    public function load_textdomain()
    {
        load_plugin_textdomain('v5blocks', false, basename(V5BLOCKS_PLUGIN_DIR) . '/languages');
    }

    public function block_localization()
    {
        if (function_exists('wp_set_script_translations')) {
            wp_set_script_translations('v5blocks-editor', 'v5blocks', V5BLOCKS_PLUGIN_DIR . '/languages');
        }
    }

    /**
     * Throw error on object clone.
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     *
     * @since 1.0.0
     * @access protected
     * @return void
     */
    public function __clone()
    {
        // Cloning instances of the class is forbidden.
        _doing_it_wrong(__FUNCTION__, esc_html__('Something went wrong.', 'v5blocks'), '1.0.0');
    }

    /**
     * Disable unserializing of the class.
     *
     * @since 1.0.0
     * @access protected
     * @return void
     */
    public function __wakeup()
    {
        // Unserializing instances of the class is forbidden.
        _doing_it_wrong(__FUNCTION__, esc_html__('Something went wrong.', 'v5blocks'), '1.0.0');
    }

}

function v5blocks()
{
    return V5Blocks::getInstance();
}

// Get the plugin running. Load on plugins_loaded action to avoid issue on multisite.
if (function_exists('is_multisite') && is_multisite()) {
    add_action('plugins_loaded', 'v5blocks', 90);
} else {
    v5blocks();
}
