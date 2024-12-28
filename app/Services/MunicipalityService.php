<?php

namespace App\Services;

use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MunicipalityService
{

    private const DEFAULT_PER_PAGE = 10;

    public function getMunicipalities(Request $request)
    {
        $municipalities = QueryBuilder::for(Municipality::class)
            ->allowedFilters([
                'name',
                'department_id'
            ])
            ->with([
                'department'
            ]);

        return $municipalities->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function getMunicipality(Municipality $municipality): Municipality
    {
        return $municipality->load('department');
    }

    public function createMunicipality(StoreMunicipalityRequest $request): Municipality
    {
        $municipality = new Municipality();

        $municipality->name = $request->name;
        $municipality->department_id = $request->departmentId;

        $municipality->save();


        return $municipality;
    }

    public function updateMunicipality(UpdateMunicipalityRequest $request, Municipality $municipality): Municipality
    {

        $municipality->name = $request->name;
        $municipality->department_id = $request->departmentId;

        $municipality->save();

        return $municipality;
    }

    public function deleteMunicipality(Municipality $municipality): void
    {
        $municipality->delete();
    }
}
