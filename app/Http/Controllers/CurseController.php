<?php
namespace App\Http\Controllers;

use App\Models\Curse;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Curse',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Finger Bearer'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'curse_level', type: 'string', example: 'special-grade'),
        new OA\Property(property: 'curse_type', type: 'string', example: 'Cursed Spirit'),
        new OA\Property(property: 'abilities', type: 'string'),
        new OA\Property(property: 'known_weaknesses', type: 'string'),
        new OA\Property(property: 'status', type: 'string', example: 'at_large'),
        new OA\Property(property: 'first_sighted_at', type: 'string', format: 'date-time'),
    ]
)]
class CurseController extends Controller
{
    #[OA\Get(
        path: '/curse',
        summary: 'List all curses',
        description: 'Returns a list of all registered curses',
        tags: ['Curses'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of curses',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Curse')
                        ),
                        new OA\Property(property: 'count', type: 'integer', example: 10),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $curses = Curse::all();

        return response()->json([
            'success' => true,
            'data'    => $curses,
            'count'   => $curses->count(),
        ]);
    }

    #[OA\Get(
        path: '/curse/{id}',
        summary: 'Get a curse by ID',
        description: 'Returns a single curse with related missions',
        tags: ['Curses'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Curse details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Curse'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Curse not found'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $curse = Curse::with('missions')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $curse,
        ]);
    }
}
