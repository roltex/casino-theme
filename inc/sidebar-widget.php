<?php
/**
 * Casino Sidebar Widget
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the widget
 */
function casino_theme_register_sidebar_widget() {
    register_widget('Casino_Sidebar_Widget');
}
add_action('widgets_init', 'casino_theme_register_sidebar_widget');

/**
 * Casino Sidebar Widget Class
 */
class Casino_Sidebar_Widget extends WP_Widget {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'casino_sidebar_widget',
            esc_html__('Casino Sidebar Widget', 'casino-theme'),
            array(
                'description' => esc_html__('A compact table-style widget for popular and recent casinos.', 'casino-theme'),
            )
        );
    }
    
    /**
     * Front-end display of widget
     *
     * @param array $args     Widget arguments
     * @param array $instance Saved values from database
     */
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        // Widget title
        $title = !empty($instance['title']) ? $instance['title'] : '';
        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        // Get number of items to show (default: 3)
        $number_of_items = !empty($instance['number_of_items']) ? intval($instance['number_of_items']) : 3;
        
        // Get popular casinos
        $popular_casinos = casino_theme_get_popular_casinos($number_of_items);
        
        // Get recent casinos
        $recent_casinos = casino_theme_get_recent_casinos($number_of_items);
        
        // Display tabs
        ?>
        <div class="casino-sidebar-widget">
            <div class="casino-tabs-header">
                <button class="casino-tab-btn active" data-tab="popular">
                    <i class="fas fa-star"></i>
                    <span>Popular</span>
                </button>
                <button class="casino-tab-btn" data-tab="recent">
                    <i class="fas fa-clock"></i>
                    <span>Recent</span>
                </button>
            </div>
            
            <div class="casino-tab-content">
                <div class="casino-tab-pane active" id="popular">
                    <?php if (!empty($popular_casinos)) : ?>
                        <div class="casino-list-compact">
                            <?php foreach ($popular_casinos as $casino) : 
                                // Get casino meta data using optimized helper function
                                $casino_meta = casino_theme_get_casino_meta($casino->ID);
                                $composite_rating = $casino_meta['_casino_composite_rating'];
                                $loyalty_program = $casino_meta['_casino_loyalty_program'];
                                $live_casino = $casino_meta['_casino_live_casino'];
                                $mobile_casino = $casino_meta['_casino_mobile_casino'];
                                ?>
                                <div class="casino-item-compact">
                                    <div class="casino-logo-compact">
                                        <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>">
                                            <?php if (has_post_thumbnail($casino->ID)) : ?>
                                                <?php echo get_the_post_thumbnail($casino->ID, 'thumbnail', array('class' => 'casino-logo-img')); ?>
                                            <?php else : ?>
                                                <div class="casino-logo-placeholder">
                                                    <i class="fas fa-dice"></i>
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="casino-details-compact">
                                        <div class="casino-title-compact">
                                            <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>">
                                                <?php echo esc_html($casino->post_title); ?>
                                            </a>
                                        </div>
                                        <?php if ($composite_rating) : ?>
                                            <div class="casino-rating-compact">
                                                <div class="rating-stars">
                                                    <?php echo casino_theme_display_rating_stars($composite_rating); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($loyalty_program || $live_casino || $mobile_casino) : ?>
                                            <div class="casino-features-compact">
                                                <?php echo casino_theme_get_casino_features($casino->ID, 'compact', true); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="no-casinos">
                            <i class="fas fa-info-circle"></i>
                            <span>No casinos found.</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="casino-tab-pane" id="recent">
                    <?php if (!empty($recent_casinos)) : ?>
                        <div class="casino-list-compact">
                            <?php foreach ($recent_casinos as $casino) : 
                                // Get casino meta data using optimized helper function
                                $casino_meta = casino_theme_get_casino_meta($casino->ID);
                                $composite_rating = $casino_meta['_casino_composite_rating'];
                                $loyalty_program = $casino_meta['_casino_loyalty_program'];
                                $live_casino = $casino_meta['_casino_live_casino'];
                                $mobile_casino = $casino_meta['_casino_mobile_casino'];
                                ?>
                                <div class="casino-item-compact">
                                    <div class="casino-logo-compact">
                                        <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>">
                                            <?php if (has_post_thumbnail($casino->ID)) : ?>
                                                <?php echo get_the_post_thumbnail($casino->ID, 'thumbnail', array('class' => 'casino-logo-img')); ?>
                                            <?php else : ?>
                                                <div class="casino-logo-placeholder">
                                                    <i class="fas fa-dice"></i>
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="casino-details-compact">
                                        <div class="casino-title-compact">
                                            <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>">
                                                <?php echo esc_html($casino->post_title); ?>
                                            </a>
                                        </div>
                                        <?php if ($composite_rating) : ?>
                                            <div class="casino-rating-compact">
                                                <div class="rating-stars">
                                                    <?php echo casino_theme_display_rating_stars($composite_rating); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($loyalty_program || $live_casino || $mobile_casino) : ?>
                                            <div class="casino-features-compact">
                                                <?php echo casino_theme_get_casino_features($casino->ID, 'compact', true); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="no-casinos">
                            <i class="fas fa-info-circle"></i>
                            <span>No casinos found.</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        
        echo $args['after_widget'];
    }
    
    /**
     * Back-end widget form
     *
     * @param array $instance Previously saved values from database
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Popular Casinos', 'casino-theme');
        $number_of_items = !empty($instance['number_of_items']) ? intval($instance['number_of_items']) : 3;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_attr_e('Title:', 'casino-theme'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number_of_items')); ?>">
                <?php esc_attr_e('Number of items to show:', 'casino-theme'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_of_items')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('number_of_items')); ?>" type="number" 
                   value="<?php echo esc_attr($number_of_items); ?>" min="1" max="10">
        </p>
        <?php
    }
    
    /**
     * Sanitize widget form values as they are saved
     *
     * @param array $new_instance Values just sent to be saved
     * @param array $old_instance Previously saved values from database
     *
     * @return array Updated safe values to be saved
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number_of_items'] = (!empty($new_instance['number_of_items'])) ? intval($new_instance['number_of_items']) : 3;
        
        return $instance;
    }
}