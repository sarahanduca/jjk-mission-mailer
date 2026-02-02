<?php
namespace App\Http\Controllers;

use App\Mail\MissionAssignedMail;
use App\Models\Mission;
use App\Models\Sorcerer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MissionController extends Controller
{
    public function index(): array
    {
        $mission = Mission::all();
        return $mission->toArray();
    }

    public function getMission($id)
    {
        $mission = Mission::findOrFail($id);
        return $mission;
    }

    // TODO arrumar esse método pois da maneira como está agora é para testar o envio de email
    public function store(Request $request)
    {
        $mission  = Mission::findOrFail($request->mission_id);
        $sorcerer = Sorcerer::findOrFail($request->sorcerer_id);

        Mail::to($sorcerer->email)
            ->queue(new MissionAssignedMail($mission, $sorcerer->name, $sorcerer->id));

        return response()->json(['message' => 'Email enviado com sucesso']);
    }
}
