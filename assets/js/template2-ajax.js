/**
 * Template 2 AJAX functionality
 * Handles dynamic content loading for casino table template 2
 */

jQuery(document).ready(function($) {
    'use strict';

    // Check if casino_theme_ajax is available
    if (typeof casino_theme_ajax === 'undefined') {
        console.error('casino_theme_ajax not found. Script may not be loaded properly.');
        return;
    }

    console.log('casino_theme_ajax object:', casino_theme_ajax);

    // Template 2 dynamic content functionality
    function initTemplate2Ajax() {
        const $template2Wrapper = $('.casino-table-wrapper.template-2');
        
        if ($template2Wrapper.length === 0) {
            console.log('Template 2 wrapper not found');
            return;
        }

        console.log('Template 2 AJAX initialized');

        const $columnTypeSelect = $template2Wrapper.find('.column-type-select');
        const $tableBody = $template2Wrapper.find('tbody');
        const $middleColumnHeader = $template2Wrapper.find('.middle-column-header');

        if ($columnTypeSelect.length === 0) {
            console.log('Column type select not found');
            return;
        }

        if ($tableBody.length === 0) {
            console.log('Table body not found');
            return;
        }

        if ($middleColumnHeader.length === 0) {
            console.log('Middle column header not found');
            return;
        }

        // Initialize with default column type
        let currentColumnType = $columnTypeSelect.val() || 'loyalty';
        console.log('Initial column type:', currentColumnType);
        
        updateColumnHeader(currentColumnType);
        loadAllColumnContent(currentColumnType);

        // Handle column type change
        $columnTypeSelect.on('change', function() {
            const newColumnType = $(this).val();
            currentColumnType = newColumnType;
            console.log('Column type changed to:', newColumnType);
            
            // Update header
            updateColumnHeader(newColumnType);
            
            // Load content for all rows
            loadAllColumnContent(newColumnType);
        });

        // Update column header based on selected type
        function updateColumnHeader(columnType) {
            let headerText = '';
            let headerIcon = '';

            switch (columnType) {
                case 'loyalty':
                    headerText = 'Loyalty Program';
                    headerIcon = 'fas fa-star';
                    break;
                case 'live_casino':
                    headerText = 'Live Casino';
                    headerIcon = 'fas fa-video';
                    break;
                case 'mobile_casino':
                    headerText = 'Mobile Casino';
                    headerIcon = 'fas fa-mobile-alt';
                    break;
                case 'year_established':
                    headerText = 'Year Established';
                    headerIcon = 'fas fa-calendar-alt';
                    break;
                case 'contact_email':
                    headerText = 'Contact Email';
                    headerIcon = 'fas fa-envelope';
                    break;
                case 'games':
                    headerText = 'Games';
                    headerIcon = 'fas fa-gamepad';
                    break;
                default:
                    headerText = 'Loyalty Program';
                    headerIcon = 'fas fa-star';
                    break;
            }

            $middleColumnHeader.html('<i class="' + headerIcon + '"></i> ' + headerText);
        }

        // Load content for all rows
        function loadAllColumnContent(columnType) {
            const rows = $tableBody.find('tr');
            console.log('Loading content for', rows.length, 'rows with column type:', columnType);
            
            rows.each(function() {
                const $row = $(this);
                const casinoId = $row.data('casino-id');
                const $middleCell = $row.find('.middle-column-cell');

                if (casinoId && $middleCell.length > 0) {
                    console.log('Loading content for casino ID:', casinoId);
                    loadColumnContent(casinoId, columnType, $middleCell);
                } else {
                    console.log('Missing casino ID or middle cell for row:', $row);
                }
            });
        }

        // Load content for a specific cell
        function loadColumnContent(casinoId, columnType, $cell) {
            // Show loading state
            $cell.html('<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i></div>');

            console.log('Making AJAX request for casino ID:', casinoId, 'column type:', columnType);
            console.log('AJAX URL:', casino_theme_ajax.ajax_url);
            console.log('Nonce:', casino_theme_ajax.nonce);

            $.ajax({
                url: casino_theme_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'casino_theme_template2_content',
                    casino_id: casinoId,
                    column_type: columnType,
                    nonce: casino_theme_ajax.nonce
                },
                success: function(response) {
                    console.log('AJAX response:', response);
                    if (response.success) {
                        $cell.html(response.data);
                    } else {
                        console.error('AJAX error:', response);
                        $cell.html('<span class="error-badge">Error loading content</span>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    console.error('XHR:', xhr);
                    $cell.html('<span class="error-badge">Error loading content</span>');
                }
            });
        }
    }

    // Initialize Template 2 AJAX functionality
    initTemplate2Ajax();

    // Re-initialize if content is loaded dynamically (e.g., via shortcodes)
    $(document).on('casino_theme_template2_loaded', function() {
        console.log('Template 2 loaded event triggered');
        initTemplate2Ajax();
    });
}); 