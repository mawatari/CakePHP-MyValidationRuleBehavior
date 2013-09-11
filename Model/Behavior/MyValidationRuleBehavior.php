<?php
/**
 * Class MyValidationRuleBehavior
 *
 * CakePHPの独自バリデーション
 *
 * @copyright     Copyright (c) MAWATARI Naoto. (http://mawatari.jp)
 * @link          http://mawatari.jp
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * example:
 * 	public $validate = [
 *		'start_datetime' => [
 *			[
 *				'rule' => ['datetime'],
 *				'message' => '正しい日時ではありません。',
 *			],
 *		],
 *		'stop_datetime' => [
 *			[
 *				'rule' => ['datetime'],
 *				'message' => '正しい日時ではありません。',
 *			],
 *			[
 *				'rule' => ['comparisonField', '>', 'start_datetime'],
 *				'message' => '開始日時より後の日時を入力してください。'
 *			]
 *		],
 * 	];
 */
class MyValidationRuleBehavior extends ModelBehavior {
/**
 * フィールド値の比較
 * オペレータを指定できる
 * Used to compare 2 field values.
 * Inspired by Utility/Validation and cakeplus
 *
 * @param array &$model model object, automatically set
 * @param array $check Value to check
 * @param string $operator Can be either a word or operand
 *    is greater >, is less <, greater or equal >=
 *    less or equal <=, is less <, equal to ==, not equal !=
 * @param string $compare_field Set field name for comparison
 * @return boolean Success
 */
	public static function comparisonField(Model $model, $check, $operator = null, $compare_field = null) {
		$check = current($check);
		$operator = str_replace(array(' ', "\t", "\n", "\r", "\0", "\x0B"), '', strtolower($operator));
		$compare_field = isset($model->data[$model->alias][$compare_field]) ? $model->data[$model->alias][$compare_field] : null;

		switch ($operator) {
			case 'isgreater':
			case '>':
				if ($check > $compare_field) {
					return true;
				}
				break;
			case 'isless':
			case '<':
				if ($check < $compare_field) {
					return true;
				}
				break;
			case 'greaterorequal':
			case '>=':
				if ($check >= $compare_field) {
					return true;
				}
				break;
			case 'lessorequal':
			case '<=':
				if ($check <= $compare_field) {
					return true;
				}
				break;
			case 'equalto':
			case '==':
				if ($check == $compare_field) {
					return true;
				}
				break;
			case 'notequal':
			case '!=':
				if ($check != $compare_field) {
					return true;
				}
				break;
			default:
				self::$errors[] = __d('cake_dev', 'You must define the $operator parameter for %s', 'Validation::comparisonField()');
		}
		return false;
	}
}
