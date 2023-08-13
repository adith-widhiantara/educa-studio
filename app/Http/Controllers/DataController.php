<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Responses\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;

class DataController extends Controller
{
    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('data.index');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function loadData(Request $request): JsonResponse
    {
        $points = Point::query()
            ->selectRaw('ROW_NUMBER() OVER (ORDER BY SUM(points_earned) DESC) as nomor, tbl_member.name as member_name, tbl_institution.name as institution_name, SUM(points_earned) as total')
            ->join('tbl_member', 'tbl_point.member_id', '=', 'tbl_member.id')
            ->join('tbl_institution', 'tbl_point.institution_id', '=', 'tbl_institution.id')
            ->groupBy('tbl_member.name', 'tbl_institution.name');

        if ($request->filled('minimal_point')) {
            $points->havingRaw('SUM(points_earned) >= ?', [$request->minimal_point]);
        }

        if ($request->filled('maximal_point')) {
            $points->havingRaw('SUM(points_earned) <= ?', [$request->maximal_point]);
        }

        return Response::success('Data berhasil dimuat', [
            'points' => $points->get(),
        ]);
    }

}
