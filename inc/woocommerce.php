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
   Breadcrumb customizations
   ========================================================== */
/* Define a custom breadcrumb delimiter in WooCommerce
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#10_Definir_un_delimiteur_de_fil_dAriane_personnalise_dans_WooCommerce
*/
add_filter( 'woocommerce_breadcrumb_defaults', 'wpsh_wc_breadcrumb_delimiter' );
function wpsh_wc_breadcrumb_delimiter( $defaults ) {
  $defaults['delimiter'] = ' > ';
  return $defaults;
}

/* Add a custom breadcrumb trail to the home URL in WooCommerce
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#11_Ajouter_un_fil_dAriane_personnalise_a_lURL_daccueil_dans_WooCommerce
*/
add_filter( 'woocommerce_breadcrumb_home_url', 'wpsh_wc_breadcrumb_home_url' );
function wpsh_wc_breadcrumb_home_url() {
  return get_permalink( 6 );
}

/* Remove the WooCommerce breadcrumb trail in WordPress
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#13_Supprimer_le_fil_dAriane_WooCommerce_dans_WordPress
*/
add_action( 'template_redirect', 'wpsh_wc_remove_shop_breadcrumbs' );
function wpsh_wc_remove_shop_breadcrumbs() {
  if ( is_shop() ) {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
  }
}

/* ==========================================================
   Product display cleanup
   ========================================================== */
/* Remove product reviews from a WooCommerce store
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#12_Supprimer_les_avis_sur_les_produits_dune_boutique_WooCommerce
*/
remove_action( 'woocommerce_product_tabs', 'woocommerce_product_reviews_tab', 30 );
remove_action( 'woocommerce_product_tab_panels', 'woocommerce_product_reviews_panel', 30 );

/* Remove WooCommerce tabs in WordPress
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#14_Supprimer_les_onglets_WooCommerce_dans_WordPress
*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

/* ==========================================================
   Checkout customizations
   ========================================================== */
/* Make filling in the "phone number" field optional in WooCommerce
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#15_Rendre_le_remplissage_du_champ_numero_de_telephone_facultatif_dans_WooCommerce
*/
add_filter( 'woocommerce_billing_fields', 'wpsh_wc_remove_required_phone' );
function wpsh_wc_remove_required_phone( $address_fields ) {
  $address_fields['billing_phone']['required'] = false;
  return $address_fields;
}

/* Redirect the customer to the "Shopping Cart" page and skip the "Checkout" page
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#16_Rediriger_le_client_vers_la_page_Panier_et_sauter_la_page_Commande
*/
add_filter( 'add_to_cart_redirect', 'wpsh_wc_redirect_to_checkout' );
function wpsh_wc_redirect_to_checkout() {
  return wc_get_checkout_url();
}