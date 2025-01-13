<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .filter-form {
            max-width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid black;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .filter-form label {
            display: inline-block;
            margin-bottom: 10px;
            color: #333;
            padding-left: 5px;
            padding-right: 10px;
        }

        .filter-form input[type="text"],
        .filter-form select {
            padding: 8px; 
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 4px;        
            display: inline-flex;
            width: 70%;
            box-shadow: #333;

        }

        .filter-form input[type="date"] {
            margin-left: 150px auto; 
            padding-left: 5px;
        }


        .filter-form button {
            width: 100px;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 auto;
            justify-content: center;
            align-content: center;
            display: inline-flex;

        }

        .filter-form button:hover {
            background-color: #45a049;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        .between {
            padding: 15px;
        }

    </style>
</head>

<body>

    <h2>Users Sheet</h2>
    <div class="filter-form">
        <form action="/report/users" method="GET">

            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter name" value="{{request("name")}}">
            <div class="between"></div>

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" placeholder="Enter phone" value="{{request("phone")}}">
            <div class="between"></div>

            <label for="from_renewal_subscription_date">Last Renew Date(from)</label>
            <input type="date" id="from_renewal_subscription_date" name="from_renewal_subscription_date" placeholder="Enter date" value="{{request("from_renewal_subscription_date")}}">
            <div class="between"></div>

            <label for="to_renewal_subscription_date">Last Renew Date(to)</label>
            <input type="date" id="to_renewal_subscription_date" name="to_renewal_subscription_date" placeholder="Enter date" value="{{request("to_renewal_subscription_date")}}">
            <div class="between"></div>

            <label for="from_end_subscription_date">Expire Date(from)</label>
            <input type="date" id="from_end_subscription_date" name="from_end_subscription_date" placeholder="Enter date" value="{{request("from_end_subscription_date")}}">
            <div class="between"></div>

            <label for="to_end_subscription_date">Expire Date(to)</label>
            <input type="date" id="to_end_subscription_date" name="to_end_subscription_date" placeholder="Enter date" value="{{request("to_end_subscription_date")}}">
            <div class="between"></div>


            <button type="submit">Apply Filter</button>
            <button type="reset">Reset</button>
        </form>
    </div>
    <div class="between"></div>
    <table>
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>Last Renew Date</th>
            <th>Expire Subscription Date</th>
            <th>Remainig Days</th>
            <th>Phone</th>
            <th>Price</th>
            <th>Visits Number</th>
        </tr>
        @foreach ($data as $user)
            <tr>
                <th>#{{ $user['id'] }}</th>
                <th>{{ $user['name'] }}</th>
                <th>{{ $user['renewal_subscription_date'] }}</th>
                <th>{{ $user['end_subscription_date'] }}</th>
                <th>{{ $user['remaining_days'] }}</th>
                <th>{{ $user['phone'] }}</th>
                <th>{{ $user['price'] }}</th>
                <th>{{ $user['visits_number'] }}</th>
            </tr>
        @endforeach
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>total:</th>
            <th>{{ $total }}</th>
            <th></th>
        </tr>
    </table>


</body>

</html>
