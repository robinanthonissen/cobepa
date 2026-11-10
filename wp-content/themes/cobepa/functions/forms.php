<?php
/**
 * Formulieren
 *
 * Het contact-block heeft een WYSIWYG-veld waarin de shortcode van eender welke
 * formulierplugin geplakt kan worden. Algemene veldstyling: src/css/base/form.scss.
 *
 * Contact Form 7 (optioneel): gebruik docs/contact-form-7.txt als formuliertemplate.
 * CF7 mag dan geen eigen <p>/<br> rond de velden zetten.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );
