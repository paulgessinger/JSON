<?php
namespace PG ;

use PG\JSON\Exception\InvalidJSON ;
use PG\JSON\Exception\ErrorDepthException ;
use PG\JSON\Exception\CtrlCharException ;
use PG\JSON\Exception\SyntaxException ;

/**
 * static class to simplify working with JSON. It throws exceptions instead
 * of failing silently.
 *
 * @package PG
 */
abstract class JSON {

    /**
     * Decodes a JSON string into an array
     *
     * @param $data string The JSON String
     * @throws JSON\Exception\CtrlCharException
     * @throws JSON\Exception\ErrorDepthException
     * @throws JSON\Exception\InvalidJSON
     * @throws JSON\Exception\SyntaxException
     * @return array The decoded data.
     */
    public static function decode($data) {
		$decoded = json_decode($data, true) ;
		
		switch(json_last_error()) {
			case JSON_ERROR_DEPTH:
				throw new ErrorDepthException('JSON_ERROR_DEPTH', JSON_ERROR_DEPTH) ;
			break;
			case JSON_ERROR_CTRL_CHAR:
				throw new CtrlCharException('JSON_ERROR_CTRL_CHAR', JSON_ERROR_CTRL_CHAR) ;
			break;
			case JSON_ERROR_SYNTAX:
				throw new SyntaxException('JSON_ERROR_SYNTAX', JSON_ERROR_SYNTAX) ;
			break;
			case JSON_ERROR_NONE:
				return $decoded ;
			break;
			default:
				throw new InvalidJSON('JSON decode failed.') ;
			break;
		}
	}

    /**
     * Encodes data into a JSON string.
     * Can optionally beautify the result immediately.
     *
     * @param $data mixed The data to encode.
     * @param bool $beautify Whether to beautify the result right away
     * @return string The JSON string.
     * @throws JSON\Exception\CtrlCharException
     * @throws JSON\Exception\ErrorDepthException
     * @throws JSON\Exception\SyntaxException
     */
    public static function encode($data, $beautify = false) {
		$encoded = json_encode($data) ;

		if($beautify) {
			$encoded = JSON::beautify($encoded) ;
		}

		switch(json_last_error()) {
			case JSON_ERROR_DEPTH:
				throw new ErrorDepthException('JSON_ERROR_DEPTH', JSON_ERROR_DEPTH) ;
			break;
			case JSON_ERROR_CTRL_CHAR:
				throw new CtrlCharException('JSON_ERROR_CTRL_CHAR', JSON_ERROR_CTRL_CHAR) ;
			break;
			case JSON_ERROR_SYNTAX:
				throw new SyntaxException('JSON_ERROR_SYNTAX', JSON_ERROR_SYNTAX) ;
			break;
			default:
				return $encoded ;
			break;
		}
	}

    /**
     * Beautifies a given JSON string.
     *
     * @param $json string The JSON string
     * @return string The beautified JSON string.
     */
    public static function beautify($json) {
		$tab = "	"; 
		$new_json = ""; 
		$indent_level = 0; 
		$in_string = false; 
	
		$json_obj = json_decode($json); 
	
		if($json_obj === false) 
			return false; 
	
		$json = json_encode($json_obj); 
		$len = strlen($json); 
	
		for($c = 0; $c < $len; $c++) 
		{ 
			$char = $json[$c]; 
			switch($char) 
			{ 
				case '{': 
				case '[': 
					if(!$in_string) 
					{ 
						$new_json .= $char . "\n" . str_repeat($tab, $indent_level+1); 
						$indent_level++; 
					} 
					else 
					{ 
						$new_json .= $char; 
					} 
					break; 
				case '}': 
				case ']': 
					if(!$in_string) 
					{ 
						$indent_level--; 
						$new_json .= "\n" . str_repeat($tab, $indent_level) . $char; 
					} 
					else 
					{ 
						$new_json .= $char; 
					} 
					break; 
				case ',': 
					if(!$in_string) 
					{ 
						$new_json .= ",\n" . str_repeat($tab, $indent_level); 
					} 
					else 
					{ 
						$new_json .= $char; 
					} 
					break; 
				case ':': 
					if(!$in_string) 
					{ 
						$new_json .= ": "; 
					} 
					else 
					{ 
						$new_json .= $char; 
					} 
					break; 
				case '"': 
					if($c > 0 && $json[$c-1] != '\\') 
					{ 
						$in_string = !$in_string; 
					} 
				default: 
					$new_json .= $char; 
					break;					
			} 
		} 
	
		return $new_json; 
	}
	
}