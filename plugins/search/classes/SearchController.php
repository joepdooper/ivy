<?php

namespace Search;

use GUMP;
use Ivy\Abstract\Controller;
use Ivy\Core\Path;
use Ivy\View\View;

class SearchController extends Controller
{
    protected Search $search;

    public function __construct()
    {
        parent::__construct();
        $this->search = new Search;
    }

    /**
     * @throws \Exception
     */
    public function post(): void
    {
        $this->search->policy('post');

        $filtered = GUMP::filter_input([
            'search' => $this->request->get('search'),
        ], [
            'search' => 'trim|sanitize_string'
        ]);

        $searches = $this->parseSearchString($filtered['search']);

        foreach ($searches as $search) {
            try {
                //
            } catch (\Exception $e) {
                $this->flashBag->add('error', $e->getMessage());
            }
        }

        $this->flashBag->add('success', 'Search successful');
        $this->redirect($this->search->getPath());
    }

    public function index(): void
    {
        $this->search->policy('index');

        $search = $this->search->fetchAll();
        View::set(Path::get('PLUGINS_PATH') . 'tags/template/manage.latte', ['tags' => $search]);
    }

    function parseSearchString(string $input): array
    {
        $matches = [];
        preg_match_all('/"([^"]+)"|\'([^\']+)\'|(\S+)/', $input, $matches);

        $results = [];
        foreach ($matches[0] as $i => $match) {
            if (!empty($matches[1][$i])) {
                $results[] = $matches[1][$i]; // double-quoted
            } elseif (!empty($matches[2][$i])) {
                $results[] = $matches[2][$i]; // single-quoted
            } else {
                $results[] = $matches[3][$i]; // unquoted
            }
        }

        return $results;
    }
}
