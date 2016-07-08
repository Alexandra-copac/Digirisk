<?php
/**
* @author: Jimmy Latour lelabodudev@gmail.com
*/

use phpDocumentor\Reflection\DocBlockFactory;

class functional_test {
	private $list_file;
	private $exclude_path = array();
	private $list_methods_to_test = array();

	public function __construct( $list_file ) {
		$this->list_file = $list_file;
	}

	public function set_exclude_path( $exclude_path ) {
		$this->exclude_path = $exclude_path;
	}

	public function execute() {
		echo "[+] Starting functional tests" . PHP_EOL . PHP_EOL;

		if ( !empty( $this->list_file ) ) {
		  foreach ( $this->list_file as $file_path ) {
				$file_path[0] = str_replace( '/', '\\', $file_path[0] );
				if ( !in_array( $file_path[0], $this->exclude_path ) ) {
					echo '[+] testing file : ' . $file_path[0] . PHP_EOL;

					$class_info = $this->get_class_info( $file_path[0] );
					$this->list_methods_to_test[$file_path[0]] = array();

					$class_name = $class_info['namespace'];
		      $class_name .= $class_info['class_name'];
		      $class = new ReflectionClass( $class_name );

					$factory = DocBlockFactory::createInstance();
		      $methods = $class->getMethods();

					$json_content = $this->load_test_json( $file_path[0] );

					if ( !empty( $methods ) ) {
					  foreach ( $methods as $element ) {
							if ( empty( $this->list_methods_to_test[$file_path[0]][$element->class] ) ) {
								$this->list_methods_to_test[$file_path[0]][$element->class] = array();
							}

							$this->list_methods_to_test[$file_path[0]][$element->class][$element->name] = array();

							$docBlock = $factory->create($element->getDocComment());

							$this->fill_method( $file_path[0], $element, $docBlock );

							if ( !empty( $json_content ) ) {
								$this->call_method( $class, $file_path[0], $this->list_methods_to_test[$file_path[0]][$element->class], $json_content );
							}
					  }
					}
				}
		  }
		}

		$this->display();

		echo "[+] End functional tests" . PHP_EOL . PHP_EOL;
	}

	private function get_class_info( $file_path ) {
		$content = file_get_contents( $file_path );

		$pattern = '/class ([a-z0-9_]+) (extends (.*) {|{)/';
    preg_match( $pattern, $content, $matched_class );

		$namespace_pattern = '/namespace (.*);/';
    preg_match( $namespace_pattern, $content, $matched_namespace );

		if ( empty( $matched_class[1] ) ) {
			return false;
		}

		return array(
			'class_name' => $matched_class[1],
			'parent_class_name' => !empty( $matched_class[3] ) ? $matched_class[3] . '\\' : '',
			'namespace' => !empty( $matched_namespace[1] ) ? $matched_namespace[1] : '',
		);
	}

	private function load_test_json( $file_path ) {
		$filename = basename( $file_path, '.class.php' );
		$path_to_json = trim( dirname( $file_path ) . '\\test\\' . $filename . '.test.json' . PHP_EOL );
		if ( is_file ( $path_to_json ) ) {
			$json_content = file_get_contents( $path_to_json );
		}
		else {
			return '';
		}

		return json_decode( $json_content, true );
	}

	private function fill_method( $file_path, $element, $docBlock ) {
		if ( !empty( $docBlock->getTags() ) ) {
		  foreach ( $docBlock->getTags() as $tag ) {
				$this->list_methods_to_test[$file_path][$element->class][$element->name][$tag->getVariableName()] = $tag->getInfo();
				$this->list_methods_to_test[$file_path][$element->class][$element->name][$tag->getVariableName()]['test'] = $this->parseTestValue( $this->list_methods_to_test[$file_path][$element->class][$element->name][$tag->getVariableName()]['type'], $this->list_methods_to_test[$file_path][$element->class][$element->name][$tag->getVariableName()]['description'] );
		  }
		}
	}

	private function call_method( $class, $file_path, $list_methods_to_test, $json_content ) {
		if ( !empty( $list_methods_to_test ) ) {
		  foreach ( $list_methods_to_test as $method_name =>  $method_to_test ) {
				if ( !empty( $json_content[$method_name] ) ) {
				  foreach ( $json_content[$method_name] as $json ) {
						echo "<pre>"; print_r($json); echo "</pre>";
						$class->getMethod($method_name)->invokeArgs( new $class->name(), $json );
				  }
				}
		  }
		}
	}

	private function parseTestValue( $type, $description ) {
		preg_match( '/\(test:(.*)\)/' , $description, $matched );

		if ( empty( $matched[1] ) ) {
			return null;
		}

		if ( $type == 'array' ) {
			settype( $matched[1], 'string' );

			$matched[1] = str_replace( '[', '', $matched[1] );
			$matched[1] = str_replace( ']', '', $matched[1] );


			$matched[1] = explode( ',', trim($matched[1]) );

			$new_array = array();

			if ( !empty( $matched[1] ) ) {
			  foreach ( $matched[1] as $element ) {
					preg_match( '/(.*)=>(.*)/', $element, $matchedKey );
					if ( !empty( $matchedKey[1] ) && !empty( $matchedKey[2] ) ) {
						$new_array[trim($matchedKey[1])] = trim($matchedKey[2]);
					}
			  }
			}

			if ( !empty( $new_array ) ) {
				$matched[1] = $new_array;
			}
		}
		else {
			settype( $matched[1], $type );
		}

		return $matched[1];
	}

	private function display() {
	}
}