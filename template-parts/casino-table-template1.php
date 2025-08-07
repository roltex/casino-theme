<?php
/**
 * Template part for displaying casino table template 1
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get parameters
$title = isset($args['title']) ? $args['title'] : 'Best Casino';
$template = isset($args['template']) ? $args['template'] : '1';
$second_col = isset($args['second_col']) ? $args['second_col'] : 'loyalty';
$limit = isset($args['limit']) ? intval($args['limit']) : 10;

// Get casinos
$casinos = get_posts(array(
    'post_type' => 'casino',
    'numberposts' => $limit,
    'post_status' => 'publish',
    'orderby' => 'meta_value_num',
    'meta_key' => '_casino_composite_rating',
    'order' => 'DESC'
));

if (!empty($casinos)) :
    ?>
    <div class="casino-table-wrapper template-1">
        <div class="table-header glass-card p-4 mb-4">
            <h2 class="table-title text-gradient mb-0"><?php echo esc_html($title); ?></h2>
        </div>
        
        <div class="table-responsive">
            <table class="table casino-table">
                <thead>
                    <tr>
                        <th class="glass-header">
                            <i class="fas fa-dice"></i>
                            <?php esc_html_e('Casino', 'casino-theme'); ?>
                        </th>
                        <th class="glass-header">
                            <?php
                            switch ($second_col) {
                                case 'loyalty':
                                    echo '<i class="fas fa-star"></i> ' . esc_html__('Loyalty Program', 'casino-theme');
                                    break;
                                case 'live_casino':
                                    echo '<i class="fas fa-video"></i> ' . esc_html__('Live Casino', 'casino-theme');
                                    break;
                                case 'mobile_casino':
                                    echo '<i class="fas fa-mobile-alt"></i> ' . esc_html__('Mobile Casino', 'casino-theme');
                                    break;
                                default:
                                    echo '<i class="fas fa-star"></i> ' . esc_html__('Loyalty Program', 'casino-theme');
                                    break;
                            }
                            ?>
                        </th>
                        <th class="glass-header">
                            <i class="fas fa-eye"></i>
                            <?php esc_html_e('Review', 'casino-theme'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($casinos as $casino) : 
                        // Get casino meta data using optimized helper function
                        $casino_meta = casino_theme_get_casino_meta($casino->ID);
                        $composite_rating = $casino_meta['_casino_composite_rating'];
                        $loyalty_program = $casino_meta['_casino_loyalty_program'];
                        $live_casino = $casino_meta['_casino_live_casino'];
                        $mobile_casino = $casino_meta['_casino_mobile_casino'];
                        $official_site = $casino_meta['_casino_official_site'];
                        ?>
                        <tr class="casino-row">
                            <td>
                                <div class="casino-info-compact">
                                    <div class="casino-logo-wrapper">
                                        <?php if (has_post_thumbnail($casino->ID)) : ?>
                                            <?php if ($official_site) : ?>
                                                <a href="<?php echo esc_url($official_site); ?>" target="_blank" rel="noopener noreferrer">
                                                    <?php echo get_the_post_thumbnail($casino->ID, 'thumbnail', array('class' => 'casino-logo')); ?>
                                                </a>
                                            <?php else : ?>
                                                <?php echo get_the_post_thumbnail($casino->ID, 'thumbnail', array('class' => 'casino-logo')); ?>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <div class="casino-logo-placeholder">
                                                <i class="fas fa-dice"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="casino-details-compact">
                                        <div class="casino-name">
                                            <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>" class="casino-title-link">
                                                <?php echo esc_html($casino->post_title); ?>
                                            </a>
                                        </div>
                                        <?php if ($composite_rating) : ?>
                                            <div class="casino-rating-compact">
                                                <?php echo casino_theme_display_rating_stars($composite_rating); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php
                                switch ($second_col) {
                                    case 'loyalty':
                                        if ($loyalty_program) {
                                            echo '<span class="feature-badge yes-badge"><i class="fas fa-check"></i> ' . esc_html__('YES', 'casino-theme') . '</span>';
                                        } else {
                                            echo '<span class="feature-badge no-badge"><i class="fas fa-times"></i> ' . esc_html__('NO', 'casino-theme') . '</span>';
                                        }
                                        break;
                                    case 'live_casino':
                                        if ($live_casino) {
                                            echo '<span class="feature-badge yes-badge"><i class="fas fa-check"></i> ' . esc_html__('YES', 'casino-theme') . '</span>';
                                        } else {
                                            echo '<span class="feature-badge no-badge"><i class="fas fa-times"></i> ' . esc_html__('NO', 'casino-theme') . '</span>';
                                        }
                                        break;
                                    case 'mobile_casino':
                                        if ($mobile_casino) {
                                            echo '<span class="feature-badge yes-badge"><i class="fas fa-check"></i> ' . esc_html__('YES', 'casino-theme') . '</span>';
                                        } else {
                                            echo '<span class="feature-badge no-badge"><i class="fas fa-times"></i> ' . esc_html__('NO', 'casino-theme') . '</span>';
                                        }
                                        break;
                                    default:
                                        if ($loyalty_program) {
                                            echo '<span class="feature-badge yes-badge"><i class="fas fa-check"></i> ' . esc_html__('YES', 'casino-theme') . '</span>';
                                        } else {
                                            echo '<span class="feature-badge no-badge"><i class="fas fa-times"></i> ' . esc_html__('NO', 'casino-theme') . '</span>';
                                        }
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($official_site) : ?>
                                    <a href="<?php echo esc_url($official_site); ?>" target="_blank" rel="noopener noreferrer" class="glass-btn glass-btn-primary">
                                        <i class="fas fa-external-link-alt"></i>
                                        <?php esc_html_e('Visit Site', 'casino-theme'); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>" class="glass-btn glass-btn-primary">
                                        <i class="fas fa-arrow-right"></i>
                                        <?php esc_html_e('Review', 'casino-theme'); ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
endif;
?>