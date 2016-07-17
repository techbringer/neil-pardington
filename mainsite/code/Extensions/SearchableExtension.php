<?php use SaltedHerring\Debugger as Debugger;

class SearchableExtension extends DataExtension {
	
	public function CutWords($str, $highlight = null, $len = 26) {
		$str = strip_tags($str);
		$words = explode(' ', $str);
		if (count($words) > 26) {
			$words = array_slice($words, 0, $len);
			$trimmed = implode(' ', $words);
			$trimmed = rtrim($trimmed, ".,") . '...';
			
			if (strpos($trimmed, $highlight) === false) {
				
				$extra = substr($str, strpos($str, $highlight) - 10, strlen($highlight) + 20) . '...';
				
				$trimmed .= ' ' . trim($extra);
			}
			
			return $this->enlighten($trimmed, $highlight);
		}
		
		
		
		return $this->enlighten($str, $highlight);		
	}
	
	private function enlighten($str, $highlight) {
		if (!empty($highlight)) {
			$highlight = strtolower($highlight);
			$str = str_ireplace($highlight, '<span class="highlight">' . $highlight . '</span>', $str);
		}
		
		return $str;
	}
	
	public function getDateCreated() {
		$date = $this->owner->Created;
		$date = new DateTime($date);
		return $date->format('M d, Y');
	}
	
	public function URL() {
		if ($this->owner->ClassName == 'Work') {
			return '/work#work-'. $this->owner->Slag;
		} elseif ($this->owner->ClassName == 'BlogEntry') {
			return '/blog/'.$this->owner->Slag;
		}
		
		return $this->owner->Link();
	}	
}