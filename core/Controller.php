<?php


namespace Core;


class Controller {
	private string $layout = 'main';

	protected function view ( string $viewFile, array $params = [] ) {
		$layoutContent = $this->layoutContent();
		$viewContent   = $this->viewContent( $viewFile, $params );

		if ( $layoutContent !== false ) {
			$content = str_replace( '{{content}}', $viewContent, $layoutContent );
		} else {
			$content = $viewContent;
		}

		echo $content;
	}

	private function viewContent ( string $file, array $params ) {
		$viewFile = ROOT_PATH . "/app/views/{$file}.php";

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

	private function layoutContent () {
		$layoutFile = ROOT_PATH . "/app/views/layouts/{$this->layout}.php";

		if ( file_exists( $layoutFile ) ) {
			ob_start();
			include_once $layoutFile;

			return ob_get_clean();
		}

		return false;
	}

	protected function setLayout ( string $layout ) {
		$this->layout = $layout;
	}
}