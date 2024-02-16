<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Palatino, URW Palladio L, serif';
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #3498db;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: separate;
            border-spacing: 0 2px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #ecf0f1;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 8px;
            /* Ajustez la valeur en pixels pour augmenter la hauteur des colonnes */
            text-align: left;
            border: 0.5px solid #bdc3c7;
            font-weight: 400;
            border-radius: 8px;
            font-size: 1.2em;
            /* Ajustez la valeur pour augmenter la taille de la police */
        }

        th {
            background-color: #3498db;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
        }


        tr:hover {
            background-color: #f0f8ff;
            transition: background-color 0.3s ease-in-out;
        }

        tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        @media (max-width: 600px) {
            table {
                width: 100%;
            }
        }
    </style>
    <title>Styled Table</title>
</head>

<body>

    <h2>Styled Table</h2>


    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th> tache</th>
                <th> description</th>
                <th> lieu</th>
                <th> maintenancier</th>
                <th> Status</th>
                <th>assigner</th>
                <th>échance</th>
                <th>fin de maintenance</th>
            </tr>
        </thead>
        @php
            $counter = 1;
        @endphp

        <tbody>
            @foreach ($histories as $history)
                <tr>
                    <td>
                        {{ $counter++ }}
                    </td>
                    <td>
                        {{ $history->name }}
                    </td>
                    <td>
                        {{ $history->description }}
                    </td>
                    <td>
                        {{ $history->place }}
                    </td>
                    <td>
                        {{ $history->user }}
                    </td>
                    <td>
                        {{ $history->status }}
                    </td>

                    <td>
                        {{ $history->start_date }}
                    </td>

                    <td>
                        {{ $history->due_date }}
                    </td>

                    <td>
                        {{ $history->updated_at }}
                    </td>
                </tr>
            @endforeach

            <!-- Ajoutez plus de lignes au besoin -->
        </tbody>
    </table>
    {{-- <img src="./{{ asset('/images/ministère.png') }}" alt="Votre Image"/> --}}

</body>

</html>
