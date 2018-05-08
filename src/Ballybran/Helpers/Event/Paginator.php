<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 26/04/18
 * Time: 16:35
 */

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
    private $starring_limit;
    private $total_page;
    private $table;


    public function __construct($dbType, $query, $limit)
    {
        $reg = new RegistryDatabase();
        $this->stmt = $reg->get($dbType);
        $this->limit = $limit;
        $this->query = $query;
        $this->page = $this->stmt->selectManager($this->query);
        $total_result = count($this->page);
        $this->total_page = ceil($total_result / $this->limit);


    }

    public function getcolum()
    {

        if (!isset($_GET['page'])) {
            $this->page = 1;
        } else {

            $this->page = $_GET['page'];
        }

        $this->starring_limit = ($this->page - 1) * $this->limit;

        return $this->stmt->selectManager(" $this->query LIMIT $this->starring_limit, $this->limit");

    }

    public function pagination()
    {
        ?>
                <?php for ($this->page = 1; $this->page <= $this->total_page; $this->page++): ?>
                    <li class="page-item"><a class="pagination" href='<?php echo "?page=$this->page"; ?>'
                                             class="pagination fade in active" aria-hidden="true"><?php echo $this->page; ?></a></li>
                <?php endfor; ?>

    <?php }
}


