<?php

// GLOBAL FUNCTIONS
include_once 'functions/enqueue-style.php';		     // LOAD STYLES
include_once 'functions/enqueue-scripts.php';		 // LOAD SCRIPTS
//get_template_part('functions/walker-nav.php');	 // WALKER NAV

// THEME FUNCTIONS
include_once 'functions/helpers.php';                // HELPER FUNCTIONS
include_once 'functions/setup.php';				     // GENERAL THEME SETUP
include_once 'functions/acf.php';					 // ACF OPTIMIZATIONS
include_once 'functions/cpt.php';					 // CUSTOM POST TYPES
include_once 'functions/taxonomies.php';			 // CUSTOM TAXONOMIES
include_once 'functions/body-class.php';			 // BODY CLASSES
include_once 'functions/image.php';				     // IMAGE UPLOAD QUALITY ALWAYS 100%
include_once 'functions/dashboard.php';			     // DASHBOARD WIDGETS
include_once 'functions/excerpt.php';				 // CUSTOM EXCERPTS
include_once 'functions/archive-title.php';		     // ARCHIVE TITLE
include_once 'functions/admin.php';				     // ADMIN
include_once 'functions/login.php';				     // LOGIN
include_once 'functions/gutenberg.php';			     // GUTENBERG
include_once 'functions/acf.php';					 // ACF OPTIMIZATIONS
include_once 'functions/timber.php';				 // INITIALIZE TIMBER
