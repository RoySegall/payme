<?php

namespace App\Http\Controllers;

use App\SalesInformation;
use Illuminate\Http\Request;

class SalesInformationController extends Controller
{
    /**
     * Return all the items.
     *
     * @return SalesInformation[]|\Illuminate\Database\Eloquent\Collection
     */
    public function show()
    {
        // todo: handle pagination.
        return SalesInformation::all();
    }
}
