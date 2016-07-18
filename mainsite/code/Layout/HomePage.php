<?php use SaltedHerring\Grid as Grid;
use SaltedHerring\Debugger as Debugger;

class HomePage extends Page {

	private static $db = array(
		'HiddenContent'	=>	'HTMLText'
	);

	private static $has_one = array(
	);
	
	private static $has_many = array(
		'Showcases'		=>	'Showcase'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab(
			'Root.Showcases',
			Grid::make('Showcases', 'Showcases', $this->Showcases())
		);
		$fields->addFieldToTab('Root.PlainTextShowcases', LiteralField::create('PlainTextShowcases', '<div style="width: 100%; max-width: 600px;">'.$this->HiddenContent.'</div>'));
		return $fields;
	}
	
	public function collect_content() {
		$showcases = $this->Showcases()->sort(array('SortOrder' => 'ASC', 'ID' => 'DESC'));;
		$this->HiddenContent = '';
		foreach ($showcases as $showcase) {
			$this->HiddenContent .= $showcase->contribute_content();
		}
		
		$this->doPublish();
	}
}


class HomePage_Controller extends Page_Controller {
	
	public function getAllShowcases() {
		return $this->Showcases()->sort(array('SortOrder' => 'ASC', 'ID' => 'DESC'));;
	}	
}