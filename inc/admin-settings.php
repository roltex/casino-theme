<?php
/**
 * Admin Settings Page for Casino Theme
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Casino Theme Admin Settings Class
 */
class Casino_Theme_Admin_Settings
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'settings_init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu()
    {
        add_menu_page(
            esc_html__('Casino Theme Settings', 'casino-theme'),
            esc_html__('Casino Settings', 'casino-theme'),
            'manage_options',
            'casino-theme-settings',
            array($this, 'options_page'),
            'dashicons-admin-generic',
            61
        );
    }

    /**
     * Initialize settings
     */
    public function settings_init()
    {
        register_setting('casinoThemeSettings', 'casino_theme_settings');

        // Register a new section in the "casino-theme-settings" page
        add_settings_section(
            'casino_theme_settings_section',
            esc_html__('General Settings', 'casino-theme'),
            array($this, 'settings_section_callback'),
            'casino-theme-settings'
        );

        // Register logo setting
        add_settings_field(
            'casino_theme_logo',
            esc_html__('Logo', 'casino-theme'),
            array($this, 'logo_render'),
            'casino-theme-settings',
            'casino_theme_settings_section'
        );

        // Register a new field in the "casino_theme_settings_section" section
        add_settings_field(
            'casino_theme_google_analytics',
            esc_html__('Google Analytics ID', 'casino-theme'),
            array($this, 'google_analytics_render'),
            'casino-theme-settings',
            'casino_theme_settings_section'
        );

        // Register a new field for custom CSS
        add_settings_field(
            'casino_theme_custom_css',
            esc_html__('Custom CSS', 'casino-theme'),
            array($this, 'custom_css_render'),
            'casino-theme-settings',
            'casino_theme_settings_section'
        );

        // Register a new field for performance settings
        add_settings_field(
            'casino_theme_performance',
            esc_html__('Performance Settings', 'casino-theme'),
            array($this, 'performance_settings_render'),
            'casino-theme-settings',
            'casino_theme_settings_section'
        );
    }

    /**
     * Settings section callback
     */
    public function settings_section_callback()
    {
        echo esc_html__('Configure general settings for your casino theme.', 'casino-theme');
    }

    /**
     * Logo field render
     */
    public function logo_render()
    {
        // Get the current custom logo ID
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo_url = '';
        
        if ($custom_logo_id) {
            $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
        }
        
        ?>
        <div class="logo-upload-container">
            <input type="hidden" id="casino_theme_logo" name="casino_theme_logo" value="<?php echo esc_attr($logo_url); ?>" />
            <div class="logo-preview">
                <?php if ($logo_url) : ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Logo Preview" style="max-width: 200px; max-height: 100px; margin: 10px 0;" />
                <?php endif; ?>
            </div>
            <button type="button" class="button button-secondary" id="upload-logo-btn">
                <?php esc_html_e('Upload Logo', 'casino-theme'); ?>
            </button>
            <button type="button" class="button button-secondary" id="remove-logo-btn" <?php echo empty($logo_url) ? 'style="display:none;"' : ''; ?>>
                <?php esc_html_e('Remove Logo', 'casino-theme'); ?>
            </button>
            <p class="description">
                <?php esc_html_e('Upload your logo image. This will be set in Site Identity. Recommended size: 200x100 pixels.', 'casino-theme'); ?>
            </p>
        </div>
        <script>
        jQuery(document).ready(function($) {
            $('#upload-logo-btn').click(function(e) {
                e.preventDefault();
                
                // Create the media frame
                var frame = wp.media({
                    title: '<?php esc_html_e('Select or Upload Logo', 'casino-theme'); ?>',
                    button: {
                        text: '<?php esc_html_e('Use this logo', 'casino-theme'); ?>'
                    },
                    multiple: false
                });

                // When an image is selected, run a callback
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#casino_theme_logo').val(attachment.url);
                    $('.logo-preview').html('<img src="' + attachment.url + '" alt="Logo Preview" style="max-width: 200px; max-height: 100px; margin: 10px 0;" />');
                    $('#remove-logo-btn').show();
                });

                // Open the modal
                frame.open();
            });

            $('#remove-logo-btn').click(function(e) {
                e.preventDefault();
                $('#casino_theme_logo').val('');
                $('.logo-preview').empty();
                $(this).hide();
            });
        });
        </script>
        <?php
    }

    /**
     * Google Analytics field render
     */
    public function google_analytics_render()
    {
        $options = get_option('casino_theme_settings');
        ?>
        <input type='text' name='casino_theme_settings[google_analytics]' value='<?php echo esc_attr($options['google_analytics'] ?? ''); ?>' placeholder='UA-XXXXXXXX-X or G-XXXXXXXXXX'>
        <p class="description"><?php esc_html_e('Enter your Google Analytics tracking ID.', 'casino-theme'); ?></p>
        <?php
    }

    /**
     * Custom CSS field render
     */
    public function custom_css_render()
    {
        $options = get_option('casino_theme_settings');
        ?>
        <textarea name='casino_theme_settings[custom_css]' rows='10' cols='50' class='large-text code'><?php echo esc_textarea($options['custom_css'] ?? ''); ?></textarea>
        <p class="description"><?php esc_html_e('Add custom CSS to override theme styles.', 'casino-theme'); ?></p>
        <?php
    }

    /**
     * Performance settings field render
     */
    public function performance_settings_render()
    {
        $options = get_option('casino_theme_settings');
        $lazy_load = isset($options['lazy_load']) ? $options['lazy_load'] : 1;
        ?>
        <fieldset>
            <label>
                <input type='checkbox' name='casino_theme_settings[lazy_load]' <?php checked($lazy_load, 1); ?> value='1'>
                <?php esc_html_e('Enable lazy loading for images', 'casino-theme'); ?>
            </label>
        </fieldset>
        <?php
    }

    /**
     * Options page display
     */
    public function options_page()
    {
        // Handle logo saving
        if (isset($_POST['submit']) && isset($_POST['casino_theme_logo'])) {
            $logo_url = sanitize_text_field($_POST['casino_theme_logo']);
            if (!empty($logo_url)) {
                // Get the attachment ID from the URL
                $attachment_id = attachment_url_to_postid($logo_url);
                if ($attachment_id) {
                    // Set the custom logo using WordPress core function
                    set_theme_mod('custom_logo', $attachment_id);
                }
            } else {
                // Remove the custom logo
                remove_theme_mod('custom_logo');
            }
            echo '<div class="notice notice-success"><p>' . esc_html__('Settings saved successfully! Logo has been set in Site Identity.', 'casino-theme') . '</p></div>';
        }
        
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Casino Theme Settings', 'casino-theme'); ?></h1>
            <form method='post'>
                <?php
                settings_fields('casinoThemeSettings');
                do_settings_sections('casino-theme-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Save logo setting
     */
    public function save_logo_setting()
    {
        if (isset($_POST['casino_theme_logo'])) {
            $logo_url = sanitize_text_field($_POST['casino_theme_logo']);
            if (!empty($logo_url)) {
                // Get the attachment ID from the URL
                $attachment_id = attachment_url_to_postid($logo_url);
                if ($attachment_id) {
                    // Set the custom logo using WordPress core function
                    set_theme_mod('custom_logo', $attachment_id);
                }
            } else {
                // Remove the custom logo
                remove_theme_mod('custom_logo');
            }
        }
    }

    /**
     * Enqueue scripts for media uploader
     */
    public function enqueue_scripts($hook)
    {
        // Only enqueue on our settings page
        if ($hook != 'toplevel_page_casino-theme-settings') {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}

// Initialize the admin settings
new Casino_Theme_Admin_Settings();

/**
 * Add Google Analytics tracking code
 */
function casino_theme_add_google_analytics()
{
    $options = get_option('casino_theme_settings');
    $ga_id = isset($options['google_analytics']) ? $options['google_analytics'] : '';
    
    if (!empty($ga_id)) {
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '<?php echo esc_attr($ga_id); ?>');
        </script>
        <?php
    }
}
add_action('wp_head', 'casino_theme_add_google_analytics');

/**
 * Add custom CSS
 */
function casino_theme_add_custom_css()
{
    // Only load on frontend, not in admin
    if (!is_admin()) {
        $options = get_option('casino_theme_settings');
        $custom_css = isset($options['custom_css']) ? $options['custom_css'] : '';
        
        if (!empty($custom_css)) {
            echo '<style id="casino-theme-custom-css">' . wp_strip_all_tags($custom_css) . '</style>';
        }
    }
}
add_action('wp_head', 'casino_theme_add_custom_css');

/**
 * Enable lazy loading for images
 */
function casino_theme_enable_lazy_loading($content)
{
    $options = get_option('casino_theme_settings');
    $lazy_load = isset($options['lazy_load']) ? $options['lazy_load'] : 1;
    
    if ($lazy_load) {
        $content = preg_replace('/<img(.*?)src=/i', '<img$1loading="lazy" src=', $content);
    }
    
    return $content;
}
add_filter('the_content', 'casino_theme_enable_lazy_loading');
