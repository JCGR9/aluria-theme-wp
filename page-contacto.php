<?php
/**
 * Template Name: Contacto
 * 
 * @package Aluria
 */

get_header();
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <p class="page-subtitle"><?php esc_html_e('Estamos aquí para ayudarte', 'aluria'); ?></p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Formulario -->
            <div class="contact-form-wrapper">
                <h2 class="contact-title"><?php esc_html_e('Envíanos un mensaje', 'aluria'); ?></h2>
                <p class="contact-text"><?php esc_html_e('¿Tienes alguna pregunta? Rellena el formulario y te responderemos lo antes posible.', 'aluria'); ?></p>
                
                <?php 
                // If Contact Form 7 is active, use it
                if (shortcode_exists('contact-form-7')) :
                    echo do_shortcode('[contact-form-7]');
                else :
                ?>
                <form class="contact-form" id="contactForm" method="post" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre"><?php esc_html_e('Nombre', 'aluria'); ?></label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidos"><?php esc_html_e('Apellidos', 'aluria'); ?></label>
                            <input type="text" id="apellidos" name="apellidos" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email"><?php esc_html_e('Email', 'aluria'); ?></label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono"><?php esc_html_e('Teléfono (opcional)', 'aluria'); ?></label>
                        <input type="tel" id="telefono" name="telefono">
                    </div>
                    <div class="form-group">
                        <label for="asunto"><?php esc_html_e('Asunto', 'aluria'); ?></label>
                        <select id="asunto" name="asunto" required>
                            <option value=""><?php esc_html_e('Selecciona una opción', 'aluria'); ?></option>
                            <option value="pedido"><?php esc_html_e('Consulta sobre un pedido', 'aluria'); ?></option>
                            <option value="producto"><?php esc_html_e('Información de producto', 'aluria'); ?></option>
                            <option value="devolucion"><?php esc_html_e('Devoluciones y cambios', 'aluria'); ?></option>
                            <option value="otro"><?php esc_html_e('Otro', 'aluria'); ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mensaje"><?php esc_html_e('Mensaje', 'aluria'); ?></label>
                        <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                    </div>
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="privacidad" name="privacidad" required>
                        <label for="privacidad"><?php printf(__('He leído y acepto la <a href="%s">política de privacidad</a>', 'aluria'), esc_url(get_privacy_policy_url())); ?></label>
                    </div>
                    <?php wp_nonce_field('aluria_contact', 'contact_nonce'); ?>
                    <button type="submit" class="btn btn-primary"><?php esc_html_e('Enviar mensaje', 'aluria'); ?></button>
                </form>
                <?php endif; ?>
            </div>

            <!-- Info de contacto -->
            <div class="contact-info-wrapper">
                <div class="contact-info-card">
                    <h3><?php esc_html_e('Información de contacto', 'aluria'); ?></h3>
                    <ul class="contact-info-list">
                        <?php $email = get_theme_mod('contact_email', 'info@aluriamodas.es'); ?>
                        <?php if ($email) : ?>
                        <li>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <div>
                                <strong><?php esc_html_e('Email', 'aluria'); ?></strong>
                                <span><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span>
                            </div>
                        </li>
                        <?php endif; ?>
                        
                        <?php $phone = get_theme_mod('contact_phone', '620 932 637 / 654 497 580'); ?>
                        <?php if ($phone) : ?>
                        <li>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <div>
                                <strong><?php esc_html_e('Teléfono', 'aluria'); ?></strong>
                                <span><?php echo esc_html($phone); ?></span>
                            </div>
                        </li>
                        <?php endif; ?>
                        
                        <?php $address = get_theme_mod('contact_location', 'Sevilla, España'); ?>
                        <?php if ($address) : ?>
                        <li>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <div>
                                <strong><?php esc_html_e('Dirección', 'aluria'); ?></strong>
                                <span><?php echo esc_html($address); ?></span>
                            </div>
                        </li>
                        <?php endif; ?>
                        
                        <?php $schedule = get_theme_mod('contact_schedule', 'Lun - Vie: 9:00 - 18:00'); ?>
                        <?php if ($schedule) : ?>
                        <li>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <div>
                                <strong><?php esc_html_e('Horario', 'aluria'); ?></strong>
                                <span><?php echo esc_html($schedule); ?></span>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="contact-social-card">
                    <h3><?php esc_html_e('Síguenos', 'aluria'); ?></h3>
                    <div class="social-links-large">
                        <?php $instagram = get_theme_mod('social_instagram', 'https://www.instagram.com/aluriamodas/'); ?>
                        <?php if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                            <span>Instagram</span>
                        </a>
                        <?php endif; ?>
                        
                        <?php $tiktok = get_theme_mod('social_tiktok', 'https://www.tiktok.com/@aluria.modas'); ?>
                        <?php if ($tiktok) : ?>
                        <a href="<?php echo esc_url($tiktok); ?>" target="_blank" rel="noopener" aria-label="TikTok">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                            <span>TikTok</span>
                        </a>
                        <?php endif; ?>
                        
                        <?php $whatsapp = get_theme_mod('contact_whatsapp', '34620932637'); ?>
                        <?php if ($whatsapp) : ?>
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
