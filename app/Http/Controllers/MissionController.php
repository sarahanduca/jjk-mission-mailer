<?php
namespace App\Http\Controllers;

use App\Services\MissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Mission',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Exorcise: Finger Bearer'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'required_sorcerer_grade', type: 'string', example: 'grade-2'),
        new OA\Property(property: 'curse_level', type: 'string', example: 'grade-2'),
        new OA\Property(property: 'category', type: 'string', example: 'exorcism'),
        new OA\Property(property: 'location', type: 'string', example: 'Tokyo'),
        new OA\Property(property: 'urgency_level', type: 'string', enum: ['low', 'medium', 'high']),
        new OA\Property(property: 'status', type: 'string', example: 'available'),
        new OA\Property(property: 'deadline', type: 'string', format: 'date-time'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
#[OA\Schema(
    schema: 'Sorcerer',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Yuji Itadori'),
        new OA\Property(property: 'email', type: 'string', example: 'yuji@jujutsu.jp'),
        new OA\Property(property: 'sorcerer_grade', type: 'string', example: 'grade-1'),
        new OA\Property(property: 'status', type: 'string', example: 'active'),
    ]
)]
class MissionController extends Controller
{
    protected MissionService $missionService;

    public function __construct(MissionService $missionService)
    {
        $this->missionService = $missionService;
    }

    #[OA\Get(
        path: '/mission',
        summary: 'List all missions',
        description: 'Returns a list of all missions with their curses',
        tags: ['Missions'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of missions',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Mission')
                        ),
                        new OA\Property(property: 'count', type: 'integer', example: 10),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $missions = \App\Models\Mission::with('curses')->get();

        return response()->json([
            'success' => true,
            'data'    => $missions,
            'count'   => $missions->count(),
        ]);
    }

    #[OA\Get(
        path: '/mission/{id}',
        summary: 'Get a mission by ID',
        description: 'Returns a single mission with curses and assignments',
        tags: ['Missions'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Mission details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Mission'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Mission not found'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $mission = \App\Models\Mission::with(['curses', 'assignments.sorcerer'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $mission,
        ]);
    }

    #[OA\Post(
        path: '/mission/generate',
        summary: 'Generate a new mission',
        description: 'Creates a new mission based on provided parameters. Optionally links a curse and assigns a sorcerer.',
        tags: ['Missions'],
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'sorcerer_id', type: 'integer', description: 'ID of sorcerer to assign', example: 1),
                    new OA\Property(property: 'curse_id', type: 'integer', description: 'ID of curse to link', example: 1),
                    new OA\Property(property: 'curse_level', type: 'string', enum: ['grade-4', 'grade-3', 'grade-2', 'semi-grade-1', 'grade-1', 'special-grade']),
                    new OA\Property(property: 'sorcerer_grade', type: 'string', enum: ['grade-4', 'grade-3', 'grade-2', 'semi-grade-1', 'grade-1', 'special-grade']),
                    new OA\Property(property: 'title', type: 'string', maxLength: 255),
                    new OA\Property(property: 'description', type: 'string'),
                    new OA\Property(property: 'category', type: 'string', maxLength: 100),
                    new OA\Property(property: 'location', type: 'string', maxLength: 255),
                    new OA\Property(property: 'urgency_level', type: 'string', enum: ['low', 'medium', 'high']),
                    new OA\Property(property: 'deadline', type: 'string', format: 'date-time'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Mission created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Mission generated successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [new OA\Property(property: 'mission', ref: '#/components/schemas/Mission')]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 500, description: 'Server error'),
        ]
    )]
    public function generate(Request $request): JsonResponse
    {
        $data = $request->all();
        if (empty($data['deadline'])) {
            unset($data['deadline']);
        }

        $validated = validator($data, [
            'sorcerer_id'    => 'nullable|integer|exists:sorcerers,id',
            'curse_id'       => 'nullable|integer|exists:curses,id',
            'curse_level'    => ['nullable', 'string', Rule::in([
                'grade-4', 'grade-3', 'grade-2', 'semi-grade-1', 'grade-1', 'special-grade',
            ])],
            'sorcerer_grade' => ['nullable', 'string', Rule::in([
                'grade-4', 'grade-3', 'grade-2', 'semi-grade-1', 'grade-1', 'special-grade',
            ])],
            'title'          => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'category'       => 'nullable|string|max:100',
            'location'       => 'nullable|string|max:255',
            'urgency_level'  => ['nullable', 'string', Rule::in(['low', 'medium', 'high'])],
            'deadline'       => 'nullable|date|after:now',
        ])->validate();

        try {
            $mission = $this->missionService->generateMission($validated);

            return response()->json([
                'success' => true,
                'message' => 'Mission generated successfully',
                'data'    => [
                    'mission' => $mission,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate mission',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Post(
        path: '/mission/{id}/send-email',
        summary: 'Send mission emails to assigned sorcerers',
        description: 'Sends email notifications to all sorcerers assigned to this mission',
        tags: ['Missions'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Emails sent successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: '2 email(s) sent'),
                        new OA\Property(property: 'mission', ref: '#/components/schemas/Mission'),
                        new OA\Property(
                            property: 'notified_sorcerers',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Sorcerer')
                        ),
                    ]
                )
            ),
            new OA\Response(response: 400, description: 'No sorcerers assigned to this mission'),
            new OA\Response(response: 404, description: 'Mission not found'),
            new OA\Response(response: 500, description: 'Server error'),
        ]
    )]
    public function sendEmail(int $id): JsonResponse
    {
        try {
            $result = $this->missionService->sendMissionEmails($id);

            $statusCode = $result['success'] ? 200 : 400;

            return response()->json($result, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send emails',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Get(
        path: '/mission/unassigned',
        summary: 'Get all unassigned missions',
        description: 'Returns a list of missions that have not been assigned to any sorcerer',
        tags: ['Missions'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of unassigned missions',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'missions',
                                    type: 'array',
                                    items: new OA\Items(ref: '#/components/schemas/Mission')
                                ),
                                new OA\Property(property: 'count', type: 'integer', example: 5),
                            ]
                        ),
                    ]
                )
            ),
        ]
    )]
    public function unassigned(): JsonResponse
    {
        $missions = $this->missionService->getUnassignedMissions();

        return response()->json([
            'success' => true,
            'data'    => [
                'missions' => $missions,
                'count'    => $missions->count(),
            ],
        ]);
    }
}
