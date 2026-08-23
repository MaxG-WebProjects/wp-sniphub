<?php
/**
 * WooCommerce customizations
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Define a custom breadcrumb delimiter in WooCommerce
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#10_Definir_un_delimiteur_de_fil_dAriane_personnalise_dans_WooCommerce
*/
/**
 * Sets a custom WooCommerce breadcrumb delimiter.
 *
 * @param array $defaults Default breadcrumb arguments.
 * @return array
 */
function wpsh_wc_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = ' > ';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'wpsh_wc_breadcrumb_delimiter' );

/* ==========================================================
   Add a custom breadcrumb trail to the home URL in WooCommerce
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#11_Ajouter_un_fil_dAriane_personnalise_a_lURL_daccueil_dans_WooCommerce
*/
/**
 * Sets a custom home URL for the WooCommerce breadcrumb trail.
 *
 * @return string
 */
function wpsh_wc_breadcrumb_home_url() {
	return get_permalink( 6 );
}
add_filter( 'woocommerce_breadcrumb_home_url', 'wpsh_wc_breadcrumb_home_url' );

/* ==========================================================
   Remove the WooCommerce breadcrumb trail on the shop page
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#13_Supprimer_le_fil_dAriane_WooCommerce_dans_WordPress
*/
/**
 * Removes the WooCommerce breadcrumb trail on the shop page.
 *
 * @return void
 */
function wpsh_wc_remove_shop_breadcrumbs() {
	// This module's own toggle doesn't guarantee WooCommerce is installed; template_redirect
	// fires on every front-end request, so is_shop() must not be called unless WooCommerce
	// actually defined it — otherwise every page load fatals with WooCommerce inactive.
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	}
}
add_action( 'template_redirect', 'wpsh_wc_remove_shop_breadcrumbs' );

/* ==========================================================
   Remove product reviews from a WooCommerce store
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#12_Supprimer_les_avis_sur_les_produits_dune_boutique_WooCommerce
*/
remove_action( 'woocommerce_product_tabs', 'woocommerce_product_reviews_tab', 30 );
remove_action( 'woocommerce_product_tab_panels', 'woocommerce_product_reviews_panel', 30 );

/* ==========================================================
   Remove WooCommerce tabs in WordPress
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#14_Supprimer_les_onglets_WooCommerce_dans_WordPress
*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

/* ==========================================================
   Make filling in the "phone number" field optional in WooCommerce
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#15_Rendre_le_remplissage_du_champ_numero_de_telephone_facultatif_dans_WooCommerce
*/
/**
 * Makes the WooCommerce billing phone number field optional.
 *
 * @param array $address_fields Billing address fields.
 * @return array
 */
function wpsh_wc_remove_required_phone( $address_fields ) {
	$address_fields['billing_phone']['required'] = false;
	return $address_fields;
}
add_filter( 'woocommerce_billing_fields', 'wpsh_wc_remove_required_phone' );

/* ==========================================================
   Redirect the customer to the "Shopping Cart" page and skip the "Checkout" page
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#16_Rediriger_le_client_vers_la_page_Panier_et_sauter_la_page_Commande
*/
/**
 * Redirects the customer to the checkout page after adding a product to the cart.
 *
 * @return string
 */
function wpsh_wc_redirect_to_checkout() {
	return wc_get_checkout_url();
}
add_filter( 'add_to_cart_redirect', 'wpsh_wc_redirect_to_checkout' );
