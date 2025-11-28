<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileAccountToggles = document.querySelectorAll('.mobile-account-toggle');

        // Toggle main mobile menu
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
                const menuIcon = this.querySelector('svg');
                if (menuIcon) {
                    if (mobileMenu.classList.contains('hidden')) {
                        menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                    } else {
                        menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                    }
                }
            });
        }

        // Toggle account submenu in mobile
        mobileAccountToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const submenu = this.nextElementSibling;
                if (submenu && submenu.classList.contains('mobile-account-menu')) {
                    submenu.classList.toggle('hidden');
                    const icon = this.querySelector('svg');
                    if (icon) {
                        icon.classList.toggle('rotate-180');
                    }
                }
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (mobileMenu && !mobileMenu.contains(event.target) && mobileMenuButton && !mobileMenuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                const menuIcon = mobileMenuButton.querySelector('svg');
                if (menuIcon) {
                    menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                }
            }
        });
    });
</script>
