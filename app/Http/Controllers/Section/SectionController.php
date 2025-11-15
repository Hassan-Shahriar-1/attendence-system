<?php

namespace App\Http\Controllers\Section;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Section\SectionOverviewResource;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(): JsonResponse
    {
        $sections = Section::query()
            ->with(['grade'])
            ->paginate(request('per_page', 10));
        return ApiResponseHelper::successResponse(SectionOverviewResource::collection($sections), true);
    }
}
