<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\ViewModels\CatalogViewModel;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): CatalogViewModel
    {
        return (new CatalogViewModel($category))->view('catalog.index');
    }
}
