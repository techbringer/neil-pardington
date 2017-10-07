<?php
use Ntb\RestAPI\BaseRestController as BaseRestController;
use SaltedHerring\Debugger;

/**
 * @file WorkAPI.php
 *
 * Controller to present the data from forms.
 * */
class WorkAPI extends BaseRestController
{
    private $pageSize   =   5;
    private $slug       =   null;
    private $isCategory =   false;

    private static $allowed_actions = array(
        'get'           => "->isAuthenticated"
    );

    public function isAuthenticated()
    {
        if ($this->request->isAjax()) {

            if ($this->slug = $this->request->param('Slug')) {

                if (!is_numeric($this->slug)) {
                    $this->isCategory   =   true;
                }

                return true;
            }

            return false;
        }

        return array('list' => array(), 'count' => 0, 'pagination' => array('message' => 'for some reason, your request didn\'t get through'));
    }


    public function get($request)
    {
        if ($this->isCategory) {
            if ($category               =   Category::get()->filter(['Slag' => $this->slug])->first()) {
                $works                  =   $category->Works();
                return $this->Paginate($works);
            }
            return array('list' => array(), 'count' => 0, 'pagination' => array('message' => 'for some reason, your request didn\'t get through'));
        }

        if ($category_page              =   CategoryPage::get()->byID($this->slug)) {

            return $this->Paginate($category_page->getCachedWorks());
        }

        return array('list' => array(), 'count' => 0, 'pagination' => array('message' => 'for some reason, your request didn\'t get through'));
    }



    private function Paginate($articles)
    {
        $artcile_count                  =   $articles->count();

        if (empty($artcile_count)) {
            return array('keywords' => $this->keywords, 'list' => array(), 'count' => 0, 'pagination' => array('message' => SiteConfig::current_site_config()->ArticleEmptyResult));
        }

        $articles                       =   $articles->sort('SortOrder ASC');

        $start                          =   $this->request->getVar('start');

        if ($artcile_count > $this->pageSize) {
            $paged                      =   new PaginatedList($articles, $this->request);

            $paged->setPageLength($this->pageSize);

            $articles                   =   $paged;
            $list                       =   $articles->getIterator();
            $data                       =   [];

            foreach ($list as $item) {
                $data[]                 =   $item->cached(true);
            }

            if ($paged->MoreThanOnePage()) {
                if ($paged->NotLastPage()) {
                    // $pagination         =   $paged->NextLink() . (!empty($this->keywords) ? ('&keywords=' . $this->keywords . '&csrf=' . Session::get('SecurityID')) : '');
                    $pagination         =   $this->sanitisePagination($paged->NextLink()); // . (!empty($this->keywords) ? ('&keywords=' . $this->keywords) : '');
                    return  array(
                        'list'          =>  $data,
                        'count'         =>  $artcile_count,
                        'pagination'    =>  array('href' => $pagination)
                    );
                }

                return  array(
                    'list'              =>  $data,
                    'count'             =>  $artcile_count,
                    'pagination'        =>  array('message' => null)
                );
            }
        }

        // Debugger::inspect($articles->count());

        $data                           =   $articles->json();

        return array(
            'list'                      =>  $data,
            'count'                     =>  count($data),
            'pagination'                =>  array('message' => null)
        );
    }

    private function sanitisePagination($pagination)
    {
        $pagination                     =   str_replace('&amp;', '&', $pagination);
        $parts                          =   parse_url($pagination);

        parse_str($parts['query'], $query);

        if (empty($query['keywords']) && !empty($this->keywords)) {
            $pagination .= '&keywords=' . $this->keywords;
        }

        return $pagination;
    }


}
