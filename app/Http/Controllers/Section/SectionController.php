<?php

namespace App\Http\Controllers\Section;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Section\CreateSectionRequest;
use App\Http\Requests\Section\UpdateSection;
use App\Http\Resources\Section\SectionOverviewResource;
use App\Models\Section;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    public function index(): JsonResponse
    {
        $sections = Section::query()
            ->with(['grade'])
            ->paginate(request('per_page', 10));
        return ApiResponseHelper::successResponse(SectionOverviewResource::collection($sections), true);
    }

    public function store(CreateSectionRequest $request)
    {
        $validatedData = $request->validated();
        $section = Section::create($validatedData);
        return ApiResponseHelper::successResponse($section);
    }

    public function update(Section $section, UpdateSection $request)
    {
        $updateData = $request->validated();
    }

    public function destroy(Section $section)
    {
        DB::beginTransaction();
        try {
            $section->grades()->detach();
            $section->delete();
            DB::commit();
            return ApiResponseHelper::successResponse([], false, 'deleted');
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::serverError($e);
        }
    }
}
