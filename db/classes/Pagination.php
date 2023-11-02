<?php
namespace classes;

class Pagination {
private $currentPage;
private $totalItems;
private $itemsPerPage;

public function __construct($currentPage, $totalItems, $itemsPerPage) {
$this->currentPage = $currentPage;
$this->totalItems = $totalItems;
$this->itemsPerPage = $itemsPerPage;
}

public function getPaginationLinks($baseUrl, $additionalParams = []) {
$totalPages = ceil($this->totalItems / $this->itemsPerPage);
$paginationHtml = '<div class="pagination">';

    for ($page = 1; $page <= $totalPages; $page++) {
    $params = array_merge(['page' => $page], $additionalParams); // Fixed the order of array_merge
    $pageUrl = $baseUrl . '?' . http_build_query($params);

    if ($page == $this->currentPage) {
    $paginationHtml .= '<a class="active" href="' . $pageUrl . '">' . $page . '</a>';
    } else {
    $paginationHtml .= '<a href="' . $pageUrl . '">' . $page . '</a>';
    }
    }

    $paginationHtml .= '</div>';
return $paginationHtml;
}
}
?>
