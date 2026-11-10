<?php
/**
 * Contact Form 7
 *
 * Gebruik de formuliertemplate uit docs/contact-form-7.txt met de
 * klassen c-form__…; CF7 mag dan geen eigen <p>/<br> rond de velden zetten.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );
