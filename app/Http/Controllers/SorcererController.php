<?php
namespace App\Http\Controllers;

use App\Models\Sorcerer;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class SorcererController extends Controller
{
    #[OA\Get(
        path: '/sorcerer',
        summary: 'List all sorcerers',
        description: 'Returns a list of all registered sorcerers',
        tags: ['Sorcerers'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of sorcerers',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Sorcerer')
                        ),
                        new OA\Property(property: 'count', type: 'integer', example: 10),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $sorcerers = Sorcerer::all();

        return response()->json([
            'success' => true,
            'data'    => $sorcerers,
            'count'   => $sorcerers->count(),
        ]);
    }

    #[OA\Get(
        path: '/sorcerer/{id}',
        summary: 'Get a sorcerer by ID',
        description: 'Returns a single sorcerer with their mission assignments',
        tags: ['Sorcerers'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Sorcerer details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Sorcerer'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Sorcerer not found'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $sorcerer = Sorcerer::with('missionAssignments.mission')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $sorcerer,
        ]);
    }
}
