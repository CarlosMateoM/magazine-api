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
            ->allowedIncludes([
                'department'
            ])
            ->allowedFilters([
                'name',
                'department_id'
            ]);

        return $municipalities->paginate($request->input('per_page', self::DEFAULT_PER_PAGE))
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
