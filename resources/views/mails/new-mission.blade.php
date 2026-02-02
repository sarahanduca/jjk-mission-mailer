<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nova Missão Atribuída - {{ config('app.name', 'Sistema de Feiticeiros') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
            color: #1b1b18;
            background-color: #fdfdfc;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .header .subtitle {
            margin-top: 10px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .mission-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }

        .mission-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }

        .detail-item {
            background: white;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .detail-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-weight: 500;
            color: #1b1b18;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .badge-urgency-high { background: #fee; color: #dc3545; border: 1px solid #fcc; }
        .badge-urgency-medium { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .badge-urgency-low { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .badge-status-pending { background: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; }
        .badge-status-active { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }
        .badge-status-completed { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .badge-category { background: #e8e8ff; color: #483d8b; border: 1px solid #d6d8ff; }

        .buttons-container {
            display: flex;
            gap: 15px;
            margin: 30px 0;
            justify-content: center;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            text-align: center;
            min-width: 140px;
            transition: all 0.3s ease;
        }

        .btn-accept {
            background: #28a745;
            color: white;
            border: 2px solid #28a745;
        }

        .btn-accept:hover {
            background: #218838;
            border-color: #1e7e34;
        }

        .btn-decline {
            background: white;
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .btn-decline:hover {
            background: #dc3545;
            color: white;
        }

        .description {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            margin: 20px 0;
            line-height: 1.8;
        }

        .deadline-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .deadline-warning svg {
            flex-shrink: 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .mission-details {
                grid-template-columns: 1fr;
            }

            .buttons-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🎯 Nova Missão Atribuída</h1>
            <div class="subtitle">Prepare-se para uma nova jornada, {{ $sorcererName ?? 'Feiticeiro' }}!</div>
        </div>

        <div class="content">
            <p>Olá <strong>{{ $sorcererName ?? 'Feiticeiro' }}</strong>,</p>
            <p>Uma nova missão foi atribuída ao seu perfil. Analise os detalhes abaixo e decida se aceita ou recusa este desafio.</p>

            <div class="mission-card">
                <h2 style="margin-top: 0;">{{ $mission->title }}</h2>

                @if($mission->deadline)
                <div class="deadline-warning">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <div>
                        <strong>Data Limite:</strong> {{ $mission->deadline->format('d/m/Y H:i') }}
                        @if($mission->deadline->isFuture())
                            <br><small>(Faltam {{ $mission->deadline->diffForHumans() }})</small>
                        @endif
                    </div>
                </div>
                @endif

                <div class="description">
                    <strong>Descrição da Missão:</strong><br>
                    {{ $mission->description ?? 'Descrição não disponível' }}
                </div>

                <div class="mission-details">
                    <div class="detail-item">
                        <div class="detail-label">ID da Missão</div>
                        <div class="detail-value">#{{ $mission->id }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Categoria</div>
                        <div class="detail-value">
                            @if($mission->category)
                                <span class="badge badge-category">{{ $mission->category }}</span>
                            @else
                                Não especificada
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Nível de Maldição</div>
                        <div class="detail-value">{{ $mission->curse_level ?? 'Não especificado' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Grau Necessário</div>
                        <div class="detail-value">{{ $mission->required_sorcerer_grade ?? 'Qualquer grau' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Localização</div>
                        <div class="detail-value">{{ $mission->location ?? 'Não especificada' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Urgência</div>
                        <div class="detail-value">
                            @if($mission->urgency_level)
                                @php
                                    $urgencyClass = [
                                        'alta' => 'badge-urgency-high',
                                        'média' => 'badge-urgency-medium',
                                        'baixa' => 'badge-urgency-low',
                                    ][strtolower($mission->urgency_level)] ?? 'badge-urgency-medium';
                                @endphp
                                <span class="badge {{ $urgencyClass }}">{{ ucfirst($mission->urgency_level) }}</span>
                            @else
                                <span class="badge badge-urgency-medium">Normal</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Status Atual</div>
                        <div class="detail-value">
                            @if($mission->status)
                                @php
                                    $statusClass = [
                                        'pendente' => 'badge-status-pending',
                                        'ativa' => 'badge-status-active',
                                        'concluída' => 'badge-status-completed',
                                    ][strtolower($mission->status)] ?? 'badge-status-pending';
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ ucfirst($mission->status) }}</span>
                            @else
                                <span class="badge badge-status-pending">Pendente</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Criação</div>
                        <div class="detail-value">{{ $mission->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>

                @if($mission->curses && $mission->curses->count() > 0)
                <div style="margin: 20px 0;">
                    <h3 style="margin-bottom: 10px;">Maldições Envolvidas</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach($mission->curses as $curse)
                            <span style="background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                {{ $curse->name }}
                                @if($curse->pivot && $curse->pivot->is_primary_target)
                                    <span style="background: #dc3545; color: white; padding: 1px 4px; border-radius: 2px; margin-left: 4px; font-size: 10px;">PRINCIPAL</span>
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p><strong>Tem até {{ $mission->deadline ? $mission->deadline->format('d/m/Y') : '48 horas' }} para responder</strong></p>
                <p style="color: #6c757d; font-size: 14px;">Sua resposta será registrada em seu histórico de missões</p>
            </div>

            <div class="buttons-container">
                <a href="{{ url('/api/missions/' . $mission->id . '/accept?user_id=' . ($userId ?? '')) }}" class="btn btn-accept">
                    ✅ Aceitar Missão
                </a>
                <a href="{{ url('/api/missions/' . $mission->id . '/decline?user_id=' . ($userId ?? '')) }}" class="btn btn-decline">
                    ❌ Recusar Missão
                </a>
            </div>

            <div style="margin-top: 30px; padding: 15px; background: #e7f3ff; border-radius: 6px; border: 1px solid #b8daff;">
                <h4 style="margin-top: 0; color: #004085;">📋 Informações Importantes</h4>
                <ul style="margin-bottom: 0; padding-left: 20px;">
                    <li>Ao aceitar, você assume total responsabilidade pela execução da missão</li>
                    <li>Missões recusadas podem ser realocadas para outros feiticeiros</li>
                    <li>O não cumprimento de missões aceitas pode afetar sua avaliação</li>
                    <li>Em caso de dúvidas, contate o Conselho de Feiticeiros</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name', 'Sistema de Feiticeiros') }}. Todos os direitos reservados.</p>
            <p>
                <a href="{{ url('/missions/' . $mission->id) }}">Ver detalhes completos</a> |
                <a href="{{ url('/dashboard') }}">Acessar Painel</a> |
                <a href="mailto:support@example.com">Suporte</a>
            </p>
            <p style="font-size: 12px; margin-top: 10px;">
                Este é um email automático. Por favor, não responda diretamente.
                <br>ID do email: {{ Str::random(10) }}
            </p>
        </div>
    </div>
</body>
</html>
