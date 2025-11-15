<?php

namespace App\Http\Controllers\Grade;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Grade\CreateGradeRequest;
use App\Http\Requests\Grade\UpdateGradeRequest;
use App\Models\Grade;
use Exception;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::select('id', 'name')
            ->withCount(['students', 'sections'])
            ->paginate(request('per_page', 10));

        return ApiResponseHelper::successResponse($grades, true);
    }

    public function store(CreateGradeRequest $request)
    {
        $validatedData = $request->validated();
        $grade = Grade::create($validatedData);
        return ApiResponseHelper::successResponse($grade);
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $updateData = $request->validated();
        $grade->update($updateData);
        return ApiResponseHelper::successResponse($grade->fresh());
    }

    public function destroy(Grade $grade)
    {
        $this->authorize('delete', $grade);
        DB::beginTransaction();
        try {
            $grade->sections()->detach();
            $grade->delete();
            DB::commit();
            return ApiResponseHelper::successResponse([], false, 'deleted');
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError($e);
        }
    }
}
