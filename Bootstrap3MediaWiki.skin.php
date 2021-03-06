<?php
/**
 * Bootstrap - A basic MediaWiki skin based on Twitter's excellent Bootstrap CSS framework
 *
 * @Version 1.0.0
 * @Author Matthew Batchelder <borkweb@gmail.com>
 * @Copyright Matthew Batchelder 2012 - http://borkweb.com/
 * @License: GPLv2 (http://www.gnu.org/copyleft/gpl.html)
 */

if ( ! defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}//end if

require_once('includes/SkinTemplate.php');

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @package MediaWiki
 * @subpackage Skins
 */
class SkinBootstrap3MediaWiki extends SkinTemplate {
	/** Using Bootstrap */
	public $skinname = 'bootstrap3-mediawiki';
	public $stylename = 'bootstrap3-mediawiki';
	public $template = 'Bootstrap3MediaWikiTemplate';
	public $useHeadElement = true;

	/**
	 * initialize the page
	 */
	public function initPage( OutputPage $out ) {
		global $wgSiteJS;
		parent::initPage( $out );
		$out->addModuleScripts( 'skins.bootstrap3mediawiki' );

		$out->addMeta( 'X-UA-Compatible', 'IE=edge' );
    	$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1' );

    	$out->addScript( '
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->' );
	}//end initPage

	/**
	 * prepares the skin's CSS
	 */
	public function setupSkinUserCss( OutputPage $out ) {
		global $wgSiteCSS, $wgStylePath, $wgServer;

		parent::setupSkinUserCss( $out );

		$out->addModuleStyles( 'skins.bootstrap3mediawiki' );

		$fontPath = /*$wgServer .*/ $wgStylePath . '/' . $this->skinname . BOOTSTRAP_DIR;
		$out->addInlineStyle( str_replace("{{1}}", $fontPath, "@font-face{font-family:'Glyphicons Halflings';src:url({{1}}/fonts/glyphicons-halflings-regular.eot);src:url({{1}}/fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'),url({{1}}/fonts/glyphicons-halflings-regular.woff) format('woff'),url({{1}}/fonts/glyphicons-halflings-regular.ttf) format('truetype'),url({{1}}/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg')}") );
	}//end setupSkinUserCss
}

/**
 * @package MediaWiki
 * @subpackage Skins
 */
class Bootstrap3MediaWikiTemplate extends QuickTemplate {
	/**
	 * @var Cached skin object
	 */
	public $skin;

	/**
	 * Template filter callback for Bootstrap skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	public function execute() {
		global $wgRequest, $wgUser, $wgSitename, $wgSitenameshort, $wgCopyrightLink, $wgCopyright, $wgBootstrap, $wgArticlePath, $wgGoogleAnalyticsID, $wgSiteCSS;
		global $wgEnableUploads;
		global $wgLogo, $wgFooterIcons;
		global $wgTOCLocation;

		$this->skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );
		$url_prefix = str_replace( '$1', '', $wgArticlePath );

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->html('headelement');
		?>
    <!-- link to content for accessibility -->
    <a href="#wiki-body" class="sr-only">Skip to main content</a>
		<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
  			<header class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>" title="<?php echo $wgSitename ?>"><?php echo isset( $wgLogo ) && $wgLogo ? "<img src='{$wgLogo}' alt='Logo'/> " : ''; echo $wgSitenameshort ?: $wgSitename; ?></a>
        </header>

        <div class="navbar-collapse collapse">
          <div class="navbar-header navbar-right">
    				<?php
    				if ( $wgUser->isLoggedIn() ) {
    					if ( count( $this->data['personal_urls'] ) > 0 ) {
    						$user_icon = '<span class="glyphicon glyphicon-user"></span>';
    						$name = strtolower( $wgUser->getName() );
    						$user_nav = $this->get_array_links( $this->data['personal_urls'], $user_icon .' '. $name, 'user' );
    						?>
    						<ul<?php $this->html('userlangattributes') ?> class="nav navbar-nav">
    							<?php echo $user_nav; ?>
    						</ul>
    						<?php
    					}//end if

    					if ( count( $this->data['content_actions']) > 0 ) {
    						$content_nav = $this->get_array_links( $this->data['content_actions'], 'Page', 'page' );
    						?>
    						<ul class="nav navbar-nav content-actions"><?php echo $content_nav; ?></ul>
    						<?php
    					}//end if
    				} else {  // else if is logged in
    					?>
    					<ul class="nav navbar-nav">
    						<li>
    						<?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Userlogin' ), wfMsg( 'login' ) ); ?>
    						</li>
    					</ul>
    					<?php
    				}
    				?>

            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $url_prefix; ?>Special:RecentChanges" class="recent-changes"><span class="glyphicon glyphicon-edit"></span> Recent Changes</a></li>
                  <li><a href="<?php echo $url_prefix; ?>Special:SpecialPages" class="special-pages"><span class="glyphicon glyphicon-star-empty"></span> Special Pages</a></li>
                  <?php if ( $wgEnableUploads ) { ?>
                  <li><a href="<?php echo $url_prefix; ?>Special:Upload" class="upload-a-file"><span class="glyphicon glyphicon-upload"></span> Upload a File</a></li>
                  <?php } ?>
                </ul>
              </li>
            </ul>
          </div>

          <form class="navbar-form navbar-right" action="<?php $this->text( 'wgScript' ) ?>" id="searchform" role="search">
            <div class="form-group">
              <input class="form-control" type="search" name="search" placeholder="Search" title="Search <?php echo $wgSitename; ?> [ctrl-option-f]" accesskey="f" id="searchInput" autocomplete="off">
            </div>
            <input class="btn" type="hidden" name="title" value="Special:Search">
          </form>

          <ul class="nav navbar-nav">
            <?php echo $this->nav( $this->get_page_links( 'MediaWiki:Bootstrap/TitleBar' ) ); ?>
          </ul>
        </div>
      </div><!-- /.container -->
		</nav>

		<main id="wiki-outer-body">
			<div id="wiki-body" class="container">
				<?php
					if ( 'sidebar' == $wgTOCLocation ) {
						?>
						<div class="row">
							<aside class="col-md-3 hidden-print toc-sidebar"></aside>
							<section class="col-md-9 wiki-body-section">
						<?php
					}//end if
				?>
  				<?php if( $this->data['sitenotice'] ): ?>
  				<div id="siteNotice" class="alert alert-warning"><?php $this->html('sitenotice') ?></div>
  				<?php endif; ?>
  				<?php if ( $this->data['undelete'] ): ?>
  				<!-- undelete -->
  				<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
  				<!-- /undelete -->
  				<?php endif; ?>
  				<?php if($this->data['newtalk'] ): ?>
  				<!-- newtalk -->
  				<div class="usermessage"><?php $this->html( 'newtalk' )  ?></div>
  				<!-- /newtalk -->
  				<?php endif; ?>

  				<div class="pagetitle page-header">
  					<h1><?php $this->html( 'title' ) ?> <small><?php $this->html('subtitle') ?></small></h1>
  				</div>

  				<article class="body">
  				<?php $this->html( 'bodytext' ) ?>
          </article>

  				<?php if ( $this->data['catlinks'] ): ?>
  				<div class="category-links">
  				<!-- catlinks -->
  				<?php $this->html( 'catlinks' ); ?>
  				<!-- /catlinks -->
  				</div>
  				<?php endif; ?>
  				<?php if ( $this->data['dataAfterContent'] ): ?>
  				<div class="data-after-content">
  				<!-- dataAfterContent -->
  				<?php $this->html( 'dataAfterContent' ); ?>
  				<!-- /dataAfterContent -->
  				</div>
  				<?php endif; ?>
  				<?php if ( 'sidebar' == $wgTOCLocation ): ?>
        </section> <!-- /.wiki-body-section -->
				<?php endif; ?>
			</div><!-- container -->
		</main>
		<footer class="footer navbar-default">
			<div class="container">
				<?php $this->includePage('MediaWiki:Bootstrap/Footer'); ?>

        <?php if( count($wgFooterIcons) > 0 ) : ?>
        <div class="pull-right">
          <?php
          foreach( $wgFooterIcons as $footerIconCategory ) {
            foreach( $footerIconCategory as $footerIcon ) {

            echo
              (isset($footerIcon[url]) ? '<a href="'.$footerIcon[url].'">' : '') .
              '<img src="' . $footerIcon[src] . '" ' .
              (isset($footerIcon[alt]) ? 'alt="'.$footerIcon[alt].'" ' : '') .
              (isset($footerIcon[height]) ? 'height="'.$footerIcon[height].'" ' : '') .
              (isset($footerIcon[width]) ? 'height="'.$footerIcon[width].'" ' : '') . '/>' .
              (isset($footerIcon[url]) ? '</a>' : '');
            }
          }
          ?>
        </div>
        <?php endif; ?>

        <?php if( isset($wgCopyright) ) : ?>
				<div class="copyright">
					<p>&copy; <?php echo date('Y'); ?> by
            <?php if(isset($wgCopyrightLink)) : ?>
            <a href="<?php echo $wgCopyrightLink; ?>"><?php echo $wgCopyright; ?></a>
          <? else : ?>
            <?php echo $wgCopyright; ?>
            <?php endif; ?>
						<!-- &bull; Powered by <a href="http://mediawiki.org">MediaWiki</a>-->
          </p>
				</div>
        <?php endif; ?>
			</div><!-- container -->
		</footer><!-- footer -->

		<?php
		$this->html('bottomscripts'); /* JS call to runBodyOnloadHook */
		$this->html('reporttime');

		if ( $this->data['debug'] ) {
			?>
			<!-- Debug output:
			<?php $this->text( 'debug' ); ?>
			-->
			<?php
		}//end if
		?>
		</body>
		</html>
		<?php
	}//end execute

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function nav( $nav ) {
		$output = '';
		foreach ( $nav as $topItem ) {
			$pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );

      $icon = '';
      if( $topItem['icon'] != null && $topItem['icon'] != '' ) {
        $icon = '<span class="glyphicon glyphicon-'.$topItem['icon'].'"></span> ';
      }

			if ( array_key_exists( 'sublinks', $topItem ) ) {
				$output .= '<li class="dropdown">';
				$output .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $icon . $topItem['title'] . ' <b class="caret"></b></a>';
				$output .= '<ul class="dropdown-menu">';

				foreach ( $topItem['sublinks'] as $subLink ) {
          $icon = '';
          if( $subLink['icon'] != null && $subLink['icon'] != '' ) {
            $icon = '<span class="glyphicon glyphicon-'.$subLink['icon'].'"></span> ';
          }


					if ( 'divider' == $subLink ) {
						$output .= "<li class='divider'></li>\n";
					} elseif ( $subLink['textonly'] ) {
						$output .= "<li class=\"dropdown-header\">" . $icon . "{$subLink['title']}</li>\n";
					} else {
						if( $subLink['local'] && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
							$href = $pageTitle->getLocalURL();
						} else {
							$href = $subLink['link'];
						}//end else

						$slug = strtolower( str_replace(' ', '-', preg_replace( '/[^a-zA-Z0-9 ]/', '', trim( strip_tags( $subLink['title'] ) ) ) ) );
						$output .= "<li {$subLink['attributes']}><a href='{$href}' class='{$subLink['class']} {$slug}'>" . $icon . "{$subLink['title']}</a>";
					}//end else
				}
				$output .= '</ul>';
				$output .= '</li>';
			} else {
				if( $pageTitle ) {
					$output .= '<li' . ($this->data['title'] == $topItem['title'] ? ' class="active"' : '') . '><a href="' . ( $topItem['external'] ? $topItem['link'] : $pageTitle->getLocalURL() ) . '">' . $icon . $topItem['title'] . '</a></li>';
				}//end if
			}//end else
		}//end foreach
		return $output;
	}//end nav

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 */
	private function nav_select( $nav ) {
		$output = '';
		foreach ( $nav as $topItem ) {
			$pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );
			$output .= '<optgroup label="'.strip_tags( $topItem['title'] ).'">';
			if ( array_key_exists( 'sublinks', $topItem ) ) {
				foreach ( $topItem['sublinks'] as $subLink ) {
					if ( 'divider' == $subLink ) {
						$output .= "<option value='' disabled='disabled' class='unclickable'>----</option>\n";
					} elseif ( $subLink['textonly'] ) {
						$output .= "<option value='' disabled='disabled' class='unclickable'>{$subLink['title']}</option>\n";
					} else {
						if( $subLink['local'] && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
							$href = $pageTitle->getLocalURL();
						} else {
							$href = $subLink['link'];
						}//end else

						$output .= "<option value='{$href}'>{$subLink['title']}</option>";
					}//end else
				}//end foreach
			} elseif ( $pageTitle ) {
				$output .= '<option value="' . $pageTitle->getLocalURL() . '">' . $topItem['title'] . '</option>';
			}//end else
			$output .= '</optgroup>';
		}//end foreach

		return $output;
	}//end nav_select

	private function get_page_links( $source ) {
		$titleBar = $this->getPageRawText( $source );
		$nav = array();
		foreach(explode("\n", $titleBar) as $line) {
			if(trim($line) == '') continue;
			if( preg_match('/^\*\*\s*----/', $line ) ) {
				$nav[ count( $nav ) - 1]['sublinks'][] = 'divider';
				continue;
			}//end if

      $icon = '';
      if(preg_match('/^(.*)\s*\(icon:(\S+)\)\s*$/', $line, $iconMatch)) {
        $icon = $iconMatch[2];
        $line = $iconMatch[1];
      }

			$sub = false;
			$link = false;
			$external = false;

      if(preg_match('/^\*\s*([^\*]*)\[\[:?(.+)\]\]/', $line, $match)) {
				$sub = false;
				$link = true;
			}elseif(preg_match('/^\*\s*([^\*\[]*)\[([^\[ ]+) (.+)\]/', $line, $match)) {
				$sub = false;
				$link = true;
				$external = true;
			}elseif(preg_match('/^\*\*\s*([^\*\[]*)\[([^\[ ]+) (.+)\]/', $line, $match)) {
				$sub = true;
				$link = true;
				$external = true;
			}elseif(preg_match('/\*\*\s*([^\*]*)\[\[:?(.+)\]\]/', $line, $match)) {
				$sub = true;
				$link = true;
			}elseif(preg_match('/\*\*\s*([^\* ]*)(.+)/', $line, $match)) {
				$sub = true;
				$link = false;
			}elseif(preg_match('/^\*\s*(.+)/', $line, $match)) {
				$sub = false;
				$link = false;
			}

			if( strpos( $match[2], '|' ) !== false ) {
				$item = explode( '|', $match[2] );
				$item = array(
					'title' => $match[1] . $item[1],
					'link' => $item[0],
					'local' => true,
				);
			} else {
				if( $external ) {
					$item = $match[2];
					$title = $match[1] . $match[3];
				} else {
					$item = $match[1] . $match[2];
					$title = $item;
				}//end else

				if( $link ) {
					$item = array('title'=> $title, 'link' => $item, 'local' => ! $external , 'external' => $external );
				} else {
					$item = array('title'=> $title, 'link' => $item, 'textonly' => true, 'external' => $external );
				}//end else
			}//end else

      $item['icon'] = $icon;

			if( $sub ) {
				$nav[count( $nav ) - 1]['sublinks'][] = $item;
			} else {
				$nav[] = $item;
			}//end else
		}

		return $nav;
	}//end get_page_links

	private function get_array_links( $array, $title, $which ) {
		$nav = array();
		$nav[] = array('title' => $title );
		foreach( $array as $key => $item ) {
			$link = array(
				'id' => Sanitizer::escapeId( $key ),
				'attributes' => $item['attributes'],
				'link' => htmlspecialchars( $item['href'] ),
				'key' => $item['key'],
				'class' => htmlspecialchars( $item['class'] ),
				'title' => htmlspecialchars( $item['text'] ),
			);

			if( 'page' == $which ) {
				switch( $link['title'] ) {
				case 'Page':
        case 'Seite': $icon = 'file'; break;
				case 'Discussion':
        case 'Diskussion': $icon = 'comment'; break;
				case 'Edit':
        case 'Bearbeiten': $icon = 'pencil'; break;
				case 'History':
        case 'Versionsgeschichte': $icon = 'time'; break;
				case 'Delete':
        case 'Löschen': $icon = 'remove'; break;
				case 'Move':
        case 'Verschieben': $icon = 'move'; break;
				case 'Protect':
        case 'Schützen': $icon = 'lock'; break;
				case 'Watch':
        case 'Beobachten': $icon = 'eye-open'; break;
        case 'Neu laden': $icon = 'refresh'; break;
        default: $icon = 'file'; break;
				}//end switch

				$link['title'] = '<span class="glyphicon glyphicon-' . $icon . '"></span> ' . $link['title'];
			} elseif( 'user' == $which ) {
				switch( $link['title'] ) {
				case 'My talk':
        case 'Diskussion': $icon = 'comment'; break;
				case 'My preferences':
        case 'Einstellungen': $icon = 'cog'; break;
				case 'My watchlist':
        case 'Beobachtungsliste': $icon = 'eye-open'; break;
				case 'My contributions':
        case 'Beiträge': $icon = 'list-alt'; break;
				case 'Log out':
        case 'Abmelden': $icon = 'off'; break;
				default: $icon = 'user'; break;
				}//end switch

				$link['title'] = '<span class="glyphicon glyphicon-' . $icon . '"></span> ' . $link['title'];
			}//end elseif

			$nav[0]['sublinks'][] = $link;
		}//end foreach

		return $this->nav( $nav );
	}//end get_array_links

	function getPageRawText($title) {
		$pageTitle = Title::newFromText($title);
		if(!$pageTitle->exists()) {
			return 'Create the page [[MediaWiki:Bootstrap/TitleBar]]';
		} else {
			$article = new Article($pageTitle);
			return $article->getRawText();
		}
	}

	function includePage($title) {
		global $wgParser, $wgUser;
		$pageTitle = Title::newFromText($title);
		if(!$pageTitle->exists()) {
			echo 'The page [[' . $title . ']] was not found.';
		} else {
			$article = new Article($pageTitle);
			$wgParserOptions = new ParserOptions($wgUser);
			$parserOutput = $wgParser->parse($article->getRawText(), $pageTitle, $wgParserOptions);
			echo $parserOutput->getText();
		}
	}

	public static function link() { }
}
