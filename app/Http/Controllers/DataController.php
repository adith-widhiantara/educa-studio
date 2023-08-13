<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Member;
use App\Responses\Response;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;

use function compact;
use function collect;
use function to_route;

class DataController extends Controller
{
    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $members = Member::query()
            ->select('name')
            ->orderBy('name')
            ->get();

        $institutions = Institution::query()
            ->select('name')
            ->orderBy('name')
            ->get();

        $points = Point::query()
            ->selectRaw('SUM(points_earned) as total')
            ->join('tbl_member', 'tbl_point.member_id', '=', 'tbl_member.id')
            ->join('tbl_institution', 'tbl_point.institution_id', '=', 'tbl_institution.id')
            ->groupBy('tbl_member.id', 'tbl_institution.id')
            ->get();

        $collect = collect($points)
            ->pluck('total')
            ->unique();

        $max = $collect
            ->sortDesc()
            ->values()
            ->all();

        $min = $collect
            ->sort()
            ->values()
            ->all();

        return view('data.index', compact('members', 'institutions', 'max', 'min'));
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'member' => ['required', 'string', 'max:255', Rule::exists('tbl_member', 'name')],
            'institution' => ['required', 'string', 'max:255', Rule::exists('tbl_institution', 'name')],
            'point' => ['required', 'integer', 'min:1'],
        ]);

        $members = Member::query()
            ->where('name', $request->member)
            ->value('id');

        $institutions = Institution::query()
            ->where('name', $request->institution)
            ->value('id');

        Point::query()
            ->create([
                'member_id' => $members,
                'institution_id' => $institutions,
                'points_earned' => $request->point,
                'transaction_date' => now(),
            ]);

        return to_route('data.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->type == 'member') {
            $data = Member::query();
        } else {
            $data = Institution::query();
        }

        $data
            ->where('name', $request->last_name)
            ->update([
                'name' => $request->name,
            ]);

        return to_route('data.index')
            ->with('success', 'Data berhasil diubah');
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function destroy(Request $request): mixed
    {
        if ($request->type == 'member') {
            $data = Member::query();
        } else {
            $data = Institution::query();
        }

        $data = $data
            ->where('name', $request->last_name)
            ->first();

        Point::query()
            ->where('member_id', $data->id)
            ->orWhere('institution_id', $data->id)
            ->delete();

        return $data->delete();
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
