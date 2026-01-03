{{-- resources/views/track-order.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Order | Legacy Leather Works</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background:#f7f5f3;
            margin:0;
        }
        .wrap{
            max-width:1000px;
            margin:60px auto;
            padding:20px;
        }
        h1{
            letter-spacing:3px;
        }
        .grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:30px;
        }
        @media(max-width:900px){
            .grid{grid-template-columns:1fr}
        }
        .card{
            background:#fff;
            border-radius:14px;
            padding:25px;
            box-shadow:0 10px 40px rgba(0,0,0,.1);
        }
        label{
            font-size:12px;
            letter-spacing:2px;
            display:block;
            margin-bottom:6px;
        }
        input{
            width:100%;
            padding:14px;
            border-radius:10px;
            border:1px solid #ccc;
            font-size:14px;
        }
        button{
            width:100%;
            padding:15px;
            border:none;
            border-radius:12px;
            background:#6B3F2A;
            color:#fff;
            margin-top:15px;
            cursor:pointer;
            letter-spacing:2px;
        }
        .status{
            font-size:14px;
            line-height:1.8;
        }
        .badge{
            display:inline-block;
            padding:6px 12px;
            border-radius:999px;
            background:#eee;
            font-size:12px;
            letter-spacing:1px;
        }
        .error{
            color:#b00020;
            margin-top:10px;
        }
        .success{
            background:#f2efe9;
            padding:15px;
            border-radius:12px;
        }
    </style>
</head>
<body>

<div class="wrap">

    <h1>TRACK ORDER</h1>

    <div class="grid">

        {{-- LEFT : FORM --}}
        <div class="card">
            <h3>Find Your Order</h3>

            <form method="POST" action="{{ route('track.order.submit') }}">
                @csrf

                <label>ORDER REFERENCE</label>
                <input
                    name="order_number"
                    placeholder="LLW-20251231-XXXXX"
                    value="{{ old('order_number') }}"
                    required
                >

                <label style="margin-top:15px;">EMAIL (OPTIONAL)</label>
                <input
                    type="email"
                    name="email"
                    placeholder="email@example.com"
                    value="{{ old('email') }}"
                >

                <button type="submit">TRACK ORDER</button>

                @if($errors->any())
                    <div class="error">
                        {{ $errors->first() }}
                    </div>
                @endif
            </form>
        </div>

        {{-- RIGHT : RESULT --}}
        <div class="card">
            <h3>Status</h3>

            @if(isset($order))
                <div class="success">
                    <p><b>Order:</b> {{ $order->order_number }}</p>
                    <p><b>Customer:</b> {{ $order->first_name }} {{ $order->last_name }}</p>
                    <p><b>Email:</b> {{ $order->email }}</p>

                    <p class="status">
                        <b>Status:</b>
                        <span class="badge">{{ strtoupper($order->status) }}</span>
                    </p>

                    <p><b>Placed On:</b> {{ $order->created_at->format('d M Y') }}</p>
                </div>
            @else
                <p class="status">
                    Enter your order reference to see the latest status.
                </p>
            @endif
        </div>

    </div>
</div>

</body>
</html>
