<?php
namespace App\Http\Controllers;

use App\Models\MissionAssignment;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'MissionAssignment',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'mission_id', type: 'integer', example: 1),
        new OA\Property(property: 'sorcerer_id', type: 'integer', example: 1),
        new OA\Property(property: 'assigned_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'started_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'completed_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'result_status', type: 'string', enum: ['success', 'partial_success', 'failure', 'aborted'], nullable: true),
        new OA\Property(property: 'casualties', type: 'integer', example: 0),
        new OA\Property(property: 'mission_report', type: 'string', nullable: true),
    ]
)]
class MissionAssignmentController extends Controller
{
    #[OA\Get(
        path: '/assignment',
        summary: 'List all mission assignments',
        description: 'Returns a list of all mission assignments with related mission and sorcerer data',
        tags: ['Assignments'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of assignments',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/MissionAssignment')
                        ),
                        new OA\Property(property: 'count', type: 'integer', example: 10),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $assignments = MissionAssignment::with(['mission', 'sorcerer'])->get();

        return response()->json([
            'success' => true,
            'data'    => $assignments,
            'count'   => $assignments->count(),
        ]);
    }

    #[OA\Get(
        path: '/assignment/{id}',
        summary: 'Get an assignment by ID',
        description: 'Returns a single mission assignment with full details',
        tags: ['Assignments'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Assignment details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/MissionAssignment'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Assignment not found'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $assignment = MissionAssignment::with(['mission.curses', 'sorcerer'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $assignment,
        ]);
    }
}
