    </main><!-- #main -->

    <!-- Footer -->
    <footer class="footer" id="footer-contacto">
        <div class="footer-container">
            <div class="footer-grid">
                <!-- Column 1 - Brand -->
                <div class="footer-column">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                        <h3 class="footer-logo">Aluria</h3>
                        <p class="footer-description"><?php echo esc_html(get_theme_mod('aluria_footer_description', 'Tu destino de moda femenina con estilo y elegancia.')); ?></p>
                        <div class="footer-social">
                            <?php 
                            $facebook = get_theme_mod('social_facebook', '');
                            $instagram = get_theme_mod('social_instagram', 'https://www.instagram.com/aluriamodas/');
                            $tiktok = get_theme_mod('social_tiktok', 'https://www.tiktok.com/@aluria.modas');
                            ?>
                            <?php if ($facebook) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" aria-label="Facebook" target="_blank" rel="noopener">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                            <?php endif; ?>
                            <?php if ($instagram) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" aria-label="Instagram" target="_blank" rel="noopener">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                            </a>
                            <?php endif; ?>
                            <?php if ($tiktok) : ?>
                            <a href="<?php echo esc_url($tiktok); ?>" aria-label="TikTok" target="_blank" rel="noopener">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Column 2 - Shop Links -->
                <div class="footer-column">
                    <h4><?php esc_html_e('Tienda', 'aluria'); ?></h4>
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-1',
                            'container' => false,
                            'menu_class' => 'footer-links',
                            'depth' => 1,
                            'fallback_cb' => function() {
                                echo '<ul class="footer-links">';
                                echo '<li><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">Catálogo</a></li>';
                                echo '</ul>';
                            }
                        ));
                        ?>
                    <?php endif; ?>
                </div>

                <!-- Column 3 - Customer Service -->
                <div class="footer-column">
                    <h4><?php esc_html_e('Ayuda', 'aluria'); ?></h4>
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-2',
                            'container' => false,
                            'menu_class' => 'footer-links',
                            'depth' => 1,
                            'fallback_cb' => function() {
                                echo '<ul class="footer-links">';
                                echo '<li><a href="' . esc_url(get_privacy_policy_url()) . '">Política de Privacidad</a></li>';
                                echo '</ul>';
                            }
                        ));
                        ?>
                    <?php endif; ?>
                </div>

                <!-- Column 4 - Contact -->
                <div class="footer-column">
                    <h4><?php esc_html_e('Contacto', 'aluria'); ?></h4>
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <?php dynamic_sidebar('footer-4'); ?>
                    <?php else : ?>
                        <div class="footer-contact">
                            <?php $email = get_theme_mod('contact_email', 'info@aluriamodas.es'); ?>
                            <?php $phone = get_theme_mod('contact_phone', '620 932 637'); ?>
                            <?php $address = get_theme_mod('contact_location', 'Sevilla, España'); ?>
                            <?php $schedule = get_theme_mod('contact_schedule', 'Lun - Vie: 9:00 - 18:00'); ?>
                            
                            <?php if ($email) : ?>
                            <p>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </p>
                            <?php endif; ?>
                            
                            <?php if ($phone) : ?>
                            <p>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </p>
                            <?php endif; ?>
                            
                            <?php if ($address) : ?>
                            <p>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <?php echo esc_html($address); ?>
                            </p>
                            <?php endif; ?>
                            
                            <?php if ($schedule) : ?>
                            <p>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <?php echo esc_html($schedule); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('Todos los derechos reservados.', 'aluria'); ?></p>
                <div class="footer-legal">
                    <a href="<?php echo esc_url(get_privacy_policy_url()); ?>"><?php esc_html_e('Privacidad', 'aluria'); ?></a>
                    <?php 
                    $terms_page = get_page_by_path('terminos');
                    if ($terms_page) : ?>
                    <a href="<?php echo esc_url(get_permalink($terms_page)); ?>"><?php esc_html_e('Términos', 'aluria'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <?php aluria_whatsapp_button(); ?>

    <?php wp_footer(); ?>
</body>
</html>
