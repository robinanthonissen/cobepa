<?php
/**
 * Template Name: Page Header
 * Description: A page with header Template
 */

// Code to display Page goes here...
$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( 'pages/page-header.twig', $context );