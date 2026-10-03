/**
 * Amazing Infotech - Modern Upgrade Interactions Script
 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var offcanvasEl = document.getElementById('offcanvasNavbar');
        var actionDock = document.querySelector('.mobile-action-dock');
        var toggler = document.querySelector('.navbar-toggler');

        if (offcanvasEl) {
            // When offcanvas begins opening
            offcanvasEl.addEventListener('show.bs.offcanvas', function () {
                document.body.classList.add('offcanvas-active');
                if (actionDock) {
                    actionDock.style.setProperty('display', 'none', 'important');
                }
            });

            // When offcanvas is fully open
            offcanvasEl.addEventListener('shown.bs.offcanvas', function () {
                document.body.classList.add('offcanvas-active');
                if (actionDock) {
                    actionDock.style.setProperty('display', 'none', 'important');
                }
            });

            // When offcanvas begins closing
            offcanvasEl.addEventListener('hide.bs.offcanvas', function () {
                document.body.classList.remove('offcanvas-active');
            });

            // When offcanvas is fully closed
            offcanvasEl.addEventListener('hidden.bs.offcanvas', function () {
                document.body.classList.remove('offcanvas-active');
                if (actionDock) {
                    actionDock.style.removeProperty('display');
                }
            });
        }

        // Toggler immediate event safeguard
        if (toggler && actionDock) {
            toggler.addEventListener('click', function () {
                setTimeout(function () {
                    if (offcanvasEl && (offcanvasEl.classList.contains('show') || offcanvasEl.classList.contains('showing'))) {
                        document.body.classList.add('offcanvas-active');
                        actionDock.style.setProperty('display', 'none', 'important');
                    }
                }, 10);
            });
        }

        // Auto-close offcanvas when clicking internal non-dropdown links
        var navLinks = document.querySelectorAll('#offcanvasNavbar .nav-link:not(.dropdown-toggle), #offcanvasNavbar .dropdown-item');
        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                if (offcanvasEl && window.bootstrap && window.bootstrap.Offcanvas) {
                    var bsOffcanvas = window.bootstrap.Offcanvas.getInstance(offcanvasEl);
                    if (bsOffcanvas) {
                        bsOffcanvas.hide();
                    }
                }
            });
        });
    });
})();
