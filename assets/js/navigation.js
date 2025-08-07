/**
 * Navigation functionality for Casino Theme
 * 
 * Handles:
 * - Sticky header with admin bar support
 * - Mobile menu interactions
 * - Navigation link behaviors
 * 
 * @package Casino_Theme
 */
(function() {
    'use strict';

    // Configuration
    const CONFIG = {
        scrollThreshold: {
            desktop: 200,
            mobile: 150
        },
        stickyHeaderHeight: 80,
        adminBarHeight: {
            desktop: 32,
            mobile: 46
        },
        breakpoints: {
            mobile: 768,
            adminBarMobile: 782
        }
    };

    // Sticky Header Functionality
    function initStickyHeader() {
        const header = document.querySelector('.site-header');
        const body = document.body;
        let stickyHeader = null;
        let scrollThreshold = getScrollThreshold();
        
        if (!header) return;

        // Utility functions
        function hasAdminBar() {
            return document.body.classList.contains('admin-bar') || document.querySelector('#wpadminbar');
        }

        function getAdminBarHeight() {
            const adminBar = document.querySelector('#wpadminbar');
            if (!adminBar) return 0;
            
            const height = adminBar.offsetHeight;
            const isMobile = window.innerWidth <= CONFIG.breakpoints.adminBarMobile;
            
            return height > 0 ? height : (isMobile ? CONFIG.adminBarHeight.mobile : CONFIG.adminBarHeight.desktop);
        }

        function getScrollThreshold() {
            return window.innerWidth <= CONFIG.breakpoints.mobile ? CONFIG.scrollThreshold.mobile : CONFIG.scrollThreshold.desktop;
        }

        function getStickyHeaderTop() {
            return hasAdminBar() ? getAdminBarHeight() + 'px' : '0';
        }

        function updateBodyPadding() {
            if (stickyHeader && stickyHeader.classList.contains('show')) {
                const adminBarHeight = hasAdminBar() ? getAdminBarHeight() : 0;
                body.style.paddingTop = (adminBarHeight + CONFIG.stickyHeaderHeight) + 'px';
            }
        }

        // Create sticky header clone
        function createStickyHeader() {
            // Remove existing sticky header
            const existingSticky = document.getElementById('sticky-header');
            if (existingSticky) {
                existingSticky.remove();
            }
            
            // Clone and configure sticky header
            stickyHeader = header.cloneNode(true);
            stickyHeader.classList.add('header-sticky');
            stickyHeader.id = 'sticky-header';
            stickyHeader.classList.remove('site-header');
            
            // Apply styles
            Object.assign(stickyHeader.style, {
                position: 'fixed',
                top: getStickyHeaderTop(),
                left: '0',
                right: '0',
                zIndex: '9999',
                transform: 'translateY(-100%)',
                transition: 'transform 0.3s ease-in-out',
                background: 'rgba(255, 255, 255, 0.15)',
                backdropFilter: 'blur(12px)',
                webkitBackdropFilter: 'blur(12px)',
                boxShadow: '0 4px 20px rgba(0, 0, 0, 0.1)'
            });
            
            // Hide top bar in sticky header
            const topBar = stickyHeader.querySelector('.top-bar');
            if (topBar) {
                topBar.style.display = 'none';
            }
            
            document.body.appendChild(stickyHeader);
            return stickyHeader;
        }

        function handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Create sticky header if needed
            if (!stickyHeader) {
                stickyHeader = createStickyHeader();
            }
            
            // Show/hide sticky header
            const shouldShow = scrollTop > scrollThreshold;
            const isVisible = stickyHeader.classList.contains('show');
            
            if (shouldShow && !isVisible) {
                stickyHeader.classList.add('show');
                stickyHeader.style.transform = 'translateY(0)';
                body.classList.add('has-sticky-header');
                updateBodyPadding();
            } else if (!shouldShow && isVisible) {
                stickyHeader.classList.remove('show');
                stickyHeader.style.transform = 'translateY(-100%)';
                body.classList.remove('has-sticky-header');
                body.style.paddingTop = '';
            }
        }

        // Throttled scroll handler
        let ticking = false;
        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        }

        // Event listeners
        window.addEventListener('scroll', requestTick, { passive: true });

        // Handle window resize
        const debouncedResize = debounce(() => {
            scrollThreshold = getScrollThreshold();
            
            if (stickyHeader) {
                stickyHeader.style.top = getStickyHeaderTop();
                updateBodyPadding();
            }
        }, 150);

        window.addEventListener('resize', debouncedResize);

        // Handle admin bar changes
        if (hasAdminBar()) {
            const adminBar = document.querySelector('#wpadminbar');
            if (adminBar) {
                const observer = new MutationObserver(debounce(() => {
                    if (stickyHeader) {
                        stickyHeader.style.top = getStickyHeaderTop();
                        updateBodyPadding();
                    }
                }, 100));

                observer.observe(adminBar, { 
                    attributes: true, 
                    attributeFilter: ['style'] 
                });
            }
        }

        // Initial check
        handleScroll();
    }

    // Sticky Sidebar Functionality
    function initStickySidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (!sidebar) return;

        function hasAdminBar() {
            return document.body.classList.contains('admin-bar') || document.querySelector('#wpadminbar');
        }

        function getAdminBarHeight() {
            const adminBar = document.querySelector('#wpadminbar');
            if (!adminBar) return 0;
            
            const height = adminBar.offsetHeight;
            const isMobile = window.innerWidth <= CONFIG.breakpoints.adminBarMobile;
            
            return height > 0 ? height : (isMobile ? CONFIG.adminBarHeight.mobile : CONFIG.adminBarHeight.desktop);
        }

        function updateSidebarPosition() {
            const adminBarHeight = hasAdminBar() ? getAdminBarHeight() : 0;
            const topOffset = adminBarHeight + 100; // 100px from top + admin bar height
            
            sidebar.style.top = topOffset + 'px';
        }

        // Initial position update
        updateSidebarPosition();

        // Update on window resize
        window.addEventListener('resize', debounce(updateSidebarPosition, 250));

        // Update on admin bar changes (if admin bar is present)
        if (hasAdminBar()) {
            const adminBar = document.querySelector('#wpadminbar');
            if (adminBar) {
                const observer = new MutationObserver(debounce(updateSidebarPosition, 100));
                observer.observe(adminBar, {
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
            }
        }
    }

    // Mobile menu functionality
    function initMobileMenuClose() {
        document.addEventListener('click', function(event) {
            const navbar = document.querySelector('.navbar');
            const toggler = document.querySelector('.navbar-toggler');
            
            if (navbar && toggler && navbar.classList.contains('show')) {
                const isClickInside = navbar.contains(event.target);
                const isToggler = toggler.contains(event.target);
                
                if (!isClickInside && !isToggler) {
                    toggler.click();
                }
            }
        });
    }

    function initNavLinkClose() {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                const navbar = document.querySelector('.navbar-collapse');
                const toggler = document.querySelector('.navbar-toggler');
                
                if (navbar && toggler && navbar.classList.contains('show')) {
                    toggler.click();
                }
            });
        });
    }

    // Utility function: Debounce
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Initialize functionality
    function init() {
        initStickyHeader();
        initStickySidebar(); // Initialize sticky sidebar
        initMobileMenuClose();
        initNavLinkClose();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
