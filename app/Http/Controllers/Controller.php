<?php
namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'JJK Mission Mailer API',
    description: 'API for managing sorcerer missions and assignments'
)]
#[OA\Server(
    url: 'http://localhost',
    description: 'Local Development Server'
)]
#[OA\Tag(name: 'Missions', description: 'Mission management endpoints')]
abstract class Controller
{
}
