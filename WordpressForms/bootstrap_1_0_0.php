<?php
if ( ! class_exists( 'WordpressForms_Bootstrap_1_0_0' ) ) {

	class WordpressForms_Bootstrap_1_0_0 {

		const VERSION = '1.0.0';

		private static $_instance;

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		private function __construct() {

			if ( ! class_exists( 'WordpressForms\\VersionHandler' ) ) {
				include 'VersionHandler.php';
			}

			$version = WordpressForms\VersionHandler::instance();

			if ( empty( $version->getVersion() ) ) {
				$version->setVersion( self::VERSION );
			}

			if ( version_compare( $version->getVersion(), self::VERSION, '<=' ) ) {
				$version->setVersion( self::VERSION );
				spl_autoload_register( array( $this, 'class_loader' ), true, true );
			}
		}

		public function class_loader( $class_name ) {

			$namespace = 'WordpressForms\\';

			$length = strlen( $namespace );

			if ( 0 !== strpos( $class_name, $namespace ) ) {
				return;
			}

			$filename = substr( $class_name, $length );

			include_once( "{$filename}.php" );
		}
	}

	WordpressForms_Bootstrap_1_0_0::instance();
}