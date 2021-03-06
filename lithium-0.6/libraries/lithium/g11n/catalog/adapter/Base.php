<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace lithium\g11n\catalog\adapter;

/**
 * The `Base` class is the foundation for all g11n catalog adapters.
 */
class Base extends \lithium\core\Object {

	/**
	 * Reads data.
	 *
	 * Override this method in subclasses if you want the adapter
	 * to have read support. The method is expected to return `null`
	 * if the passed category is not supported.
	 *
	 * @param string $category A category.
	 * @param string $locale A locale identifier.
	 * @param string $scope The scope for the current operation.
	 * @return array|void
	 */
	public function read($category, $locale, $scope) {
		return null;
	}

	/**
	 * Writes data.
	 *
	 * Override this method in subclasses if you want the adapter
	 * to have write support. The method is expected to return `false`
	 * if the passed category is not supported.
	 *
	 * Please note that existing data is silently overwritten.
	 *
	 * @param string $category A category.
	 * @param string $locale A locale identifier.
	 * @param string $scope The scope for the current operation.
	 * @param mixed $data The data to write.
	 * @return boolean
	 */
	public function write($category, $locale, $scope, $data) {
		return false;
	}

	/**
	 * Prepares an item before it is being written.
	 *
	 * Override this method in sublcasses if you need to
	 * i.e. escape the item's values.
	 *
	 * @param mixed $item
	 * @return mixed
	 */
	protected function _prepareForWrite($item) {
		return $item;
	}

	/**
	 * Merges an item into given data.
	 *
	 * @param array $data Data to merge item into.
	 * @param array $item Item to merge into $data. The item must have an `'id'` key.
	 * @return array The merged data.
	 */
	protected function _merge($data, $item) {
		if (!isset($item['id'])) {
			return $data;
		}
		$id = $item['id'];

		$defaults = array(
			'ids' => array(),
			'translated' => null,
			'flags' => array(),
			'comments' => array(),
			'occurrences' => array()
		);
		$item += $defaults;

		if (!isset($data[$id])) {
			$data[$id] = $item;
			return $data;
		}
		foreach (array('ids', 'flags', 'comments', 'occurrences') as $field) {
			$data[$id][$field] = array_merge($data[$id][$field], $item[$field]);
		}
		if (is_array($item['translated'])) {
			$data[$id]['translated'] = (array) $data[$id]['translated'] + $item['translated'];
		} elseif (!isset($data[$id]['translated'])) {
			$data[$id]['translated'] = $item['translated'];
		}
		return $data;
	}
}

?>