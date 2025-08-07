<?php
/**
 * Custom fields for casino and game post types
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta boxes to casino post type
 */
function casino_theme_add_casino_meta_box() {
    add_meta_box(
        'casino-details',
        esc_html__('Casino Details', 'casino-theme'),
        'casino_theme_casino_details_callback',
        'casino',
        'normal',
        'high'
    );
    
    add_meta_box(
        'casino-rating',
        esc_html__('Casino Rating', 'casino-theme'),
        'casino_theme_casino_rating_callback',
        'casino',
        'normal',
        'high'
    );
    
    add_meta_box(
        'casino-linked-games',
        esc_html__('Linked Games', 'casino-theme'),
        'casino_theme_casino_linked_games_callback',
        'casino',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'casino_theme_add_casino_meta_box');

/**
 * Add meta boxes to game post type
 */
function casino_theme_add_game_meta_box() {
    add_meta_box(
        'game-linked-casinos',
        esc_html__('Linked Casinos', 'casino-theme'),
        'casino_theme_game_linked_casinos_callback',
        'game',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'casino_theme_add_game_meta_box');

/**
 * Casino details meta box callback
 */
function casino_theme_casino_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('casino_theme_save_casino_meta', 'casino_theme_casino_meta_nonce');
    
    // Get current values using optimized helper function
    $casino_meta = casino_theme_get_casino_meta($post->ID);
    $official_site = $casino_meta['_casino_official_site'];
    $year_established = $casino_meta['_casino_year_established'];
    $contact_email = $casino_meta['_casino_contact_email'];
    $loyalty_program = $casino_meta['_casino_loyalty_program'];
    $live_casino = $casino_meta['_casino_live_casino'];
    $mobile_casino = $casino_meta['_casino_mobile_casino'];
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="casino_official_site"><?php esc_html_e('Official Site', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="url" id="casino_official_site" name="casino_official_site" 
                       value="<?php echo esc_attr($official_site); ?>" class="regular-text">
                <p class="description"><?php esc_html_e('Enter the official website URL.', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_year_established"><?php esc_html_e('Year of Establishment', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_year_established" name="casino_year_established" 
                       value="<?php echo esc_attr($year_established); ?>" class="small-text" min="1900" max="<?php echo date('Y'); ?>">
                <p class="description"><?php esc_html_e('Enter the year the casino was established.', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_contact_email"><?php esc_html_e('Contact Email', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="email" id="casino_contact_email" name="casino_contact_email" 
                       value="<?php echo esc_attr($contact_email); ?>" class="regular-text">
                <p class="description"><?php esc_html_e('Enter the contact email address.', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php esc_html_e('Features', 'casino-theme'); ?>
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text"><?php esc_html_e('Features', 'casino-theme'); ?></legend>
                    <label>
                        <input type="checkbox" name="casino_loyalty_program" value="1" <?php checked($loyalty_program, '1'); ?>>
                        <?php esc_html_e('Loyalty Program', 'casino-theme'); ?>
                    </label><br>
                    <label>
                        <input type="checkbox" name="casino_live_casino" value="1" <?php checked($live_casino, '1'); ?>>
                        <?php esc_html_e('Live Casino', 'casino-theme'); ?>
                    </label><br>
                    <label>
                        <input type="checkbox" name="casino_mobile_casino" value="1" <?php checked($mobile_casino, '1'); ?>>
                        <?php esc_html_e('Mobile Casino', 'casino-theme'); ?>
                    </label>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Casino rating meta box callback
 */
function casino_theme_casino_rating_callback($post) {
    // Get current values
    $composite_rating = get_post_meta($post->ID, '_casino_composite_rating', true);
    $games_rating = get_post_meta($post->ID, '_casino_games_rating', true);
    $live_casino_rating = get_post_meta($post->ID, '_casino_live_casino_rating', true);
    $payout_rating = get_post_meta($post->ID, '_casino_payout_rating', true);
    $licensing_rating = get_post_meta($post->ID, '_casino_licensing_rating', true);
    $payment_methods_rating = get_post_meta($post->ID, '_casino_payment_methods_rating', true);
    $withdrawal_speed_rating = get_post_meta($post->ID, '_casino_withdrawal_speed_rating', true);
    $support_rating = get_post_meta($post->ID, '_casino_support_rating', true);
    $offers_rating = get_post_meta($post->ID, '_casino_offers_rating', true);
    $mobile_rating = get_post_meta($post->ID, '_casino_mobile_rating', true);
    $website_rating = get_post_meta($post->ID, '_casino_website_rating', true);
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="casino_composite_rating"><?php esc_html_e('Composite Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_composite_rating" name="casino_composite_rating" 
                       value="<?php echo esc_attr($composite_rating); ?>" class="small-text" min="0" max="10" step="0.1" readonly>
                <p class="description"><?php esc_html_e('Automatically calculated from individual ratings.', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_games_rating"><?php esc_html_e('Games Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_games_rating" name="casino_games_rating" 
                       value="<?php echo esc_attr($games_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_live_casino_rating"><?php esc_html_e('Live Casino Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_live_casino_rating" name="casino_live_casino_rating" 
                       value="<?php echo esc_attr($live_casino_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_payout_rating"><?php esc_html_e('Payout Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_payout_rating" name="casino_payout_rating" 
                       value="<?php echo esc_attr($payout_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_licensing_rating"><?php esc_html_e('Licensing Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_licensing_rating" name="casino_licensing_rating" 
                       value="<?php echo esc_attr($licensing_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_payment_methods_rating"><?php esc_html_e('Payment Methods Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_payment_methods_rating" name="casino_payment_methods_rating" 
                       value="<?php echo esc_attr($payment_methods_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_withdrawal_speed_rating"><?php esc_html_e('Withdrawal Speed Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_withdrawal_speed_rating" name="casino_withdrawal_speed_rating" 
                       value="<?php echo esc_attr($withdrawal_speed_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_support_rating"><?php esc_html_e('Support Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_support_rating" name="casino_support_rating" 
                       value="<?php echo esc_attr($support_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_offers_rating"><?php esc_html_e('Offers Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_offers_rating" name="casino_offers_rating" 
                       value="<?php echo esc_attr($offers_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_mobile_rating"><?php esc_html_e('Mobile Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_mobile_rating" name="casino_mobile_rating" 
                       value="<?php echo esc_attr($mobile_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="casino_website_rating"><?php esc_html_e('Website Rating', 'casino-theme'); ?></label>
            </th>
            <td>
                <input type="number" id="casino_website_rating" name="casino_website_rating" 
                       value="<?php echo esc_attr($website_rating); ?>" class="small-text" min="0" max="10" step="0.1">
                <p class="description"><?php esc_html_e('Rate from 1 to 10 with step of 0.1', 'casino-theme'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Casino linked games meta box callback
 */
function casino_theme_casino_linked_games_callback($post) {
    // Get all games
    $games = get_posts(array(
        'post_type' => 'game',
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    // Get currently linked games
    $linked_games = get_post_meta($post->ID, '_casino_linked_games', true);
    if (empty($linked_games) || !is_array($linked_games)) {
        $linked_games = array();
    }
    
    if (!empty($games)) :
        ?>
        <ul class="casino-linked-games-list">
            <?php foreach ($games as $game) : ?>
                <li>
                    <label>
                        <input type="checkbox" name="casino_linked_games[]" value="<?php echo esc_attr($game->ID); ?>" 
                               <?php checked(in_array($game->ID, $linked_games)); ?>>
                        <?php echo esc_html($game->post_title); ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    else :
        ?>
        <p><?php esc_html_e('No games found.', 'casino-theme'); ?></p>
        <?php
    endif;
}

/**
 * Game linked casinos meta box callback
 */
function casino_theme_game_linked_casinos_callback($post) {
    // Get all casinos
    $casinos = get_posts(array(
        'post_type' => 'casino',
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    // Get currently linked casinos
    $linked_casinos = get_post_meta($post->ID, '_game_linked_casinos', true);
    if (empty($linked_casinos) || !is_array($linked_casinos)) {
        $linked_casinos = array();
    }
    
    if (!empty($casinos)) :
        ?>
        <ul class="game-linked-casinos-list">
            <?php foreach ($casinos as $casino) : 
                $composite_rating = get_post_meta($casino->ID, '_casino_composite_rating', true);
                ?>
                <li>
                    <label>
                        <input type="checkbox" name="game_linked_casinos[]" value="<?php echo esc_attr($casino->ID); ?>" 
                               <?php checked(in_array($casino->ID, $linked_casinos)); ?>>
                        <?php echo esc_html($casino->post_title); ?>
                        <?php if ($composite_rating) : ?>
                            (<?php echo esc_html(number_format($composite_rating, 1)); ?>/10)
                        <?php endif; ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    else :
        ?>
        <p><?php esc_html_e('No casinos found.', 'casino-theme'); ?></p>
        <?php
    endif;
}

/**
 * Save casino meta data with enhanced security
 */
function casino_theme_save_casino_meta($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['casino_theme_casino_meta_nonce']) || 
        !wp_verify_nonce($_POST['casino_theme_casino_meta_nonce'], 'casino_theme_save_casino_meta')) {
        return;
    }

    // Check if user has permissions to save data
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if our custom fields are being sent
    if (!isset($_POST['casino_official_site']) && 
        !isset($_POST['casino_year_established']) && 
        !isset($_POST['casino_contact_email'])) {
        return;
    }

    // Sanitize and save official site
    if (isset($_POST['casino_official_site'])) {
        $official_site = esc_url_raw($_POST['casino_official_site']);
        update_post_meta($post_id, '_casino_official_site', $official_site);
    }

    // Sanitize and save year established
    if (isset($_POST['casino_year_established'])) {
        $year_established = intval($_POST['casino_year_established']);
        if ($year_established >= 1900 && $year_established <= date('Y')) {
            update_post_meta($post_id, '_casino_year_established', $year_established);
        }
    }

    // Sanitize and save contact email
    if (isset($_POST['casino_contact_email'])) {
        $contact_email = sanitize_email($_POST['casino_contact_email']);
        if (is_email($contact_email)) {
            update_post_meta($post_id, '_casino_contact_email', $contact_email);
        }
    }

    // Sanitize and save loyalty program
    if (isset($_POST['casino_loyalty_program'])) {
        $loyalty_program = sanitize_text_field($_POST['casino_loyalty_program']);
        update_post_meta($post_id, '_casino_loyalty_program', $loyalty_program);
    } else {
        delete_post_meta($post_id, '_casino_loyalty_program');
    }

    // Sanitize and save live casino
    if (isset($_POST['casino_live_casino'])) {
        $live_casino = sanitize_text_field($_POST['casino_live_casino']);
        update_post_meta($post_id, '_casino_live_casino', $live_casino);
    } else {
        delete_post_meta($post_id, '_casino_live_casino');
    }

    // Sanitize and save mobile casino
    if (isset($_POST['casino_mobile_casino'])) {
        $mobile_casino = sanitize_text_field($_POST['casino_mobile_casino']);
        update_post_meta($post_id, '_casino_mobile_casino', $mobile_casino);
    } else {
        delete_post_meta($post_id, '_casino_mobile_casino');
    }

    // Save individual ratings
    $rating_fields = array(
        'casino_games_rating',
        'casino_live_casino_rating',
        'casino_payout_rating',
        'casino_licensing_rating',
        'casino_payment_methods_rating',
        'casino_withdrawal_speed_rating',
        'casino_support_rating',
        'casino_offers_rating',
        'casino_mobile_rating',
        'casino_website_rating'
    );

    $total_rating = 0;
    $rating_count = 0;

    foreach ($rating_fields as $field) {
        if (isset($_POST[$field])) {
            $rating = floatval($_POST[$field]);
            if ($rating >= 0 && $rating <= 10) {
                update_post_meta($post_id, '_' . $field, $rating);
                $total_rating += $rating;
                $rating_count++;
            }
        }
    }

    // Calculate and save composite rating
    if ($rating_count > 0) {
        $composite_rating = round($total_rating / $rating_count, 1);
        update_post_meta($post_id, '_casino_composite_rating', $composite_rating);
    }

    // Sanitize and save linked games
    if (isset($_POST['casino_linked_games']) && is_array($_POST['casino_linked_games'])) {
        $linked_games = array_map('intval', $_POST['casino_linked_games']);
        $linked_games = array_filter($linked_games); // Remove empty values
        update_post_meta($post_id, '_casino_linked_games', $linked_games);
    } else {
        delete_post_meta($post_id, '_casino_linked_games');
    }
}
add_action('save_post_casino', 'casino_theme_save_casino_meta');

/**
 * Save game meta data
 */
function casino_theme_save_game_meta($post_id) {
    // Check if user has permission to edit post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if not autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Save linked casinos
    if (isset($_POST['game_linked_casinos'])) {
        $linked_casinos = array_map('intval', $_POST['game_linked_casinos']);
        update_post_meta($post_id, '_game_linked_casinos', $linked_casinos);
    } else {
        delete_post_meta($post_id, '_game_linked_casinos');
    }
}
add_action('save_post_game', 'casino_theme_save_game_meta');