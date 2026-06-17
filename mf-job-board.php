<?php
/**
 * Plugin Name:       MF Job Board
 * Plugin URI:        https://mfdsgn.com/
 * Description:       Self-contained job board for WordPress + Elementor. No external plugins. Show the list with [mk_vacatures] (alias [mf_jobs]) on a page; the detail page runs through the theme (header, page-banner, footer) with clean content — no post meta or author box. Available in English, Dutch and Turkish.
 * Version:           1.6.1
 * Author:            MF
 * Text Domain:       mf-job-board
 * Domain Path:       /languages
 *
 * ---------------------------------------------------------------------------
 *  NOT (TR):
 *   - LİSTE: normal tema sayfasına [mk_vacatures] (veya [mf_jobs]).
 *   - DETAY: temanın single.php yapısını taklit eden kendi şablonu (header +
 *     page-banner + footer korunur, yazar/tarih meta'sı basılmaz).
 *   - Diller: kaynak metinler İngilizce; /languages içinde Hollandaca (nl_NL)
 *     ve Türkçe (tr_TR) çevirileri var. Site dili neyse o görünür.
 *   - İçerik metinleri (örnek ilanlar / landing) çeviri sistemine DAHİL DEĞİL;
 *     onlar veridir, olduğu gibi kalır.
 * ---------------------------------------------------------------------------
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MKV_VERSION', '1.6.1' );
define( 'MKV_PATH', plugin_dir_path( __FILE__ ) );
define( 'MKV_URL', plugin_dir_url( __FILE__ ) );

/** Standaard sollicitatie-mailadres. Te overschrijven in Instellingen of via de filter. */
if ( ! defined( 'MKV_APPLY_EMAIL' ) ) {
	define( 'MKV_APPLY_EMAIL', 'vacatures@mijnkompaan.nl' );
}

/** Vertalingen laden (nl_NL, tr_TR, … uit /languages). */
function mkv_load_textdomain() {
	load_plugin_textdomain( 'mf-job-board', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'mkv_load_textdomain' );

require_once MKV_PATH . 'includes/cpt.php';
require_once MKV_PATH . 'includes/meta.php';
require_once MKV_PATH . 'includes/shortcode.php';
require_once MKV_PATH . 'includes/settings.php';

/** CSS registreren. */
function mkv_register_style() {
	if ( ! wp_style_is( 'mkv-style', 'registered' ) ) {
		wp_register_style( 'mkv-style', MKV_URL . 'assets/vacatures.css', array(), MKV_VERSION );
	}
}

/**
 * CSS in de <head> laden op een vacature-detailpagina of op elke pagina/bericht
 * waar de shortcode [mk_vacatures] staat — ook als die via Elementor is geplaatst
 * (de shortcode zit dan in _elementor_data, niet in post_content).
 */
function mkv_enqueue_assets() {
	$load = is_singular( 'vacature' );

	if ( ! $load && is_singular() ) {
		$post = get_post();
		if ( $post ) {
			if ( has_shortcode( (string) $post->post_content, 'mk_vacatures' ) ) {
				$load = true;
			} else {
				$elementor = get_post_meta( $post->ID, '_elementor_data', true );
				if ( is_string( $elementor ) && false !== strpos( $elementor, 'mk_vacatures' ) ) {
					$load = true;
				}
			}
		}
	}

	if ( $load ) {
		mkv_register_style();
		wp_enqueue_style( 'mkv-style' );
	}
}
add_action( 'wp_enqueue_scripts', 'mkv_enqueue_assets' );

/**
 * Detailpagina via onze schone template renderen (tenzij het thema zelf een
 * single-vacature.php levert — dan wint die).
 */
function mkv_template_include( $template ) {
	if ( is_singular( 'vacature' ) ) {
		$theme = locate_template( array( 'single-vacature.php' ) );
		if ( ! $theme ) {
			return MKV_PATH . 'templates/single-vacature.php';
		}
	}
	return $template;
}
add_action( 'template_include', 'mkv_template_include' );

/**
 * Rewrite-regels automatisch verversen na een update (versiewissel).
 * Lost het symptoom op waarbij /vacature/... als blog/archief (met auteur,
 * datum, sidebar) rendert in plaats van als losse detailpagina, doordat de
 * permalinkstructuur na een update niet was ververst.
 */
function mkv_maybe_flush_rewrites() {
	if ( get_option( 'mkv_rewrite_version' ) !== MKV_VERSION ) {
		flush_rewrite_rules( false );
		update_option( 'mkv_rewrite_version', MKV_VERSION );
	}
}
add_action( 'init', 'mkv_maybe_flush_rewrites', 11 ); // na CPT-registratie (init @10)

/**
 * Eventuele archief-/categorie-URL's omleiden naar de echte overzichtspagina,
 * zodat de standaard thema-bloglijst (met auteur/datum/sidebar) nooit verschijnt.
 * Alleen omleiden naar een pagina — nooit naar het archief zelf (geen lus).
 */
function mkv_redirect_archive() {
	if ( ! is_post_type_archive( 'vacature' ) && ! is_tax( 'vacature_categorie' ) ) {
		return;
	}
	$target = mkv_listing_url();
	if ( $target && $target !== home_url( '/' ) ) {
		wp_safe_redirect( $target, 302 );
		exit;
	}
}
add_action( 'template_redirect', 'mkv_redirect_archive' );

/** Activatie: geen voorbeeldcontent — alleen CPT registreren + rewrites verversen. */
function mkv_activate() {
	mkv_register_cpt();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mkv_activate' );

function mkv_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'mkv_deactivate' );
