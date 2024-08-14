<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mailing Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 70%;
            margin: 100px auto;
        }

        .form-row {
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-field {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="form-row">
            <a href="{{ config('app.dashboard_url') }}/dashboard.html" class="btn">Go to Web Server - Nginx</a>
            <br><hr>
            <form action="{{ route('send.email') }}" method="post">
                @csrf
                <div class="form-field">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>
                <br>
                <div class="form-field">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message"></textarea>
                </div>
                <br>
                <div style="display: flex; justify-content: flex-end;">
                    <button>
                        Send Email
                    </button>
                </div>
            </form>
        </div>
        <hr>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No.</th>
                    <th style="width: 25%">Sent To</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mailDetails ?? [] as $mail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mail->email }}</td>
                        <td>{{ $mail->message }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
