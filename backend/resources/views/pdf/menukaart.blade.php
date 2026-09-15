<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">

    <title>Menukaart De Gouden Draak</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #000;
            font-size: 12px;
        }

        h1 {
            margin-bottom: 5px;
            text-align: center;
            color: #b00000;
        }

        .subtitle {
            margin-bottom: 25px;
            text-align: center;
        }

        h2 {
            margin: 20px 0 8px;
            padding-bottom: 4px;
            border-bottom: 2px solid #b00000;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }

        .number {
            width: 12%;
            font-weight: bold;
        }

        .name {
            width: 73%;
        }

        .price {
            width: 15%;
            text-align: right;
            white-space: nowrap;
        }

        .description {
            font-style: italic;
        }
    </style>
</head>

<body>
    <h1>De Gouden Draak</h1>

    <div class="subtitle">
        Chinees-Indische specialiteiten
    </div>

    @foreach ($gerechtenPerCategorie as $categorie => $gerechten)
        <h2>{{ $categorie }}</h2>

        <table>
            @foreach ($gerechten as $gerecht)
                <tr>
                    <td class="number">
                        {{ $gerecht->menunummer }}{{ $gerecht->menu_toevoeging }}.
                    </td>

                    <td class="name">
                        {{ $gerecht->naam }}

                        @if ($gerecht->beschrijving)
                            <span class="description">
                                ({{ $gerecht->beschrijving }})
                            </span>
                        @endif
                    </td>

                    <td class="price">
                        € {{ number_format($gerecht->price, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </table>
    @endforeach
</body>
</html>