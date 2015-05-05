<?php
/**
 * Bootstrap MediaWiki
 *
 * @bootstrap-mediawiki.php
 * @ingroup Skins
 * @author Matthew Batchelder (http://borkweb.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( ! defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

#Check $wgVersion for MW version
if( version_compare( $wgVersion, '1.23', '<=' ) ) {
	# Use old Bootstrap Version compatible with jQuery < 1.11
	define( 'BOOTSTRAP_DIR', '/bootstrap-3.1.1' );
	define( 'BOOTSWATCH_DIR', '/css/bootswatch-3.1.1' );
} else {
	define( 'BOOTSTRAP_DIR', '/bootstrap-3.3.4' );
	define( 'BOOTSWATCH_DIR', '/css/bootswatch-3.3.4' );
}

$wgExtensionCredits['skin'][] = array(
	'path'        => __FILE__,
	'name'        => 'Bootstrap3-Mediawiki',
	'description' => 'MediaWiki skin using Bootstrap 3',
  'url' 			  => 'http://www.github.com/jneug/bootstrap3-mediawiki',
	'author'      => array(
      '[http://jonas-neugebauer.de Jonas Neugebauer]',
      '[http://borkweb.com Matthew Batchelder]',
  ),
);

$wgValidSkinNames['bootstrap3mediawiki'] = 'Bootstrap3MediaWiki';
$wgAutoloadClasses['SkinBootstrap3MediaWiki'] = __DIR__ . '/Bootstrap3MediaWiki.skin.php';

$skinDirParts = explode( DIRECTORY_SEPARATOR, __DIR__ );
$skinDir = array_pop( $skinDirParts );

if( isset($wgBsTheme) ) {
  $bsTheme = BOOTSWATCH_DIR .'/'. $wgBsTheme . '.min.css';
} else {
  $bsTheme = BOOTSTRAP_DIR . '/css/bootstrap.min.css';
}

$wgResourceModules['skins.bootstrap3mediawiki'] = array(
	'styles' => array(
		$skinDir . $bsTheme                    => array( 'media' => 'all' ),
		$skinDir . '/css/style.css'            => array( 'media' => 'all' ),
	),
	'scripts' => array(
		$skinDir . BOOTSTRAP_DIR . '/js/bootstrap.min.js',
		$skinDir . '/js/behave.js',
		$skinDir . '/js/behavior.js',
	),
	'dependencies' => array(
		'jquery',
		'jquery.mwExtension',
		'jquery.client',
		'jquery.cookie',
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath'  => &$GLOBALS['wgStyleDirectory'],
);

if ( isset( $wgSiteJS ) ) {
	$wgResourceModules['skins.bootstrap3mediawiki']['scripts'][] = $skinDir . '/js/' . $wgSiteJS;
}//end if

if ( isset( $wgSiteCSS ) ) {
	$wgResourceModules['skins.bootstrap3mediawiki']['styles'][] = $skinDir . '/css/' . $wgSiteCSS;
}//end if
