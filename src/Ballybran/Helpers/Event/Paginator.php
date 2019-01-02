<?php

namespace Ballybran\Helpers\Event;

use Ballybran\Database\DBconnection;
use Ballybran\Database\RegistryDatabase;

class Paginator extends DBconnection
{

    private $conn;
    private $limit;
    private $page;
    private $query;
    private $total;
    private $starringlimit;
    private $totalpage;
    private $table;
    private $total_result;


    public function __construct($dbType, $query, $limit)
    {
        $reg = new RegistryDatabase();
        $this->stmt = $reg->get($dbType);
        $this->limit = $limit;
        $this->query = $query;
        $this->page = $this->stmt->selectManager($this->query);
        $this->total_result = count($this->page);
        $this->totalpage = ceil($this->total_result / $this->limit);


    }

    public function getColum()
    {



            $this->page =( isset( $_GET['page']) ) ? $_GET['page'] : 1;

        $this->starringlimit = ($this->page - 1) * $this->limit;

        return $this->stmt->selectManager(" $this->query LIMIT $this->starringlimit, $this->limit");

    }

    public function createLinks($list_class)
    {
        if ($this->limit == 'all') {
            return '';
        }
        $links = (isset($_GET['links'])) ? $_GET['links'] : $this->total_result;

        $last = $this->totalpage;

        $start = (($this->page - $links) > 0) ? $this->page - $links : 1;
        $end = (($this->page + $links) < $last) ? $this->page + $links : $last;

        $html = '<ul class="' . $list_class . '">';

        $class = ($this->page == 1) ? "disabled" : "";
        $html .= '<li class="' . $class . '"><a class="page-link" href="?limit=' . $this->limit . '&page=' . ($this->page - 1) . '">&laquo;</a></li>';


        if ($start > 1) {
            $html .= '<li><a href="?limit=' . $this->limit . '&page=1">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }

        for ($i = $start; $i <= $end; $i++) {
            $class = ($this->page == $i) ? "active" : "";
            $html .= '<li class="' . $class . '"><a class="page-link" href="?limit=' . $this->limit . '&page=' . $i . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a class="page-link" href="?limit=' . $this->limit . '&page=' . $last . '">' . $last . '</a></li>';
        }

        $class = ($this->page == $last) ? "disabled" : "";
        $html .= '<li class="' . $class . '"><a class="page-link" href="?limit=' . $this->limit . '&page=' . ($this->page + 1) . '">&raquo;</a></li>';

        $html .= '</ul>';

        return $html;
    }
}
