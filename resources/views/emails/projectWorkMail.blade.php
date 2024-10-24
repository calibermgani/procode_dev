<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    * {
        font-family: Verdana, Arial, sans-serif;
        color: black;
    }

    table {
        font-size: small;
    }

    thead,
    th {
        background-color: #0e969c2b;

    }

    th,
    td {
        text-align: center;
        padding-right: 30px;
    }
</style>

<body>

    <div class="table-responsive pb-2">

        {{-- <p>Hi {{ $reportingPerson != null ? App\Http\Helper\Admin\Helpers::getUserNameById($reportingPerson) : 'All' }}, </p> --}}

        <p>These are yesterday pending records</p>
        <table class="table" border="1" style="border-collapse: collapse">
            <thead>
                <tr>
                    <th style="text-align: left;padding: 5px;">Project</th>
                    <th style="text-align: left;padding: 5px;">Chats</th>
                    <th style="text-align: left;padding: 5px;">Coder</th>
                    <th style="text-align: left;padding: 5px;">QA</th>
                    <th style="text-align: left;padding: 5px;">Balance</th>
                </tr>
            </thead>
            <tbody>

                @if (isset($mailBody) && count($mailBody) > 0)
                    @foreach ($mailBody as $data)
                        <tr>
                            <td style="text-align: left;padding: 5px;">{{ $data['project'] }}</td>
                            <td style="text-align: left;padding: 5px;">{{ $data['Chats'] }}</td>
                            <td style="text-align: left;padding: 5px;">{{ $data['Coder'] }}</td>
                            <td style="text-align: left;padding: 5px;">{{ $data['QA'] }}</td>
                            <td style="text-align: left;padding: 5px;">{{ $data['Balance'] }}</td>
                        </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
        <br>
        @include('emails.emailFooter')
    </div>
</body>

</html>
