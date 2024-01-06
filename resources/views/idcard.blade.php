<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Employee ID Card</title>
  <style>
    /* Add your custom CSS here */
    .card {
      width: 300px;
      height: 435px;
      border: 1px solid black;
      border-radius: 10px;
      margin: 20px auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      height: 100px;
      background-color: #77d4fc;
      display: flex;
      align-items: center;
      justify-content: space-evenly;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .card-header img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 2px solid white;
    }
    .card-body img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 2px solid white;
    }

    .card-body {
      padding: 20px;
      text-align: center;
    }

    .card-body h3 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
      color: #444;
    }

    .card-body p {
      margin: 10px 0;
      font-size: 18px;
      color: #666;
    }

    .card-body span {
      display: inline-block;
      margin: 5px;
      font-size: 16px;
      color: #888;
    }

    .card-footer {
      height: 55px;
      background-color: #77d4fc;
      display: flex;
      align-items: center;
      justify-content: center;
      bottom: 0;
      position: relative;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    .card-footer p {
      font-size: 14px;
      color: white;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-header">
      <img src="{{ asset('img/logo.png') }}" alt="Company Logo">
    </div>
    <div class="card-body">
        <img src="https://static.thenounproject.com/png/321991-200.png" alt="Employee photo" />
        <h3>{{ $employee->nama }}</h3>
        <p>{{ $employee->jobpos['nama'] }}</p>
        <span><strong>ID:</strong> {{ $employee->id }}</span>
        <span><strong>Email:</strong> {{ $employee->email }}</span>
        <span><strong>Phone:</strong> {{ $employee->telp }}</span>
    </div>
    <div class="card-footer">
      <p>© 2024 PT.Sport Indonesia . All rights reserved.</p>
    </div>
  </div>
</body>
</html>
