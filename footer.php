    </main><!-- #main -->

    <!-- Footer -->
    <footer class="footer">
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

    <!-- Favorites Panel -->
    <div class="favorites-panel" id="favoritesPanel">
        <div class="favorites-header">
            <h3><?php esc_html_e('Mis Favoritos', 'aluria'); ?></h3>
            <button class="favorites-close" id="favoritesClose" aria-label="<?php esc_attr_e('Cerrar', 'aluria'); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="favorites-content" id="favoritesContent">
            <div class="favorites-empty">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <p><?php esc_html_e('Aún no tienes favoritos', 'aluria'); ?></p>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="quick-view-modal" id="quickViewModal">
        <div class="quick-view-overlay"></div>
        <div class="quick-view-content">
            <button class="quick-view-close" aria-label="<?php esc_attr_e('Cerrar', 'aluria'); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="quick-view-grid">
                <div class="quick-view-image zoom-container">
                    <img src="" alt="" id="quickViewImage">
                    <div class="zoom-lens" id="zoomLens"></div>
                    <div class="zoom-result" id="zoomResult"></div>
                </div>
                <div class="quick-view-info">
                    <span class="quick-view-stock" id="quickViewStock"></span>
                    <span class="quick-view-category" id="quickViewCategory"></span>
                    <h2 class="quick-view-name" id="quickViewTitle"></h2>
                    <p class="quick-view-price" id="quickViewPrice"></p>
                    <div class="quick-view-description" id="quickViewDescription"></div>
                    <div class="quick-view-options">
                        <div class="option-group">
                            <label><?php esc_html_e('Cantidad:', 'aluria'); ?></label>
                            <div class="qty-selector">
                                <button class="qty-btn" id="qtyMinus">−</button>
                                <span class="qty-value" id="qtyValue">1</span>
                                <button class="qty-btn" id="qtyPlus">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="quick-view-actions">
                        <button class="btn btn-primary" id="addToCartModal">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            <?php esc_html_e('Añadir al Carrito', 'aluria'); ?>
                        </button>
                        <a href="" class="btn-whatsapp-small" id="quickViewWhatsApp" target="_blank">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <?php esc_html_e('Consultar', 'aluria'); ?>
                        </a>
                    </div>
                    <a href="" class="btn btn-secondary" id="quickViewLink" style="margin-top: 10px; text-align: center; display: block;">
                        <?php esc_html_e('Ver producto completo', 'aluria'); ?>
                    </a>
                    <button class="quick-view-favorite" id="quickViewFavorite">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                        <?php esc_html_e('Añadir a favoritos', 'aluria'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
