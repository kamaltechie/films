<?php

class Pagination {
    private $itemsPerPage;
    private $totalItems;

    public function __construct($itemsPerPage, $totalItems) {
        $this->itemsPerPage = $itemsPerPage;
        $this->totalItems = $totalItems;
    }

    public function getPaginationLinks($currentPage, $baseUrl) {
        $totalPages = ceil($this->totalItems / $this->itemsPerPage);

        if ($totalPages <= 1) {
            return ''; // No need for pagination if there's only one page
        }

        $pagination = '<ul class="pagination">';
        $range = 3; // Number of links to show on each side of the current page

        // Previous link
        if ($currentPage > 1) {
            $previousPage = $currentPage - 1;
            $pagination .= "<li><a href='$baseUrl?page=$previousPage'>&laquo;</a></li>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i >= $currentPage - $range && $i <= $currentPage + $range) {
                if ($i === $currentPage) {
                    $pagination .= "<li class='active'>$i</li>";
                } else {
                    $pagination .= "<li><a href='$baseUrl?page=$i'>$i</a></li>";
                }
            }
        }

        // Next link
        if ($currentPage < $totalPages) {
            $nextPage = $currentPage + 1;
            $pagination .= "<li><a href='$baseUrl?page=$nextPage'>&raquo;</a></li>";
        }

        $pagination .= '</ul>';

        return $pagination;
    }
}
