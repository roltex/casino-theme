/**
 * Casino Widget Tabs Functionality
 *
 * Handles tab switching for the casino sidebar widget
 *
 * @package Casino_Theme
 */
(function() {
    'use strict';

    function initCasinoWidgetTabs() {
        const tabContainers = document.querySelectorAll('.casino-sidebar-widget');
        
        tabContainers.forEach(container => {
            const tabButtons = container.querySelectorAll('.casino-tab-btn');
            const tabPanes = container.querySelectorAll('.casino-tab-pane');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Remove active class from all buttons and panes
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabPanes.forEach(pane => pane.classList.remove('active'));
                    
                    // Add active class to clicked button and corresponding pane
                    this.classList.add('active');
                    const targetPane = container.querySelector(`#${targetTab}`);
                    if (targetPane) {
                        targetPane.classList.add('active');
                    }
                });
            });
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCasinoWidgetTabs);
    } else {
        initCasinoWidgetTabs();
    }

})();