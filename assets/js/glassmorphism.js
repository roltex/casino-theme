/**
 * Glass Morphism Enhancement JavaScript
 * 
 * This file contains basic JavaScript enhancements for the Glass Morphism theme
 * 
 * @package Casino_Theme
 */

(function($) {
    'use strict';

    // Initialize when DOM is ready
    $(document).ready(function() {
        initGlassmorphism();
    });

    /**
     * Initialize all Glass Morphism features
     */
    function initGlassmorphism() {
        initInteractiveElements();
    }

    /**
     * Initialize interactive elements
     */
    function initInteractiveElements() {
        // Enhanced form interactions
        $('.glass-input, .form-control').on('focus', function() {
            $(this).parent().addClass('focused');
        }).on('blur', function() {
            $(this).parent().removeClass('focused');
        });

        // Enhanced modal interactions
        $('.modal').on('show.bs.modal', function() {
            $(this).find('.modal-content').addClass('slide-in-right');
        });

        // Enhanced search functionality
        $('#searchModal .glass-input').on('input', function() {
            const query = $(this).val();
            if (query.length > 2) {
                showSearchSuggestions(query);
            } else {
                hideSearchSuggestions();
            }
        });
    }

    /**
     * Enhanced navigation interactions
     */
    function initNavigationInteractions() {
        // Smooth scrolling for anchor links
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800, 'easeInOutQuart');
            }
        });

        // Enhanced mobile menu
        $('.navbar-toggler').on('click', function() {
            const $navbar = $(this).closest('.navbar');
            $navbar.toggleClass('menu-open');
        });
    }

    /**
     * Enhanced search modal
     */
    function initSearchModal() {
        $('#searchModal').on('shown.bs.modal', function() {
            $(this).find('.glass-input').focus();
        });
    }

    /**
     * Show search suggestions
     */
    function showSearchSuggestions(query) {
        const $suggestions = $('#searchSuggestions');
        if (!$suggestions.length) {
            $('<div id="searchSuggestions" class="search-suggestions glass-card-light"></div>').insertAfter('#searchModal .glass-input');
        }
        
        const suggestions = [
            'Casino Royale',
            'Golden Palace',
            'Lucky Star',
            'Royal Flush'
        ].filter(item => item.toLowerCase().includes(query.toLowerCase()));
        
        if (suggestions.length) {
            const $suggestions = $('#searchSuggestions');
            $suggestions.html(suggestions.map(suggestion => 
                `<div class="suggestion-item">${suggestion}</div>`
            ).join('')).show();
        }
    }

    /**
     * Hide search suggestions
     */
    function hideSearchSuggestions() {
        $('#searchSuggestions').hide();
    }

    /**
     * Initialize all enhanced interactions
     */
    function initEnhancedInteractions() {
        initNavigationInteractions();
        initSearchModal();
    }

    // Initialize enhanced interactions
    initEnhancedInteractions();

    /**
     * Utility function for smooth animations
     */
    $.easing.easeInOutQuart = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
        return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
    };

})(jQuery); 