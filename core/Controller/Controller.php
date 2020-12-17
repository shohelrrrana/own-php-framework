<?php


namespace Core\Controller;

/**
 * Class Controller
 *
 * @package Core\Controller
 */
abstract class Controller {
	/**
	 * Default view layout
	 *
	 * @var string $layout
	 */
	private string $layout = 'main';

	/**
	 * Get view content with layout
	 *
	 * @param string $viewFile
	 * @param array $params
	 *
	 * @return bool|false|string|string[]
	 */
	protected function view ( string $viewFile, array $params = [] ) {
		$layoutContent = $this->layoutContent();
		$viewContent   = $this->viewContent( $viewFile, $params );

		if ( $layoutContent !== false ) {
			$content = str_replace( '{{content}}', $viewContent, $layoutContent );
		} else {
			$content = $viewContent;
		}

		return $content;
	}

	/**
	 * Get only view content
	 *
	 * @param string $file
	 * @param array $params
	 *
	 * @return false|string
	 */
	private function viewContent ( string $file, array $params ) {
		$viewFile = VIEW_PATH . DS . $file . '.php';

		if ( file_exists( $viewFile ) ) {
			foreach ( $params as $key => $value ) {
				$$key = $value;
			}

			ob_start();
			include_once $viewFile;

			return ob_get_clean();

		} else {
			return "View file {$viewFile} is not found";
		}

	}

	/**
	 * Get layout content
	 *
	 * @return bool|false|string
	 */
	private function layoutContent () {
		$layoutFile = VIEW_PATH . DS . 'layouts' . DS . $this->layout . '.php';

		if ( file_exists( $layoutFile ) ) {
			ob_start();
			include_once $layoutFile;

			return ob_get_clean();
		}

		return false;
	}

	/**
	 * Set layout
	 *
	 * @param string $layout
	 */
	protected function setLayout ( string $layout ) {
		$this->layout = $layout;
	}
}