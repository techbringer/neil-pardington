<?php use SaltedHerring\Grid as Grid;
use SaltedHerring\Debugger as Debugger;
class BlogsPage extends Page {

	protected static $db = array(
	);

	protected static $has_one = array(
	);
	
	protected static $has_many = array(
		'Blogs'			=>	'BlogEntry'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		if (!empty($this->ID)) {
			$fields->addFieldsToTab(
				'Root.Blogs',
				array(
					Grid::make('Blogs', 'Blogs', $this->Blogs(), false)
				)
			);
		}
		return $fields;
	}
	
}


class BlogsPage_Controller extends Page_Controller {
	protected static $url_handlers = array(
		''		=>	'index',
		'$slag'	=>  'getEntry'
	);
	
	protected static $allowed_actions = array(
		'index',
		'getEntry'
	);
	
	public function index($request) {
		return $this->renderWith(array('BlogsPage', 'Page'));
	}
	
	public function getEntry($request) {
		$slag = $request->param('slag');
		//Debugger::inspect($slag);
		$blog = $this->Blogs()->filter(array('slag' => $slag))->first();
		/*if ($works->count() == 0) {
			$err = HomePage::get()->first();
			return $this->customise(array(
					'HeaderImage'		=>	$err->HeaderImage(),
					'SubTitle'			=>	$subtitle,
					'ViewportHeight'	=>	'normal',
					'HideTitle'			=>	false,
					'Content'			=>	'<h2>Found no work</h2><p>Load some?</p>'
				))->renderWith(array('Page'));
		}*/
		return $this->customise($blog)->renderWith(array('Page'));
	}
	
	public function isBlogEntry() {
		$request = $this->request;
		$slag = $request->param('slag');
		if (empty($slag)) { return false; }
		$blog = $this->Blogs()->filter(array('slag' => $slag));
		if (!empty($blog)) { return true; }
		return false;
	}
}