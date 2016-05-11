<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_workunit_ctr_01 extends post_ctr_01 {

	public $element_prefix = 'UT';

	protected $model_name   = 'wpdigi_workunit_mdl_01';
	protected $post_type    = WPDIGI_STES_POSTTYPE_SUB;
	protected $meta_key    	= '_wp_workunit';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to society from WP Rest API	*/
	protected $base = 'digirisk/workunit';
	protected $version = '0.1';

	private $current_workunit;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	function __construct() {
		parent::__construct();

		/**	Inclusion du modèle pour les groupements / Include groups' model	*/
		include_once( WPDIGI_STES_PATH . '/model/workunit.model.01.php' );

		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for societies management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );

		/**	Create shortcodes for elements displaying	*/
		/**	Shortcode for displaying a dropdown with all groups	*/
		add_shortcode( 'wpdigi-workunit-list', array( &$this, 'shortcode_workunit_list' ) );
	}

	/**
	 * SETTER - Création des types d'éléments pour la gestion de l'entreprise / Create the different element for society management
	 */
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create society : main element 	*/
		$labels = array(
				'name'                => __( 'Work units', 'wpdigi-i18n' ),
				'singular_name'       => __( 'Work unit', 'wpdigi-i18n' ),
				'menu_name'           => __( 'Work units', 'wpdigi-i18n' ),
				'name_admin_bar'      => __( 'Work units', 'wpdigi-i18n' ),
				'parent_item_colon'   => __( 'Parent Item:', 'wpdigi-i18n' ),
				'all_items'           => __( 'Work units', 'wpdigi-i18n' ),
				'add_new_item'        => __( 'Add a work unit', 'wpdigi-i18n' ),
				'add_new'             => __( 'Add a work unit', 'wpdigi-i18n' ),
				'new_item'            => __( 'New a work unit', 'wpdigi-i18n' ),
				'edit_item'           => __( 'Edit a work unit', 'wpdigi-i18n' ),
				'update_item'         => __( 'Update a work unit', 'wpdigi-i18n' ),
				'view_item'           => __( 'View a work unit', 'wpdigi-i18n' ),
				'search_items'        => __( 'Search a work unit', 'wpdigi-i18n' ),
				'not_found'           => __( 'Not found', 'wpdigi-i18n' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'wpdigi-i18n' ),
		);
		$rewrite = array(
				'slug'                => '/',
				'with_front'          => true,
				'pages'               => true,
				'feeds'               => true,
		);
		$args = array(
				'label'               => __( 'Digirisk work unit', 'wpdigi-i18n' ),
				'description'         => __( 'Manage societies into digirisk', 'wpdigi-i18n' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', ),
				'hierarchical'        => true,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => $rewrite,
				'capability_type'     => 'page',
		);
		register_post_type( $this->post_type, $args );
	}

	/**
	 * ROUTES - Ajoute les routes spécifiques pour les unités de travail / Add workunit specific routes
	 *
	 * @param array $array_route Les routes existantes dans l'API REST de wordpress / Existing routes into Wordpress REST API
	 *
	 * @return array La liste des routes personnalisées ajoutées aux routes existantes / The personnalized routes added to existing
	 */
	public function callback_register_route( $array_route ) {
		$array_route = parent::callback_register_route( $array_route );

		$array_route['/' . $this->version . '/get/' . $this->base . '/(?P<id>\d+)/identity' ] = array(
				array( array( $this, 'get_workunit_identity' ), WP_JSON_Server::READABLE | WP_JSON_Server::ACCEPT_JSON )
		);

		return $array_route;
	}

	/**
	 * ROUTES - Récupération des informations principale d'une unité de travail / Get the main information about a workunit
	 *
	 * @param integer $id L'identifiant de l'unité de travail dont on veux récupèrer uniquement l'identité principale / Workunit identifier we want to get main identity for
	 */
	function get_workunit_identity( $id ) {
		global $wpdb;

		$query  = $wpdb->prepare(
				"SELECT P.post_title, P.post_modified, PM.meta_value AS _wpdigi_unique_identifier
				FROM {$wpdb->posts} AS P
				INNER JOIN {$wpdb->postmeta} AS PM ON ( PM.post_id = P.ID )
				WHERE P.ID = %d
				AND PM.meta_key = %s", $id, '_wpdigi_unique_identifier'
		);
		$work_unit = $wpdb->get_row( $query );

		return $work_unit;
	}

	/**
	 * Affiche la liste des groupements existant sous forme de liste déroulante si il en existe plusieurs / Display a dropdown with all groups if there are several existing
	 *
	 * @param array $args Les paramètres passés au travers du shortcode / Parameters list passed thrgough shortcode
	 *
	 * @return string Le code html permettant d'afficher la liste déroulante contenant les groupements existant / The HTML code allowing to display existing groups
	 */
	public function shortcode_workunit_list( $args ) {
		$output = '';

		/**	Get existing groups for display	*/
		$list = $this->index( array( 'posts_per_page' => -1, 'parent_id' => 0, 'post_status' => array( 'publish', ), 'post_parent' => $args[ 'group_id' ] ), false );

		/**	Define a nonce for display sheet using ajax	*/
		$workunit_display_nonce = wp_create_nonce( 'wpdigi_workunit_sheet_display' );

		/**	Affichage de la liste des unités de travail pour le groupement actuellement sélectionné / Display the work unit list for current selected group	*/
		ob_start();
		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'list' ) );
		$output = ob_get_contents();
		ob_end_clean();

		return  $output;
	}

	/**
	 * Affiche une fiche d'unité de travail à partir d'un identifiant donné / Display a work unit from given identifier
	 *
	 * @param integer $id L'indentifiant de l'unité de travail à afficher / The workunit identifier to display
	 * @param string $dislay_mode Optionnal Le mode d'affichage de la fiche (simple, complète, publique, ...) / The display mode (simple, complete, public, ... )
	 */
	public function display( $id, $dislay_mode = 'simple' ) {
		/**	Get the work unit to display	*/
		$this->current_workunit = $this->show( $id );
		$element_post_type = $this->get_post_type();

		/**	Set default tab in work unit - Allow modification throught filter	*/
		$workunit_default_tab = apply_filters( 'wpdigi_workunit_default_tab', '' );

		/**	Display the template	*/
		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'sheet', $dislay_mode ) );
	}

	/**
	 * Construit l'affichage des onglets existant dans une unité de travail / Build the existing tab for workunit
	 *
	 * @param Object $workunit L'unité de travail actuellement en cours d'édition / The current work unit
	 * @param string $default_tab L'onglet a sélectionner automatiquement : The default tab to select
	 */
	function display_workunit_tab( $workunit, $default_tab ) {
		/**	Définition de la liste des onglets pour les unités de travail - modifiable avec un filtre / Define a tab list for work unit - editable list through filter	*/
		$tab_list = apply_filters( 'wpdigi_workunit_sheet_tab', array(), $workunit );

		/**	Affichage des onglets définis pour les unités de travail / Display defined tabs for work unit	*/
		require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit/tab', 'list' ) );
	}

	/**
	 * Gestion de l'affichage du contenu des onglets pour une unité de travail / Manage content display into workunit
	 *
	 * @param Object $workunit La définition complète de l'unité de travail sur laquelle on se trouve / The complete definition for the current workunit we are on
	 * @param string $tab_to_display Permet de sélectionner les données a afficher ( par défaut affiche un shortcode basé sur cet valeur ) / Allows to display tab content to display ( Display a shortcode composed with this value by default )
	 */
	function display_workunit_tab_content( $workunit, $tab_to_display ) {
		/**	Application d'un filtre d'affichage selon la partie a afficher demandée par l'utilisateur / Apply filter for display user's requested part	*/
		$output = apply_filters( 'wpdigi_workunit_sheet_content', '', $workunit, $tab_to_display );
		/**	Par défaut on va afficher un shortcode ayant pour clé la valeur de $tab_to_display / By default display a shortcode composed with $tab_to_display	*/
		if ( empty( $output ) ) {
			require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit/tab', 'default' ) );
		}
		else {
			echo $output;
		}
	}

}

global $wpdigi_workunit_ctr;
$wpdigi_workunit_ctr = new wpdigi_workunit_ctr_01();