<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $commande->numCommande }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .facture-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
            text-align: right;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>ISI BURGER</h1>
    <p>Dakar, Sénégal</p>
</div>

<div class="facture-info">
    <h2>Facture #{{ $commande->numCommande }}</h2>
    <p><strong>Date:</strong> {{ $commande->updated_at->format('d/m/Y') }}</p>
    <p><strong>Client:</strong> {{ $commande->user->prenom }} {{ $commande->user->nom }}</p>
    <p><strong>Email:</strong> {{ $commande->user->email }}</p>
    <p><strong>Téléphone:</strong> {{ $commande->user->telephone }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>Burger</th>
        <th>Prix unitaire</th>
        <th>Quantité</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @php $total = 0; @endphp
    @foreach($commande->details as $detail)
        @php
            $itemTotal = $detail->burger->prix * $detail->quantite;
            $total += $itemTotal;
        @endphp
        <tr>
            <td>{{ $detail->burger->libelle }}</td>
            <td>{{ number_format($detail->burger->prix, 0, ',', ' ') }} F CFA</td>
            <td>{{ $detail->quantite }}</td>
            <td>{{ number_format($itemTotal, 0, ',', ' ') }} F CFA</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="total">
    Total: {{ number_format($total, 0, ',', ' ') }} F CFA
</div>

<div class="footer">
    <p>Merci pour votre commande! Revenez nous voir bientôt.</p>
    <p>ISI BURGER - Téléphone: xx xxx xx xx - Email: contact@isiburger.com</p>
</div>
</body>
</html>
