<?php

class WordTrimmerExtension extends DataExtension {
	
	public function CutWords($str, $len = 26) {
		$str = strip_tags($str);
		$words = explode(' ', $str);
		if (count($words) > 26) {
			$words = array_slice($words, 0, $len);
			$trimmed = implode(' ', $words);
			$trimmed = rtrim($trimmed, ".,") . '...';
			
			return $trimmed;
		}
		
		return $str;		
	}
	
}