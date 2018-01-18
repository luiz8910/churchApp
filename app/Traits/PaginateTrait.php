<?php
/**
 * Created by PhpStorm.
 * User: luizfernandosanches
 * Date: 17/01/18
 * Time: 16:05
 */

namespace App\Traits;


use Illuminate\Pagination\LengthAwarePaginator;

trait PaginateTrait
{
    /**
     * Create a length aware custom paginator instance.
     *
     * @param  Collection  $items
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate($items, $perPage = 10)
    {
        //Get current page form url e.g. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Slice the collection to get the items to display in current page
        $currentPageItems = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        //Create our paginator and pass it to the view
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }
}