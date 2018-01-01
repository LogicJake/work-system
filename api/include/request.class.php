<?php

/**
 * 封装 AJAX 传入数据的类
 * !!本文件不用于防注入等操作!!
 * Author: Rex
 */

class Request {
	public static $body;
	public static $pager;
	public static function initialize() {
		if ($_SERVER['REQUEST_METHOD'] != 'GET') {
			self::$body = [];
			$param = file_get_contents('php://input');
			$param = json_decode($param, true);
			if (is_array($param)) {
				foreach ($param as $key => $value) {
					if (is_bool($value)) {
						self::$body[$key] = intval($value);
					} else {
						self::$body[$key] = $value;
					}
				}
			}
		}
		if (isset($_GET['_pn'])) {
			self::$pager = [
				'page' => intval($_GET['_pn']),
				'pageSize' => DEFAULT_PAGE_SIZE
			];
			if (isset($_GET['_ps'])) {
				self::$pager['pageSize'] = intval($_GET['_ps']);
			}
		} else {
			self::$pager = null;
		}
	}
}
