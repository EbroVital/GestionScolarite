<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu {{ $recu->numero_recu }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        .container {
            padding: 20px;
        }

        .header {
            margin-bottom: 30px;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 20px;
        }

        .header-left {
            width: 50%;
            float: left;
        }

        .header-right {
            width: 50%;
            float: right;
            text-align: right;
        }

        .logo h2 {
            color: #0d6efd;
            margin-bottom: 5px;
        }

        .badge-paye {
            background-color: #198754;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .numero-recu {
            color: #0d6efd;
            font-size: 20px;
            font-weight: bold;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            color: #6c757d;
            text-transform: uppercase;
            font-size: 11px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
            border: none;
        }

        .info-table td:first-child {
            color: #6c757d;
            width: 40%;
        }

        .info-table td:last-child {
            font-weight: bold;
        }

        .montant-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }

        .montant-label {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .montant-value {
            color: #198754;
            font-size: 24px;
            font-weight: bold;
        }

        .situation-box {
            border: 2px solid #0d6efd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .situation-header {
            background-color: #0d6efd;
            color: white;
            padding: 8px 15px;
            margin: -15px -15px 15px -15px;
            border-radius: 6px 6px 0 0;
            font-weight: bold;
        }

        .stat-row {
            text-align: center;
            margin-bottom: 15px;
        }

        .stat-col {
            display: inline-block;
            width: 32%;
            vertical-align: top;
        }

        .stat-label {
            color: #6c757d;
            font-size: 10px;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 16px;
            font-weight: bold;
        }

        .progress-bar {
            height: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .progress-fill {
            height: 100%;
            background-color: #198754;
        }

        .note-box {
            background-color: #cff4fc;
            border: 1px solid #9eeaf9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .signature-box {
            text-align: center;
            margin-top: 40px;
        }

        .signature-line {
            border-top: 2px solid #000;
            width: 200px;
            margin: 50px auto 10px auto;
        }

        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 10px;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
            margin-top: 30px;
        }

        .text-success { color: #198754; }
        .text-danger { color: #dc3545; }
        .text-muted { color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        {{-- En-tête --}}
        <div class="header clearfix">
            <div class="header-left">
                <div class="logo">
                    <h2>ÉCOLE [NOM]</h2>
                    <p class="text-muted">
                        Adresse de l'école<br>
                        Téléphone : +225 XX XX XX XX XX<br>
                        Email : contact@ecole.com
                    </p>
                </div>
            </div>
            <div class="header-right">
                <div class="badge-paye">✓ PAYÉ</div>
                <div>
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Reçu N°</div>
                    <div class="numero-recu">{{ $recu->numero_recu }}</div>
                </div>
            </div>
        </div>

        {{-- Informations --}}
        <div class="clearfix section">
            <div style="width: 55%; float: left;">
                <div class="section-title">Informations de l'élève</div>
                <table class="info-table">
                    <tr>
                        <td>Nom complet :</td>
                        <td>{{ $recu->paiement->eleve->nom_complet }}</td>
                    </tr>
                    <tr>
                        <td>Matricule :</td>
                        <td>{{ $recu->paiement->eleve->matricule }}</td>
                    </tr>
                    <tr>
                        <td>Classe :</td>
                        <td>{{ $recu->paiement->eleve->classe->nom }}</td>
                    </tr>
                    <tr>
                        <td>Année scolaire :</td>
                        <td>{{ $recu->paiement->eleve->classe->anneeScolaire->libelle }}</td>
                    </tr>
                </table>
            </div>

            <div style="width: 50%; float: right;">
                <div class="section-title">Détails du paiement</div>
                <table class="info-table">
                    <tr>
                        <td>Date :</td>
                        <td>{{ $recu->date_emission }}</td>
                    </tr>
                    <tr>
                        <td>Mode de paiement :</td>
                        <td>{{ $recu->paiement->typePaiement->libelle }}</td>
                    </tr>
                    @if($recu->paiement->reference_transaction)
                    <tr>
                        <td>Référence :</td>
                        <td>{{ $recu->paiement->reference_transaction }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Montant --}}
        <div class="montant-box">
            <div class="montant-label">Montant payé</div>
            <div class="montant-value">{{ formater_montant($recu->montant) }}</div>
        </div>

        {{-- Situation financière --}}
        @php
            $fraisTotal = $recu->paiement->eleve->classe->fraisScolaire->montant;
            $totalPaye = $recu->paiement->eleve->paiements->sum('montant');
            $soldeRestant = $fraisTotal - $totalPaye;
            $pourcentage = $fraisTotal > 0 ? ($totalPaye / $fraisTotal) * 100 : 0;
        @endphp

        <div class="situation-box">
            <div class="situation-header">📊 Situation financière de l'élève</div>

            <div class="stat-row clearfix">
                <div class="stat-col">
                    <div class="stat-label">Frais de scolarité</div>
                    <div class="stat-value">{{ formater_montant($fraisTotal) }}</div>
                </div>
                <div class="stat-col">
                    <div class="stat-label">Total payé</div>
                    <div class="stat-value text-success">{{ formater_montant($totalPaye) }}</div>
                </div>
                <div class="stat-col">
                    <div class="stat-label">Solde restant</div>
                    <div class="stat-value {{ $soldeRestant > 0 ? 'text-danger' : 'text-success' }}">
                        {{ formater_montant($soldeRestant) }}
                    </div>
                </div>
            </div>

            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ min($pourcentage, 100) }}%"></div>
            </div>
            <div style="text-align: center; font-size: 10px; color: #6c757d;">
                {{ number_format($pourcentage, 1) }}% payé
            </div>
        </div>

        {{-- Note --}}
        <div class="note-box">
            <strong>ℹ Note :</strong> Ce reçu fait foi de paiement. Veuillez le conserver précieusement.
        </div>

        {{-- Signature --}}
        <div class="signature-box">
            <div style="font-size: 11px; color: #6c757d; margin-bottom: 5px;">Signature et cachet</div>
            <div class="signature-line"></div>
            <div class="text-muted" style="font-size: 10px;">Le caissier</div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Merci pour votre confiance</p>
        </div>
    </div>
</body>
</html>
